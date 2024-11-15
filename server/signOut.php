<?php

session_start();
unset($_SESSION["userName"]);
header("location:../client/src/signIn.php");

?>
