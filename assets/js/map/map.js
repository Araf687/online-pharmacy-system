// // initialize leaflet map, and set its center and zoom level
// const map = L.map("map").setView([90.0, 24.0], 13);

// // adding layer on map 
// L.titleLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
//   attribution:
//     '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
// }).addToMap(map);

var map = L.map('map').setView([ 24.0,90.0], 7);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);