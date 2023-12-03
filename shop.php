<!DOCTYPE html>
<html lang="en">
<?php
include('./includes/head.php');
include('./config/dbConn.php');
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

        $imgSrc = $shopImage ? "assets/img/shop/" . $shopImage : "assets/img/shop/pharmacy.png";

        ?>
        <div class="d-flex">
            <div style="width:20%">

                <div class="sidebar bg-light py-3 px-4 bg-white" style="height:300px;overflow-y:scroll">
                    <ul class="list-unstyled">
                        <?php
                        $categoryQuerry = "SELECT `id`,`cat_name` FROM category";
                        $result = $conn->query($categoryQuerry);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $catId = $row["id"];
                                $catName = $row["cat_name"];

                                $subCategoryQuerry = "SELECT `id`,`sub_category_name` FROM sub_category WHERE category_id=$catId AND pharmacy_id=$shopId";
                                $subCategoryQresult = $conn->query($subCategoryQuerry);

                                $rowCount = $subCategoryQresult->num_rows;
                                if ($rowCount > 0) { ?>
                        <button href="#services"
                            class="w-100 btn btn-toggle d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse">
                            <?= $catName ?> <span class="fw-bold">+</span>
                        </button>
                        <li>
                            <ul class="collapse bg-light-subtle" id="services">
                                <?php
                                            while ($subCategoryRow = $subCategoryQresult->fetch_assoc()) {
                                                $subCategoryId = $subCategoryRow["id"];
                                                $subCategoryName = $subCategoryRow["sub_category_name"];
                                            ?>
                                <li><a href="#" class="link-dark rounded "><?= $subCategoryName?></a></li>
                                <?php
                                            } 
                                            ?>
                            </ul>
                        </li>

                        <?php
                                } else {
                                    ?>
                        <li>
                            <button href="#" class="btn btn-toggle w-100 text-start"
                                catId=<?= $catId ?>><?= $catName ?></button>
                        </li>

                        <?php
                                }

                            }
                        }
                        ?>

                    </ul>
                </div>

            </div>
            <div style="width:80%"><img src=<?= $imgSrc ?> class="card-img-top" style="height:300px" alt="..."></div>
        </div>


        <section>
            <div class="container">
                <div class="row my-3 gap-2">
                    <?php
                    $productQuerry = "SELECT * from product WHERE pharmacy_id=$id";
                    $prdQuerryResult = $conn->query($productQuerry);
                    $rowCount = $prdQuerryResult->num_rows;
                    if ($rowCount > 0) {
                        while ($productRow = $prdQuerryResult->fetch_assoc()) {
                            $prdId = $productRow["prd_id"];
                            $prdName = $productRow["prd_name"];
                            $prdPrice = $productRow["prd_price"];
                            $prdImage = $productRow["prd_image"];
                            $prdDescription = $productRow["prd_description"];
                            $prdCategoryId = $productRow["prd_cat_id"];
                            $prdSubCategoryId = $productRow["prd_sub_cat_id"];

                            $imgSrc = "../admin-panel-PiPharm-main/assets/images/product/" . $prdImage;
                            ?>
                    <div class="col-md-3">
                        <div class="card p-2 rounded-3" style="width: 100%;">
                            <img src=<?= $imgSrc ?> class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">
                                    <?= $prdName ?>
                                </h5>
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <span class="input-group-addon decrement">
                                        <i class="fas fa-minus"></i>
                                    </span>
                                    <input type="text" id="quantity" class="form-control text-center mx-3" value="1">
                                    <span class="input-group-addon increment">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                </div>
                                <a href="#" class="btn btn-primary w-100 rounded-5">Add to Cart</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        </div>
        </div>
    </section>
    <?php
                        }
                    }
                    ?>

    </div>
    </div>


    </section>


    </section>

    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Change the '+' and '-' signs on collapse/expand
    document.querySelectorAll('.sidebar .collapse').forEach(collapseElement => {
        collapseElement.addEventListener('show.bs.collapse', function() {
            const parentAnchor = this.previousElementSibling;
            parentAnchor.querySelector('span').textContent = '-';
        });
        collapseElement.addEventListener('hide.bs.collapse', function() {
            const parentAnchor = this.previousElementSibling;
            parentAnchor.querySelector('span').textContent = '+';
        });
    });
    $(document).ready(function() {
        $('.increment').click(function() {
            var value = parseInt($('#quantity').val(), 10);
            value = isNaN(value) ? 0 : value;
            value++;
            $('#quantity').val(value);
        });

        $('.decrement').click(function() {
            var value = parseInt($('#quantity').val(), 10);
            value = isNaN(value) ? 0 : value;
            value--;
            $('#quantity').val(value < 1 ? 1 : value);
        });
    });
    </script>
</body>

</html>