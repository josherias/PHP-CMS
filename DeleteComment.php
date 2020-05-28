<?php require('./Includes/DB.php'); ?>
<?php require('./Includes/Functions.php'); ?>
<?php require('./Includes/Sessions.php'); ?>

<?php

if (isset($_GET['id'])) {
    $SearchQueryParameter = $_GET['id'];
    $connectingDB;

    $sql = "DELETE FROM comments WHERE id = '$SearchQueryParameter'";
    $Execute = $connectingDB->query($sql);

    if ($Execute) {
        $_SESSION['SuccessMessage'] = 'Comment Deleted Successfully';
        Redirect_to('Comments.php');
    } else {
        $_SESSION['ErrorMessage'] = 'Something went wrong';
        Redirect_to('Comments.php');
    }
}




?>