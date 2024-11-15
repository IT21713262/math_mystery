<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="../css/signIn.css">
    <link rel="shortcut icon" href="../Photos/icon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="right_container">
        <div class="sign_container">
            <img src="../assets/board.png" alt="" id="board">

            <img src="../assets/sign.png" alt="key" class="topic ts" id="sign">
            <img src="../assets/reg.png" alt="key" class="topic" id="reg">
            <img src="../assets/b1.png" alt="key" class="banana" id="banana">

            <div class="form sign">
                <div class="text_fields">
                    <span>USERNAME</span>
                    <input type="text" placeholder="Enter User Name" class="text-area userName">
                </div>
                <div class="text_fields">
                    <span>PASSWORD</span>
                    <input type="password" placeholder="Enter Password" class="text-area pass" id="pswd_part">
                </div>
                <div class="error" id="error">

                </div>
                <div class="btn_items">
                    <button class="button" id="signBtn">Sign In</button>
                </div>
                <div class="scnd_option_class">
                    <p class="signupbtn" onclick="register()">Don't have an account?&nbsp; <span>Register</span></p>
                </div>

            </div>
            <div class="form signUp">
               
                <div class="text_fields">
                    <span>USERNAME</span>
                    <input type="text" placeholder="Enter User Name" class="text-area ruserName">
                </div>
                <div class="text_fields">
                    <span>PASSWORD</span>
                    <input type="password" placeholder="Enter Password" class="text-area rpass" id="rpswd_part">
                </div>
                <div class="text_fields">
                    <span>CONFIRM PASSWORD</span>
                    <input type="password" placeholder="Enter Confirm Password" class="text-area rconpass" id="rpswd_part">
                </div>
                <div class="error" id="rerror">
                       
                </div>
                <div class="btn_items">
                    <button class="button" id="regbtn">Register</button>
                </div>
                <div class="scnd_option_class">
                    <p class="signupbtn" onclick="signIn()">have an account?&nbsp; <span>Sign In</span></p>
                </div>

            </div>
        </div>

    </div>
    <script>
        $(document).ready(function () {

            //sign In-----------------------------------------------------------------------

            function isValidUserName(userName) {
                var regex = /^[a-zA-Z0-9]*$/; // Regular expression to allow only letters and numbers
                if (!regex.test(userName)) {
                    return false;
                } else {
                    return true;
                }

            }


            $('#signBtn').click(function (e) {

                e.preventDefault();

                var userName = $('.userName').val();
                var pass = $('.pass').val();


                if (userName === "" || pass === "") {
                    $('#error').addClass('active');
                    $('#error').text("Fields Can't Be Empty");
                    //console.log('empty')
                } else {
                    if (isValidUserName(userName)) {
                        $('#error').removeClass('active');

                        var dataSet = {
                            userName: userName,
                            pass: pass,
                        };

                        $.ajax({

                            type: 'POST',
                            url: '../../server/signIn.php', // Update with the correct path to your PHP file
                            data: dataSet,
                            success: function (response) {

                                //console.log(response);

                                if (response.trim() === 'success') {
                                    window.location.href = './menu.php';
                                }
                                if (response.trim() === 'fail') {
                                    $('#error').addClass('active');
                                    $('#error').text('Email And Password Does Not Match');
                                }
                            },
                            error: function () {
                                alert('Error occurred. Please try again.');
                            }

                        });

                    } else {
                        $('#error').addClass('active');
                        $('#error').text("Can't use special characters for Username");
                    }
                }

            });


            //register--------------------------------------------------------------------------


            function isValidUserName(userName) {
                var regex = /^[a-zA-Z0-9]*$/; 
                if (!regex.test(userName)) {
                    return false;
                } else {
                    return true;
                }

            }

            function isValidPass(pass, conPass) {

                if (pass.length >= 8) {
                    if (pass === conPass) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return error;
                }

            }

            $('#regbtn').click(function (e) {

                //console.log('click')

                e.preventDefault();

                //var email = $('.remail').val();
                var userName = $('.ruserName').val();
                var pass = $('.rpass').val();
                var conPass = $('.rconpass').val();

                if (userName === "" || pass === "" || conPass === "") {
                    $('#rerror').addClass('active');
                    $('#rerror').text("Fields Can't Be Empty");
                    console.log('empty')
                } else {

                    var userNameCheck = isValidUserName(userName);
                    var passCheck = isValidPass(pass, conPass);

                    if (userNameCheck === true && passCheck === true) {
                        $('#rerror').removeClass('active');

                        var dataSet = {
                            userName: userName,
                            pass: pass,
                        };

                        //console.log(dataSet)

                        $.ajax({

                            type: 'POST',
                            url: '../../server/signUp.php',
                            data: dataSet,
                            success: function (response) {

                                console.log(response)
                                if (response === 'Registered') {
                                    $('#rerror').addClass('active');
                                    $('#rerror').text('User is Already Registered');
                                }
                                if (response === 'Success') {
                                    window.location.href = './signIn.php';
                                }
                                console.log(response)
                            },
                            error: function () {
                                alert('Error occurred. Please try again.');
                            }

                        });


                    } else {

                       
                        if (userNameCheck === false) {
                            $('#rerror').addClass('active');
                            $('#rerror').text("Can't use special characters for Username");
                        }
                        if (passCheck === false) {
                            $('#rerror').addClass('active');
                            $('#rerror').text('Password Does Not Match');
                        }
                        if (passCheck === error) {
                            $('#rerror').addClass('active');
                            $('#rerror').text('Password Must Be 8 Or More Characters Long');
                        }


                    }

                }



            });



        })
    </script>

    <script src="../js/buttons.js"></script>

</body>

</html>