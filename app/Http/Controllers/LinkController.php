<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Jobs\ProcessLinkJob;
use App\Models\Link;
use App\Models\LinkClick;
use App\Services\LinkService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LinkController extends Controller
{
    public function __construct(protected LinkService $linkService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request()->input('page', 1);

        return Link::where('code_user', auth('sanctum')->id())
            ->paginate(20, ['*'], 'page', $page)->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLinkRequest $request)
    {
        $data = $request->validated();

        $data['short_url'] = $this->linkService->shorten($data['original_url']);

        ProcessLinkJob::dispatch($data)->onQueue('database');

        $url = url('/api/'.$data['short_url']);

        return response()->json([
            'message'   => 'O link está sendo processado.',
            'short_url' => $url,
        ], 202);
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        if ($link->code_user != auth('sanctum')->id()) {
            return response()->json([
                'message' => 'link não encontrado',
                'status' => 404,
            ], 404);
        }

        return $link->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLinkRequest $request, Link $link)
    {
        if ($link->code_user != auth('sanctum')->id()) {
            return response()->json([
                'message' => 'link não encontrado',
                'status' => 404,
            ], 404);
        }

        $data = $request->validated();

        if (isset($data['original_url'])) {
            $link->originaL_url = $data['original_url'];
            $link->short_url = $this->linkService->shorten($data['original_url']);
        }

        if (isset($data['expires_at'])) {
            $link->expires_at = $data['expires_at'];
        }

        $update = $link->save();

        if ($update) {
            return response()->json([
                'message' => 'Link atualizado com sucesso.',
                'status' => 200,
            ]);
        }

        return response()->json([
            'message' => 'Erro ao atualizar link.',
            'status' => 500,
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        if ($link->code_user != auth('sanctum')->id()) {
            return response()->json([
                'message' => 'link não encontrado',
                'status' => 404,
            ], 404);
        }

        DB::beginTransaction();

        $removeClicks = LinkClick::where('link_id', $link->id_link)->delete();
        $remove = $link->delete();

        if ($remove) {

            DB::commit();

            Log::debug('Link excluído', [
                'link' => $link,
                'removeClicks' => $removeClicks,
            ]);

            return response()->json([
                'message' => 'Link removido com sucesso.',
                'status' => 200
            ]);
        }

        DB::rollBack();

        return response()->json([
            'message' => 'Erro ao remover link.',
            'status' => 500
        ], 500);
    }
}
