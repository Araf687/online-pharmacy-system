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
                    $id=null;
                     if (isset($_GET['id'])) {
                        $id = (int)$_GET['id'];
                        

                     }
                        // $shopRow="SELECT * FROM  ";
                        $shopQuerry="SELECT *
                        FROM pharmacy_admin AS pa
                        INNER JOIN pharmacy_address AS pad
                        ON pa.id = pad.pharmacy_id
                        WHERE pa.id = $id";
                        $shopQuerryRun=mysqli_query($conn, $shopQuerry);
                        while($shopRow=$shopQuerryRun->fetch_assoc()){
                            $allShopQuerryResult= "".$shopRow["id"]."".$shopRow["first_name"]."".$shopRow["last_name"]." ".$shopRow["shop_name"]." ".$shopRow["admin_email"];
                            $shopId=$shopRow["id"];
                            $shopName=$shopRow["shop_name"];
                            $shopImage=$shopRow["shop_image"];
                            $shopRating=$shopRow["rating"];
                            $address=$shopRow["address"].", ".$shopRow["city"];

                            $imgSrc=$shopImage?"assets/img/shop/".$shopImage:"assets/img/shop/pharmacy.png";

                            ?>
                            <div style="background-color:#f2f2f2;">
                                <img src=<?=$imgSrc?> class="card-img-top" style="width:100%;height:500px" alt="...">
                            </div>

        <section class="w-75">
            <div class="container pb-5 pt-4">
                <div class="row">

                    <div class="col-md-3 pt-4">

                        <div class="card shadow rounded-4" style="width:100%;">

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

                </div>
            </div>
        </section>
        <?php    
                        }
                ?>

    </section>
    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>
</body>

</html>