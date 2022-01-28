<?php

namespace Database\Factories;

use App\Models\EngineRelease;
use App\Models\User;
use App\Models\Resource;
use App\Models\ResourceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'resource_type_id' => ResourceType::factory(),
            'engine_release_id' => EngineRelease::factory(),
            'uploader_id' => User::factory(),
            'title' => $this->faker->words(3, true),
            'slug' => $this->faker->unique()->slug(3, true),
            'description' => $this->faker->sentences(3, true),
            'youtube_video_id' => 'iKd8nTtVZTM',
            'is_draft' => $this->faker->boolean(),
        ];
    }
}
