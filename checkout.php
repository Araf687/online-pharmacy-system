<!DOCTYPE html>
<html lang="en">
<?php include('./includes/head.php') ?>

<body class='bg-light-subtle'>
    <section class="d-flex justify-content-center stickyNav" style="background-color:white">
        <section class="w-75 position-sticky">
            <?php include('./includes/navbar.php') ?>
        </section>
    </section>
    <section>
        <section style="background-color: #eee; min-height:91.3vh">
            <section class="container pt-3">
                <div class="row bg-white ps-2">
                    <div class="col-md-8 overflow-auto py-4" style="max-height:86vh">
                        <p class="fs-3 mb-4">Product Details</p>
                        <div class="d-flex align-items-center">
                            <p class="w-25">Image</p>
                            <p class="w-50">Product name</p>
                            <p style="width:25%">Product Price</p>
                            <p style="width:25%">Quantity</p>
                            <p style="width:25%">sub Total</p>
                        </div>
                        <?php
                        $userId = $_SESSION["loggedInId"];

                        $sql = "SELECT cartitem.*, product.* 
                     FROM cartitem
                     INNER JOIN product ON cartitem.prod_id = product.prd_id 
                     WHERE cartitem.cust_id = $userId";
                        $result = mysqli_query($conn, $sql);
                        $i = $total_qty = $total = 0;
                        ;

                        $row_count = mysqli_num_rows($result);

                        while ($row = mysqli_fetch_array($result)) {
                            $cart_item_id = $row["id"];
                            $product_id = $row["prod_id"];
                            $product_name = $row["prd_name"];
                            $product_price = $row["price"];
                            $product_image = $row["prd_image"];
                            $product_qty = $row["qty"];



                            $image_source = isset($product_image) ? "../pipharm-admin-panel/assets/images/product/" . $product_image : "assets/img/default.jpg";
                            ?>
                            <div class="d-flex align-items-center">
                                <div class="w-25"><img src=<?= $image_source ?> class="p-1 bir img-thumbnail" width="90"
                                        alt="asa"></div>
                                <div class="w-50">
                                    <?= $product_name ?>
                                </div>
                                <div style="width:25%">
                                    <?= $product_price ?>
                                </div>
                                <div style="width:25%">
                                    <?= $product_qty ?>
                                </div>
                                <div style="width:25%"><i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                    <?= ($product_qty * $product_price) ?>
                                </div>
                            </div>

                            <?php

                            $total = $total + ($product_qty * $product_price);
                            $total_qty = $total_qty + $product_qty;

                            echo "<hr/>";

                        }
                        ?>
                        <div class="d-flex align-items-center">

                            <div style="width:100%" class="fs-6">
                                <p><strong>Total</strong></p>
                            </div>

                            <div style="width:25%" class="fs-6">
                                <p>
                                    <?= $total_qty ?>
                                </p>
                            </div>
                            <div style="width:25%">
                                <p class="fs-6"><i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                    <?= $total ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 p-4" style="background-color:#75aa22">
                        <div class="tab">
                            <button class="tablinks" onclick="openCity(event, 'London')">Card</button>
                            <button class="tablinks" onclick="openCity(event, 'Paris')">Bkash</button>
                            <button class="tablinks" onclick="openCity(event, 'Tokyo')">Nagad</button>
                        </div>

                        <div id="London" class="tabcontent">
                            <h3>London</h3>
                            <p>London is the capital city of England.</p>
                        </div>

                        <div id="Paris" class="tabcontent">
                            <h3>Paris</h3>
                            <p>Paris is the capital of France.</p>
                        </div>

                        <div id="Tokyo" class="tabcontent">
                            <h3>Tokyo</h3>
                            <p>Tokyo is the capital of Japan.</p>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>

</html>