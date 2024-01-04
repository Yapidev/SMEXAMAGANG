<?php

namespace Database\Seeders;

use App\Models\Siswa as ModelsSiswa;
use Illuminate\Database\Seeder;
use App\Siswa;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            $class = '';
            $class_types = ['X', 'XI', 'XII'];
            $class_jurusans = ['RPL', 'MP', 'BD', 'AK', 'LP'];

            $random_class_type = $faker->randomElement($class_types);
            $random_class_jurusan = $faker->randomElement($class_jurusans);
            $random_kelas = $faker->numberBetween(1, 4); // Membuat nomor kelas secara acak antara 1 dan 4

            $class = $random_class_type . $random_class_jurusan . $random_kelas;

            ModelsSiswa::create([
                'name' => $faker->name,
                'class' => $class,
                'phone_number' => '08' . $faker->numerify(str_repeat('#', $faker->numberBetween(8, 11))),
                'nik' => $faker->unique()->numerify('################'),
                'gender' => $faker->randomElement(['L', 'P']),
            ]);
        }
    }
}
