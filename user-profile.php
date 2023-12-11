<!DOCTYPE html>
<html lang="en">
<?php include('./includes/head.php') ?>

<body>
    <section class="d-flex justify-content-center position-sticky shadow stickyNav" style="background-color:white">
        <section class="w-75">
            <?php include('./includes/navbar.php') ?>
        </section>
    </section>
    <section>
        <section style="background-color: #eee; min-height:91.3vh">
            <div class="container py-4">
                <div class="row">
                    <div class="col-lg-4">
                        <?php
                        $userId = $_SESSION["loggedInId"];
                        $sql = "SELECT u.*, ua.* FROM user u
                                JOIN user_address ua ON u.id = ua.user_id
                                WHERE u.id = $userId AND u.status='active'";
                        $result = mysqli_query($conn, $sql);

                      
                        while ($row = $result->fetch_assoc()) {
                            $userId = $row["id"];
                            $username = $row["name"];
                            $email = $row["email"];
                            $image = $row["image"];
                            $phone = $row["phone"];
                            $type = $row["type"];
                            $status = $row["status"];
                            $user_address_id = $row["address_id"];
                            $house_name = $row["house_name"];
                            $street = $row["street"];
                            $post_office = $row["post_office"];
                            $city = $row["city"];

                            $image_src = $image ? "./assets/img/user/" . $image : "./assets/img/user/user.png";
                            
                        }
                        ?>
                        <input type="text" name="user_id" value=<?= $userId ?> style="display:none" />
                        <div class="card mb-4" style="border-radius:5px">

                            <div class="card-body text-center">
                                <p style="text-align:right;"><i class="fa-solid fa-user-pen fs-4" style="cursor:pointer;" ></i></p>
                                <img src=<?= $image_src ?> alt="avatar" class="rounded-circle img-fluid"
                                    style="width: 150px;">
                                <h5 class="mt-3 mb-0">
                                    <?= $username ?>
                                </h5>
                                <p class="text-muted mb-1 fs-">
                                    <?= $type ?>
                                </p>
                            </div>
                        </div>
                        <div class="card mb-4" style="border-radius:5px">
                            <div class="card-body">
                                <h5 class="card-title mb-4">User Information</h5>
                                <div>
                                    <i class="fa-regular fa-user me-4"></i>
                                    <span>
                                        <?= $username ?>
                                    </span>
                                </div>
                                <hr>
                                <div>
                                    <i class="fa-regular fa-envelope me-4"></i>
                                    <span>
                                        <?= $email ?>
                                    </span>
                                </div>
                                <hr>
                                <div>
                                    <i class="fa-solid fa-phone me-4"></i>
                                    <span>
                                        <?= $phone != '' ? $phone : "N/A" ?>
                                    </span>
                                </div>

                                <hr>
                                <div>
                                    <i class="fa-regular fa-id-badge me-4"></i>
                                    <span>
                                        <?= $type ?>
                                    </span>
                                </div>
                                <hr>
                                <div>
                                    <i class="fa-solid fa-user-check me-4"></i>
                                    <span>
                                        <?= ucfirst($status) ?>
                                    </span>
                                </div>
                                <hr>
                                <div>
                                    <i class="fa-solid fa-location-dot me-4"></i>
                                    <span>Address</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-3 mb-md-0" style="border-radius:10px">
                                    <div class="card-body" style="min-height:82vh; overflow-y:scroll">
                                        <p class="mb-4"><span class="text-primary font-italic me-1">
                                                Orders</span>
                                            Status
                                        </p>
                                        <div class="px-2">
                                            <div class="d-flex justify-content-between py-1 px-2 mb-3"
                                                style="background-color:#f2f30659;border-radius:6px;">
                                                <p class="mb-1">Order:201</p>
                                                <p class="mb-1">Transaction: BDT 1050</p>
                                                <p class="mb-1">Delivery: Pending</p>
                                            </div>
                                            <div class="d-flex justify-content-between py-1 px-2 mb-3"
                                                style="background-color:#cffcd4;border-radius:6px;">
                                                <p class="mb-1">Order:201</p>
                                                <p class="mb-1">Transaction: BDT 1050</p>
                                                <p class="mb-1">Delivery: Completed</p>
                                            </div>
                                            <div class="d-flex justify-content-between py-1 px-2 mb-3"
                                                style="background-color:#cffcd4;border-radius:6px;">
                                                <p class="mb-1 ">Order:201</p>
                                                <p class="mb-1 ">Transaction: BDT 1050</p>
                                                <p class="mb-1 ">Delivery: Completed</p>
                                            </div>

                                            <div class="d-flex justify-content-between py-1 px-2 mb-3"
                                                style="background-color:#f4450559;border-radius:6px;">
                                                <p class="mb-1 ">Order:201</p>
                                                <p class="mb-1 ">Transaction: BDT 1050</p>
                                                <p class="mb-1 ">Delivery: Canceled</p>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <?php include('./includes/script.php')?>

</body>

</html>