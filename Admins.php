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

    $Username = $_POST['Username'];
    $Name = $_POST['Name'];
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword'];
    $Admin =  $_SESSION['UserName'];
    // date_default_timezone_set();
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);


    if (empty($Username) || empty($Password) || empty($ConfirmPassword)) {
        $_SESSION['ErrorMessage'] = 'All fields must be filled';
        Redirect_to('Admins.php');
    } elseif (strlen($Password) < 4) {
        $_SESSION['ErrorMessage'] = 'Password should be greater than 3 characters';
        Redirect_to('Admins.php');
    } elseif ($Password !== $ConfirmPassword) {
        $_SESSION['ErrorMessage'] = 'Password and Confirm Password should match ';
        Redirect_to('Admins.php');
    } elseif (CheckUserNameExistsOrNot($Username, $connectingDB)) {
        $_SESSION['ErrorMessage'] = 'Username already exists. Try another  ';
        Redirect_to('Admins.php');
    } else {
        //insert new admin into database query
        $sql = "INSERT INTO admins (datetime,username,password,aname,addedby) 
                VALUES (:dateTime,:userName,:password,:aName,:adminName)";

        $Password = md5($Password);

        $stmt = $connectingDB->prepare($sql);
        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':userName', $Username);
        $stmt->bindValue(':password', $Password);
        $stmt->bindValue(':aName', $Name);
        $stmt->bindValue(':adminName', $Admin);
        $Execute = $stmt->execute();




        if ($Execute) {
            $_SESSION['SuccessMessage'] = "New Admin with name of {$Name} Added sucessfully";
            Redirect_to('Admins.php');
        } else {
            $_SESSION['ErrorMessage'] = 'something went wrong';
            Redirect_to('Admins.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Page</title>

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
                        <i class="fas fa-user" style="color: #27aae1;"></i> Manage Admins

                    </h1>
                </div>
            </div>
        </div>
    </header>
    <!-- ---------X------------HEADER-------------X--------- -->
    <!-- --------------MAIN--------------------------------- -->
    <section class="container">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height: 400px">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <form action="Admins.php" method="POST">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Admin</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <!-- -------------USername------------------ -->
                            <div class="form-group">
                                <label for="username">
                                    <span class="FieldInfo">Username:</span>
                                </label>
                                <input class="form-control" type="text" name="Username" id="username" value="" />
                            </div>
                            <!-- --------X-----USername--------X---------- -->

                            <!-- -------------Name------------------ -->
                            <div class="form-group">
                                <label for="name">
                                    <span class="FieldInfo">Name:</span>
                                </label>
                                <input class="form-control" type="text" name="Name" id="name" value="" />
                                <span class="text-muted">Optional</span>
                            </div>
                            <!-- --------X-----Name--------X---------- -->

                            <!-- -------------Password------------------ -->
                            <div class="form-group">
                                <label for="password">
                                    <span class="FieldInfo">Password:</span>
                                </label>
                                <input class="form-control" type="password" name="Password" id="password" value="" />
                            </div>
                            <!-- --------X-----Password--------X---------- -->

                            <!-- -------------Confirm Password------------------ -->
                            <div class="form-group">
                                <label for="confirmpassword">
                                    <span class="FieldInfo"> Confirm Password:</span>
                                </label>
                                <input class="form-control" type="password" name="ConfirmPassword" id="confirmpassword" value="" />
                            </div>
                            <!-- -----X--------Confirm Password-------X----------- -->

                            <div class="row">
                                <!-- ------------Redirect to dashboard--------------- -->
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block"> <i class="fas fa-arrow-left"></i> Back to Dashboard </a>
                                </div>
                                <!-- ------X------Redirect to dashboard-------X-------- -->

                                <!-- --------------Submit button----------------- -->
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check"></i> Publish
                                    </button>
                                </div>
                                <!-- -------X-------Submit button---------X-------- -->
                            </div>
                        </div>
                    </div>
                </form>

                <h2>Existing Admins</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date&Time</th>
                            <th>User Name</th>
                            <th>Admin Name</th>
                            <th>Added by</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <?php
                    $connectingDB;
                    $sql = "SELECT * FROM admins ORDER BY id desc";
                    $Execute = $connectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $AdminId = $DataRows['id'];
                        $DateTime = $DataRows['datetime'];
                        $AdminUserName = $DataRows['username'];
                        $AdminName = $DataRows['aname'];
                        $AddedBy = $DataRows['addedby'];
                        $SrNo++;
                    ?>

                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
                                <td><?php echo htmlentities($DateTime); ?></td>
                                <td><?php echo htmlentities($AdminUserName); ?></td>
                                <td><?php echo htmlentities($AdminName); ?></td>
                                <td><?php echo htmlentities($AddedBy); ?></td>
                                <td><a class="btn btn-danger" href="DeleteAdmin.php?id=<?php echo htmlentities($AdminId); ?>">Delete</a></td>

                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </section>

    <!-- --------x------MAIN---------------------x------------ -->
    <!-- ----------------FOOTER-------------------------------- -->
    <br>
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