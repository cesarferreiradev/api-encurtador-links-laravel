<?php

namespace Database\Factories;

use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LinkClick>
 */
class LinkClickFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idLink = Link::inRandomOrder()->first();

        return [
            'link_id'    => $idLink,
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'referer'    => $this->faker->url(),
            'clicked_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
