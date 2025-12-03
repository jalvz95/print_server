@extends('layouts.app')

@section('title', 'CUPS Backend Diagram')

@section('content')
<div x-data="cupsBackendSimulation()" x-init="init()">
    <!-- Header -->
    <div class="bg-purple-50 border-l-4 border-purple-400 p-4 mb-6 rounded">
        <div class="flex items-center">
            <div class="text-3xl mr-3">🐧</div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">CUPS Backend Diagram</h1>
                <p class="text-sm text-gray-600 mt-1">Simulación del flujo de procesamiento de documentos en CUPS (Common Unix Printing System)</p>
            </div>
        </div>
        <a href="{{ route('tipo-servidor.index') }}" class="text-sm text-purple-600 hover:text-purple-800 mt-2 inline-block">← Volver a selección de tipos</a>
    </div>

    <!-- Controles de Simulación -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-wrap items-center gap-4">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Formato de entrada</label>
                <select x-model="inputFormat" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="text">📄 Text</option>
                    <option value="pdf">📕 PDF</option>
                    <option value="hpgl">📐 HP/GL</option>
                    <option value="raster">🖼️ Raster Image</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Backend de salida</label>
                <select x-model="outputBackend" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <optgroup label="Local Connections">
                        <option value="parallel">Parallel</option>
                        <option value="serial">Serial</option>
                        <option value="usb">USB</option>
                        <option value="ieee1394">IEEE-1394</option>
                    </optgroup>
                    <optgroup label="Network Connections">
                        <option value="ipp">IPP</option>
                        <option value="lprlpd">LPR/LPD</option>
                        <option value="smb">SMB/CIFS</option>
                        <option value="jetdirect">AppSocket/JetDirect</option>
                        <option value="appletalk">NetATalk/AppleTalk</option>
                    </optgroup>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Filtro de salida</label>
                <select x-model="outputFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="pcl">PCL</option>
                    <option value="escp">ESC/P</option>
                    <option value="dymo">Dymo</option>
                    <option value="gutenprint">Gutenprint</option>
                    <option value="turboprint">TurboPrint</option>
                </select>
            </div>
            <div class="flex items-end">
                <button @click="startSimulation()" 
                        :disabled="isRunning"
                        class="bg-purple-600 hover:bg-purple-700 disabled:bg-gray-400 text-white px-6 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
                    <span x-show="!isRunning">▶️ Iniciar Simulación</span>
                    <span x-show="isRunning">⏳ Procesando...</span>
                </button>
            </div>
            <div class="flex items-end">
                <button @click="resetSimulation()" 
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                    🔄 Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Diagrama Principal -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6 overflow-x-auto">
        <div class="min-w-[1000px]">
            <!-- Nivel 1: Aplicación Linux/UNIX -->
            <div class="flex justify-center mb-6">
                <div class="bg-gray-100 border-2 border-gray-400 rounded-lg px-8 py-4 text-center" :class="{'ring-4 ring-purple-400 bg-purple-50': currentStep === 'app'}">
                    <div class="text-2xl mb-1">🖥️</div>
                    <div class="font-semibold text-gray-800">Linux/UNIX Application Programs</div>
                    <div class="text-xs text-gray-500 mt-1">Origen del documento</div>
                </div>
            </div>

            <!-- Flechas hacia Input Formats -->
            <div class="flex justify-center mb-2">
                <svg class="w-full h-8" style="max-width: 600px;">
                    <line x1="50%" y1="0" x2="12.5%" y2="100%" stroke="#9CA3AF" stroke-width="2" marker-end="url(#arrowhead)"/>
                    <line x1="50%" y1="0" x2="37.5%" y2="100%" stroke="#9CA3AF" stroke-width="2" marker-end="url(#arrowhead)"/>
                    <line x1="50%" y1="0" x2="62.5%" y2="100%" stroke="#9CA3AF" stroke-width="2" marker-end="url(#arrowhead)"/>
                    <line x1="50%" y1="0" x2="87.5%" y2="100%" stroke="#9CA3AF" stroke-width="2" marker-end="url(#arrowhead)"/>
                    <defs>
                        <marker id="arrowhead" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                            <polygon points="0 0, 10 3.5, 0 7" fill="#9CA3AF"/>
                        </marker>
                    </defs>
                </svg>
            </div>

            <!-- Nivel 2: Input Formats -->
            <div class="mb-2">
                <div class="text-xs text-gray-500 font-medium mb-2 ml-2">Input Formats</div>
                <div class="grid grid-cols-4 gap-4">
                    <div class="border-2 rounded-lg p-3 text-center transition-all duration-300"
                         :class="inputFormat === 'text' ? 'border-blue-500 bg-blue-50 ring-2 ring-blue-300' : 'border-gray-300 bg-white'">
                        <div class="text-xl">📄</div>
                        <div class="text-sm font-medium">Text</div>
                        <div class="text-xs text-gray-400 mt-1">text/plain</div>
                    </div>
                    <div class="border-2 rounded-lg p-3 text-center transition-all duration-300"
                         :class="inputFormat === 'pdf' ? 'border-red-500 bg-red-50 ring-2 ring-red-300' : 'border-gray-300 bg-white'">
                        <div class="text-xl">📕</div>
                        <div class="text-sm font-medium">PDF</div>
                        <div class="text-xs text-gray-400 mt-1">application/pdf</div>
                    </div>
                    <div class="border-2 rounded-lg p-3 text-center transition-all duration-300"
                         :class="inputFormat === 'hpgl' ? 'border-green-500 bg-green-50 ring-2 ring-green-300' : 'border-gray-300 bg-white'">
                        <div class="text-xl">📐</div>
                        <div class="text-sm font-medium">HP/GL</div>
                        <div class="text-xs text-gray-400 mt-1">application/vnd.hp-HPGL</div>
                    </div>
                    <div class="border-2 rounded-lg p-3 text-center transition-all duration-300"
                         :class="inputFormat === 'raster' ? 'border-orange-500 bg-orange-50 ring-2 ring-orange-300' : 'border-gray-300 bg-white'">
                        <div class="text-xl">🖼️</div>
                        <div class="text-sm font-medium">Raster Images</div>
                        <div class="text-xs text-gray-400 mt-1">image/*</div>
                    </div>
                </div>
            </div>

            <!-- Pre-Filters Labels -->
            <div class="grid grid-cols-4 gap-4 mb-1">
                <div class="text-center text-xs text-purple-600 font-medium" x-show="currentStep === 'prefilter' && inputFormat === 'text'">⬇️ text-to-ps</div>
                <div class="text-center text-xs text-purple-600 font-medium" x-show="currentStep === 'prefilter' && inputFormat === 'pdf'">⬇️ pdf-to-ps</div>
                <div class="text-center text-xs text-purple-600 font-medium" x-show="currentStep === 'prefilter' && inputFormat === 'hpgl'">⬇️ hpgl-to-ps</div>
                <div class="text-center text-xs text-purple-600 font-medium" x-show="currentStep === 'prefilter' && inputFormat === 'raster'">⬇️ image-to-ps</div>
            </div>

            <!-- Nivel 3: PostScript (Primera etapa) -->
            <div class="flex justify-center my-4">
                <div class="border-2 rounded-lg p-4 text-center w-80 transition-all duration-300"
                     :class="currentStep === 'postscript1' ? 'border-purple-500 bg-purple-100 ring-4 ring-purple-300' : 'border-gray-400 bg-gray-50'">
                    <div class="font-bold text-gray-800">PostScript</div>
                    <div class="text-xs text-gray-500 italic">Mime type:</div>
                    <div class="text-sm font-mono bg-white rounded px-2 py-1 mt-1">application/postscript</div>
                </div>
            </div>

            <!-- ps-to-ps filter -->
            <div class="flex justify-center mb-1">
                <div class="text-xs text-purple-600 font-medium" x-show="currentStep === 'psfilter'">⬇️ ps-to-ps (normalización)</div>
            </div>

            <!-- Nivel 4: PostScript (Segunda etapa) -->
            <div class="flex justify-center my-4">
                <div class="border-2 rounded-lg p-4 text-center w-80 transition-all duration-300"
                     :class="currentStep === 'postscript2' ? 'border-purple-500 bg-purple-100 ring-4 ring-purple-300' : 'border-gray-400 bg-gray-50'">
                    <div class="font-bold text-gray-800">PostScript</div>
                    <div class="text-xs text-gray-500 italic">Mime type:</div>
                    <div class="text-sm font-mono bg-white rounded px-2 py-1 mt-1">application/vnd.postscript</div>
                </div>
            </div>

            <!-- Foomatic/Ghostscript path -->
            <div class="flex justify-center items-center gap-8 my-4">
                <div class="text-xs text-purple-600 font-medium" x-show="currentStep === 'rasterize'">⬇️ ps-to-raster</div>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-3 text-center text-xs"
                     :class="currentStep === 'ghostscript' ? 'border-orange-400 bg-orange-50' : ''">
                    <div class="font-medium text-gray-600">CUPS-external</div>
                    <div class="text-gray-500">Ghostscript</div>
                    <div class="text-gray-400">(o AFPL Ghostscript)</div>
                </div>
            </div>

            <!-- Nivel 5: CUPS-raster -->
            <div class="flex justify-center my-4">
                <div class="border-2 rounded-lg p-4 text-center w-96 transition-all duration-300"
                     :class="currentStep === 'raster' ? 'border-cyan-500 bg-cyan-100 ring-4 ring-cyan-300' : 'border-gray-400 bg-gray-50'">
                    <div class="font-bold text-gray-800">CUPS-raster</div>
                    <div class="text-xs text-gray-500 italic">MIME type:</div>
                    <div class="text-sm font-mono bg-white rounded px-2 py-1 mt-1">application/vnd.cups-raster</div>
                </div>
            </div>

            <!-- Nivel 6: Output Filters -->
            <div class="mb-2">
                <div class="text-xs text-gray-500 font-medium mb-2 ml-2">Raster to Device Filters</div>
                <div class="grid grid-cols-5 gap-3">
                    <div class="border-2 rounded-lg p-3 text-center transition-all duration-300"
                         :class="outputFilter === 'pcl' && currentStep === 'output' ? 'border-green-500 bg-green-100 ring-2 ring-green-300' : 'border-gray-300 bg-white'">
                        <div class="text-xs text-gray-400">Raster-to-PCL</div>
                        <div class="text-sm font-bold mt-1">PCL</div>
                    </div>
                    <div class="border-2 rounded-lg p-3 text-center transition-all duration-300"
                         :class="outputFilter === 'escp' && currentStep === 'output' ? 'border-green-500 bg-green-100 ring-2 ring-green-300' : 'border-gray-300 bg-white'">
                        <div class="text-xs text-gray-400">Raster-to-ESC/P</div>
                        <div class="text-sm font-bold mt-1">ESC/P</div>
                    </div>
                    <div class="border-2 rounded-lg p-3 text-center transition-all duration-300"
                         :class="outputFilter === 'dymo' && currentStep === 'output' ? 'border-green-500 bg-green-100 ring-2 ring-green-300' : 'border-gray-300 bg-white'">
                        <div class="text-xs text-gray-400">Raster-to-Dymo</div>
                        <div class="text-sm font-bold mt-1">Dymo</div>
                    </div>
                    <div class="border-2 rounded-lg p-3 text-center transition-all duration-300"
                         :class="outputFilter === 'gutenprint' && currentStep === 'output' ? 'border-green-500 bg-green-100 ring-2 ring-green-300' : 'border-gray-300 bg-white'">
                        <div class="text-xs text-gray-400">Raster-to-printer</div>
                        <div class="text-sm font-bold mt-1">Gutenprint</div>
                    </div>
                    <div class="border-2 rounded-lg p-3 text-center transition-all duration-300"
                         :class="outputFilter === 'turboprint' && currentStep === 'output' ? 'border-green-500 bg-green-100 ring-2 ring-green-300' : 'border-gray-300 bg-white'">
                        <div class="text-xs text-gray-400">Raster-to-TurboPrint</div>
                        <div class="text-sm font-bold mt-1">TurboPrint</div>
                    </div>
                </div>
            </div>

            <!-- Nivel 7: CUPS Backends -->
            <div class="mt-6 border-2 border-gray-400 rounded-lg p-4 transition-all duration-300"
                 :class="currentStep === 'backend' ? 'border-blue-500 bg-blue-50' : 'bg-gray-50'">
                <div class="text-center font-bold text-gray-800 mb-4">CUPS Backends</div>
                <div class="text-center text-xs text-gray-500 mb-4">(transfer print commands to print devices)</div>
                
                <div class="grid grid-cols-2 gap-4">
                    <!-- Local Connections -->
                    <div class="border border-gray-300 rounded-lg p-3">
                        <div class="text-sm font-medium text-gray-700 mb-3 text-center">Local Connections</div>
                        <div class="grid grid-cols-4 gap-2">
                            <div class="border rounded p-2 text-center text-xs transition-all duration-300"
                                 :class="outputBackend === 'parallel' && currentStep === 'backend' ? 'border-blue-500 bg-blue-100 ring-2 ring-blue-300' : 'border-gray-200 bg-white'">
                                Parallel
                            </div>
                            <div class="border rounded p-2 text-center text-xs transition-all duration-300"
                                 :class="outputBackend === 'serial' && currentStep === 'backend' ? 'border-blue-500 bg-blue-100 ring-2 ring-blue-300' : 'border-gray-200 bg-white'">
                                Serial
                            </div>
                            <div class="border rounded p-2 text-center text-xs transition-all duration-300"
                                 :class="outputBackend === 'usb' && currentStep === 'backend' ? 'border-blue-500 bg-blue-100 ring-2 ring-blue-300' : 'border-gray-200 bg-white'">
                                USB
                            </div>
                            <div class="border rounded p-2 text-center text-xs transition-all duration-300"
                                 :class="outputBackend === 'ieee1394' && currentStep === 'backend' ? 'border-blue-500 bg-blue-100 ring-2 ring-blue-300' : 'border-gray-200 bg-white'">
                                IEEE-1394
                            </div>
                        </div>
                    </div>
                    
                    <!-- Network Connections -->
                    <div class="border border-gray-300 rounded-lg p-3">
                        <div class="text-sm font-medium text-gray-700 mb-3 text-center">Network Connections</div>
                        <div class="grid grid-cols-5 gap-2">
                            <div class="border rounded p-2 text-center text-xs transition-all duration-300"
                                 :class="outputBackend === 'ipp' && currentStep === 'backend' ? 'border-blue-500 bg-blue-100 ring-2 ring-blue-300' : 'border-gray-200 bg-white'">
                                IPP
                            </div>
                            <div class="border rounded p-2 text-center text-xs transition-all duration-300"
                                 :class="outputBackend === 'lprlpd' && currentStep === 'backend' ? 'border-blue-500 bg-blue-100 ring-2 ring-blue-300' : 'border-gray-200 bg-white'">
                                LPR/LPD
                            </div>
                            <div class="border rounded p-2 text-center text-xs transition-all duration-300"
                                 :class="outputBackend === 'smb' && currentStep === 'backend' ? 'border-blue-500 bg-blue-100 ring-2 ring-blue-300' : 'border-gray-200 bg-white'">
                                SMB/CIFS
                            </div>
                            <div class="border rounded p-2 text-center text-xs transition-all duration-300"
                                 :class="outputBackend === 'jetdirect' && currentStep === 'backend' ? 'border-blue-500 bg-blue-100 ring-2 ring-blue-300' : 'border-gray-200 bg-white'">
                                JetDirect
                            </div>
                            <div class="border rounded p-2 text-center text-xs transition-all duration-300"
                                 :class="outputBackend === 'appletalk' && currentStep === 'backend' ? 'border-blue-500 bg-blue-100 ring-2 ring-blue-300' : 'border-gray-200 bg-white'">
                                AppleTalk
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nivel 8: Impresoras -->
            <div class="flex justify-center gap-8 mt-6" x-show="currentStep === 'printer'">
                <div class="text-center animate-bounce">
                    <div class="text-4xl">🖨️</div>
                    <div class="text-xs text-gray-500 mt-1">Impresora</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Log de Proceso -->
    <div class="bg-gray-900 rounded-lg shadow-lg p-4 mb-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-semibold text-gray-300">📋 Log de Procesamiento CUPS</h3>
            <span class="text-xs text-gray-500">cupsd</span>
        </div>
        <div class="font-mono text-xs space-y-1 max-h-48 overflow-y-auto" id="log-container">
            <template x-for="(log, index) in logs" :key="index">
                <div :class="log.type === 'info' ? 'text-cyan-400' : log.type === 'success' ? 'text-green-400' : log.type === 'warning' ? 'text-yellow-400' : 'text-gray-400'">
                    <span class="text-gray-500" x-text="log.time"></span>
                    <span x-text="log.message"></span>
                </div>
            </template>
            <div x-show="logs.length === 0" class="text-gray-500">Esperando inicio de simulación...</div>
        </div>
    </div>

    <!-- Explicación del Diagrama -->
    <div class="bg-white rounded-lg shadow-sm p-6 border-2 border-purple-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">📚 Explicación del Flujo CUPS</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-purple-700 mb-2">1. Input Formats (Formatos de Entrada)</h4>
                <p class="text-sm text-gray-600 mb-4">CUPS acepta múltiples formatos: texto plano, PDF, HP/GL (gráficos vectoriales), e imágenes raster (PNG, JPEG, etc.).</p>
                
                <h4 class="font-medium text-purple-700 mb-2">2. Pre-Filters (Pre-Filtros)</h4>
                <p class="text-sm text-gray-600 mb-4">Cada formato se convierte a PostScript usando filtros específicos: <code class="bg-gray-100 px-1 rounded">text-to-ps</code>, <code class="bg-gray-100 px-1 rounded">pdf-to-ps</code>, <code class="bg-gray-100 px-1 rounded">hpgl-to-ps</code>, <code class="bg-gray-100 px-1 rounded">image-to-ps</code>.</p>
                
                <h4 class="font-medium text-purple-700 mb-2">3. PostScript Processing</h4>
                <p class="text-sm text-gray-600 mb-4">El documento pasa por dos etapas PostScript: primero <code class="bg-gray-100 px-1 rounded">application/postscript</code> y luego se normaliza a <code class="bg-gray-100 px-1 rounded">application/vnd.postscript</code>.</p>
            </div>
            
            <div>
                <h4 class="font-medium text-purple-700 mb-2">4. CUPS-raster</h4>
                <p class="text-sm text-gray-600 mb-4">El filtro <code class="bg-gray-100 px-1 rounded">ps-to-raster</code> convierte PostScript al formato raster nativo de CUPS, que puede usar Ghostscript externamente.</p>
                
                <h4 class="font-medium text-purple-700 mb-2">5. Device Filters (Filtros de Dispositivo)</h4>
                <p class="text-sm text-gray-600 mb-4">El raster se convierte al lenguaje nativo de la impresora: PCL, ESC/P, Dymo, o usando drivers como Gutenprint o TurboPrint.</p>
                
                <h4 class="font-medium text-purple-700 mb-2">6. CUPS Backends</h4>
                <p class="text-sm text-gray-600">Finalmente, el trabajo se envía a la impresora via conexiones locales (USB, Parallel, Serial) o de red (IPP, LPR/LPD, SMB/CIFS, JetDirect, AppleTalk).</p>
            </div>
        </div>
    </div>
</div>

<script>
function cupsBackendSimulation() {
    return {
        inputFormat: 'pdf',
        outputBackend: 'ipp',
        outputFilter: 'pcl',
        currentStep: '',
        isRunning: false,
        logs: [],

        init() {
            this.addLog('info', 'CUPS Backend Diagram cargado. Selecciona opciones e inicia la simulación.');
        },

        addLog(type, message) {
            const now = new Date();
            const time = now.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            this.logs.push({ type, message, time: `[${time}]` });
            
            // Auto-scroll
            this.$nextTick(() => {
                const container = document.getElementById('log-container');
                if (container) container.scrollTop = container.scrollHeight;
            });
        },

        async startSimulation() {
            if (this.isRunning) return;
            this.isRunning = true;
            this.logs = [];

            const formatNames = {
                'text': 'Text (text/plain)',
                'pdf': 'PDF (application/pdf)',
                'hpgl': 'HP/GL (application/vnd.hp-HPGL)',
                'raster': 'Raster Image (image/*)'
            };

            const filterNames = {
                'text': 'texttops',
                'pdf': 'pdftops',
                'hpgl': 'hpgltops',
                'raster': 'imagetops'
            };

            // Step 1: Application
            this.currentStep = 'app';
            this.addLog('info', `Documento recibido desde aplicación Linux/UNIX`);
            this.addLog('info', `Formato de entrada: ${formatNames[this.inputFormat]}`);
            await this.delay(1000);

            // Step 2: Pre-filter
            this.currentStep = 'prefilter';
            this.addLog('info', `Ejecutando pre-filtro: ${filterNames[this.inputFormat]}`);
            this.addLog('warning', `Convirtiendo ${this.inputFormat.toUpperCase()} → PostScript...`);
            await this.delay(1200);

            // Step 3: PostScript 1
            this.currentStep = 'postscript1';
            this.addLog('success', `Conversión completada: application/postscript`);
            await this.delay(800);

            // Step 4: PS Filter
            this.currentStep = 'psfilter';
            this.addLog('info', `Ejecutando filtro: pstops (normalización)`);
            await this.delay(800);

            // Step 5: PostScript 2
            this.currentStep = 'postscript2';
            this.addLog('success', `PostScript normalizado: application/vnd.postscript`);
            await this.delay(800);

            // Step 6: Rasterize
            this.currentStep = 'rasterize';
            this.addLog('info', `Ejecutando filtro: pstoraster`);
            this.addLog('info', `Invocando Ghostscript para rasterización...`);
            await this.delay(1200);

            // Step 7: Raster
            this.currentStep = 'raster';
            this.addLog('success', `Rasterización completada: application/vnd.cups-raster`);
            await this.delay(800);

            // Step 8: Output filter
            this.currentStep = 'output';
            const filterMap = {
                'pcl': 'rastertopclx',
                'escp': 'rastertoepson',
                'dymo': 'rastertodymo',
                'gutenprint': 'rastertogutenprint',
                'turboprint': 'rastertoturboprint'
            };
            this.addLog('info', `Ejecutando filtro de salida: ${filterMap[this.outputFilter]}`);
            this.addLog('warning', `Convirtiendo raster → ${this.outputFilter.toUpperCase()}...`);
            await this.delay(1000);

            // Step 9: Backend
            this.currentStep = 'backend';
            const backendMap = {
                'parallel': 'parallel:/dev/lp0',
                'serial': 'serial:/dev/ttyS0',
                'usb': 'usb://HP/LaserJet',
                'ieee1394': 'ieee1394://printer',
                'ipp': 'ipp://printer.local:631/ipp/print',
                'lprlpd': 'lpd://printserver/queue',
                'smb': 'smb://server/printer',
                'jetdirect': 'socket://192.168.1.100:9100',
                'appletalk': 'pap://printer'
            };
            this.addLog('success', `Filtro de salida completado`);
            this.addLog('info', `Enviando al backend: ${backendMap[this.outputBackend]}`);
            await this.delay(1000);

            // Step 10: Printer
            this.currentStep = 'printer';
            this.addLog('success', `✅ Trabajo enviado exitosamente a la impresora`);
            this.addLog('info', `Backend: ${this.outputBackend.toUpperCase()}`);

            await this.delay(1500);
            this.isRunning = false;
        },

        resetSimulation() {
            this.currentStep = '';
            this.logs = [];
            this.isRunning = false;
            this.addLog('info', 'Simulación reiniciada. Listo para nueva ejecución.');
        },

        delay(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
    }
}
</script>
@endsection
