<?php require('./Includes/DB.php'); ?>
<?php require('./Includes/Functions.php'); ?>
<?php require('./Includes/Sessions.php'); ?>
<?php
//geting the url directory using server super global
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];

//making page password protected
Confirm_Login(); ?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Posts</title>

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
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>
                        <i class="fa fa-blog" style="color: #27aae1;"></i> Blog Posts
                    </h1>
                </div>
                <!-- -----------------Buttons---------------------- -->
                <div class="col-lg-3 mb-2">
                    <a href="AddNewPost.php" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i> Add New Post
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Categories.php" class="btn btn-info btn-block">
                        <i class="fas fa-folder-plus"></i> Add New category
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Admins.php" class="btn btn-warning btn-block">
                        <i class="fas fa-user-plus"></i> Add New Admin
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Comments.php" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i> Approve Comments
                    </a>
                </div>
                <!-- -----------------Buttons---------------------- -->
            </div>
        </div>
    </header>
    <!-- ---------X------------HEADER-------------X--------- -->

    <!-- --------------MAIN--------------------------------- -->
    <section class="container py-2 mb-4" style="min-height: 400px;">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-hover">
                    <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                    ?>
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Action</th>
                            <th>Live Preview</th>
                        </tr>
                    </thead>

                    <?php
                    $connectingDB;
                    $sql = "SELECT * FROM posts";
                    $stmt = $connectingDB->query($sql);
                    $Sr = 0;
                    while ($DataRows = $stmt->fetch()) {
                        $Id         =   $DataRows['id'];
                        $DateTime   =   $DataRows['datetime'];
                        $PostTitle  =   $DataRows['title'];
                        $Category   =   $DataRows['category'];
                        $Admin      =   $DataRows['author'];
                        $Image      =   $DataRows['image'];
                        $PostText   =   $DataRows['post'];
                        $Sr++;


                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo $Sr; ?>
                                </td>
                                <td>
                                    <?php if (strlen($PostTitle) > 20) {
                                        $PostTitle = substr($PostTitle, 0, 15) . '..';
                                    }
                                    echo $PostTitle; ?>
                                </td>

                                <td><?php if (strlen($Category) > 8) {
                                        $Category = substr($Category, 0, 8) . '..';
                                    }
                                    echo $Category; ?>
                                </td>
                                <td><?php if (strlen($DateTime) > 11) {
                                        $DateTime = substr($DateTime, 0, 11) . '..';
                                    }
                                    echo $DateTime; ?>
                                </td>
                                <td><?php
                                    if (strlen($Admin) > 6) {
                                        $Admin = substr($Admin, 0, 6) . '..';
                                    }
                                    echo $Admin; ?>
                                </td>
                                <td><img src="Uploads/<?php echo $Image; ?>" width="100px" height="50px" alt=""></td>

                                <td>
                                    <?php
                                    $Total = ApproveCommentAccordingToPost($Id, $connectingDB);
                                    if ($Total > 0) {
                                    ?>
                                        <span class="badge badge-success">
                                            <?php echo $Total; ?>
                                        </span>
                                    <?php } ?>

                                    <span />

                                    <?php
                                    $Total = DisApproveCommentAccordingToPost($Id, $connectingDB);

                                    if ($Total > 0) {
                                    ?>
                                        <span class="badge badge-danger">
                                            <?php echo $Total; ?>
                                        </span>
                                    <?php } ?>



                                </td>
                                <td>
                                    <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
                                    <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
                                </td>
                                <td>
                                    <a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>

                </table>
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