<?php require('./Includes/DB.php'); ?>
<?php require('./Includes/Functions.php'); ?>
<?php require('./Includes/Sessions.php'); ?>

<?php

if (isset($_GET['id'])) {
    $SearchQueryParameter = $_GET['id'];
    $connectingDB;

    $sql = "DELETE FROM admins WHERE id = '$SearchQueryParameter'";
    $Execute = $connectingDB->query($sql);

    if ($Execute) {
        $_SESSION['SuccessMessage'] = 'Admin Deleted Successfully';
        Redirect_to('Admins.php');
    } else {
        $_SESSION['ErrorMessage'] = 'Something went wrong';
        Redirect_to('Admins.php');
    }
}




?>