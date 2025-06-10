@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
@stop

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Web Worker - Cálculo Intensivo</h1>
    </section>

    <section class="content">
        <div class="card card-primary">
            <div class="card-body">
                <button onclick="iniciarCalculo()" class="btn btn-primary">Iniciar Cálculo</button>
                <div id="resultado" style="margin-top: 20px;"></div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('archivos-js')
<script>
    function iniciarCalculo() {
        const numeros = Array.from({ length: 100000 }, () => Math.floor(Math.random() * 100000));
        const resultadoDiv = document.getElementById("resultado");
        resultadoDiv.innerHTML = "Calculando...";

        if (typeof(Worker) !== "undefined") {
            const worker = new Worker("{{ asset('js/worker.js') }}");

            worker.onmessage = function(e) {
                if (e.data.error) {
                    resultadoDiv.innerHTML = "Error: " + e.data.error;
                } else {
                    resultadoDiv.innerHTML = `<p><strong>Primeros 50 números ordenados:</strong></p><pre>${e.data.join(", ")}</pre>`;
                }
            };

            worker.onerror = function(err) {
                resultadoDiv.innerHTML = "Error en el Worker: " + err.message;
            };

            worker.postMessage(numeros);
        } else {
            resultadoDiv.innerHTML = "Tu navegador no soporta Web Workers.";
        }
    }
</script>
@endsection
