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
                    <div id="testMap"></div>
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
            const handleClickSearchNearestPharmacy = () => {
                console.log("asda");
                const userLat = $('#userLat').val();
                const userLong = $('#userLong').val();

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
                        resultedPharmacyList.forEach(element => {
                            const lat1 = parseInt(userLat);
                            const long1 = parseInt(userLong);
                            const lat2 = parseInt(element.latitude);
                            const long2 = parseInt(element.longitude);
                            distance(lat1, long1, lat2, long2);
                            console.log(lat1, long1, lat2, long2);
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("Error fetching data:", errorThrown);
                    },
                });
            };

            const distance = (latitude1, longitude1, latitude2, longitude2) => {
                // Replace 'YOUR_API_KEY' with your OpenRouteService API key
                const apiKey = '5b3ce3597851110001cf62487c2dcc7104274a92936bd95838f2af37';

                // Replace these coordinates with your start and end points
                const start = [latitude1, longitude1];
                const end = [latitude2, longitude2];

                // Construct the API URL
                const apiUrl = `https://api.openrouteservice.org/v2/directions/driving-car?api_key=${apiKey}&start=${start.join(',')}&end=${end.join(',')}`;

                // Make a request to the OpenRouteService API
                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        // Extract the distance from the API response
                        const distance = data.features[0].properties.segments[0].distance;
                        console.log(`Distance: ${distance} meters`);
                    })
                    .catch(error => console.log('Error fetching data from OpenRouteService:', error));


            };
        </script>


    </section>




    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>


</body>

</html>