<?php
include('../../config/dbConn.php');
if (isset($_POST['shopId'])) {
    $shopId = $_POST['shopId'];

    $categoryQuerry = "SELECT `id`,`cat_name` FROM category";
    $result = $conn->query($categoryQuerry);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $catId = $row["id"];
            $catName = $row["cat_name"];

            $subCategoryQuerry = "SELECT `id`,`sub_category_name` FROM sub_category WHERE category_id=$catId AND pharmacy_id=$shopId";
            $subCategoryQresult = $conn->query($subCategoryQuerry);

            $rowCount = $subCategoryQresult->num_rows;
            if ($rowCount > 0) { ?>
                <button href="#services" onclick='<?="selectCategory($catId)" ?>' class="w-75 btn btn-toggle d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse">
                    <?= $catName ?> 
                    <span class="fw-bold">+</span>
                </button>
                <li>
                    <ul class="collapse bg-light-subtle" id="services">
                        
                        <?php
                        while ($subCategoryRow = $subCategoryQresult->fetch_assoc()) {
                            $subCategoryId = $subCategoryRow["id"];
                            $subCategoryName = $subCategoryRow["sub_category_name"];
                            ?>
                            <li><span onclick='<?="selectCategory($shopId,$catId,$subCategoryId)" ?>' class="link-dark rounded ">
                                    <?= $subCategoryName ?>
                                </span></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>

            <?php } else { ?>
                <li><button href="#" class="btn btn-toggle w-100 text-start" onclick='<?="selectCategory($shopId,$catId)" ?>'><?= $catName ?></button></li>


                <?php
            }

        }
    }
}

?>