<?php

namespace Database\Seeders;

use App\Models\Impresora;
use Illuminate\Database\Seeder;

class ImpresoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $impresoras = [
            [
                'nombre' => 'Impresora 1',
                'estado' => Impresora::ESTADO_FUNCIONAL,
                'descripcion_estado' => 'Impresora funcionando correctamente',
                'activa' => true,
            ],
            [
                'nombre' => 'Impresora 2',
                'estado' => Impresora::ESTADO_SIN_TINTA,
                'descripcion_estado' => 'Impresora sin tinta disponible',
                'activa' => true,
            ],
            [
                'nombre' => 'Impresora 3',
                'estado' => Impresora::ESTADO_SIN_HOJAS,
                'descripcion_estado' => 'Impresora sin hojas disponibles',
                'activa' => true,
            ],
            [
                'nombre' => 'Impresora 4',
                'estado' => Impresora::ESTADO_DESCONECTADA,
                'descripcion_estado' => 'Impresora desconectada de la red',
                'activa' => true,
            ],
        ];

        foreach ($impresoras as $impresora) {
            Impresora::create($impresora);
        }
    }
}
