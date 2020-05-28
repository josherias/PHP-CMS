<?php require('./Includes/DB.php'); ?>
<?php require('./Includes/Functions.php'); ?>
<?php require('./Includes/Sessions.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog Page</title>

    <link rel="stylesheet" href="./Css/all.css" />
    <link rel="stylesheet" href="./Css/bootstrap.min.css" />
    <link rel="stylesheet" href="./Css/style.css" />
</head>

<body>
    <!-- ---------------------NAVBAR---------------------- -->
    <div class="" style="height: 5px; background: #27aae1;"></div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="Blog.php?page=1" class="navbar-brand">JOSH</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Home</a>
                    </li>

                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Blog</a>
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
                    <li class="nav-item">
                        <a href="Login.php" class="nav-link"><i class="fas fa-user"></i> Admin Login</a>
                    </li>
                </ul>
                <!-- ------X--------search button-----X-------- -->
            </div>
        </div>
    </nav>
    <div class="" style="height: 5px; background: #27aae1;"></div>

    <!-- ---------X------------NAVBAR-------------X--------- -->

    <!-- ---------------------HEADER---------------------- -->
    <div class="container">
        <div class="row mt-4">
            <!-- ------Main Area-------- -->
            <div class="col-sm-9">
                <h1>The complete CMS Blog</h1>
                <h1 class="lead">The complete Blog Using PHP @ Josh</h1>
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <?php
                $connectingDB;
                // Code for our search button
                if (isset($_GET['SearchButton'])) {
                    $Search = $_GET['Search'];

                    $sql = "SELECT * FROM posts 
                            WHERE datetime LIKE :search
                            OR title LIKE :search
                            OR category LIKE :search
                            OR post LIKE :search";
                    $stmt = $connectingDB->prepare($sql);
                    $stmt->bindValue(':search', '%' . $Search . '%');
                    $stmt->execute();
                }
                //query when pagination is active, Blog.php?page=1;
                elseif (isset($_GET['page'])) {
                    $Page = $_GET['page'];
                    if ($Page == 0 || $Page < 1) {
                        $ShowPostFrom = 0;
                    } else {
                        $ShowPostFrom = ($Page * 5) - 5;
                    }


                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,5";
                    $stmt = $connectingDB->query($sql);
                }
                //query when  category is active in url Tab
                elseif (isset($_GET['category'])) {
                    $Category = $_GET['category'];

                    $sql = "SELECT * FROM posts WHERE category='$Category' ORDER BY id desc";
                    $stmt = $connectingDB->query($sql);
                    $stmt->execute();
                }

                // the default sql query if search button isnt clicked
                else {
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
                    $stmt = $connectingDB->query($sql);
                }
                while ($DataRows = $stmt->fetch()) {
                    $PostId = $DataRows['id'];
                    $DateTime = $DataRows['datetime'];
                    $PostTitle = $DataRows['title'];
                    $Category = $DataRows['category'];
                    $Admin = $DataRows['author'];
                    $Image = $DataRows['image'];
                    $PostDescription = $DataRows['post'];
                ?>

                    <div class="card mb-5">
                        <img src="Uploads/<?php echo htmlentities($Image); ?>" class="img-fluid card-img-top" alt="" style="max-height: 400px;">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
                            <small class="text-muted"> <strong>Category :</strong> <a href="Blog.php?category=<?php echo htmlentities($Category); ?>"> <?php echo htmlentities($Category); ?> </a> <br><strong>Written By</strong> <a href="Profile.php?username=<?php echo htmlentities($Admin);  ?>"> <?php echo htmlentities($Admin); ?></a> On <?php echo htmlentities($DateTime); ?></small>
                            <span style="float:right;" class="badge badge-dark text-light">Comments <?php echo htmlentities(ApproveCommentAccordingToPost($PostId, $connectingDB)); ?></span>

                            <hr>
                            <p class="card-text"><?php if (strlen($PostDescription) > 150) {
                                                        $PostDescription = substr($PostDescription, 0, 15) . "...";
                                                    }
                                                    echo htmlentities($PostDescription); ?></p>
                            <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right;">
                                <span class="btn btn-info">Read More >> </span>
                            </a>

                        </div>
                    </div>

                <?php } ?>

                <!-- ----pagination----- -->
                <nav>
                    <ul class="pagination pagination-lg">
                        <!-- --------creating backward button------ -->
                        <?php
                        if (isset($Page)) {
                            if ($Page > 1) { ?>
                                <li class="page-item">
                                    <a href="Blog.php?page=<?php echo $Page - 1; ?>" class="page-link">&laquo; </a>
                                </li>
                        <?php }
                        } ?>

                        <?php
                        global $connectingDB;
                        $sql = "SELECT COUNT(*) FROM posts";
                        $stmt = $connectingDB->query($sql);
                        $RowPagination = $stmt->fetch();
                        $TotalPosts = array_shift($RowPagination);
                        // echo $TotalPosts;
                        $PostPagination = $TotalPosts / 5;
                        $PostPagination = ceil($PostPagination);
                        // echo $PostPagination;

                        for ($i = 1; $i <= $PostPagination; $i++) {
                            if (isset($Page)) {
                                if ($i == $Page) { ?>
                                    <li class="page-item active">
                                        <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?> </a>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="page-item">
                                        <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?> </a>
                                    </li>
                        <?php }
                            }
                        } ?>
                        <!-- --------creating forward button------ -->
                        <?php
                        if (isset($Page) && !empty($Page)) {
                            if ($Page + 1 <= $PostPagination) { ?>
                                <li class="page-item">
                                    <a href="Blog.php?page=<?php echo $Page + 1; ?>" class="page-link">&raquo; </a>
                                </li>
                        <?php }
                        } ?>


                    </ul>
                </nav>


            </div>
            <!-- --X----Main Area----X---- -->

            <!-- ------Side Area-------- -->
            <div class="col-sm-3 d-none d-md-block d-lg-block">
                <!-- -------card one ------- -->
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="Images/tik-tok-0827.jpg" class="d-block img-fluid mb-3" alt="">
                        <div class="text-center">
                            <a href="www.google.com/tiktok" target="_blank">
                                <h3>Tik Tok</h3>
                            </a>
                            <h4 class="lead">Sign Up for free</h4>
                            <p>Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit. Dolorum consequuntur autem iste
                                voluptatem temporibus inventore similique repellat omnis, quo ullam
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad, nam.</p>
                        </div>
                    </div>
                </div>
                <br>

                <!-- -------card three ------- -->
                <div class="card mt-5">
                    <div class="card-body">
                        <img src="Images/Whopper.jpg" class="d-block img-fluid mb-3" alt="">
                        <div class="text-center">
                            <a href="www.google.com/whooper" target="_blank">
                                <h3>Whooper</h3>
                            </a>
                            <h4 class="lead">Anywhere AnyPlace AnyTime</h4>
                            <p>Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit. Dolorum consequuntur autem iste
                                voluptatem temporibus inventore similique repellat omnis, quo ullam
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad, nam.</p>
                        </div>
                    </div>
                </div>
                <!-- -------card four ------- -->
                <div class="card mt-5">
                    <div class="card-header bg-primary text-light">
                        <h2 class="lead">Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        $connectingDB;

                        $sql  = "SELECT * FROM category ORDER BY id desc";
                        $stmt = $connectingDB->query($sql);
                        while ($DataRows = $stmt->fetch()) {
                            $CategoryId = $DataRows['id'];
                            $CategoryName = $DataRows['title'];
                        ?>
                            <a href="Blog.php?category=<?php echo $CategoryName ?>" class="btn btn-light btn-block"><?php echo htmlentities($CategoryName); ?></a> <br>
                        <?php } ?>
                    </div>

                </div>
                <br>
                <!-- -------card three ------- -->
                <div class="card mt-5">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="www.google.com/tiktok" target="_blank">
                                <h3>Huawei Technologies</h3>
                            </a>

                            <h4 class="lead">Get the latest Technology</h4>
                            <p>Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit.</p>
                        </div>
                        <img src="Images/huawei.jpeg" class="d-block img-fluid mb-3" alt="">
                    </div>
                </div>
                <br>
                <!-- -------card six ------- -->
                <div class="card mt-5">
                    <div class="card-header bg-info text-white">
                        <h2 class="lead">Recent Posts</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        $connectingDB;
                        $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                        $stmt = $connectingDB->query($sql);

                        while ($DataRows = $stmt->fetch()) {
                            $Id = $DataRows['id'];
                            $Title = $DataRows['title'];
                            $DateTime = $DataRows['datetime'];
                            $Image = $DataRows['image'];

                        ?>
                            <div class="media">
                                <img src="Uploads/<?php echo  htmlentities($Image); ?>" alt="" class="d-block img-fluid align-self-start" width="90" height="94">
                                <div class="media-body ml-2">
                                    <a href="FullPost.php?id=<?php echo  htmlentities($Id); ?>" target="_blank">
                                        <h6 class="lead"><?php echo  htmlentities($Title); ?></h6>
                                    </a>
                                    <p class="small"><?php echo  htmlentities($DateTime); ?></p>
                                </div>
                            </div>
                            <hr>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- -X-----Side Area-----X--- -->
        </div>
    </div>
    <!-- ---------X------------HEADER-------------X--------- -->

    <!-- --------------MAIN--------------------------------- -->
    <br>
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