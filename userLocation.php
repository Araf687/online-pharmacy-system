<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Show User Location on Map</title>

  <!-- //leaflet src link  -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

  <!-- bootstrap link  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- font awesome link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referre" />


  <style>
    #map {
      opacity: 0.5;
      /* Reduced opacity to indicate disabled state */
      height: 500px;
      pointer-events: none;
      /* Disable pointer events */
    }
  </style>
</head>

<?php
include('config/dbConn.php');
session_start();
?>

<body>
  <section class="d-flex justify-content-center position-sticky shadow stickyNav" style="background-color:white">
    <section class="w-75">
      <?php include('./includes/navbar.php') ?>
    </section>
  </section>
  <section class="mt-3 ">

    <div class="container card p-4">

      <div class="row">
        <div class="col-md-12 mb-4">
          <h3 class="text-center">Edit User</h3>
        </div>

        <div class="col-md-7">
          <h4 class="mb-3">Profile Information</h4>
          <?php
          $userId = $_SESSION["loggedInId"];
          $sql = "SELECT u.*, ua.* FROM user u
                                JOIN user_address ua ON u.id = ua.user_id
                                WHERE u.id = $userId AND u.status='active' LIMIT 1";
          $result = mysqli_query($conn, $sql);


          $row = $result->fetch_assoc();
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
          ?>
          <form id="updateUserForm">
            <div class="row">
              <div class="col-md-12 mb-3"><img src=<?= $image_src ?> height="100" alt="" id="imagePreview"></div>
              <span class="ms-2 mb-2" onclick="clickEditImage()" style="cursor:pointer"><i
                  class="fa-regular fa-pen-to-square"></i> edit image </span>
              <input type="file" name="" id="imageInput" onchange="handleInputImage(event)" name="userImage"
                style="display:none">
              <div class="col-md-4 mb-2">
                <div class="form-group">
                  <label for="exampleFormControlInput1">Name</label>
                  <input type="email" class="form-control" name="userName" id="exampleFormControlInput1"
                    value='<?= $username ?>'>
                </div>
              </div>

              <div class=" col-md-4 form-group  mb-2">
                <label for="exampleFormControlInput1">Email</label>
                <input type="email" class="form-control" name="email" id="exampleFormControlInput1" value=<?= $email ?>>
              </div>
              <div class="col-md-4 form-group  mb-4">
                <label for="exampleFormControlInput1">Phone</label>
                <input type="email" class="form-control" name="phone" id="exampleFormControlInput1" value=<?= $phone ?>>
              </div>
              <div class="col-md-12 form-group">
                <h6>User Address</h6>
              </div>
              <div class="col-md-6 form-group  mb-2">
                <label for="exampleFormControlInput1">Address</label>
                <input type="email" class="form-control" name="userName" id="exampleFormControlInput1"
                  value='<?= $house_name ?>'>
              </div>
              <div class="col-md-6 form-group  mb-2">
                <label for="exampleFormControlInput1">Street Name</label>
                <input type="email" class="form-control" name="userName" id="exampleFormControlInput1"
                  value='<?= $street ?>'>
              </div>
              <div class="col-md-6 form-group  mb-2">
                <label for="exampleFormControlInput1">City</label>
                <input type="email" class="form-control" name="userName" id="exampleFormControlInput1"
                  value='<?= $city ?>'>
              </div>
              <div class="col-md-6 form-group  mb-4">
                <label for="exampleFormControlInput1">Post Office</label>
                <input type="email" class="form-control" name="userName" id="exampleFormControlInput1"
                  value='<?= $post_office ?>'>
              </div>

              <div class="col-md-12 form-group mb-2">
                <h6>Users Home Location (<small style="font-weight:500" class="text-primary">Press here to give your
                    current location. We assume that its your home location</small>)</h6>
              </div>
              <div class="col-md-12 form-group">

                <button type="button" class="btn btn-success" onclick="getLocationFromBrowser()">Current
                  Location</button>

                <div class="ms-2 d-none"><span>Latitude & Longitude</span>
                  <div><input type="text" id="LatLong" required></div>
                </div>
              </div>

            </div>
          </form>
        </div>
        <div class="col-md-5">
          <div id="map" class="mb-2 rounded shadow"></div>
          <p class="text-center" style="font-size:18px">You can also drag the blue marker to set the specific location.
          </p>
        </div>
        <div class="col-md-12">
          <button type="button" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </section>




  <!--Leaflet js link. Make sure you put this AFTER Leaflet's CSS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script src="assets/js/map/map.js"></script>
  <script>
    const clickEditImage = () => {

      // Find the file input element by its ID
      var fileInput = document.getElementById('imageInput');

      // Simulate a click on the file input
      fileInput.click();

    }

    const handleInputImage = (event) => {
      let preview = document.getElementById('imagePreview');

      console.log(event.target.files[0]);
      preview.src = URL.createObjectURL(event.target.files[0]);
      preview.onload = function () {
        URL.revokeObjectURL(preview.src) // free memory
      }
    }

    $(document).ready(function () {

      let request;

      $("#updateUserForm").submit(function (event) {

        event.preventDefault();
        if (request) {
          request.abort();
        }
        var $form = $(this);
        var serializedData = $form.serialize();

        request = $.ajax({
          url: "php_backend/user/updateUser.php",
          type: "post",
          data: serializedData,
        });

        request.done(function (response, textStatus, jqXHR) {
          console.log(response);
          // console.log($.parseJSON(response));
          const jsonData = $.parseJSON(response);

          if (jsonData?.isSuccess) {
            // $("#successmsg-area").text(jsonData.message);
            console.log(jsonData);
            Swal.fire({
              title: "Good job!",
              text: "Logged In Successfully",
              icon: "success"
            });

            
            location.href = 'user-profile.php';
          } else {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Failed to login",
            });
          }
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
          console.error("The following error occurred: " + textStatus, errorThrown);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
          });
        });
        request.always(function () { });
      });
    })
  </script>

</body>

</html>