<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Regla;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuarios de ejemplo
        $usuarios = [
            ['nombre' => 'Departamento Contabilidad', 'cuota_actual' => 100, 'activo' => true],
            ['nombre' => 'Departamento Recursos Humanos', 'cuota_actual' => 50, 'activo' => true],
            ['nombre' => 'Usuario A', 'cuota_actual' => 0, 'activo' => true],
            ['nombre' => 'Usuario B', 'cuota_actual' => 200, 'activo' => true],
            ['nombre' => 'Estudiante Premium', 'cuota_actual' => 500, 'activo' => true],
        ];

        foreach ($usuarios as $usuario) {
            Usuario::create($usuario);
        }

        // Crear reglas de ejemplo
        $reglas = [
            [
                'nombre' => 'Límite por Cuota Cero',
                'tipo' => Regla::TIPO_CUOTA_USUARIO,
                'parametro_objetivo' => 'cuota_actual',
                'valor_limite' => '0',
                'accion' => Regla::ACCION_BLOQUEAR,
                'activa' => true,
            ],
            [
                'nombre' => 'Restricción Trabajo Grande',
                'tipo' => Regla::TIPO_RESTRICCION_TRABAJO,
                'parametro_objetivo' => 'paginas',
                'valor_limite' => '200',
                'accion' => Regla::ACCION_REDUCIR_PRIORIDAD,
                'activa' => true,
            ],
            [
                'nombre' => 'Restricción Impresión a Color',
                'tipo' => Regla::TIPO_RESTRICCION_TRABAJO,
                'parametro_objetivo' => 'es_color',
                'valor_limite' => 'true',
                'accion' => Regla::ACCION_ADVERTIR,
                'activa' => false, // Inactiva por defecto para permitir pruebas
            ],
        ];

        foreach ($reglas as $regla) {
            Regla::create($regla);
        }

        // Ejecutar seeder de impresoras
        $this->call(ImpresoraSeeder::class);
    }
}

