<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\User;
use App\Services\LinkService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Link::class;

    public function definition(): array
    {
        $linkService = app(LinkService::class);

        $user = User::inRandomOrder()->first();

        return [
            'original_url' => $this->faker->url,
            'short_url'    => $linkService->shorten($this->faker->url),
            'expires_at'   => $this->faker->dateTimeBetween('now', '+1 year'),
            'code_user'    => $user->id ?? null,
        ];
    }
}
