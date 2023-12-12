<?php
include('../../config/dbConn.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pharmacy_id_list = explode(", ", $_POST["pharmacy_id_list"]);
    $user_id = $_POST["user_id"];
    $delevery_method = $_POST["delevery_method"];

    foreach ($pharmacy_id_list as $id) {

        $sql_setOrder = "INSERT INTO order (`order_code`,`pharmacy_id_list`,`cust_id`,`contact_no`,`total_items`,`sale_amount`,`tax`,`shipping_cost`,`shipping_address`,`delivery_option`,`delivery_status`,`payment_method`,`order_type`) VALUES ($product_id, $qty, $price,$userId,$pharmacy_id)";

        $sql_getCartItem = "SELECT * from cartitem WHERE `cust_id`=$user_id AND pharmacy_id=$id";
        
        $sql_setOrderItems = "INSERT INTO orderitems (`order_code`, `prod_id`,`qty`, `subTotal`) VALUES ($product_id, $qty, $price,$userId,$pharmacy_id)";
    }

} ?>