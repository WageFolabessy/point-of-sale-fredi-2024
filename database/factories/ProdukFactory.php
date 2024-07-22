<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'kode_produk' => $this->faker->unique()->ean13,
            'nama_produk' => $this->faker->unique()->word,
            'id_kategori' => 7,
            'merk' => $this->faker->optional()->word,
            'harga_beli' => $this->faker->numberBetween(1000, 100000),
            'harga_jual' => $this->faker->numberBetween(1000, 100000),
            'diskon' => $this->faker->numberBetween(0, 100),
            'stok' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
