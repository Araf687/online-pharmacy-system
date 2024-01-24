<!DOCTYPE html>
<html lang="en">
<?php include('./includes/head.php') ?>

<body class='bg-light-subtle'>
    <section class="d-flex justify-content-center position-sticky shadow stickyNav" style="background-color:white">
        <section class="w-75">
            <?php include('./includes/navbar.php') ?>
        </section>
    </section>
    <section class="d-flex" style="height:450px">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search..." aria-label="Search"
                        aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">Search</button>
                    </div>
                </div>
            </div>
    </section>


    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>


</body>

</html>