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

    <section class="d-flex justify-content-center bg-light">
        <section class="w-75">
            <div class="container pb-5 pt-4">
                <div class="row">
                    <?php 
                    $id=null;
                    if(isset($_GET['id'])){
                        $id=$_GET['id'];
                    }
                        // $shopQueryRow="SELECT * FROM  ";
                        $shopQuerry="SELECT *
                        FROM pharmacy_admin
                        INNER JOIN pharmacy_address ON pharmacy_admin.id = pharmacy_address.pharmacy_id
                        WHERE pharmacy_admin.id = 5";
                        $shopQueryResult=mysqli_query($conn, $shopQuerry);
                        while($shopQueryRow=$shopQueryResult->fetch_assoc()){
                            $shopId=$shopQueryRow["id"];
                            $shopName=$shopQueryRow["shop_name"];
                            $shopImage=$shopQueryRow["shop_image"];
                            $shopRating=$shopQueryRow["rating"];
                            $address=$shopQueryRow["address"].", ".$shopQueryRow["city"];
                            $imgSrc=$shopImage?"assets/img/shop/".$shopImage:"assets/img/shop/pharmacy.png";

                            ?>
                    <div class="col-md-12 pt-4">

                        <div class="card shadow rounded-4" style="width:100%;">
                            <div class="p-3" style="background-color:#f2f2f2;">
                                <img src=<?=$imgSrc?> class="card-img-top" style="height:180px;" alt="...">
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-center"><?=$shopName?></h5>
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
                                            <small><?=$address?></small>
                                        </div>
                                    </div>

                                </div>
                                <div style="width:80%"><img src=<?= $imgSrc ?> class="card-img-top" style="height:300px"
                                        alt="..."></div>
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
                                                        <input type="text" id="quantity"
                                                            class="form-control text-center mx-3" value="1">
                                                        <span class="input-group-addon increment">
                                                            <i class="fas fa-plus"></i>
                                                        </span>
                                                    </div>
                                                    <a href="#" class="btn btn-primary w-100 rounded-5">Add to Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                        }
                    }
                    ?>

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