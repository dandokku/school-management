<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageName = "profile_".Str::random(10).".jpg";
        $imageUrl = 'https://i.pravatar.cc/400?img='.rand(1,70);
        Storage::disk('public')->put('students/'.$imageName, file_get_contents($imageUrl));
        return [
            'firstname'=>$this->faker->firstName(),
            'lastname'=>$this->faker->lastName(),
            'address'=>$this->faker->address(),
            'phone'=>$this->faker->phoneNumber(),
            'course_of_study'=>$this->faker->randomElement(["Computer Science", "Cyber Security", "Data Science", "Artificial Intelligence", "Machine Learning"]),
            'profile_picture'=>$this->faker->imageUrL,
            'email'=>$this->faker->unique()->safeEmail(),
            'profile_picture'=>'student/'.$imageName,
        ];
    }
}
