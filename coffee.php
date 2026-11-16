<?php
session_start();
include("../config/db.php");

if(isset($_POST['save'])){

$member_id = $_POST['member_id'];
$kilos = $_POST['kilos'];
$price = $_POST['price'];

$conn->query("INSERT INTO coffee(member_id,kilos,price_per_kg,record_date)
VALUES('$member_id','$kilos','$price',CURDATE())");
}

$members = $conn->query("SELECT * FROM members");
$data = $conn->query("SELECT coffee.*, members.full_name 
FROM coffee 
LEFT JOIN members ON coffee.member_id=members.id");
?>

<!DOCTYPE html>
<html>
<head>
<title>Coffee</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<?php include("sidebar.php"); ?>

<div class="main">

<h1>Coffee Records</h1>

<div class="card">

<form method="POST">

<select name="member_id">
<?php while($m = $members->fetch_assoc()){ ?>
<option value="<?= $m['id'] ?>"><?= $m['full_name'] ?></option>
<?php } ?>
</select>

<input type="number" name="kilos" placeholder="Kilos">
<input type="number" name="price" placeholder="Price per KG">

<button name="save">Save Record</button>

</form>

</div>

<div class="card">

<table width="100%" border="1" cellpadding="8">

<tr>
<th>Farmer</th>
<th>Kilos</th>
<th>Price</th>
<th>Total</th>
</tr>

<?php while($row = $data->fetch_assoc()){ ?>

<tr>
<td><?= $row['full_name'] ?></td>
<td><?= $row['kilos'] ?></td>
<td><?= $row['price_per_kg'] ?></td>
<td><?= $row['total_amount'] ?></td>
</tr>

<?php } ?>

</table>

</div>

</div>
</body>
</html>