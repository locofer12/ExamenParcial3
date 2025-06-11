import './bootstrap';
// Geolocalización
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        document.getElementById('lat').innerText = lat;
        document.getElementById('lon').innerText = lon;

        const map = L.map('map').setView([lat, lon], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        L.marker([lat, lon]).addTo(map).bindPopup('Tu ubicación actual').openPopup();
    }, function (error) {
        alert('Error al obtener ubicación: ' + error.message);
    });
} else {
    alert("Tu navegador no soporta geolocalización.");
}

// Canvas 
const canvas = document.getElementById('canvas'); 
const ctx = canvas.getContext('2d'); 

ctx.fillStyle = "#ffffff"; 
ctx.fillRect(0, 0, canvas.width, canvas.height); 
 
let dibujando = false; 
 
canvas.addEventListener('mousedown', () => { 
    dibujando = true; 
    ctx.beginPath(); 
}); 
canvas.addEventListener('mouseup', () => { 
    dibujando = false; 
    ctx.closePath(); 
}); 
canvas.addEventListener('mousemove', dibujar); 
 
function dibujar(e) { 
    if (!dibujando) return; 
    ctx.lineWidth = 2; 
    ctx.lineCap = 'round'; 
    ctx.strokeStyle = 'black'; 
    ctx.lineTo(e.offsetX, e.offsetY); 
    ctx.stroke(); 
    ctx.beginPath(); 
    ctx.moveTo(e.offsetX, e.offsetY); 
} 

function guardarCanvas() { 
    const link = document.createElement('a'); 
    link.download = 'dibujo.jpg'; 
    link.href = canvas.toDataURL('image/jpeg'); 
    link.click(); 
}

function limpiarCanvas() {
    // Limpia el canvas llenándolo de blanco
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
}

// Video
const video = document.getElementById('video');
const fotoCanvas = document.getElementById('foto');
const fotoCtx = fotoCanvas.getContext('2d');

navigator.mediaDevices.getUserMedia({ video: true })
  .then(stream => video.srcObject = stream)
  .catch(error => alert('No se pudo acceder a la cámara: ' + error.message));
function tomarFoto() {
  fotoCtx.drawImage(video, 0, 0, fotoCanvas.width, fotoCanvas.height);
  const link = document.createElement('a'); 
  link.download = 'captura.jpg'; 
  link.href = fotoCanvas.toDataURL('image/jpeg'); 
  link.click(); 
}


document.querySelector('#boton-guardar').addEventListener('click', guardarCanvas);
document.querySelector('#boton-limpiar').addEventListener('click', limpiarCanvas);
document.querySelector('#boton-video').addEventListener('click', tomarFoto);
