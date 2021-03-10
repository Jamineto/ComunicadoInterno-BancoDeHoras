<?php

namespace Database\Factories;

use App\Models\Comunicado;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComunicadoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comunicado::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'assunto' => $this->faker->words('5',true),
            'autor_id' => $this->faker->numberBetween(1,5),
            'conteudo' => $this->faker->text(),
            'ativo' => 1,
            'origem_id' => $this->faker->numberBetween(1,5),
            'destino_id' => $this->faker->numberBetween(1,5),
        ];
    }
}
