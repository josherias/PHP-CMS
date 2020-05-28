<?php require('./Includes/DB.php'); ?>
<?php require('./Includes/Functions.php'); ?>
<?php require('./Includes/Sessions.php'); ?>
<?php
//fetch existing data
$SearchQueryParameter = $_GET['username'];

$connectingDB;
$sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username = :userName";
$stmt = $connectingDB->prepare($sql);
$stmt->bindValue(':userName', $SearchQueryParameter);
$stmt->execute();
$Result = $stmt->rowCount();

if ($Result == 1) {
    while ($DataRows = $stmt->fetch()) {
        $ExistingName = $DataRows['aname'];
        $ExistingBio = $DataRows['abio'];
        $ExistingImage = $DataRows['aimage'];
        $ExistingHeadline = $DataRows['aheadline'];
    }
} else {
    $_SESSION['ErrorMessage'] = "Bad Request !!";
    Redirect_to("Blog.php?page=1");
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>

    <link rel="stylesheet" href="./Css/all.css" />
    <link rel="stylesheet" href="./Css/bootstrap.min.css" />
    <link rel="stylesheet" href="./Css/style.css" />
</head>

<body>
    <!-- ---------------------NAVBAR---------------------- -->
    <div class="" style="height: 5px; background: #27aae1;"></div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">JOSH</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Features</a>
                    </li>

                </ul>
                <!-- --------------search button------------- -->
                <ul class="navbar-nav ml-auto">
                    <form class="form-inline d-none d-sm-block" action="Blog.php" method="GET">
                        <div class="form-group">
                            <input class="form-control mr-2" type="text" name="Search" placeholder="Search here">
                            <button type="submit" class="btn btn-primary" name="SearchButton">Go</button>

                        </div>
                    </form>
                </ul>
                <!-- ------X--------search button-----X-------- -->
            </div>
        </div>
    </nav>
    <div class="" style="height: 5px; background: #27aae1;"></div>

    <!-- ---------X------------NAVBAR-------------X--------- -->

    <!-- ---------------------HEADER---------------------- -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>
                        <i class="fa fa-user text-success mr-2" style="color: #27aae1;"></i> <?php echo htmlentities($ExistingName); ?>
                    </h1>
                    <h3><?php echo htmlentities($ExistingHeadline); ?></h3>
                </div>
            </div>
        </div>
    </header>
    <!-- ---------X------------HEADER-------------X--------- -->
    <!-- --------------MAIN--------------------------------- -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-md-3" style="min-height: 400px;">
                <img src="Images/<?php echo htmlentities($ExistingImage); ?>" class="d-block img-fluid mb-3 rounded-circle" alt="">
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <p class="lead"><?php echo htmlentities($ExistingBio); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- --------x------MAIN---------------------x------------ -->
    <!-- ----------------FOOTER-------------------------------- -->

    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">
                        Theme | By Josh |<span id="year"></span> &copy; ---All Rights
                        Reserved.
                    </p>
                    <p class="text-center small">
                        <a href="#" style="color: white; text-decoration: none; cursor: pointer;">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero,
                            ea deserunt veritatis atque numquam mollitia evenie t incidunt,

                            <br />
                            &trade; wwww.josherias.com &trade; Foreign Josh
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <div class="" style="height: 5px; background: #27aae1;"></div>

    <!-- --------x--------FOOTER---------------x----------------- -->

    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script>
        $("#year").text(new Date().getFullYear());
    </script>
</body>

</html>