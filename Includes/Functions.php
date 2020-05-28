<?php require('./Includes/DB.php'); ?>

<?php
global $connectingDB;

//to redirect user to another page
function Redirect_to($New_Location)
{
    header("Location:" . $New_Location);
    exit;
}

//check if usr name exists in database
function CheckUserNameExistsOrNot($Username, $connectingDB)
{

    $sql = "SELECT username FROM admins WHERE username = :userName";
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindvalue(':userName', $Username);
    $stmt->execute();
    $Result = $stmt->rowcount();

    if ($Result == 1) {
        return true;
    } else {
        return false;
    }
}

//making pages password protected
function Confirm_Login()
{
    if (isset($_SESSION['UserId'])) {
        return true;
    } else {
        $_SESSION['ErrorMessage'] = "Login Required !";
        Redirect_to('Login.php');
    }
}

//total posts
function TotalPosts($connectingDB)
{
    $connectingDB;
    $sql = "SELECT COUNT(*) FROM posts";
    $stmt = $connectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalPosts = array_shift($TotalRows);
    echo $TotalPosts;
}

function TotalCategories($connectingDB)
{
    $connectingDB;
    $sql = "SELECT COUNT(*) FROM category";
    $stmt = $connectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCateogories = array_shift($TotalRows);
    echo $TotalCateogories;
}
function TotalAdmins($connectingDB)
{
    $connectingDB;
    $sql = "SELECT COUNT(*) FROM admins";
    $stmt = $connectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalAdmins = array_shift($TotalRows);
    echo $TotalAdmins;
}

function TotalComments($connectingDB)
{
    $connectingDB;
    $sql = "SELECT COUNT(*) FROM comments";
    $stmt = $connectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalComments = array_shift($TotalRows);
    echo $TotalComments;
}


function ApproveCommentAccordingToPost($PostId, $connectingDB)
{
    $connectingDB;
    $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status = 'ON'";
    $stmtApprove = $connectingDB->query($sqlApprove);
    $RowTotal = $stmtApprove->fetch();
    $Total = array_shift($RowTotal);
    return $Total;
}

function DisApproveCommentAccordingToPost($PostId, $connectingDB)
{
    $connectingDB;
    $sqlDisApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status = 'OFF'";
    $stmtDisApprove = $connectingDB->query($sqlDisApprove);
    $RowTotal = $stmtDisApprove->fetch();
    $Total = array_shift($RowTotal);
    return $Total;
}
