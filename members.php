<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: ../index.php");
    exit();
}

if(isset($_POST['save'])){

    $member_no = $_POST['member_no'];
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $village = $_POST['village'];

    $conn->query("INSERT INTO members(member_no,full_name,gender,phone,village)
    VALUES('$member_no','$full_name','$gender','$phone','$village')");
}

$data = $conn->query("SELECT * FROM members");
?>

<!DOCTYPE html>
<html>
<head>
<title>Members</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<?php include("sidebar.php"); ?>

<div class="main">

<h1>Members Management</h1>

<div class="card">

<form method="POST">

<input type="text" name="member_no" placeholder="Member No" required>
<input type="text" name="full_name" placeholder="Full Name" required>
<input type="text" name="gender" placeholder="Gender">
<input type="text" name="phone" placeholder="Phone">
<input type="text" name="village" placeholder="Village">

<button name="save">Save Member</button>

</form>

</div>

<div class="card">

<table width="100%" border="1" cellpadding="8">

<tr>
<th>ID</th>
<th>No</th>
<th>Name</th>
<th>Phone</th>
<th>Village</th>
</tr>

<?php while($row = $data->fetch_assoc()){ ?>

<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['member_no'] ?></td>
<td><?= $row['full_name'] ?></td>
<td><?= $row['phone'] ?></td>
<td><?= $row['village'] ?></td>
</tr>

<?php } ?>

</table>

</div>

</div>
</body>
</html>