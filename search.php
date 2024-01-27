<!DOCTYPE html>
<html lang="en">
<?php include('./includes/head.php') ?>

<body class='bg-light-subtle'>
    <section class="d-flex justify-content-center position-sticky shadow stickyNav" style="background-color:white">
        <section class="w-75">
            <?php include('./includes/navbar.php') ?>
        </section>
    </section>
    <section style="min-height:458px">
        <div class="container">
            <div class="row p-3 pt-4">
                <div class="col-md-12">
                    <div class="mb-2" >
                        <input type="text" class="d-none" value='<?= $_SESSION['userLatitude'] ?>' id="userLat">
                        <input type="text" class="d-none" value='<?= $_SESSION['userLongitude'] ?>' id="userLong">
                        <button type="button" class="btn btn-primary" data-mdb-ripple-init
                            onclick="handleClickSearchNearestPharmacy()" style="font-size:18px"><i
                                class="fa-brands fa-searchengin me-1"></i>Nearest Pharmacy</button>
                    </div>
                    <div class="input-group">
                        <select class="form-select" aria-label="Default select example" id="searchOption"
                            style="max-width:190px">
                            <option selected>Select Option</option>
                            <option value="type_medicine">Search by Medicine</option>
                            <option value="type_pharmacy">Search Pharmacy</option>

                        </select>
                        <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                            aria-describedby="search-addon" id="searchInput" />
                        <button type="button" class="btn btn-outline-primary" data-mdb-ripple-init
                            onclick="handleClickSearch()">search</button>

                    </div>

                </div>
                <div id="map" class="d-none"></div>
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center align-items-center mt-1">
                                <div style="display: none; text-align:center " id="loadingSpinner">
                                    <!-- Add this wherever you want the spinner to appear -->
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>

                                    </div>
                                    <p>Loading...</p>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="row" id="searchResult"></div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!--Leaflet js link. Make sure you put this AFTER Leaflet's CSS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <!-- leaflet routing machine js file link -->
        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

        <!-- <script>
            const userLat = parseFloat($('#userLat').val());
            const userLong = parseFloat($('#userLong').val());

            // Assuming you have a Leaflet map instance
            var map = L.map('map');

            const handleClickSearchNearestPharmacy = () => {
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
                        console.log(resultData);
                        const resultedPharmacyList = resultData.data.resultData;


                        // const newPharmacyList = getRouteDistance(resultedPharmacyList);

                        getRouteDistance(resultData.data.resultData)
                            .then((result) => {
                                // This block will be executed after all distances are calculated
                                console.log(result);
                                newPharmacyList=result;
                                // Sorting the array based on the 'distance' property
                                newPharmacyList.sort((a, b) => {
                                    return parseFloat(a.distance) - parseFloat(b.distance)
                                });

                                const cardParent = document.getElementById('searchResult');
                                cardParent.innerHTML = '';

                                newPharmacyList.forEach(element => {
                                    createShopCard(element, cardParent)
                                });
                            })
                            .catch((error) => {
                                console.error(error);
                            });







                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("Error fetching data:", errorThrown);
                    },
                });
            };

            const getRouteDistance = async (objectArray) => {
                console.log(objectArray)
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
                        element.distance = (distance / 1000).toFixed(2);
                        // console.log('Route Distance:', (distance/1000).toFixed(2),"km");
                    });

                    // Add the control to the map
                    control.addTo(map);
                });

                return objectArray;

            }

            const createShopCard = (cardData, cardParent) => {

                // Sample data
                const imgSrc = "../pipharm-admin-panel/assets/images/store/banner/" + cardData.shopImage;
                const shopName = cardData.shopName;
                const address = cardData.address;
                const distance = cardData.distance;
                const shopId = cardData.id;

                // Create a new div element
                const cardContainer = document.createElement('div');
                cardContainer.className = 'col-md-3 pt-4';

                // Create the card structure
                cardContainer.innerHTML = `
                    <div class="card shadow rounded-4" style="width:100%;">
                        <div class="p-3" style="background-color:#f2f2f2;">
                            <img src="${imgSrc}" class="card-img-top" style="height:180px;" alt="..." onerror="this.src='assets/img/default.jpg'">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-center">${shopName}</h5>
                            <div>
                                <div class="my-1">
                                    <p class="text-center">
                                        ${Array.from({ length: 5 }, (_, i) => `<i class="fa-regular fa-star"></i>`).join('')}
                                    </p>
                                    <div class="d-flex align-items-center" style="height:50px">
                                        <div class="p-2 border me-2 rounded"><i class="fa-solid fa-location-dot "></i></div>
                                        <small>${address}</small>
                                    </div>
                                    <div class="d-flex align-items-center" style="height:50px">
                                        <div class="p-2 border me-2 rounded"><i class="fa-solid fa-location-dot "></i></div>
                                        <small>Distance: ${distance}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center border-top">
                                <a href="shop.php?id=${shopId}" style="color:#022314">Visit <i class="fa-solid fa-arrow-right ps-1"></i></a>
                            </div>
                        </div>
                    </div>
                `;

                // Append the new card to the container
                cardParent.appendChild(cardContainer);
            }


        </script> -->

        <script>
            const userLat = parseFloat($('#userLat').val());
            const userLong = parseFloat($('#userLong').val());

            // Assuming you have a Leaflet map instance
            var map = L.map('map');



            const showLoadingMessage = () => {
                const loadingSpinner = document.getElementById('loadingSpinner');
                loadingSpinner.style.display = 'block';
            };

            const hideLoadingMessage = () => {
                const loadingSpinner = document.getElementById('loadingSpinner');
                loadingSpinner.style.display = 'none';
            };

            const handleClickSearchNearestPharmacy = async () => {
                try {

                    showLoadingMessage();
                    const data = await $.ajax({
                        url: "php_backend/search/search-nearest-pharmacy.php",
                        method: "POST",
                        data: {
                            userLat: userLat,
                            userLong: userLong,
                        },
                    });

                    const resultData = JSON.parse(data);

                    if (resultData.isSuccess) {
                        const resultedPharmacyList = resultData.data.resultData;

                        // Wait for distance calculations to complete
                        const newPharmacyList = await getRouteDistance(resultedPharmacyList);
                        showNearestPharmacy(resultedPharmacyList);
                    }
                    else {
                        if (resultData.data.hasOwnProperty("error")) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                            });
                        }
                        else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "No pharmacy has been found!",
                            });
                        }
                    }



                } catch (error) {
                    showLoadingMessage();
                    console.error("Error fetching data:", error);
                }
            };

            const handleClickSearch = async () => {
                const searchOption = $('#searchOption').val();
                const searchData = $('#searchInput').val();
                const postData = {
                    searchData: searchData,
                    searchOption: searchOption
                };
                try {
                    showLoadingMessage();
                    const data = await $.ajax({
                        url: "php_backend/search/searchCode.php",
                        method: "POST",
                        data: postData,
                    });

                    const resultData = JSON.parse(data);


                    if (resultData.isSuccess) {
                        const resultedPharmacyList = resultData.data.resultData;

                        // Wait for distance calculations to complete
                        const newPharmacyList = await getRouteDistance(resultedPharmacyList);
                        showNearestPharmacy(resultedPharmacyList);
                    }
                    else {
                        hideLoadingMessage();
                        if (searchOption == "type_medicine") {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "No pharmacy has been found that sells this " + searchData + " !",
                            });
                        }
                        else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: resultData.message,
                            });
                        }


                    }

                } catch (error) {

                    console.error("Error fetching data:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                    });

                }
            };


            const showNearestPharmacy = (newPharmacyList) => {

                // Sorting the array based on the 'distance' property
                newPharmacyList.sort((a, b) => parseFloat(a.distance) - parseFloat(b.distance));

                const cardParent = document.getElementById('searchResult');
                clearDiv(cardParent);

                newPharmacyList.forEach(element => {
                    createShopCard(element, cardParent);
                });
                hideLoadingMessage();
            }

            const getRouteDistance = async (objectArray) => {
                // Use Promise.all to await all distance calculations in parallel
                await Promise.all(objectArray.map(async function (element) {
                    var start = L.latLng(userLat, userLong);
                    var end = L.latLng(parseFloat(element.latitude), parseFloat(element.longitude));

                    var control = L.Routing.control({
                        waypoints: [start, end],
                    });

                    // Promisify the routing control event
                    const routeSelectedPromise = new Promise((resolve) => {
                        control.on('routeselected', function (event) {
                            var route = event.route;
                            var distance = route.summary.totalDistance;
                            element.distance = (distance / 1000).toFixed(2);
                            resolve();
                        });
                    });

                    control.addTo(map);

                    // Wait for the routeSelectedPromise to complete
                    await routeSelectedPromise;
                }));

                return objectArray;
            };

            const createShopCard = (cardData, cardParent) => {

                // Sample data
                const imgSrc = "../pipharm-admin-panel/assets/images/store/banner/" + cardData.shopImage;
                const shopName = cardData.shopName;
                const address = cardData.address;
                const distance = cardData.distance;
                const shopId = cardData.id;

                // Create a new div element
                const cardContainer = document.createElement('div');
                cardContainer.className = 'col-md-3 pt-4';

                // Create the card structure
                cardContainer.innerHTML = `
                        <div class="card shadow rounded-4" style="width:100%;">
                            <div class="p-3" style="background-color:#f2f2f2;">
                                <img src="${imgSrc}" class="card-img-top" style="height:180px;" alt="..." onerror="this.src='assets/img/default.jpg'">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-center">${shopName}</h5>
                                <div>
                                    <div class="my-1">
                                        <p class="text-center">
                                            ${Array.from({ length: 5 }, (_, i) => `<i class="fa-regular fa-star"></i>`).join('')}
                                        </p>
                                        <div class="d-flex align-items-center" style="height:50px">
                                            <div class="p-2 border me-2 rounded"><i class="fa-solid fa-location-dot "></i></div>
                                            <small>${address}</small>
                                        </div>
                                        <div class="d-flex align-items-center" style="height:50px">
                                            <div class="p-2 border me-2 rounded"><i class="fa-solid fa-location-dot "></i></div>
                                            <small>Distance: ${distance} km</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center border-top">
                                    <a href="shop.php?id=${shopId}" style="color:#022314">Visit <i class="fa-solid fa-arrow-right ps-1"></i></a>
                                </div>
                            </div>
                        </div>
                    `;

                // Append the new card to the container
                cardParent.appendChild(cardContainer);
            }
            const clearDiv = (div) => {
                div.innerHTML = '';
            }
        </script>



    </section>




    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>


</body>

</html>