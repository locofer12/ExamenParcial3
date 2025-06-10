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
