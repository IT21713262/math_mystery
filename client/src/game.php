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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/game.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>

        let timeLeft = localStorage.getItem('timeLeft');
        let score = localStorage.getItem('score') || 0;
        let numQuestions = localStorage.getItem('numQuestions') || 1;
        let currentLevel = localStorage.getItem('currentLevel') || 1;
        let livesLeft = localStorage.getItem('livesLeft');
        let timer;
        let imgApi;
        let solution;
        let timerInterval;

        function updateUI() {
            // document.getElementById("question-number").textContent = numQuestions;
            document.getElementById("score").textContent = score;
            document.getElementById("timer").textContent = timeLeft;
            //document.getElementById("level-no").textContent = currentLevel;
        }

        function fetchImage() {
            fetch('https://marcconrad.com/uob/banana/api.php')
                .then(response => response.json())
                .then(data => {
                    imgApi = data.question;
                    solution = data.solution;
                    document.getElementById("imgApi").src = imgApi;

                })
                .catch(error => {
                    console.error('Error fetching image from the API:', error);
                });
        }

        //setting green to correct answer
        function correctAns(ans) {
            ans.css('background-color', '#00E142')
            setTimeout(() => {
                ans.css('background-color', 'rgb(39, 39, 39)')
            }, 1000);
        }
        //setting red to wrong answer
        function wrongAns(ans) {
            ans.css('background-color', 'rgb(255, 43, 43)')
            setTimeout(() => {
                ans.css('background-color', 'rgb(39, 39, 39)')
            }, 1000);
        }
        //updating lives
        function lives() {
            $(".lives").html("<img src='../assets/heart.gif'>".repeat(livesLeft));
            if (timeLeft == -1) {
                countDown()
            }
            console.log(livesLeft)
        }


        //Game over
        function gameOver() {
            if (livesLeft == 0) {
                var audioElement = document.getElementById("over");
                var audio = document.getElementById("myAudio");
                audio.pause();
                audioElement.play();
                document.getElementById("clock").pause();
                $('.timeTag').removeClass('active');
                $('.overOut').css('display', 'flex');
                $('.life').css('display', 'none');
            }
        }


        //Time Countdown
        function countDown() {
            clearInterval(timerInterval);
            timeLeft = localStorage.getItem('timeLeft');
            timerInterval = setInterval(() => {
                $("#timer").text(timeLeft);

                if (timeLeft <= 10) {
                    $('.timeTag').addClass('active');
                    document.getElementById("clock").play();
                }

                timeLeft -= 1;

                if (timeLeft < 0) {
                    clearInterval(timerInterval);
                    $('.timeTag').removeClass('active');
                    livesLeft -= 1;
                    lives();
                    document.getElementById("wrong").play();
                    document.getElementById("clock").pause();
                    // console.log(livesLeft)
                    fetchImage();
                }
                if (livesLeft == 0) {
                    clearInterval(timerInterval);
                    document.getElementById("clock").pause();
                    gameOver();
                }
            }, 1000);
        }




        //High Score Calculator
        function highScore(score) {
            var dataSet = {
                score: score,
                userName: "<?php echo $_SESSION['userName']; ?>"
            };


            console.log(dataSet)

            $.ajax({

                type: 'POST',
                url: '../../server/highScore.php',
                data: dataSet,
                success: function (response) {

                    if (response === 'Success') {
                        //console.log(response);
                    }
                    console.log(response);
                },
                error: function () {
                    alert('Error occurred. Please try again.');
                }

            });
        }



        document.addEventListener("DOMContentLoaded", function () {
            updateUI();
            fetchImage();
            lives();
        });






        $(document).ready(function () {

            countDown();


            $(".ansBtn").click(function (e) {
                var userAns = $(this).text();
                if (userAns == solution) {
                    correctAns($(this))
                    document.getElementById("correct").play();
                    //document.getElementById("note").innerHTML = 'Correct';
                    score += 10;
                    highScore(score)
                    numQuestions += 1;
                    fetchImage();
                    updateUI();
                    countDown();
                    $('.timeTag').removeClass('active');
                    document.getElementById("clock").pause();
                }
                else {
                    wrongAns($(this))
                    var audioElement = document.getElementById("wrong");
                    audioElement.currentTime = 0;
                    audioElement.play();

                    livesLeft -= 1;
                    lives();
                    gameOver();
                }
            })

            $('#again').click(function (e) {
                $('.overOut').css('display', 'none');
            })

            //in game audio
            $('#ingame').click(function (e) {
                var audio = document.getElementById("myAudio");

                if (audio.paused) {
                    audio.play();
                    $(this).html("<i class='fas fa-volume-mute'></i>");
                    console.log('play')
                }
                else {
                    audio.pause();
                    $(this).html("<i class='fas fa-music'></i>");
                    console.log('pause')
                }

            })




        })
    </script>
</head>

<body>
    <div class="container">
        <img src="../assets/b3.png" alt="key" class="banana" id="banana">
        <div class="life lives">
            <img src="../assets/heart.gif" alt="">
            <img src="../assets/heart.gif" alt="">
            <img src="../assets/heart.gif" alt="">
            <img src="../assets/heart.gif" alt="">
            <img src="../assets/heart.gif" alt="">
        </div>
        <div class="score">
            <p>Score <span id="score">10</span></p>
        </div>
        <a href="./menu.php">
            <div class="home controlBtn">
                <i class="fas fa-home"></i>
            </div>
        </a>
        <div class="music controlBtn" id="ingame">
            <i class='fas fa-volume-mute'></i>
        </div>
        <div class="time">
            <img src="../assets/stopwatch.png" alt="">
            <div class="timeIn">
                <p><span id="timer">10</span>s</p>
            </div>
        </div>

        <div class="question">
            <div class="imgApi">
                <img src="" alt="Question Image" id="imgApi" class="color-image">
            </div>
            <div class="qAnswers">
                <button class='ansBtn'>0</button>
                <button class='ansBtn'>1</button>
                <button class='ansBtn'>2</button>
                <button class='ansBtn'>3</button>
                <button class='ansBtn'>4</button>
                <button class='ansBtn'>5</button>
                <button class='ansBtn'>6</button>
                <button class='ansBtn'>7</button>
                <button class='ansBtn'>8</button>
                <button class='ansBtn'>9</button>
            </div>
        </div>
        <img src="../assets/board.png" alt="" id="board">

        <audio id="correct" src="../sounds/correct.mp3" preload="auto"></audio>
        <audio id="wrong" src="../sounds/wrong.mp3" preload="auto"></audio>
        <audio id="over" src="../sounds/over.mp3" preload="auto"></audio>
        <audio id="clock" src="../sounds/clock.mp3" preload="auto"></audio>
        <audio autoplay loop id="myAudio">
            <source src="../sounds/ingame.mp3" type="audio/mpeg">
        </audio>
    </div>
    <div class="overOut">
        <div class="over">
            <p>GAME OVER</p>
            <a href="" id="again"><button>Play Again</button></a>
            <a href="./menu.php"><button> Home</button></a>
        </div>
    </div>
</body>

</html>