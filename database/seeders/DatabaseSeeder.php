<?php

namespace Database\Seeders;

use App\Models\Engine;
use App\Models\EngineRelease;
use App\Models\HelpSubject;
use App\Models\User;
use App\Models\Resource;
use App\Models\ResourceType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $users = User::factory(10)->create();

        Engine::factory()
            ->count(3)
            ->has(EngineRelease::factory()->count(10))
            ->create();

        $engineReleases = EngineRelease::all();

        ResourceType::factory()
            ->count(3)
            ->has(
                Resource::factory()
                    ->count(10)
                    ->state(fn () => [
                        'engine_release_id' => $engineReleases->random()->id,
                        'uploader_id' => $users->random()->id,
                    ])
                    ->hasResourceLinks(3)
            )
            ->create();

        Resource::all()->each(function ($resource) use ($users) {
            $resource->upvoters()->attach($users->random(rand(0, 10)));
        });

        HelpSubject::factory()->count(10)->create();
    }
}
