<?php
session_start(); // Start the session

// Check if the user ID session variable is set
if (!isset($_SESSION['user_id'])) {
    // If not set, redirect to index.php
    header("Location: index.php");
    exit();
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
    <style>
        .container .title p::before {
            left: unset !important;
        }

        .container {
            max-width: 1000px !important;
            height: 500px;
        }
    </style>
</head>

<body>
    <!-- Register form start-->
    <div class="container" id="register-con">
        <div class="title" style="text-align: right;">
            <p>
                <a href="php/logout.php">Logout</a>
            </p>
        </div>

        <div class="img-stl">
            <img width="300px;" src="assets/images/ExpertusOne_New_Logo.png.webp" alt="ExpertusOne">
        </div>

        <div>
            <p class="user-p">Welcome to
                <?php echo htmlspecialchars($_SESSION['name']); ?>
            </p>
        </div>

        <p class="pcon">
            ExpertusONE: The
            zero-compromises enterprise learning platform
        </p>

        <p class="pcon">
           Thank You Regards !
        </p>


    </div>
    <!-- Register form end -->

    <!-- Script start -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.14.0/sweetalert2.min.js"></script>
    <script>
        // Ready Function
        $(document).ready(function () {
            // You can add any additional JavaScript here if needed
        });
    </script>
</body>

</html>