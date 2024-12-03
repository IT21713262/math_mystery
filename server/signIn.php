<?php
session_start();

include('./dbConnect.php');

$userName = $_POST['userName'];
$pass = $_POST['pass'];

$sql = "SELECT `password` FROM `users` WHERE `userName`=?";
$stmt = mysqli_prepare($con, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $userName);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPass = $row['password'];

        // Verify the password
        if (password_verify($pass, $hashedPass)) {
            $_SESSION["userName"] = $userName;
            echo "success";
        } else {
            echo "fail";
        }
    } else {
        echo "fail";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error in preparing SQL statement";
}

mysqli_close($con);
?>
