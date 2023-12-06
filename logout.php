<?php
session_start();
session_destroy();
echo "<script>console.log('asas');localStorage.removeItem('loggedInData');</script>";
header("Location: index.php");
?>