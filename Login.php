<?php require('./Includes/DB.php'); ?>
<?php require('./Includes/Functions.php'); ?>
<?php require('./Includes/Sessions.php'); ?>

<?php
// if already logged in, login page shouldnt be accesssed
if (isset($_SESSION['UserId'])) {
    Redirect_to('Dashboard.php');
}


if (isset($_POST['Submit'])) {
    $UserName = $_POST['Username'];
    $Password = $_POST['Password'];

    if (empty($UserName) || empty($Password)) {
        $_SESSION['ErrorMessage'] = "All fields must be filled";
        Redirect_to("Login.php");
    } else {
        // get username and password from database 

        $sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
        $stmt = $connectingDB->prepare($sql);
        $stmt->bindValue(':userName', $UserName);
        $stmt->bindValue(':passWord', $Password);
        $stmt->execute();
        $Result = $stmt->fetch();

        if ($Result) {

            $_SESSION['UserId'] = $Result['id'];
            $_SESSION['UserName'] = $Result['username'];
            $_SESSION['AdminName'] = $Result['aname'];

            $_SESSION['SuccessMessage'] = "Welcome " . $_SESSION["AdminName"];

            //if tracking url SESSION has a value
            if (isset($_SESSION['TrackingURL'])) {
                Redirect_to(Redirect_to($_SESSION['TrackingURL']));
            } else {
                //otherwise go to defaut url
                Redirect_to('Dashboard.php');
            }
        } else {
            $_SESSION['ErrorMessage'] = 'Incorrect Username/Password';
            Redirect_to('Login.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

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
                </div>
            </div>
        </div>
    </header>
    <!-- ---------X------------HEADER-------------X--------- -->

    <br>
    <!-- --------------MAIN--------------------------------- -->
    <section class="container py-4 my-5">
        <div class="row">
            <div class="offset-sm-3 col-sm-6" style="min-height: 400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <div class="card bg-secondary text-light">
                    <div class="card-header ">
                        <h4>Please Log In</h4>
                    </div>
                    <div class="card-body bg-dark">
                        <form action="Login.php" method="post">
                            <!-- ----------- Username -------------------- -->
                            <div class="form-group">
                                <label for="username"><span class="FieldInfo">Username:</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="Username" id="username" value="">
                                </div>
                            </div>
                            <!-- --X--------- Username --------X------------ -->
                            <!-- ----------- Password-------------------- -->
                            <div class="form-group">
                                <label for="password"><span class="FieldInfo">Password:</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="Password" id="password" value="">
                                </div>
                            </div>
                            <!-- --X--------- Password--------X------------ -->
                            <!-- ------------------Button----------------------- -->
                            <div class="form-group">
                                <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
                            </div>
                            <!-- --------X----------Button-------X---------------- -->
                        </form>
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