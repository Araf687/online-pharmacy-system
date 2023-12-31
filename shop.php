<!DOCTYPE html>
<html lang="en">
<?php
include('./includes/head.php');

?>

<body class='bg-light-subtle'>
    <section class="d-flex justify-content-center stickyNav" style="background-color:white">
        <section class="w-75 position-sticky">
            <?php include('./includes/navbar.php') ?>
        </section>

    </section>
    <section>

        <?php
        $id = null;
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
        }

        $shopQuerry = "SELECT *
                        FROM pharmacy_admin AS pa
                        INNER JOIN pharmacy_address AS pad
                        ON pa.id = pad.pharmacy_id
                        WHERE pa.id = $id";
        $shopQuerryRun = mysqli_query($conn, $shopQuerry);
        $shopRow = $shopQuerryRun->fetch_assoc();
        $allShopQuerryResult = "" . $shopRow["id"] . "" . $shopRow["first_name"] . "" . $shopRow["last_name"] . " " . $shopRow["shop_name"] . " " . $shopRow["admin_email"];
        $shopId = $shopRow["id"];
        $shopName = $shopRow["shop_name"];
        $shopImage = $shopRow["shop_image"];
        $shopRating = $shopRow["rating"];
        $address = $shopRow["address"] . ", " . $shopRow["city"];

        $imgSrc = $shopImage ? "../pipharm-admin-panel/assets/images/store/banner/" . $shopImage : "assets/img/shop/pharmacy.png";

        ?>
        <div class="d-flex">
            <div class="w-25">
                <img src="assets/img/map.jpeg" class="card-img-top" style="height:300px" alt="...">

            </div>
            <a href="login.php" id="loginPageLink" style="display:none">login</a>
            <div class="w-75" > 
                <?php
                $sliderImageSql = "SELECT * FROM slider WHERE `admin_id`=$id";
                $fetchResult = mysqli_query($conn, $sliderImageSql);
                $rowCount = mysqli_num_rows($fetchResult);
                ?>
                
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <?php
                        $listIndex = 1;
                        if ($row_count > 0) {
                            $slider_image_src_array=[];
                            while ($row = mysqli_fetch_array($fetchResult)) {
                                $slider_image= $row["slider_image"];
                                $image_src=$slider_image?"../pipharm-admin-panel/assets/images/slider/".$slider_image:"assets/img/default.jpg";
                                $slider_image_src_array[]=$image_src;
                                ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $listIndex ?>"></li>
                                <?php
                            }

                        }
                        ?>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src=<?= $imgSrc ?> alt="First slide" height=300>
                        </div>
                        <?php
                        $listIndex = 1;
                        
                        if ($row_count > 0) {
                            foreach ($slider_image_src_array as $src) {
                               
                               
                                ?>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src=<?=$src?> alt="Second slide" height=300>
                                </div>

                                <?php
                            }

                        }
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <section class="d-flex">
            <div class="w-25" style="background-color:#f5f6fa;">
                <p class="text-center bg-success p-1 text-light fs-5">Category List</p>
                <div class="sidebar px-4 pt-2" style="height:500px;overflow-y:scroll;">
                    <ul class="list-unstyled" id="category_list">

                    </ul>

                </div>
            </div>
            <div class="w-75">

                <div class="container">

                    <div class="row my-3" id="product_list">


                    </div>
                </div>

            </div>
        </section>
        </div>
        </div>
    </section>


    </div>
    </div>


    </section>


    </section>
    <script src="assets/js/all_shop.js"></script>
    <script>
        loadAllProducts(<?= $id ?>);

    </script>

    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>
    <script>var shopId = <?= $shopId ?>;</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>