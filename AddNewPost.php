<?php require('./Includes/DB.php'); ?>
<?php require('./Includes/Functions.php'); ?>
<?php require('./Includes/Sessions.php'); ?>
<?php
//geting the url directory using server super global
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];

//making page password protected
Confirm_Login(); ?>
<?php
if (isset($_POST['Submit'])) {

    $PostTitle  = $_POST['PostTitle'];
    $Category   = $_POST["Category"];
    $Image      = $_FILES['Image']['name'];
    $Target     = "Uploads/" . basename($_FILES['Image']['name']);
    $PostText   = $_POST['PostDescription'];
    $Admin      = $_SESSION['UserName'];
    // date_default_timezone_set();
    $CurrentTime = time();
    $DateTime    = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);


    if (empty($PostTitle)) {
        $_SESSION['ErrorMessage'] = 'Title cant be empty';
        Redirect_to('AddNewPost.php');
    } elseif (strlen($PostTitle) < 5) {
        $_SESSION['ErrorMessage'] = 'Post title should be greater than 5 characters';
        Redirect_to('AddNewPost.php');
    } elseif (strlen($PostText) > 9999) {
        $_SESSION['ErrorMessage'] = 'Post Description should be less 1000 characters';
        Redirect_to('AddNewPost.php');
    } elseif (empty($Category)) {
        $_SESSION['ErrorMessage'] = 'Category cant be empty';
        Redirect_to('AddNewPost.php');
    } else {

        //insert post into database 

        $sql = "INSERT INTO posts (datetime, title, category, author, image, post) 
                VALUES (:dateTime, :postTitle, :categoryName, :adminName, :imageName, :postDescription)";
        $stmt = $connectingDB->prepare($sql);

        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':postTitle', $PostTitle);
        $stmt->bindValue(':categoryName', $Category);
        $stmt->bindValue(':adminName', $Admin);
        $stmt->bindValue(':imageName', $Image);
        $stmt->bindValue(':postDescription', $PostText);
        $Execute = $stmt->execute();

        move_uploaded_file($_FILES['Image']['tmp_name'], $Target);

        if ($Execute) {
            $_SESSION['SuccessMessage'] = "Post was  Added sucessfully";
            Redirect_to("AddNewPost.php");
        } else {
            $_SESSION['ErrorMessage'] = 'something went wrong';
            Redirect_to("AddNewPost.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add New Post</title>

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
                        <i class="fas fa-edit" style="color: #27aae1;"></i> Add New Post
                    </h1>
                </div>
            </div>
        </div>
    </header>
    <!-- ---------X------------HEADER-------------X--------- -->
    <!-- --------------MAIN--------------------------------- -->
    <section class="container py-3">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height: 400px">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>

                <!-- --------------FORM---------------------------------- -->
                <form action="AddNewPost.php" method="POST" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light ">

                        <div class="card-body bg-dark">
                            <!-- -----X---------post title------------X-------------------- -->
                            <div class="form-group">
                                <label for="title">
                                    <span class="FieldInfo">Post Title :</span>
                                </label>
                                <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type Title Here" value="" />
                            </div>
                            <!-- -----X---------post title------------X-------------------- -->

                            <!-- --------------choose Category-------------------------------- -->
                            <div class="form-group py-2">
                                <label for="CategoryTitle">
                                    <span class="FieldInfo">Choose Category :</span>
                                </label>
                                <select class="form-control" name="Category" id="CategoryTitle">
                                    <?php
                                    // fetching all categories from the category table
                                    global $connectingDB;
                                    $sql = "SELECT id,title FROM category";
                                    $stmt = $connectingDB->query($sql);

                                    while ($DataRows = $stmt->fetch()) {
                                        $Id = $DataRows["id"];
                                        $CategoryName = $DataRows["title"];

                                    ?>
                                        <option><?php echo $CategoryName; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- ------X--------choose Category-------------X------------------- -->

                            <!-- --------------Image file-------------------------------- -->
                            <div class="form-group py-2">

                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                    <label for="imageSelect" class="custom-file-label">Select Image</label>
                                </div>
                            </div>
                            <!-- -------X-------Image file-------------X------------------- -->

                            <!-- --------------post---------------------------------------- -->
                            <div class="form-group">
                                <label for="Post"> <span class="FieldInfo">Post:</span></label>
                                <textarea class="form-control" name="PostDescription" id="Post" cols="80" rows="8"></textarea>
                            </div>
                            <!-- ------X--------post---------------X------------------------ -->

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