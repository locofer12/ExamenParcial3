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
        
    </div>
</body>
</html>
