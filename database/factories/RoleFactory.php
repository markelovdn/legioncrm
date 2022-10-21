<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = [
            'Администратор системы',
            'Администратор организации',
            'Руководитель организации',
            'Тренер',
            'Родитель',
            'Спортсмен'];

        while(count($data) > 1) {
            foreach ($data as $name){
                return [
                    'name' => $name
                ];
            };
        }
        array_shift($data);

    }
}
