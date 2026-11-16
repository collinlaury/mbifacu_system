<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: ../index.php");
    exit();
}

$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
<title>Users</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

<?php include("sidebar.php"); ?>

<div class="main">

<h1>👤 System Users</h1>

<div class="card">

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Username</th>
<th>Role</th>
</tr>

<?php while($u = $users->fetch_assoc()){ ?>

<tr>
<td><?= $u['id'] ?></td>
<td><?= $u['name'] ?></td>
<td><?= $u['username'] ?></td>
<td><?= $u['role'] ?></td>
</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>