<?php
session_start();

// Generate a CSRF token
if (empty($_SESSION['csrf_token'])) {
   $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.14.0/sweetalert2.css" />
</head>


<body>

    <!-- Login form start-->

    <div class="container" id="login-con" style="max-width: 500px;">
        <div class="title">
            <p>Login</p>
        </div>

        <form action="#" id="login_form">
            <input type="hidden" name="csrf_token" class="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="user_details" style="display: inherit;">
                <div class="input_box" style="width: unset;">
                    <label for="username">Username</label>
                    <input type="text" id="log_username" placeholder="Username / Email id" required>
                </div>
                <div class="input_box" style="width: unset;">
                    <label for="pass">Password</label>
                    <input type="password" id="log_pass" placeholder="Password" required>
                </div>
            </div>
            <div class="rem" style="width: unset;">
                <label>
                    <input type="checkbox" id="remember_me"> Remember Me
                </label>
            </div>
            <div class="reg-a" id="loginErr" style="display: none;">
                <span style="color: red;">Username or Password does not exist!</span>
            </div>
            <div class="reg-a" id="csrfErr" style="display: none;">
                <span style="color: red;">Invalid CSRF token!</span>
            </div>
            <div class="reg-a">
                <a id="register-show" href="#">Don't have a Register? Sign up now</a>
            </div>
            <div class="reg_btn">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>


    <!-- Login form start-->

    <!-- Register form start-->
    <div class="container" id="register-con">
        <div class="title">
            <p>Registration</p>
        </div>

        <form action="#" id="Register_form">
            <div class="user_details">
                <div class="input_box">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" placeholder="Enter your name" required>
                </div>
                <div class="input_box">
                    <label for="username">Username</label>
                    <input type="text" id="username" placeholder="Enter your username" required>
                </div>
                <div class="input_box">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Enter your email" required>
                </div>
                <div class="input_box">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" placeholder="Enter your number" required pattern="\d{10}"
                        maxlength="10" minlength="10" title="Please enter a 10-digit phone number">
                </div>
                <div class="input_box">
                    <label for="pass">Password</label>
                    <input type="password" id="pass" name="pass" placeholder="Enter your password" required
                        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}"
                        title="Must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.">
                    <div id="progressContainer">
                        <div id="progressBar"></div>
                    </div>
                </div>

                <div class="input_box">
                    <label for="confirmPass">Confirm Password</label>
                    <input type="password" id="confirmPass" placeholder="Confirm your password" required>
                    <div class="reg-a mt-2" id="passErr">
                        <span style="color: red;">Password is not matching?</span>
                    </div>
                </div>
            </div>
            <div class="reg-a" id="userErr">
                <span style="color: red;">Username already exists.</span>
            </div>
            <div class="reg-a" id="csrfErr" style="display: none;">
                <span style="color: red;">Invalid CSRF token!</span>
            </div>
            <div class="reg-a">
                <a id="login-show" href="#">Already have a Register?
                    Login now</a>
            </div>
            <div class="reg_btn">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
    <!-- Register form end -->

    <!-- Script start -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.14.0/sweetalert2.min.js"></script>
    <script>
        // Ready Function
        $(document).ready(function () {
            $("#register-con").hide();
            $("#csrfErr").hide();
            $("#passErr").hide();
            $("#userErr").hide();
            $("#loginErr").hide();

            // Check if username is stored in localStorage and populate the field
            if (localStorage.getItem("username")) {
                $("#log_username").val(localStorage.getItem("username"));
                $("#remember_me").prop("checked", true);
            }

            if (localStorage.getItem("password")) {
                $("#log_pass").val(localStorage.getItem("password"));
            }
        });

        // Registration Form Show
        $("#register-show").click(function () {
            $("#register-con").show();
            $("#login-con").hide();
        });

        // Login Form Show
        $("#login-show").click(function () {
            $("#register-con").hide();
            $("#login-con").show();
        });

        $("#confirmPass").click(function () {
            $("#passErr").hide();
        });

        // Register Form
        $("#Register_form").submit(function (e) {
            e.preventDefault();
            var name = $("#name").val();
            var csrf_token = $(".csrf_token").val();
            var user_name = $("#username").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var pass = $("#pass").val();
            var confirmPass = $("#confirmPass").val();


            if (pass != confirmPass) {
                $("#passErr").show();
                return;
            }

            // AJAX request
            $.ajax({
                url: "php/Register_insert.php",
                type: "POST",
                data: {
                    name: name,
                    csrf_token: csrf_token,
                    user_name: user_name,
                    email: email,
                    phone: phone,
                    pass: pass
                },
                success: function (data) {
                    if (data == "1") {
                        Swal.fire({
                            title: "Registered Successfully!",
                            text: "Welcome to ExpertusONE",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else if (data == "0") {
                        $("#userErr").show();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("Error: " + textStatus, errorThrown);
                    $("#responseMessage").text("An error occurred. Please try again.").show();
                }
            });
        });

        // Login Form Submission
        $("#login_form").submit(function (e) {
            e.preventDefault();
            var user_name = $("#log_username").val();
            var pass = $("#log_pass").val();
            var csrf_token = $(".csrf_token").val();
            var rememberMe = $("#remember_me").is(":checked");

            // AJAX request
            $.ajax({
                url: "php/login_check.php",
                type: "POST",
                data: {
                    user_name: user_name,
                    csrf_token: csrf_token,
                    pass: pass
                },
                success: function (data) {
                    if (data == "1") {
                        // Successful login
                        if (rememberMe) {
                            localStorage.setItem("username", user_name); // Store username
                            localStorage.setItem("password", pass); // Store password
                        } else {
                            localStorage.removeItem("username"); // Clear username if not checked
                            localStorage.removeItem("password"); // Clear password if not checked
                        }
                        window.location.href = 'user-index.php'; // Redirect to user dashboard
                    } else if (data == "0") {
                        $("#loginErr").show(); // Show error message
                    } else if (data == "2") {
                        $("#csrfErr").show(); // Show error message
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("Error: " + textStatus, errorThrown);
                    $("#responseMessage").text("An error occurred. Please try again.").show();
                }
            });
        });

        document.getElementById('pass').addEventListener('input', function () {
            const password = this.value;
            const progressBar = document.getElementById('progressBar');
            const strength = getPasswordStrength(password);
            updateProgressBar(strength);
        });

        function getPasswordStrength(password) {
            let strength = ''; // Initialize strength
            if (password.length >= 0) {
                if (/[A-Z]/.test(password) && /[a-z]/.test(password) && /\d/.test(password) && /[\W_]/.test(password)) {
                    strength = 'Strong';
                } else if (/[A-Z]/.test(password) && /[a-z]/.test(password) && /\d/.test(password)) {
                    strength = 'Medium';
                } else if (/[A-Z]/.test(password) || /[a-z]/.test(password) || /\d/.test(password) || /[\W_]/.test(password)) {
                    strength = 'Weak';
                }
            }
            return strength;
        }

        function getColor(strength) {
            switch (strength) {
                case 'Strong':
                    return 'green';
                case 'Medium':
                    return 'orange';
                case 'Weak':
                    return 'red';
                default:
                    return 'transparent'; // No color for empty input
            }
        }

        function updateProgressBar(strength) {
            let width;
            switch (strength) {
                case 'Strong':
                    width = '100%';
                    break;
                case 'Medium':
                    width = '60%';
                    break;
                case 'Weak':
                    width = '30%';
                    break;
                default:
                    width = '0%'; // No width for empty input
            }
            const progressBar = document.getElementById('progressBar');
            progressBar.style.width = width;
            progressBar.style.backgroundColor = getColor(strength);
        }

        // Reset the progress bar when input is cleared
        document.getElementById('pass').addEventListener('change', function() {
            if (this.value === '') {
                updateProgressBar('');
            }
        });

    </script>
</body>

</html>