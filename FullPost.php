<?php require('./Includes/DB.php'); ?>
<?php require('./Includes/Functions.php'); ?>
<?php require('./Includes/Sessions.php'); ?>
<?php
$SearchQueryParameter = $_GET['id'];
?>
<?php
if (isset($_POST['Submit'])) {

    $Name = $_POST['CommenterName'];
    $Email = $_POST['CommenterEmail'];
    $Comment = $_POST['CommenterThoughts'];
    // date_default_timezone_set();
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);


    if (empty($Name) || empty($Email) || empty($Comment)) {
        $_SESSION['ErrorMessage'] = 'All fields must be filled';
        Redirect_to("FullPost.php?id=$SearchQueryParameter");
    } elseif (strlen($Comment) > 499) {
        $_SESSION['ErrorMessage'] = 'Comment should be less than 500 characters';
        Redirect_to("FullPost.php?id=$SearchQueryParameter");
    } else {

        //query to insert comment in the database
        $sql = "INSERT INTO comments (datetime,name,email,comment,approvedby,status,post_id) 
                VALUES (:datetimE, :namE, :emaiL, :commenT, 'Pending', 'OFF',:postIdFromURL)"; //created a relationship btn our posts and comments using postid
        $stmt = $connectingDB->prepare($sql);
        $stmt->bindValue(':datetimE', $DateTime);
        $stmt->bindValue(':namE', $Name);
        $stmt->bindValue(':emaiL', $Email);
        $stmt->bindValue(':commenT', $Comment);
        $stmt->bindValue(':postIdFromURL', $SearchQueryParameter);
        $Execute = $stmt->execute();




        if ($Execute) {
            $_SESSION['SuccessMessage'] = "Comment submitted sucessfully";
            Redirect_to("FullPost.php?id=$SearchQueryParameter");
        } else {
            $_SESSION['ErrorMessage'] = 'Something went wrong';
            Redirect_to("FullPost.php?id=$SearchQueryParameter");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Full Post Page</title>

    <link rel="stylesheet" href="./Css/all.css" />
    <link rel="stylesheet" href="./Css/bootstrap.min.css" />
    <link rel="stylesheet" href="./Css/style.css" />
    <style media="screen"></style>
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
            </div>
        </div>
    </nav>
    <div class="" style="height: 5px; background: #27aae1;"></div>

    <!-- ---------X------------NAVBAR-------------X--------- -->

    <!-- ---------------------HEADER---------------------- -->
    <div class="container">
        <div class="row mt-4">
            <!-- ------Main Area-------- -->
            <div class="col-sm-8">
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
                // the default sql query if search button isnt clicked
                else {
                    $PostIdFromURL = $_GET['id'];
                    if (!isset($PostIdFromURL)) {
                        $_SESSION['ErrorMessage'] = "Sorry page not found";
                        Redirect_to("Blog.php");
                    }
                    $sql = "SELECT * FROM posts WHERE id = '$PostIdFromURL'";
                    $stmt = $connectingDB->query($sql);
                    $Result = $stmt->rowCount();

                    if ($Result != 1) {
                        $_SESSION['ErrorMessage'] = "Sorry page not found";
                        Redirect_to("Blog.php?page=1");
                    }
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
                            <small class="text-muted"> <strong>Category :</strong> <a href="Blog.php?category=<?php echo htmlentities($Category); ?>"> <?php echo htmlentities($Category); ?> </a> <br><strong>Written By</strong> <?php echo htmlentities($Admin); ?> On <?php echo htmlentities($DateTime); ?></small>


                            <hr>
                            <p class="card-text"><?php echo htmlentities($PostDescription); ?></p>


                        </div>
                    </div>

                <?php } ?>
                <!-- ------------comments section----------------------- -->

                <span class="FieldInfo">Comments</span>
                <br> <br>
                <!-- --------------------fetching existing comments------------ -->
                <?php
                $connectingDB;
                $sql = "SELECT * FROM comments 
                        WHERE post_id = '$SearchQueryParameter' AND status = 'ON'";
                $stmt = $connectingDB->query($sql);

                while ($DataRows = $stmt->fetch()) {
                    $CommentDate = $DataRows['datetime'];
                    $CommenterName = $DataRows['name'];
                    $CommentContent = $DataRows['comment'];

                ?>
                    <div>
                        <div class="media ">
                            <img class="d-block img-fluid align-self-start" src="Images/j.gif" alt="" width="100px">
                            <div class="media-body ml-2 mb-3 CommentBlock">
                                <h6 class="lead"><strong><?php echo $CommenterName; ?></strong></h6>
                                <p class="small"><?php echo $CommentDate; ?></p>
                                <p><?php echo $CommentContent; ?></p>

                            </div>

                        </div>
                        <hr>
                    </div>
                <?php  } ?>

                <!-- -----------X---------fetching existing comments------X------ -->

                <div class="mt-4">
                    <form action="FullPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="FieldInfo">Share your thouts about this post</h5>
                                <small style="color: red;">Your Comment will Only be visible After Approval</small>
                            </div>
                            <div class="card-body">
                                <!-- --------------CommenterNAme Field------------- -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                        </div>
                                        <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
                                    </div>
                                </div>
                                <!-- -------X-------CommenterNAme Field-----X-------- -->

                                <!-- --------------Email Field------------- -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                        </div>
                                        <input class="form-control" type="email" name="CommenterEmail" placeholder="Email" value="">
                                    </div>
                                </div>
                                <!-- -------X-------Email Field-----X-------- -->

                                <!-- --------------Text Area------------- -->
                                <div class="form-group">
                                    <textarea class="form-control" name="CommenterThoughts" id="" cols="20" rows="6"></textarea>
                                </div>
                                <!-- -------X-------Text Area-----X-------- -->

                                <!-- --------------Submit Button------------- -->
                                <div class="">
                                    <button class="btn btn-primary" type="submit" name="Submit">Submit</button>
                                </div>
                                <!-- -------X-------Submit Button-----X-------- -->
                            </div>
                        </div>
                    </form>
                </div>
                <!-- ----X--------comments section----------X---------- -->


            </div>
            <!-- --X----Main Area----X---- -->

            <!-- ------Side Area-------- -->
            <div class="col-sm-4 d-none d-md-block d-lg-block">
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
                                <h3>Order From Whopper</h3>
                            </a>
                            <h4 class="lead">Anywhere AnyPlace AnyTime</h4>
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
                        <div class="text-center">

                            <a href="www.google.com/Huawei" target="_blank">
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