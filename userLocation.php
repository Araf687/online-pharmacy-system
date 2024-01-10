<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Show User Location on Map</title>

  <!-- //leaflet src link  -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />


  <style>
    #map {
      width: 40%;
      height: 500px;
    }
  </style>
</head>

<body>
  <h1>Show User Location on Map</h1>

  <div id="map"></div>
  <div>
  <button type="button" class="btn btn-success">Give your current location</button>
  </div>


  <!--Leaflet js link. Make sure you put this AFTER Leaflet's CSS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script src="assets/js/map/map.js"></script>

</body>

</html>