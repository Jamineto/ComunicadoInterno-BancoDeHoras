<?php

namespace Database\Factories;

use App\Models\Funcionario;
use Illuminate\Database\Eloquent\Factories\Factory;


class FuncionarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Funcionario::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'matricula' => $this->faker->unique()->randomNumber(9),
            'nome' => $this->faker->name(),
            'data_nasc' => $this->faker->date(),
            'total_horas' => $this->faker->numberBetween(-50,50),
            'setor_id' => $this->faker->numberBetween(0,5)
        ];
    }
}
