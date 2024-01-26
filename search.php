<!DOCTYPE html>
<html lang="en">
<?php include('./includes/head.php') ?>

<body class='bg-light-subtle'>
    <section class="d-flex justify-content-center position-sticky shadow stickyNav" style="background-color:white">
        <section class="w-75">
            <?php include('./includes/navbar.php') ?>
        </section>
    </section>
    <section style="height:458px">
        <div class="container">
            <div class="row p-4 pt-5">
                <div class="col-md-12 mb-4">
                    <div class="input-group">
                        <select class="form-select" aria-label="Default select example" style="max-width:180px">
                            <option selected>Select Option</option>
                            <option value="1">Search by Medicine</option>
                            <option value="2">Search Pharmacy</option>

                        </select>
                        <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                            aria-describedby="search-addon" />
                        <button type="button" class="btn btn-outline-primary" data-mdb-ripple-init>search</button>

                    </div>
                    <input type="text" value='<?= $_SESSION['userLatitude'] ?>' id="userLat">
                    <input type="text" value='<?= $_SESSION['userLongitude'] ?>' id="userLong">
                    <button type="button" class="btn btn-primary mt-3" data-mdb-ripple-init
                        onclick="handleClickSearchNearestPharmacy()"><i
                            class="fa-brands fa-searchengin me-1"></i>Nearest Pharmacy</button>
                </div>
                <div class="col-md-12">
                    <div id="map"></div>
                    <div class="row" id="searchResult">

                    </div>
                </div>
            </div>
        </div>
        <!--Leaflet js link. Make sure you put this AFTER Leaflet's CSS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <!-- leaflet routing machine js file link -->
        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

        <script>
            const userLat = parseFloat($('#userLat').val());
            const userLong = parseFloat($('#userLong').val());

            // Assuming you have a Leaflet map instance
            var map = L.map('map').setView([51.505, -0.09], 13);

            // Add a tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            const handleClickSearchNearestPharmacy = () => {
                console.log("asda");


                // Fetch data using AJAX
                $.ajax({
                    url: "php_backend/search/search-nearest-pharmacy.php", // Replace with your server endpoint
                    method: "POST",
                    data: {
                        userLat: userLat,
                        userLong: userLong,
                    },
                    success: function (data) {
                        const resultData = JSON.parse(data);
                        const resultedPharmacyList = resultData.data.resultData;
                        console.log(resultData, resultedPharmacyList);
                        checkDistance(resultedPharmacyList);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("Error fetching data:", errorThrown);
                    },
                });
            };

            const checkDistance = (objectArray) => {
                // Iterate over the array and calculate distance for each pair
                objectArray.forEach(function (element) {
                    var start = L.latLng(userLat, userLong);
                    var end = L.latLng(parseFloat(element.latitude), parseFloat(element.longitude));

                    var control = L.Routing.control({
                        waypoints: [start, end],
                    });

                    // Listen for the routeselected event
                    control.on('routeselected', function (event) {
                        // Access the route information including distance
                        var route = event.route;
                        var distance = route.summary.totalDistance;
                        console.log('Route Distance:', distance);
                    });

                    // Add the control to the map
                    control.addTo(map);
                });

            }
        </script>


    </section>




    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>


</body>

</html>