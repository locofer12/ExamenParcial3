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
                --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                padding: 20px;
            }

            .dashboard-container {
                max-width: 1400px;
                margin: 0 auto;
            }

            .dashboard-header {
                text-align: center;
                margin-bottom: 40px;
                color: white;
            }

            .dashboard-title {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 10px;
                text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .dashboard-subtitle {
                font-size: 1.1rem;
                opacity: 0.9;
                font-weight: 400;
            }

            .bento-grid {
                display: grid;
                grid-template-columns: repeat(12, 1fr);
                grid-template-rows: repeat(8, 100px);
                gap: 20px;
                width: 100%;
            }

            .bento-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: var(--border-radius);
                box-shadow: var(--shadow-lg);
                padding: 24px;
                transition: var(--transition);
                border: 1px solid rgba(255, 255, 255, 0.2);
                position: relative;
                overflow: hidden;
            }

            .bento-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            .bento-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: var(--gradient);
            }

            .card-header-custom {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 20px;
                padding-bottom: 16px;
                border-bottom: 2px solid #f1f5f9;
            }

            .card-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                color: white;
            }

            .card-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--dark-color);
                margin: 0;
            }

            .geo-card {
                grid-column: span 8;
                grid-row: span 4;
                --gradient: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            }

            .geo-card .card-icon {
                background: var(--primary-color);
            }

            #map {
                width: 100%;
                height: 250px;
                border-radius: 12px;
                box-shadow: var(--shadow);
            }

            .location-info {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 16px;
                margin-bottom: 20px;
            }

            .location-item {
                background: #f8fafc;
                padding: 12px 16px;
                border-radius: 8px;
                border-left: 4px solid var(--primary-color);
            }

            .location-label {
                font-size: 0.875rem;
                color: #64748b;
                margin-bottom: 4px;
            }

            .location-value {
                font-size: 1rem;
                font-weight: 600;
                color: var(--dark-color);
            }

            .canvas-card {
                grid-column: span 4;
                grid-row: span 6;
                --gradient: linear-gradient(90deg, var(--secondary-color), var(--warning-color));
            }

            .canvas-card .card-icon {
                background: var(--secondary-color);
            }

            #canvas {
                width: 100%;
                height: 200px;
                border: 2px solid #e2e8f0;
                border-radius: 8px;
                cursor: crosshair;
                margin-bottom: 16px;
            }

            .canvas-tools {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .tool-group {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .tool-label {
                font-size: 0.875rem;
                font-weight: 500;
                color: var(--dark-color);
                min-width: 50px;
            }

            .canvas-buttons {
                display: flex;
                flex-direction: column;
                gap: 8px;
                margin-top: 16px;
            }

            .camera-card {
                grid-column: span 8;
                grid-row: span 4;
                --gradient: linear-gradient(90deg, var(--success-color), var(--primary-color));
            }

            .camera-card .card-icon {
                background: var(--success-color);
            }

            .camera-content {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                align-items: start;
            }

            #video, #foto {
                width: 100%;
                height: 180px;
                border-radius: 8px;
                border: 2px solid #e2e8f0;
            }

            .camera-controls {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .btn-custom {
                border-radius: 8px;
                font-weight: 500;
                padding: 8px 16px;
                border: none;
                transition: var(--transition);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .btn-primary-custom {
                background: var(--primary-color);
                color: white;
            }

            .btn-primary-custom:hover {
                background: #4f46e5;
                transform: translateY(-1px);
            }

            .btn-success-custom {
                background: var(--success-color);
                color: white;
            }

            .btn-success-custom:hover {
                background: #059669;
                transform: translateY(-1px);
            }

            .btn-danger-custom {
                background: var(--danger-color);
                color: white;
            }

            .btn-danger-custom:hover {
                background: #dc2626;
                transform: translateY(-1px);
            }

            .btn-secondary-custom {
                background: #6b7280;
                color: white;
            }

            .btn-secondary-custom:hover {
                background: #4b5563;
                transform: translateY(-1px);
            }

            @media (max-width: 1200px) {
                .bento-grid {
                    grid-template-columns: repeat(8, 1fr);
                }
                
                .geo-card {
                    grid-column: span 8;
                    grid-row: span 4;
                }
                
                .canvas-card {
                    grid-column: span 4;
                    grid-row: span 6;
                }
                
                .camera-card {
                    grid-column: span 4;
                    grid-row: span 6;
                }
            }

            @media (max-width: 768px) {
                .bento-grid {
                    grid-template-columns: 1fr;
                    grid-template-rows: auto;
                    gap: 16px;
                }
                
                .bento-card {
                    grid-column: span 1 !important;
                    grid-row: auto !important;
                    padding: 20px;
                }
                
                .camera-content {
                    grid-template-columns: 1fr;
                    gap: 16px;
                }
                
                .location-info {
                    grid-template-columns: 1fr;
                }
                
                .dashboard-title {
                    font-size: 2rem;
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .bento-card {
                animation: fadeInUp 0.6s ease-out;
            }

            .bento-card:nth-child(1) { animation-delay: 0.1s; }
            .bento-card:nth-child(2) { animation-delay: 0.2s; }
            .bento-card:nth-child(3) { animation-delay: 0.3s; }
        </style>
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
