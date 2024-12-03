<?php

include('./dbConnect.php');

$userName = $_POST['userName'];
$pass = $_POST['pass'];

// Hash the password before storing it in the database
$hashedPass = password_hash($pass, PASSWORD_DEFAULT);

$sql = "SELECT * FROM `users` WHERE `userName`='" . $userName . "'";

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "Registered";
} else {
    $sql1 = "INSERT INTO `users` (`userName`, `password`, `highScore`) VALUES ('" . $userName . "', '" . $hashedPass . "', 0);";

    if (mysqli_query($con, $sql1)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

?>
