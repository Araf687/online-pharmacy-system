<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
function formatDateTime($dbDateTime)
{
    // Create a DateTime object from the database datetime string
    $dateTime = new DateTime($dbDateTime);

    // Format the DateTime as desired (e.g., "M d, Y h:i A" for "Jan 01, 2022 12:30 PM")
    $formattedDateTime = $dateTime->format("M d, Y h:i A");

    return $formattedDateTime;
}
?>

<body>
    <?php
    if (isset($_SESSION['userUpdate'])) {
        echo "<script> Swal.fire({
        title: 'Good job!',
        text: 'User Update Successfully',
        icon: 'success'
      })</script>";
        unset($_SESSION['userUpdate']);
    } else if (isset($_SESSION['order_status'])) {
        echo "<script> Swal.fire({
            title: 'Good job!',
            text: 'User Update Successfully',
            icon: 'success'
          })</script>";
        if (isset($_SESSION['pharmacy_list'])) {
            $pharmacyList = json_encode($_SESSION['pharmacy_list']);
            echo "<script> $(document).ready(function() {getReview($pharmacyList)}) </script>";

        }
        unset($_SESSION['order_status']);
    }
    ?>
     <section class="d-flex justify-content-center stickyNav" style="background-color:white">
            <section class="navArea position-sticky">
                <?php include('./includes/navbar.php') ?>
            </section>

        </section>
    <section>
        <section class="d-flex align-items-center" style="background-color: #eee; height:92.5vh">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
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
                        <div class="card mb-4 p-2" style="border-radius:5px">

                            <div class="card-body text-center">
                                <!-- <p style="text-align:right;"><i class="fa-solid fa-user-pen fs-4"
                                        style="cursor:pointer;"></i></p> -->
                                <img src=<?= $image_src ?> alt="avatar" class="rounded-circle img-fluid"
                                    style="width: 150px;">
                                <h5 class="mt-3 mb-0">
                                    <?= $username ?>
                                </h5>
                                <p class="text-muted mb-1 fs-">
                                    <?= $type ?>
                                </p>
                                <!-- Button trigger modal -->
                                <a href="userLocation.php">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa-solid fa-user-pen " style="cursor:pointer;"></i> Edit Profile
                                    </button>
                                </a>

                            </div>
                        </div>
                        <div class="card py-1" style="border-radius:5px">
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
                    <div class="col-lg-9 ">
                        <div class="row ">
                            <div class="col-md-12 ">
                                <div class="card mb-md-0" style="border-radius:10px">
                                    <div class="card-body" style="height:83.5vh; overflow-y:scroll">
                                        <p class="mb-4">
                                            <span class="text-primary font-italic me-1">Orders</span>
                                            Status
                                        </p>
                                        <div class="px-2">
                                            <table class="table"
                                                style="font-family: arial, sans-serif;border-collapse: collapse;width: 100%;">
                                                <tr>
                                                    <th style="text-align: left;padding: 8px;">Order Code</th>
                                                    <th style="text-align: left;padding: 8px;">Amount</th>
                                                    <th style="text-align: left;padding: 8px;">Order Status</th>
                                                    <th style="text-align: left;padding: 8px;">Delivery Status</th>
                                                    <th style="text-align: left;padding: 8px;">Date</th>
                                                    <!-- <th style="text-align: left;padding: 8px;">Action</th> -->

                                                </tr>
                                                <?php
                                                // Query to fetch orders for a specific user
                                                $sql_all_orders = "SELECT * FROM orders WHERE `cust_id` = $userId";

                                                $result_all_orders = mysqli_query($conn, $sql_all_orders);
                                                // print_r($result_all_orders);
                                                
                                                while ($row = $result_all_orders->fetch_assoc()) {
                                                    // Display order information (Modify this part as needed)
                                                    $orderCode = $row["order_code"];
                                                    $total = $row["sale_amount"] + $row["tax"] + $row["shipping_cost"];
                                                    $order_status = $row["order_status"];
                                                    $delivery_status = $row["delivery_status"];
                                                    $date_time = $row["created_date"];

                                                    $rowColor = "rgba(154, 154, 154, 0.2)";
                                                    $fontColor = "#9a9a9a;";

                                                    if ($delivery_status == "on-the-way") {

                                                        $rowColor = "rgba(122, 186, 66, 0.2)";
                                                        $fontColor = "#448108";
                                                    } else if ($delivery_status == "completed") {
                                                        $rowColor = "rgba(66, 186, 150, 0.2)";
                                                        $fontColor = "#42ba96";

                                                    } else if ($delivery_status == "packaging") {
                                                        $rowColor = "rgba(200, 219, 27, 0.2)";
                                                        $fontColor = "#aaae38";
                                                    }


                                                    ?>

                                                    <tr
                                                        style='margin-bottom:5px;background-color:<?= $rowColor ?>;border-radius:6px;color:<?= $fontColor ?>'>
                                                        <td style="text-align: left;padding: 8px;">

                                                            <?= $orderCode ?>

                                                        </td>
                                                        <td style="text-align: left;padding: 8px;">
                                                            BDT
                                                            <?= $total ?>

                                                        </td>
                                                        <td style="text-align: left;padding: 8px;">

                                                            <?= $order_status ?>

                                                        </td>
                                                        <td style="text-align: left;padding: 8px;">


                                                            <?= $delivery_status ?>

                                                        </td>
                                                        <td style="text-align: left;padding: 8px;">


                                                            <?= formatDateTime($date_time) ?>

                                                        </td>
                                                        <!-- <td style="text-align: left;padding: 8px;">


                                                            <div>
                                                                <img src="" id="dropdownMenuButton"
                                                                    class="rounded-circle dropdown-toggle"
                                                                    style="width: 35px; cursor:pointer"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false" />
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item" href="user-profile.php"><i
                                                                            class="fa-solid fa-user me-2"
                                                                            style="color:#12dab9;"></i>Profile</a>
                                                                    <a class="dropdown-item" href="reset-password.php"><i
                                                                            class="fa-solid fa-screwdriver-wrench me-2"
                                                                            style="color:#12dab9;"></i></i>Reset
                                                                        Password</a>
                                                                    <a class="dropdown-item" href="logout.php"><i
                                                                            class="fa-solid fa-power-off me-2"
                                                                            style="color:red;"></i>Logout</a>

                                                                </div>
                                                            </div>

                                                        </td> -->

                                                    </tr>

                                                <?php } ?>
                                            </table>

                                            <!-- <div class="d-flex justify-content-between py-1 px-2 mb-3"
                                                >
                                            </div> -->

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

    <script>
        const getReview = (pharmacyList) => {
            console.log(pharmacyList, typeof (pharmacyList));

        }
    </script>

    <?php include('./includes/script.php') ?>


</body>

</html>