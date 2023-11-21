<?php
include('../../config/dbConn.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try{
        $name = isset($_POST['name']) ? mysqli_real_escape_string($conn,$_POST['name']) : null;
        $email = isset($_POST['email']) ? mysqli_real_escape_string($conn,$_POST['email']) : null;
        $password = isset($_POST['password']) ? mysqli_real_escape_string($conn,$_POST['password']) : null;
        $tableName= 'user';
        // echo "sdj";
        // echo json_encode(["isSuccess" => false, "data" => ["name"=>$name, "email"=>$email, "pass"=>$password, "registerType"=>$tableName],"message" => "Failed to add admin"]);

        $duplicateEmailError='';
        $checkDuplcateEmail="SELECT `email` FROM $tableName WHERE `email`='$email'";
        $runQuery=mysqli_query($conn, $checkDuplcateEmail);
        if (mysqli_num_rows($runQuery) > 0) {
            $duplicateEmailError="Email already exist";
        }

        if($duplicateEmailError!=""){
            echo json_encode(["isSuccess" => false, "data" => ["duplicateEmail"=>$duplicateEmailError],"message" => "Failed to register user"]);
        }else{
            // $date = date('Y-m-d');
            // $password = password_hash($password, PASSWORD_DEFAULT);

            $sql_pharmacy_admin = "INSERT INTO $tableName (`admin_name`, `admin_email`, `admin_phone`, `admin_password`, `admin_image`, `shop_name`, `shop_image`, `status`)
            VALUES ('$name','$email', '', '$password','','','','active')";

            $sql_user ="INSERT INTO $tableName (`name`, `email`, `phone`, `password`, `status`)
            VALUES ('$name', '$email', '', '$password', 'active')";

            $result = mysqli_query($conn, $tableName=='user'?$sql_user:$sql_pharmacy_admin);


            if ($result === TRUE) {
                echo json_encode(["isSuccess" => true, "data" => [], "message" =>" Registerd successfully"]);
            } else {
                echo json_encode(["isSuccess" => false, "data" => ["error"=>mysqli_error($conn)], "message" => "Failed to register"]);
            }
        }
    }catch(Exception $e){
        echo json_encode(["isSuccess" => false, "data" => [], "message" => "Failed to register"]);
    }
}
?>