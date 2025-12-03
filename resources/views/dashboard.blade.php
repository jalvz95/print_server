@extends('layouts.app')

@section('title', 'Dashboard - Estadísticas')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">📊 Dashboard de Impresión</h1>
                <p class="text-sm text-gray-500 mt-1">Vista general del sistema con estadísticas en tiempo real</p>
            </div>
            <div class="text-sm text-gray-500 sm:text-right">
                <p>Última actualización</p>
                <p class="font-medium text-gray-700">{{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Estadísticas principales - Grid uniforme -->
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-5 flex flex-col justify-center">
            <div class="flex items-center gap-3">
                <span class="text-2xl">📄</span>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['total_trabajos'] }}</p>
                    <p class="text-xs text-gray-500">Total Trabajos</p>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 rounded-lg shadow-sm p-5 border border-yellow-200 flex flex-col justify-center">
            <div class="flex items-center gap-3">
                <span class="text-2xl">⏳</span>
                <div>
                    <p class="text-2xl font-bold text-yellow-700">{{ $estadisticas['en_cola'] }}</p>
                    <p class="text-xs text-yellow-600">En Cola</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 rounded-lg shadow-sm p-5 border border-blue-200 flex flex-col justify-center">
            <div class="flex items-center gap-3">
                <span class="text-2xl">⚙️</span>
                <div>
                    <p class="text-2xl font-bold text-blue-700">{{ $estadisticas['en_proceso'] }}</p>
                    <p class="text-xs text-blue-600">En Proceso</p>
                </div>
            </div>
        </div>

        <div class="bg-red-50 rounded-lg shadow-sm p-5 border border-red-600 flex flex-col justify-center">
            <div class="flex items-center gap-3">
                <span class="text-2xl">🚫</span>
                <div>
                    <p class="text-2xl font-bold text-red-700">{{ $estadisticas['bloqueados'] }}</p>
                    <p class="text-xs text-red-600">Bloqueados</p>
                </div>
            </div>
        </div>

        <div class="bg-green-50 rounded-lg shadow-sm p-5 border border-green-200 flex flex-col justify-center">
            <div class="flex items-center gap-3">
                <span class="text-2xl">✅</span>
                <div>
                    <p class="text-2xl font-bold text-green-700">{{ $estadisticas['terminados'] }}</p>
                    <p class="text-xs text-green-600">Terminados</p>
                </div>
            </div>
        </div>

        <div class="bg-purple-50 rounded-lg shadow-sm p-5 border border-purple-200 flex flex-col justify-center">
            <div class="flex items-center gap-3">
                <span class="text-2xl">📑</span>
                <div>
                    <p class="text-2xl font-bold text-purple-700">{{ number_format($totalPaginas) }}</p>
                    <p class="text-xs text-purple-600">Páginas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Métricas secundarias -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="text-2xl">🖨️</span>
                </div>
                <div class="min-w-0">
                    <p class="text-xl font-bold text-gray-900">{{ $impresorasStats['total'] }}</p>
                    <p class="text-xs text-gray-500">Impresoras</p>
                    <p class="text-xs text-green-600 font-medium">{{ $impresorasStats['funcionales'] }} funcionales</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="text-2xl">👥</span>
                </div>
                <div class="min-w-0">
                    <p class="text-xl font-bold text-gray-900">{{ $usuarios->count() }}</p>
                    <p class="text-xs text-gray-500">Usuarios</p>
                    <p class="text-xs text-blue-600 font-medium">{{ $usuarios->where('activo', true)->count() }} activos</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="text-2xl">📋</span>
                </div>
                <div class="min-w-0">
                    <p class="text-xl font-bold text-gray-900">{{ $reglasStats['total'] }}</p>
                    <p class="text-xs text-gray-500">Reglas</p>
                    <p class="text-xs text-amber-600 font-medium">{{ $reglasStats['activas'] }} activas</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="text-2xl">⏱️</span>
                </div>
                <div class="min-w-0">
                    <p class="text-xl font-bold text-gray-900">{{ number_format($tiempoPromedioSegundos, 1) }}s</p>
                    <p class="text-xs text-gray-500">Tiempo Promedio</p>
                    <p class="text-xs text-gray-400">por trabajo</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos Fila 1 - 3 columnas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-6">Distribución por Estado</h3>
            <div class="h-52 flex items-center justify-center">
                <canvas id="estadosChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-6">Trabajos por Prioridad</h3>
            <div class="h-52 flex items-center justify-center">
                <canvas id="prioridadChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 md:col-span-2 lg:col-span-1">
            <h3 class="text-sm font-semibold text-gray-700 mb-6">Color vs Blanco/Negro</h3>
            <div class="h-52 flex items-center justify-center">
                <canvas id="colorChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Gráficos Fila 2 - 2 columnas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-6">Actividad - Últimos 7 Días</h3>
            <div class="h-60">
                <canvas id="diasChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-6">Top Usuarios</h3>
            <div class="h-60">
                <canvas id="usuariosChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Gráficos Fila 3 - 2 columnas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-6">Estado de Impresoras</h3>
            <div class="h-52 flex items-center justify-center">
                <canvas id="impresorasEstadoChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-6">Carga por Impresora</h3>
            <div class="h-52">
                <canvas id="impresorasChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tablas - 2 columnas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Últimos Trabajos -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-700">Últimos Trabajos</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase px-6 py-3">Usuario</th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase px-6 py-3">Descripción</th>
                            <th class="text-center text-xs font-medium text-gray-500 uppercase px-4 py-3">Pág.</th>
                            <th class="text-center text-xs font-medium text-gray-500 uppercase px-4 py-3">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($ultimosTrabajos as $trabajo)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 text-sm text-gray-900 whitespace-nowrap">{{ $trabajo->usuario->nombre ?? 'N/A' }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600 max-w-[180px] truncate">{{ $trabajo->descripcion }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 text-center">{{ $trabajo->paginas }}</td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $estadoClasses = match($trabajo->estado) {
                                        'Terminado' => 'bg-green-100 text-green-700',
                                        'En Cola' => 'bg-yellow-100 text-yellow-700',
                                        'En Proceso' => 'bg-blue-100 text-blue-700',
                                        'Bloqueado' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $estadoClasses }}">
                                    {{ $trabajo->estado }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">No hay trabajos registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cuotas de Usuarios -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-700">Cuotas de Usuarios</h3>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    @forelse($usuarios->take(6) as $usuario)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 bg-indigo-500 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $usuario->nombre }}</p>
                                <p class="text-xs text-gray-500">{{ $usuario->trabajos_count }} trabajos</p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0 ml-4">
                            @php
                                $cuotaClass = $usuario->cuota_actual > 50 ? 'text-green-600' : ($usuario->cuota_actual > 10 ? 'text-yellow-600' : 'text-red-600');
                            @endphp
                            <p class="text-lg font-bold {{ $cuotaClass }}">{{ $usuario->cuota_actual }}</p>
                            <p class="text-xs text-gray-400">cuota</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-sm text-gray-500 py-8">No hay usuarios registrados</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Motivos de Bloqueo -->
    @if($motivosBloqueo->count() > 0)
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700">⚠️ Motivos de Bloqueo Frecuentes</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($motivosBloqueo as $motivo)
                <div class="flex items-start gap-3 p-4 bg-red-50 border border-red-100 rounded-lg">
                    <span class="text-red-500 flex-shrink-0">🚫</span>
                    <div class="min-w-0">
                        <p class="text-sm text-red-800 break-words">{{ $motivo->motivo_bloqueo }}</p>
                        <p class="text-xs text-red-500 mt-1">{{ $motivo->total }} ocurrencias</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Estado de Impresoras -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700">🖨️ Estado Detallado de Impresoras</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($impresoras as $impresora)
                @php
                    $cardClasses = match($impresora->estado) {
                        'funcional' => 'bg-green-50 border-green-200',
                        'sin_tinta' => 'bg-yellow-50 border-yellow-200',
                        'sin_hojas' => 'bg-orange-50 border-orange-200',
                        default => 'bg-red-50 border-red-200'
                    };
                @endphp
                <div class="p-4 rounded-lg border {{ $cardClasses }}">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-medium text-gray-900 truncate pr-2">{{ $impresora->nombre }}</h4>
                        <span class="text-xl flex-shrink-0">{{ $impresora->icono_estado }}</span>
                    </div>
                    <div class="space-y-1 text-sm">
                        <p class="text-gray-600">Estado: <span class="font-medium capitalize">{{ str_replace('_', ' ', $impresora->estado) }}</span></p>
                        <p class="text-gray-600">Trabajos: <span class="font-medium">{{ $impresora->trabajos_count }}</span></p>
                    </div>
                </div>
                @empty
                <p class="col-span-full text-center text-sm text-gray-500 py-8">No hay impresoras registradas</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script id="chart-data" type="application/json">{!! json_encode($chartData) !!}</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = JSON.parse(document.getElementById('chart-data').textContent);
    
    const defaultFont = { family: 'system-ui, -apple-system, sans-serif', size: 11 };
    
    const defaultOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { padding: 15, usePointStyle: true, font: defaultFont }
            }
        }
    };

    // Estados (Doughnut)
    new Chart(document.getElementById('estadosChart'), {
        type: 'doughnut',
        data: {
            labels: chartData.estadosPie.labels,
            datasets: [{
                data: chartData.estadosPie.data,
                backgroundColor: chartData.estadosPie.colors,
                borderWidth: 0
            }]
        },
        options: {
            ...defaultOptions,
            cutout: '60%',
            plugins: {
                legend: { position: 'right', labels: { padding: 12, usePointStyle: true, font: { size: 11 } } }
            }
        }
    });

    // Prioridad (Bar)
    new Chart(document.getElementById('prioridadChart'), {
        type: 'bar',
        data: {
            labels: chartData.prioridadBar.labels,
            datasets: [{
                data: chartData.prioridadBar.data,
                backgroundColor: chartData.prioridadBar.colors,
                borderRadius: 6,
                borderSkipped: false,
                maxBarThickness: 50
            }]
        },
        options: {
            ...defaultOptions,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { font: defaultFont } },
                x: { grid: { display: false }, ticks: { font: defaultFont } }
            }
        }
    });

    // Color vs B/N (Doughnut)
    new Chart(document.getElementById('colorChart'), {
        type: 'doughnut',
        data: {
            labels: chartData.colorDoughnut.labels,
            datasets: [{
                data: chartData.colorDoughnut.data,
                backgroundColor: chartData.colorDoughnut.colors,
                borderWidth: 0
            }]
        },
        options: { ...defaultOptions, cutout: '60%' }
    });

    // Últimos 7 días (Line)
    new Chart(document.getElementById('diasChart'), {
        type: 'line',
        data: {
            labels: chartData.trabajosDiaLine.labels,
            datasets: [{
                label: 'Trabajos',
                data: chartData.trabajosDiaLine.trabajos,
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#3B82F6',
                borderWidth: 2
            }, {
                label: 'Páginas',
                data: chartData.trabajosDiaLine.paginas,
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#10B981',
                borderWidth: 2
            }]
        },
        options: {
            ...defaultOptions,
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { font: defaultFont } },
                x: { grid: { display: false }, ticks: { font: defaultFont } }
            }
        }
    });

    // Usuarios (Bar horizontal)
    new Chart(document.getElementById('usuariosChart'), {
        type: 'bar',
        data: {
            labels: chartData.usuariosBar.labels,
            datasets: [{
                label: 'Trabajos',
                data: chartData.usuariosBar.trabajos,
                backgroundColor: '#6366F1',
                borderRadius: 4,
                maxBarThickness: 20
            }, {
                label: 'Páginas',
                data: chartData.usuariosBar.paginas,
                backgroundColor: '#A855F7',
                borderRadius: 4,
                maxBarThickness: 20
            }]
        },
        options: {
            ...defaultOptions,
            indexAxis: 'y',
            scales: {
                x: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { font: defaultFont } },
                y: { grid: { display: false }, ticks: { font: defaultFont } }
            }
        }
    });

    // Estado Impresoras (Doughnut)
    new Chart(document.getElementById('impresorasEstadoChart'), {
        type: 'doughnut',
        data: {
            labels: chartData.impresorasEstado.labels,
            datasets: [{
                data: chartData.impresorasEstado.data,
                backgroundColor: chartData.impresorasEstado.colors,
                borderWidth: 0
            }]
        },
        options: { ...defaultOptions, cutout: '55%' }
    });

    // Carga por Impresora (Bar)
    new Chart(document.getElementById('impresorasChart'), {
        type: 'bar',
        data: {
            labels: chartData.impresorasBar.labels,
            datasets: [{
                label: 'Trabajos',
                data: chartData.impresorasBar.trabajos,
                backgroundColor: '#14B8A6',
                borderRadius: 4,
                maxBarThickness: 30
            }, {
                label: 'Páginas',
                data: chartData.impresorasBar.paginas,
                backgroundColor: '#F59E0B',
                borderRadius: 4,
                maxBarThickness: 30
            }]
        },
        options: {
            ...defaultOptions,
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { font: defaultFont } },
                x: { grid: { display: false }, ticks: { font: defaultFont } }
            }
        }
    });
});
</script>
@endsection
