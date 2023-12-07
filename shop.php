<!DOCTYPE html>
<html lang="en">
<?php
include('./includes/head.php');

?>

<body class='bg-light-subtle'>
    <section class="d-flex justify-content-center stickyNav" style="background-color:white">
        <section class="w-75 position-sticky">
            <?php include('./includes/navbar.php') ?>
        </section>

    </section>
    <section>

        <?php
        $id = null;
        if(isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }

        $shopQuerry = "SELECT *
                        FROM pharmacy_admin AS pa
                        INNER JOIN pharmacy_address AS pad
                        ON pa.id = pad.pharmacy_id
                        WHERE pa.id = $id";
        $shopQuerryRun = mysqli_query($conn, $shopQuerry);
        $shopRow = $shopQuerryRun->fetch_assoc();
        $allShopQuerryResult = "".$shopRow["id"]."".$shopRow["first_name"]."".$shopRow["last_name"]." ".$shopRow["shop_name"]." ".$shopRow["admin_email"];
        $shopId = $shopRow["id"];
        $shopName = $shopRow["shop_name"];
        $shopImage = $shopRow["shop_image"];
        $shopRating = $shopRow["rating"];
        $address = $shopRow["address"].", ".$shopRow["city"];

        $imgSrc = $shopImage ? "assets/img/shop/".$shopImage : "assets/img/shop/pharmacy.png";

        ?>
        <div class="d-flex">
            <div class="w-25">
                <img src="assets/img/map.jpeg" class="card-img-top" style="height:300px" alt="...">
            </div>
            <a href="login.php" id="loginPageLink" style="display:none" >login</a>
            <div class="w-75"><img src=<?= $imgSrc ?> class="card-img-top" style="height:300px" alt="..."></div>
        </div>
        <section class="d-flex">
            <div class="w-25" style="background-color:#d3f9ee;">
                <p class="text-center bg-success p-1 text-light fs-5">Category List</p>
                <div class="sidebar px-4" style="height:500px;overflow-y:scroll;">
                    <ul class="list-unstyled">
                        <?php
                        $categoryQuerry = "SELECT `id`,`cat_name` FROM category";
                        $result = $conn->query($categoryQuerry);
                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $catId = $row["id"];
                                $catName = $row["cat_name"];

                                $subCategoryQuerry = "SELECT `id`,`sub_category_name` FROM sub_category WHERE category_id=$catId AND pharmacy_id=$shopId";
                                $subCategoryQresult = $conn->query($subCategoryQuerry);

                                $rowCount = $subCategoryQresult->num_rows;
                                if($rowCount > 0) { ?>
                                    <button href="#services"
                                        class="w-100 btn btn-toggle d-flex justify-content-between align-items-center"
                                        data-bs-toggle="collapse">
                                        <?= $catName ?> <span class="fw-bold">+</span>
                                    </button>
                                    <li>
                                        <ul class="collapse bg-light-subtle" id="services">
                                            <?php
                                            while($subCategoryRow = $subCategoryQresult->fetch_assoc()) {
                                                $subCategoryId = $subCategoryRow["id"];
                                                $subCategoryName = $subCategoryRow["sub_category_name"];
                                                ?>
                                                <li><a href="#" class="link-dark rounded ">
                                                        <?= $subCategoryName ?>
                                                    </a></li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>

                                <?php } else { ?>
                                    <li><button href="#" class="btn btn-toggle w-100 text-start" catId=<?= $catId ?>><?= $catName ?></button></li>


                                    <?php
                                }

                            }
                        }
                        ?>

                    </ul>
                </div>
            </div>
            <div class="w-75">
            
                <div class="container">
                    
                    <div class="row my-3">
                        <?php
                        $userId = isset($_SESSION["loggedInId"]) ? $_SESSION["loggedInId"] : null;
                        $productQuerry = "SELECT * from product WHERE pharmacy_id=$id";
                        $prdQuerryResult = $conn->query($productQuerry);
                        $rowCount = $prdQuerryResult->num_rows;
                        if($rowCount > 0) {
                            while($productRow = $prdQuerryResult->fetch_assoc()) {

                                $prdId = $productRow["prd_id"];
                                $prdName = $productRow["prd_name"];
                                $prdPrice = $productRow["prd_price"];
                                $prdImage = $productRow["prd_image"];
                                $prdDescription = $productRow["prd_description"];
                                $prdCategoryId = $productRow["prd_cat_id"];
                                $prdSubCategoryId = $productRow["prd_sub_cat_id"];

                                $imgSrc = "../pipharm-admin-panel/assets/images/product/".$prdImage;
                                ?>
                                <div class="col-md-3">
                                    <div class="card p-2 rounded-3" style="width: 100%;">
                                        <img src=<?= $imgSrc ?> class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">
                                                <?= $prdName ?>
                                            </h5>
                                            <div class="d-flex justify-content-center align-items-center mb-2">
                                                <span type="button" class="btn input-group-addon btn-number" data-type="minus"
                                                    data-field=<?= "quantity_".$prdId ?>> <i class="fas fa-minus"></i></span>
                                                <input type="text" id=<?= "quantity_".$prdId ?>
                                                    class="form-control text-center mx-3" value="1">
                                                <span type="button" class="btn input-group-addon btn-number" data-type="plus"
                                                    data-field=<?= "quantity_".$prdId ?>> <i class="fas fa-plus"></i> </span>
                                            </div>
                                            
                                            <a href="#" class="btn btn-primary w-100 rounded-5"
                                                onclick='<?php echo "addToCart($prdId,$prdPrice,$userId)" ?>'>Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div>
                </div>

            </div>
        </section>
        </div>
        </div>
    </section>


    </div>
    </div>


    </section>


    </section>

    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Change the '+' and '-' signs on collapse/expand
        document.querySelectorAll('.sidebar .collapse').forEach(collapseElement => {
            collapseElement.addEventListener('show.bs.collapse', function () {
                const parentAnchor = this.previousElementSibling;
                parentAnchor.querySelector('span').textContent = '-';
            });
            collapseElement.addEventListener('hide.bs.collapse', function () {
                const parentAnchor = this.previousElementSibling;
                parentAnchor.querySelector('span').textContent = '+';
            });
        });

        $(document).ready(function () {
            $('.btn-number').click(function (e) {
                e.preventDefault();

                var fieldName = $(this).attr('data-field');
                var type = $(this).attr('data-type');
                var input = $("input[id='" + fieldName + "']");
                var currentVal = parseInt(input.val());
                console.log(currentVal,input,type,fieldName)

                if (!isNaN(currentVal)) {
                    if (type === 'minus') {
                        if (currentVal > 0) {
                            input.val(currentVal - 1);
                        }
                    } else if (type === 'plus') {
                        input.val(currentVal + 1);
                    }
                } else {
                    input.val(0);
                }
            });
        });
        // Function to add to cart
        function addToCart(productId, productPrice, userId) {
            var quantity = parseInt($("#quantity_" + productId).val());
            // Perform action to add product with productId and quantity to cart
            // For example, use AJAX to send this data to the server (e.g., PHP endpoint)
            // $.post('add_to_cart.php', { productId: productId, quantity: quantity }, function(data) {
            //     // Handle response from server (e.g., success message)
            // });
            var dataToSend = {
                id: productId,
                qty: quantity,
                price: productPrice
            };
            if (userId) {
                $.ajax({
                    type: "POST",
                    url: "php_backend/addToCart/add_to_cart.php", // Replace with your backend PHP file
                    data: dataToSend,
                    success: function (response) {
                        console.log(response)
                        // Handle the response from the server
                        const res = JSON.parse(response);

                        if (res.type == "add") {
                            console.log("added item")
                            //update cart
                            var currentValue = parseInt($("#cart").text());
                            var incrementedValue = currentValue + 1;
                            $("#cart").text(incrementedValue);
                        }
                        else {
                            console.log("added updated");
                        }
                        // Example: Display a success message to the user
                        // alert('Data sent successfully to backend');
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText); // Log any errors to the console
                        // Example: Display an error message to the user
                        alert('Error sending data to backend');
                    }
                });
            }
            else{
                console.log("asd");
                document.getElementById('loginPageLink').click();
            }

            // alert('Added ' + quantity + ' items of product with ID ' + productId + ' to cart');
        }
    </script>
  

</body>

</html>