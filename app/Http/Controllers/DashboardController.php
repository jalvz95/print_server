<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Trabajo;
use App\Models\Regla;
use App\Models\Impresora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Mostrar dashboard principal con estadísticas y gráficos
     */
    public function index()
    {
        // Estadísticas básicas de trabajos
        $estadisticas = [
            'total_trabajos' => Trabajo::count(),
            'en_cola' => Trabajo::where('estado', Trabajo::ESTADO_EN_COLA)->count(),
            'en_proceso' => Trabajo::where('estado', Trabajo::ESTADO_EN_PROCESO)->count(),
            'bloqueados' => Trabajo::where('estado', Trabajo::ESTADO_BLOQUEADO)->count(),
            'terminados' => Trabajo::where('estado', Trabajo::ESTADO_TERMINADO)->count(),
            'enviados' => Trabajo::where('estado', Trabajo::ESTADO_ENVIADO)->count(),
        ];

        // Total de páginas impresas
        $totalPaginas = Trabajo::where('estado', Trabajo::ESTADO_TERMINADO)->sum('paginas');
        $paginasEnCola = Trabajo::whereIn('estado', [Trabajo::ESTADO_EN_COLA, Trabajo::ESTADO_EN_PROCESO])->sum('paginas');

        // Trabajos por prioridad
        $trabajosPorPrioridad = [
            'urgente' => Trabajo::where('prioridad', Trabajo::PRIORIDAD_URGENTE)->count(),
            'normal' => Trabajo::where('prioridad', Trabajo::PRIORIDAD_NORMAL)->count(),
            'baja' => Trabajo::where('prioridad', Trabajo::PRIORIDAD_BAJA)->count(),
        ];

        // Trabajos color vs blanco/negro
        $trabajosColor = Trabajo::where('es_color', true)->count();
        $trabajosBN = Trabajo::where('es_color', false)->count();

        // Trabajos por usuario (top 10)
        $trabajosPorUsuario = Trabajo::select('usuario_id', DB::raw('count(*) as total'), DB::raw('sum(paginas) as paginas'))
            ->with('usuario')
            ->groupBy('usuario_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Trabajos por impresora
        $trabajosPorImpresora = Trabajo::select('impresora_id', DB::raw('count(*) as total'), DB::raw('sum(paginas) as paginas'))
            ->with('impresora')
            ->whereNotNull('impresora_id')
            ->groupBy('impresora_id')
            ->orderByDesc('total')
            ->get();

        // Trabajos de los últimos 7 días
        $trabajosPorDia = Trabajo::select(
                DB::raw('DATE(tiempo_envio) as fecha'),
                DB::raw('count(*) as total'),
                DB::raw('sum(paginas) as paginas')
            )
            ->where('tiempo_envio', '>=', Carbon::now()->subDays(7))
            ->groupBy(DB::raw('DATE(tiempo_envio)'))
            ->orderBy('fecha')
            ->get();

        // Usuarios y sus cuotas
        $usuarios = Usuario::withCount('trabajos')
            ->orderByDesc('trabajos_count')
            ->get();

        // Estado de impresoras
        $impresoras = Impresora::withCount('trabajos')->get();
        $impresorasStats = [
            'total' => $impresoras->count(),
            'funcionales' => $impresoras->where('estado', Impresora::ESTADO_FUNCIONAL)->count(),
            'sin_tinta' => $impresoras->where('estado', Impresora::ESTADO_SIN_TINTA)->count(),
            'sin_hojas' => $impresoras->where('estado', Impresora::ESTADO_SIN_HOJAS)->count(),
            'desconectadas' => $impresoras->where('estado', Impresora::ESTADO_DESCONECTADA)->count(),
        ];

        // Reglas activas
        $reglas = Regla::where('activa', true)->get();
        $reglasStats = [
            'total' => Regla::count(),
            'activas' => $reglas->count(),
        ];

        // Motivos de bloqueo más comunes
        $motivosBloqueo = Trabajo::where('estado', Trabajo::ESTADO_BLOQUEADO)
            ->whereNotNull('motivo_bloqueo')
            ->select('motivo_bloqueo', DB::raw('count(*) as total'))
            ->groupBy('motivo_bloqueo')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Tiempo promedio de procesamiento (para trabajos terminados)
        $tiempoPromedioSegundos = Trabajo::where('estado', Trabajo::ESTADO_TERMINADO)
            ->whereNotNull('tiempo_inicio_proceso')
            ->whereNotNull('tiempo_terminacion')
            ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, tiempo_inicio_proceso, tiempo_terminacion)) as promedio')
            ->value('promedio') ?? 0;

        // Últimos trabajos
        $ultimosTrabajos = Trabajo::with(['usuario', 'impresora'])
            ->orderByDesc('tiempo_envio')
            ->limit(10)
            ->get();

        // Datos para gráficos JSON
        $chartData = [
            'estadosPie' => [
                'labels' => ['En Cola', 'En Proceso', 'Bloqueados', 'Terminados', 'Enviados'],
                'data' => [
                    $estadisticas['en_cola'],
                    $estadisticas['en_proceso'],
                    $estadisticas['bloqueados'],
                    $estadisticas['terminados'],
                    $estadisticas['enviados'],
                ],
                'colors' => ['#EAB308', '#3B82F6', '#EF4444', '#22C55E', '#6B7280'],
            ],
            'prioridadBar' => [
                'labels' => ['Urgente', 'Normal', 'Baja'],
                'data' => array_values($trabajosPorPrioridad),
                'colors' => ['#EF4444', '#3B82F6', '#6B7280'],
            ],
            'colorDoughnut' => [
                'labels' => ['Color', 'Blanco/Negro'],
                'data' => [$trabajosColor, $trabajosBN],
                'colors' => ['#8B5CF6', '#64748B'],
            ],
            'usuariosBar' => [
                'labels' => $trabajosPorUsuario->pluck('usuario.nombre')->toArray(),
                'trabajos' => $trabajosPorUsuario->pluck('total')->toArray(),
                'paginas' => $trabajosPorUsuario->pluck('paginas')->toArray(),
            ],
            'impresorasBar' => [
                'labels' => $trabajosPorImpresora->pluck('impresora.nombre')->toArray(),
                'trabajos' => $trabajosPorImpresora->pluck('total')->toArray(),
                'paginas' => $trabajosPorImpresora->pluck('paginas')->toArray(),
            ],
            'trabajosDiaLine' => [
                'labels' => $trabajosPorDia->pluck('fecha')->map(fn($f) => Carbon::parse($f)->format('d/m'))->toArray(),
                'trabajos' => $trabajosPorDia->pluck('total')->toArray(),
                'paginas' => $trabajosPorDia->pluck('paginas')->toArray(),
            ],
            'impresorasEstado' => [
                'labels' => ['Funcionales', 'Sin Tinta', 'Sin Hojas', 'Desconectadas'],
                'data' => [
                    $impresorasStats['funcionales'],
                    $impresorasStats['sin_tinta'],
                    $impresorasStats['sin_hojas'],
                    $impresorasStats['desconectadas'],
                ],
                'colors' => ['#22C55E', '#EAB308', '#F97316', '#EF4444'],
            ],
        ];

        return view('dashboard', compact(
            'estadisticas',
            'totalPaginas',
            'paginasEnCola',
            'trabajosPorPrioridad',
            'trabajosColor',
            'trabajosBN',
            'trabajosPorUsuario',
            'trabajosPorImpresora',
            'trabajosPorDia',
            'usuarios',
            'impresoras',
            'impresorasStats',
            'reglas',
            'reglasStats',
            'motivosBloqueo',
            'tiempoPromedioSegundos',
            'ultimosTrabajos',
            'chartData'
        ));
    }
}
