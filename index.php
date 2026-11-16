<?php
session_start();
include("config/db.php");

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");

    if($sql->num_rows > 0){
        $row = $sql->fetch_assoc();

        $_SESSION['user'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        header("Location: pages/dashboard.php");
        exit();
    } else {
        $error = "Invalid Username or Password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>MBIFACU Login</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- VIDEO BACKGROUND -->
<video autoplay muted loop id="bg-video">
    <source src="assets/videos/mbifacu.mp4" type="video/mp4">
</video>

<div class="login-container">

    <div class="glass-box">

        <h1>☕ MBIFACU</h1>
        <p>Cooperative Management System</p>

        <?php if(isset($error)){ ?>
            <div class="error"><?= $error ?></div>
        <?php } ?>

        <form method="POST">

            <input type="text" name="username" placeholder="Username" required>

            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="login">Login</button>

        </form>

    </div>

</div>

</body>
</html>