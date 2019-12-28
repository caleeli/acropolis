<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Aporte;
use App\User;
use Faker\Generator as Faker;

$factory->define(Aporte::class, function (Faker $faker) {
    return [
        'miembro_id' => factory(User::class),
        'mes' => $faker->numberBetween(1, 12),
        'gestion' => $faker->numberBetween(2017, 2019),
        'fecha_pago' => $faker->dateTime(),
        'monto' => $faker->numberBetween(1, 3) * 50,
        'recibo' => $faker->numberBetween(12345, 23456),
        'imagen' => function () use ($faker) {
            $filepath = $faker->randomElement(glob(resource_path('images/specs/*.*')));
            $name = basename($filepath);
            $mime = mime_content_type($filepath);
            $ext = count($ext = explode('.', $name)) > 1 ? $ext[count($ext) - 1] : '';
            $path = uniqid('', true) . '.' . $ext;
            $url = url('/storage/' . $path);
            return json_encode([
                'name' => $name,
                'mime' => $mime,
                'path' => $path,
                'url' => $url,
            ]);
        },
        'recibo' => $faker->numberBetween(12345, 23456),
        'verificado_por' => $faker->randomElement(['AM', 'DC', 'VC']),
    ];
});
