<?php

namespace Database\Factories;

use App\Models\Auditory;
use App\Models\Group;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class HourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'time' => $this->faker->numberBetween(1, 8),
            'date' => $this->faker->dateTimeThisMonth(),
            'group_id' => Group::factory()->create()->id,
            'auditory_id' => Auditory::factory()->create()->id,
            'subject_id' => Subject::factory()->create()->id,
            'type_id' => Type::factory()->create()->id,
            'teacher_id' => Teacher::factory()->create()->id
        ];
    }

}
