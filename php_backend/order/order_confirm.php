<?php
include('../../config/dbConn.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pharmacy_id_list = explode(", ", $_POST["pharmacy_id_list"]);
    $user_id = $_POST["user_id"];
    $payment_method = $_POST["payment_method"];

    foreach ($pharmacy_id_list as $id) {
        $sql_getCartItem = "SELECT * from cartitem WHERE `cust_id`=$user_id AND pharmacy_id=$id";
        $result_getCartItem = mysqli_query($conn, $sql_getCartItem);
        $cartItem_row_count = mysqli_num_rows($result_getCartItem);
        $orderCode = 'ORD#' . $userID . '-' . $id . '-' . time();
        if ($cartItem_row_count > 0) {
            while ($row_getCartItem = mysqli_fetch_array($result_getCartItem)) {
                $qty = $row_getCartItem['qty'];
                $product_id = $row_getCartItem['prod_id'];
                $subTotal = $row_getCartItem['price'] * $qty;
                $flag = 0;
                $sql_setOrderItems = "INSERT INTO orderitems (`order_code`, `prod_id`,`qty`, `subTotal`) VALUES ($orderCode, $product_id, $qty,$subTotal)";
                $result_setOrderItems = mysqli_query($conn, $sql_setOrderItems);

                if ($result_setOrderItems) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }
            }

            $sql_setOrder = "INSERT INTO order (`order_code`,`pharmacy_id`,`cust_id`,`contact_no`,`total_items`,`sale_amount`,`tax`,`shipping_cost`,`shipping_address`,`delivery_option`,`delivery_status`,`payment_method`,`order_type`) VALUES ('$orderCode', $id, $user_id,'',$cartItem_row_count,'','','','','pending','$payment_method','online')";

            $result_setOrderItems = mysqli_query($conn, $sql_setOrder);
            if ($result_setOrderItems) {

            }

        }






    }

} ?>