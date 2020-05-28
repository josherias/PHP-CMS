<?php require('./Includes/DB.php'); ?>
<?php require('./Includes/Functions.php'); ?>
<?php require('./Includes/Sessions.php'); ?>
<?php
//geting the url directory using server super global
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];

//making page password protected
Confirm_Login(); ?>
<?php

///fetching existing admin data
$AdminId = $_SESSION['UserId'];
$connectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $connectingDB->query($sql);

while ($DataRows = $stmt->fetch()) {
    $ExistingName = $DataRows['aname'];
    $ExistingUserName = $DataRows['username'];
    $ExistingHeadline = $DataRows['aheadline'];
    $ExistingBio = $DataRows['abio'];
    $ExistingImage = $DataRows['aimage'];
}
///fetching existing admin data end

if (isset($_POST['Submit'])) {

    $AdminId = $_SESSION['UserId'];

    $AName  = $_POST['Name'];
    $AHeadline   = $_POST["Headline"];
    $ABio   = $_POST['Bio'];
    $Image      = $_FILES['Image']['name'];
    $Target     = "Images/" . basename($_FILES['Image']['name']);


    if (strlen($AHeadline) > 30) {
        $_SESSION['ErrorMessage'] = 'Headline Should be less than 30 characters';
        Redirect_to('MyProfile.php');
    } elseif (strlen($ABio) > 500) {
        $_SESSION['ErrorMessage'] = 'Bio should be less 1000 characters';
        Redirect_to('MyProfile.php');
    } else {
        //Query to update admin data in the database when everything is fine
        $connectingDB;
        if (!empty($_FILES['Image']['name'])) {

            $sql = "UPDATE admins
                    SET aname = '$AName', aheadline ='$AHeadline', abio = '$ABio' , aimage ='$Image'
                    WHERE id ='$AdminId'";
        } else {
            // dont update if image is empty
            $sql = "UPDATE admins
                    SET aname = '$AName', aheadline ='$AHeadline', abio = '$ABio'
                    WHERE id ='$AdminId'";
        }

        $Execute = $connectingDB->query($sql);
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target); //function to send updated image to the images folder

        // var_dump($Execute);
        if ($Execute) {
            $_SESSION['SuccessMessage'] = "Details Updated sucessfully";
            Redirect_to('MyProfile.php');
        } else {
            $_SESSION['ErrorMessage'] = 'something went wrong';
            Redirect_to('MyProfile.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Profile</title>

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
                        <a href="MyProfile.php" class="nav-link">
                            <i class="fas fa-user text-success"></i> My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="Dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="Posts.php" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="Categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="Admins.php" class="nav-link">Manage Admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="Comments.php" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Live blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="Logout.php" class="nav-link text-danger">
                            <i class="fas fa-user-times"></i> Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="" style="height: 5px; background: #27aae1;"></div>

    <!-- ---------X------------NAVBAR-------------X--------- -->

    <!-- ---------------------HEADER---------------------- -->
    <header class="bg-dark text-white py-3 mb-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>
                        <i class="fas fa-user mr-2 text-success"></i> <?php echo htmlentities($ExistingUserName) ?>
                    </h1>
                    <small><?php echo htmlentities($ExistingHeadline); ?></small>
                </div>
            </div>
        </div>
    </header>
    <!-- ---------X------------HEADER-------------X--------- -->

    <!-- --------------MAIN--------------------------------- -->
    <section class="container py-3">
        <div class="row">
            <!-- ------- left Area ------- -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h3><?php echo $ExistingName; ?></h3>
                    </div>
                    <div class="card-body">
                        <img src="Images/<?php echo htmlentities($ExistingImage); ?>" class="d-block img-fluid mb-3" alt="">
                        <div>
                            <p><?php echo htmlentities($ExistingBio); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- --X----- left Area ---X---- -->

            <!-- ----- right area--------- -->
            <div class="col-md-9" style="min-height: 400px">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>

                <!-- --------------FORM---------------------------------- -->
                <form action="MyProfile.php" method="POST" enctype="multipart/form-data">
                    <div class="card bg-dark text-light">
                        <div class="card-header bg-secondary text-light">
                            <h1>Edit Profile</h1>
                        </div>

                        <div class="card-body">
                            <!-- -----X---------name------------X-------------------- -->
                            <div class="form-group">
                                <input class="form-control" type="text" name="Name" placeholder="Your Name" value="" />
                            </div>
                            <!-- -----X---------name------------X-------------------- -->
                            <br>
                            <!-- --------------Headline-------------------------------- -->
                            <div class="form-group">
                                <input class="form-control" type="text" name="Headline" placeholder="Headline" value="" />
                                <small class="text-muted">Add a professional headline like 'Engineer' at Tesla or 'Designer'</small>
                                <span class="text-danger">Not more than 30 characters</span>
                            </div>
                            <!-- ------X--------Headline-------------X------------------- -->

                            <!-- --------------bio---------------------------------------- -->
                            <div class="form-group">
                                <textarea class="form-control" name="Bio" cols="80" rows="8" placeholder="Enter You Bio"></textarea>
                            </div>
                            <!-- ------X--------Bio---------------X------------------------ -->

                            <!-- --------------Image file-------------------------------- -->
                            <div class="form-group py-2">

                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                    <label for="imageSelect" class="custom-file-label">Select Image</label>
                                </div>
                            </div>
                            <!-- -------X-------Image file-------------X------------------- -->



                            <!-- --------------Buttons--------------------------------------- -->
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block"> <i class="fas fa-arrow-left"></i> Back to Dashboard </a>
                                </div>
                                <!-- --------------Submit Button--------------------------------------- -->
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check"></i> Publish
                                    </button>
                                </div>
                            </div>
                            <!-- ------X--------Buttons---------------X------------------------ -->
                        </div>
                    </div>
                </form>
                <!-- ------------X------FORM------------------X---------------- -->

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