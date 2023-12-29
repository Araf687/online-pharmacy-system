<section class="d-flex justify-content-between align-items-center py-1 bg-white">
    <a href="index.php" style="text-decoration:none">
        <div class="d-flex">
            <div style="padding-right:2px; color:#75aa22;">
                <h3 style="font-weight:700; font-size:40px">Pi</h3>
            </div>
            <div class="pe-1">
                <h3 style="font-weight:700; font-size:40px; color:#426e0a">Pharm</h3>
            </div>
            <div style="line-height: 0.85;
                margin-top: 14px;">
                <p class="my-0 py-0" style="color:#b9997c"><span style="font-weight:600">online</span></p>
                <p class="my-0 py-0" style="color:#b9997c"><span style="font-weight:600">store</span> </p>
            </div>

        </div>
    </a>
    <!-- <div style="width:380px">
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div> -->
    <div>
        <nav class="d-flex align-items-center">
            <a href="about.php" class="link-underline-light text-decoration-none me-3">About</a>
            <a href="category.php" class="link-underline-light text-decoration-none me-3">Categories</a>
            <a href="all-shop.php" class="link-underline-light text-decoration-none me-3">Shops</a>
            <a href="" class="link-underline-light text-decoration-none me-3">Help</a>
            <span class="position-relative mt-1" data-toggle="modal" data-target="#cartModal">
                <span><i class="fa-solid fa-cart-shopping" style="font-size:20px"></i></span>
                <span id="cart" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php
                    if (isset($_SESSION['loggedInId'])) {
                        $userId=$_SESSION['loggedInId'];
                        $sql="SELECT * FROM cartitem WHERE `cust_id`=$userId";
                        $result=mysqli_query($conn,$sql);
                        $row_count = mysqli_num_rows($result);
                        echo $row_count;
                    }
                    ?>
                </span>
            </span>

            <span class="ms-4">
                <?php
                if (isset($_SESSION['userType']) == false) {
                    ?>
                    <a href="login.php" class="link-underline-light text-decoration-none"><i
                            class="fa-solid fa-arrow-right-to-bracket"></i> login</a>
                    <?php
                } else {
                    if (isset($_SESSION['user_img'])) {
                        $imgSrc = $_SESSION['user_img'] ? "assets/img/user/" . $_SESSION['user_img'] : "assets/img/user/user.png";
                    }
                    ?>
                    <div>
                        <img src=<?= $imgSrc ?> id="dropdownMenuButton" class="rounded-circle dropdown-toggle"
                            style="width: 35px;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" />
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="user-profile.php" ><i class="fa-solid fa-user me-2" style="color:#12dab9;"></i>Profile</a>
                            <a class="dropdown-item" href="logout.php"><i class="fa-solid fa-power-off me-2" style="color:red;"></i>Logout</a>

                        </div>
                    </div>
                <?php } ?>
            </span>




        </nav>
    </div>

</section>