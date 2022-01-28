<?php

namespace Database\Factories;

use App\Models\HelpSubject;
use Illuminate\Database\Eloquent\Factories\Factory;

class HelpSubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HelpSubject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->sentences(10, true),
        ];
    }
}
