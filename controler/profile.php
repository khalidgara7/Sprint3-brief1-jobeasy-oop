<?php
session_start();

?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Registration or Sign Up form in HTML CSS | CodingLab </title>
    <link rel="stylesheet" href="../styles/registerstyle.css">
</head>

<body>
<div class="wrapper">
    <h2>Personnel Information</h2>
    <form action="auth.php" method="POST">
        <div class="input-box" style="margin-top: 1.5rem;">
            <label> *Update your name* </label>
            <input type="text" name="name" value="<?= @$_SESSION['name']?>" required>
        </div>
        <div class="input-box button" style="margin-top: 3rem;">
            <input type="submit" name="updateProfile" value="save change">
        </div>

        <div class="input-box  ">
            <input type="Submit" name="deleteAccount" value="delete account">
        </div>

    </form>
</div>
</body>

</html>