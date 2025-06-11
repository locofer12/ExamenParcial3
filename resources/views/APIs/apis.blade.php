<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>APIs en Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">🎯 Funcionalidades con APIs en Laravel</h2>

        <!-- 1. Geolocalización -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-geo-alt-fill"></i> Geolocalización
            </div>
            <div class="card-body">
                <p>Tu ubicación actual:</p>
                <ul>
                    <li><strong>Latitud:</strong> <span id="lat"></span></li>
                    <li><strong>Longitud:</strong> <span id="lon"></span></li>
                </ul>
                <div id="map" class="rounded"></div>
            </div>
        </div>

        <!-- 2. Canvas de dibujo -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-secondary text-white">
                <i class="bi bi-pencil-fill"></i> Dibujo en Canvas
            </div>
            <div class="card-body">
                <p>Usa el mouse para dibujar líneas negras:</p>
                <canvas id="canvas" width="500" height="300" class="rounded mb-3"></canvas><br>

                <button id="boton-guardar" class="btn btn-outline-primary">
                    <i class="bi bi-save"></i> Guardar como JPG
                </button>
                <button id="boton-limpiar" class="btn btn-outline-danger">
                    <i class="bi bi-eraser"></i> Limpiar Canvas
                </button>
            </div>
        </div>

        <!-- 3. Video desde camara -->
        <div class="card mb-5 shadow-sm ">
            <div class="card-header bg-negro-mate">
                <i class="bi bi-camera-video-fill"></i> Cámara Web
            </div>
            <div class="card-body text-center">
                <p>Captura una imagen desde tu cámara:</p>

                <video id="video" width="320" height="240" autoplay class="rounded border mb-3"></video><br>

                <button id="boton-video" class="btn btn-outline-success mb-3">
                    <i class="bi bi-camera-fill"></i> Tomar Foto
                </button><br>

                <canvas id="foto" width="320" height="240" class="rounded"></canvas>
            </div>
        </div>

    </div>
</body>
</html>
@vite('resources/css/app.css')
<!-- Librerías externas -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@vite('resources/js/app.js')
