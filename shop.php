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
                                <div class="text-center border-top">
                                    <a href=<?php echo "shop.php?id=".$shopId;?> style="color:#022314">Visit <i
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