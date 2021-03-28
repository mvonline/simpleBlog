<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'text' => $this->faker->text,
            'tags' =>json_encode([
                $this->faker->randomElement(
                    [
                        "politic","sport","technology","science", "art","nature", "space"
                    ]
                )
            ]),
            'created_by' => 1
        ];
    }
}
