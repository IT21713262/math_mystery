<?php
session_start();

if (!isset($_SESSION["userName"])) {
    header("LOCATION:./signIn.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Mystery</title>
    <link rel="stylesheet" href="../css/menu.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body>
    <div class="container">
        <div class="gameMenu">
            <img src="../assets/board.png" alt="" id="board">
            <img src="../assets/glogo.png" alt="key" class="topic gl" id="glogo">
             <img src="../assets/b1.png" alt="key" class="banana" id="banana">

            <div class="buttons">
                <button class="b1 play" >PLAY</button>
                <button class="b2" onclick="score()">HIGH SCORE</button>
                <button class="b3" onclick="htp()">HOW TO PLAY</button>
                <button class="b4" onclick="signOut()">SIGN OUT</button>
            </div>
        </div>
        <div class="levelOut">
            <div class="level">
                <div class="closeLevel">X</div>
                <p>Choose Difficulty</p>
                <button id='easy'>Easy</button>
                <button id='medium'>Medium</button>
                <button id='hard'>Hard</button>
            </div>
        </div>

        <div class="howToPlay">
            <div class="close">
                <h1 onclick="htp()">X</h1>
            </div>

            <h1>How To Play</h1>

            <div class="table">

                <div class="tableIn">
                    <div class="row">
                        <div class="e">
                            <h2>Easy</h2>
                        </div>
                        <div>
                            <p>Here the player must find the answer related to the position of tomatoes in the given
                                math
                                table from the answer pile given below. It can be addition, subtraction, multiplication
                                or
                                division. It includes a 30 seconds timeout and 6 rounds of retries.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="e">
                            <h2 id="medium">Medium</h2>
                        </div>
                        <div>
                            <p>Here the player must find the answer related to the position of tomatoes in the given
                                math
                                table from the
                                answer pile given below. It can be addition, subtraction, multiplication or division. It
                                includes a 20 seconds timeout and 4 rounds of retries.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="e m">
                            <h2>Hard</h2>
                        </div>
                        <div>
                            <p>Here the player must find the answer related to the position of tomatoes in the given
                                math
                                table from the answer pile given below. It can be addition, subtraction, multiplication
                                or
                                division. It includes a 15 seconds timeout and 3 rounds of retries.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="score">

            <div class="close">
                <h1 onclick="score()">X</h1>
            </div>

            <h1>High Score</h1>

            <table>
                <th>Rank</th>
                <th>Name</th>
                <th>Score</th>

                <?php

                include('../../server/dbConnect.php');

                $sql = "SELECT * FROM `users` ORDER BY `highScore` DESC LIMIT 10;";

                $result = mysqli_query($con, $sql);

                if (mysqli_num_rows($result) > 0) {

                    $rank = 1;

                    while ($row = mysqli_fetch_assoc($result)) {

                        echo "
                        <tr>
                            <td>" . $rank . "</td>
                            <td>" . $row['userName'] . "</td>
                            <td>" . $row['highScore'] . "</td>
                        </tr>
                        
                        ";
                        $rank++;
                    }

                }


                ?>

            </table>

        </div>

    </div>



    <script src="../js/menu.js"></script>

    <script>
        function signOut() {
            window.location.href = '../../server/signOut.php';
        }
        // function play() {
        //     window.location.href = '../../server/signOut.php';
        // }



        //references took from chatgpt-------------------------------------------
        $(document).ready(function () {
            $('.play').click(function () {
                $('.levelOut').css('display', 'flex');
                $('.level').css('display', 'block');
            })
            $('.closeLevel').click(function () {
                $('.levelOut').css('display', 'none')
            })
            $('#easy').click(function () {
                localStorage.setItem('livesLeft', '6');
                localStorage.setItem('timeLeft', '30');
                window.location.href = "./game.php";
            })
            $('#medium').click(function () {
                localStorage.setItem('livesLeft', '4');
                localStorage.setItem('timeLeft', '20');
                window.location.href = "./game.php";
            })
            $('#hard').click(function () {
                localStorage.setItem('livesLeft', '3');
                localStorage.setItem('timeLeft', '15');
                window.location.href = "./game.php";
            })
            //in game audio
            $('#ingame').click(function (e) {
                var audio = document.getElementById("myAudio");

                if (audio.paused) {
                    audio.play();
                    $(this).html("<i class='bi bi-volume-mute'></i>");
                    console.log('play')
                }
                else {
                    audio.pause();
                    $(this).html("<i class='bi bi-music-note'></i>");
                    console.log('pause')
                }

            })


        })
    </script>

</body>

</html>