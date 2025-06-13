@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --border-radius: 16px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            padding: 2rem;
        }

        .dashboard-title {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .bento-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow);
            transition: var(--transition);
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
        }

        .bento-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            border: none;
        }

        .header-icon {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        .btn-custom {
            background: linear-gradient(135deg, var(--success-color), #059669);
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            color: white;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 auto;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(16, 185, 129, 0.2);
        }

        .btn-custom:disabled {
            background: linear-gradient(135deg, #9ca3af, #6b7280);
        }

        .resultado-container {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .alert {
            border-radius: 12px;
            padding: 1.5rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #065f46;
        }

        pre {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            border: 1px solid #e5e7eb;
            overflow-x: auto;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
@stop

@section('content')
<div class="container">
    <h2 class="dashboard-title text-center">⚙️ Web Worker - Cálculo Intensivo</h2>
    
    <div class="bento-card">
        <div class="card-header-custom">
            <i class="bi bi-cpu-fill header-icon"></i>
            <h3 class="m-0">Proceso en segundo plano</h3>
        </div>
        
        <div class="card-body">
            <p class="lead text-center mb-4">Se generarán 100,000 números aleatorios, se mostrarán los primeros 50 números ya ordenados.</p>
            
            <div class="text-center">
                <button id="btnCalculo" onclick="iniciarCalculo()" class="btn btn-custom">
                    <i class="bi bi-play-fill"></i> Iniciar Cálculo
                </button>
            </div>
            
            <div id="resultado" class="resultado-container"></div>
        </div>
    </div>
</div>
@endsection

@section('archivos-js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function iniciarCalculo() {
        const numeros = Array.from({ length: 100000 }, () => Math.floor(Math.random() * 100000));
        const resultadoDiv = document.getElementById("resultado");
        const btn = document.getElementById("btnCalculo");

        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Calculando...';
        resultadoDiv.innerHTML = `
            <div class="d-flex justify-content-center my-3">
                <div class="spinner-border text-primary" role="status"></div>
            </div>
            <p class="text-center">Procesando, por favor espera...</p>
        `;

        if (typeof(Worker) !== "undefined") {
            const inicio = performance.now();
            const worker = new Worker("{{ asset('js/webworker/worker.js') }}");

            worker.onmessage = function(e) {
                const fin = performance.now();
                const tiempo = ((fin - inicio) / 1000).toFixed(2);

                if (e.data.error) {
                    resultadoDiv.innerHTML = `<div class="alert alert-danger">❌ Error: ${e.data.error}</div>`;
                } else {
                    resultadoDiv.innerHTML = `
                        <div class="alert alert-success">
                            <p><strong>🧮 Primeros 50 números ordenados:</strong></p>
                            <pre>${e.data.join(", ")}</pre>
                            <p class="mt-2">✅ Cálculo completado en <strong>${tiempo}</strong> segundos.</p>
                        </div>
                    `;
                }

                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-play-fill"></i> Iniciar Cálculo';
            };

            worker.onerror = function(err) {
                resultadoDiv.innerHTML = `<div class="alert alert-danger">❌ Error en el Worker: ${err.message}</div>`;
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-play-fill"></i> Iniciar Cálculo';
            };

            worker.postMessage(numeros);
        } else {
            resultadoDiv.innerHTML = `<div class="alert alert-warning">⚠️ Tu navegador no soporta Web Workers.</div>`;
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-play-fill"></i> Iniciar Cálculo';
        }
    }
</script>
@endsection
