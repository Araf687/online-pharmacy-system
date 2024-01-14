var map = L.map("map").setView([24.0, 90.0], 7);

L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

const getLocationFromBrowser = () => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
      var latitude = position.coords.latitude;
      var longitude = position.coords.longitude;
      console.log(position);
      showUserLocationOnMap(latitude, longitude);
    });
  } else {
    alert("Geolocation is not supported by this browser.");
  }
};
const showUserLocationOnMap = (latitude, longitude) => {

   // Remove the previous marker if it exists
   if (currentMarker) {
    map.removeLayer(currentMarker);
  }

  // Update visual appearance (optional)
  document.getElementById("map").style.opacity = 1; // Restore opacity
  document.getElementById("map").style.pointerEvents = "auto"; // Enable pointer events
  
  map.flyTo([latitude, longitude], 17, { draggable: true });
  document.getElementById("LatLong").value = `${latitude}, ${longitude}`;

  // Create a draggable marker
  var marker = L.marker([latitude, longitude], { draggable: true }).addTo(map);
  currentMarker=marker;

  // Event listener for the marker dragend event
  marker.on("drag", function (event) {
    var newPosition = event.target.getLatLng();

    // Update map view to the new marker position
    map.setView(newPosition);
  });
  marker.on("dragend", function (event) {
    const { lat, lng } = event.target.getLatLng();
    document.getElementById("LatLong").value = `${lat}, ${lng}`;
  });
};

const showDistance=(center,destination)=>{
  const control= L.Routing.control({
    waypoints: [
      L.latLng(center[0], center[1]),
      L.latLng(destination[0], destination[1])
    ],
    routeWhileDragging: true
  }).addTo(map);

  // Listen for the routeselected event
  control.on('routeselected', function (event) {
    // Access the route information including distance
    const route = event.route;
    const distance = route.summary.totalDistance;
    console.log('Route Distance:', distance);
  });

}