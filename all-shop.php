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
    <section class="d-flex justify-content-center bg-light">
        <section class="w-75">
            <div class="container pb-5 pt-4">
                <h3>All Shops</h3>
                <div class="row">
                    <?php
                    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
                    $sub_category_id = isset($_GET['sub_category_id']) ? $_GET['sub_category_id'] : null;
                    $query1 = "SELECT *
                        FROM pharmacy_admin
                        JOIN pharmacy_address ON pharmacy_admin.id = pharmacy_address.pharmacy_id;
                        ";
                    // echo $category_id . "  " . $sub_category_id;
                    $query2 = "SELECT DISTINCT s.*, sa.*
                    FROM pharmacy_admin s
                    INNER JOIN product p ON s.id = p.pharmacy_id
                    INNER JOIN sub_category sc ON p.prd_sub_cat_id = sc.id
                    LEFT JOIN pharmacy_address sa ON s.id = sa.pharmacy_id
                    WHERE sc.category_id = $category_id AND sc.id=$sub_category_id";

                    

                    $allShopQueryRun = mysqli_query($conn, $allShopQuery);
                    echo var_dump($allShopQueryRun);

                    while ($allShopQuery = mysqli_fetch_array($allShopQueryRun)) {
                        $allShopQueryResult = "" . $allShopQuery["id"] . "" . $allShopQuery["first_name"] . "" . $allShopQuery["last_name"] . " " . $allShopQuery["shop_name"] . " " . $allShopQuery["admin_email"];
                        $shopId = $allShopQuery["id"];
                        $shopName = $allShopQuery["shop_name"];
                        $shopImage = $allShopQuery["shop_image"];
                        $shopRating = $allShopQuery["rating"];
                        $address = $allShopQuery["address"] . ", " . $allShopQuery["city"];

                        $imgSrc = $shopImage ? "assets/img/shop/" . $shopImage : "assets/img/shop/pharmacy.png";

                        ?>
                        <div class="col-md-3 pt-4">

                            <div class="card shadow rounded-4" style="width:100%;">
                                <div class="p-3" style="background-color:#f2f2f2;">
                                    <img src=<?= $imgSrc ?> class="card-img-top" style="height:180px;" alt="...">
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title text-center">
                                        <?= $shopName ?>
                                    </h5>
                                    <div>
                                        <div class="my-1">
                                            <p class="text-center">
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    ?>
                                                    <i class="fa-regular fa-star"></i>
                                                    <?php
                                                }

                                                ?>

                                            </p>
                                            <div class="d-flex align-items-center" style="height:50px">
                                                <div class="p-2 border me-2 rounded"><i
                                                        class="fa-solid fa-location-dot "></i></div>
                                                <small>
                                                    <?= $address ?>
                                                </small>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-center border-top">
                                        <a href=<?php echo "shop.php?id=" . $shopId; ?> style="color:#022314">Visit <i
                                                class="fa-solid fa-arrow-right ps-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </section>

    </section>
    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>
</body>

</html>