@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@stop

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">⚙️ Web Worker - Cálculo Intensivo</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-cpu-fill"></i> Proceso en segundo plano
        </div>
        <div class="card-body">
            <p>Se generarán 100,000 números aleatorios, se mostrarán los primeros 50 números ya ordenados.</p>
            <div class="text-center mb-3">
                <button id="btnCalculo" onclick="iniciarCalculo()" class="btn btn-success">
                    <i class="bi bi-play-fill"></i> Iniciar Cálculo
                </button>
            </div>
            <div id="resultado" class="mt-3"></div>
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
