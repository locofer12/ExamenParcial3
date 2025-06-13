<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>APIs Dashboard - Laravel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="dashboard-container">
            <div class="dashboard-header">
                <h1 class="dashboard-title">🚀 APIs Dashboard</h1>
                <p class="dashboard-subtitle">Funcionalidades interactivas con Laravel</p>
            </div>
            <div class="bento-grid">
                <!-- 1. Geolocalización -->
                <div class="bento-card geo-card">
                    <div class="card-header-custom">
                        <div class="card-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <h3 class="card-title">Geolocalización</h3>
                    </div>
                    
                    <div class="location-info">
                        <div class="location-item">
                            <div class="location-label">Latitud</div>
                            <div class="location-value" id="lat">Cargando...</div>
                        </div>
                        <div class="location-item">
                            <div class="location-label">Longitud</div>
                            <div class="location-value" id="lon">Cargando...</div>
                        </div>
                    </div>
                    
                    <div id="map"></div>
                </div>

                <!-- 2. Canvas de dibujo -->
                <div class="bento-card canvas-card">
                    <div class="card-header-custom">
                        <div class="card-icon">
                            <i class="bi bi-pencil-fill"></i>
                        </div>
                        <h3 class="card-title">Canvas</h3>
                    </div>
                    
                    <canvas id="canvas" width="300" height="200"></canvas>
                    
                    <div class="canvas-tools">
                        <div class="tool-group">
                            <span class="tool-label">Color:</span>
                            <input type="color" id="colorPicker" value="#6366f1" class="form-control form-control-sm" style="width: 50px; height: 35px;">
                        </div>
                        
                        <div class="tool-group">
                            <span class="tool-label">Grosor:</span>
                            <input type="range" id="grosor" min="1" max="20" value="3" class="form-range">
                        </div>
                    </div>
                    
                    <div class="canvas-buttons">
                        <button id="borrador" class="btn btn-custom btn-secondary-custom btn-sm">
                            <i class="bi bi-eraser-fill"></i> Borrador
                        </button>
                        <button id="boton-guardar" class="btn btn-custom btn-primary-custom btn-sm">
                            <i class="bi bi-download"></i> Guardar
                        </button>
                        <button id="boton-limpiar" class="btn btn-custom btn-danger-custom btn-sm">
                            <i class="bi bi-trash"></i> Limpiar
                        </button>
                    </div>
                </div>

                <!-- 3. Video desde camara -->
                <div class="bento-card camera-card">
                    <div class="card-header-custom">
                        <div class="card-icon">
                            <i class="bi bi-camera-video-fill"></i>
                        </div>
                        <h3 class="card-title">Cámara Web</h3>
                    </div>
                    
                    <div class="camera-content">
                        <div class="camera-preview">
                            <video id="video" width="100%" height="180" autoplay class="rounded"></video>
                            <div class="camera-controls mt-3">
                                <button id="boton-video" class="btn btn-custom btn-success-custom">
                                    <i class="bi bi-camera-fill"></i> Tomar Foto
                                </button>
                                <button id="boton-limpiar-foto" class="btn btn-custom btn-danger-custom d-none">
                                    <i class="bi bi-x-circle-fill"></i> Borrar
                                </button>
                                <button id="boton-guardar-foto" class="btn btn-custom btn-primary-custom d-none">
                                    <i class="bi bi-download"></i> Guardar
                                </button>
                            </div>
                        </div>
                        
                        <div class="camera-result">
                            <canvas id="foto" width="100%" height="180" class="rounded"></canvas>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i> La foto capturada aparecerá aquí
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @vite('resources/css/app.css')
        
        <!-- Librerías externas -->
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        
        @vite('resources/js/app.js')

    </body>
</html>
