<?php
session_start();
include("../config/db.php");

if(isset($_POST['save'])){

$member_id = $_POST['member_id'];
$amount = $_POST['amount'];

$conn->query("INSERT INTO payments(member_id,amount,payment_date)
VALUES('$member_id','$amount',CURDATE())");
}

$members = $conn->query("SELECT * FROM members");

$data = $conn->query("SELECT payments.*, members.full_name
FROM payments
LEFT JOIN members ON payments.member_id=members.id");
?>

<!DOCTYPE html>
<html>
<head>
<title>Payments</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<?php include("sidebar.php"); ?>

<div class="main">

<h1>Payments</h1>

<div class="card">

<form method="POST">

<select name="member_id">
<?php while($m = $members->fetch_assoc()){ ?>
<option value="<?= $m['id'] ?>"><?= $m['full_name'] ?></option>
<?php } ?>
</select>

<input type="number" name="amount" placeholder="Amount">

<button name="save">Record Payment</button>

</form>

</div>

<div class="card">

<table width="100%" border="1" cellpadding="8">

<tr>
<th>Farmer</th>
<th>Amount</th>
<th>Date</th>
</tr>

<?php while($row = $data->fetch_assoc()){ ?>

<tr>
<td><?= $row['full_name'] ?></td>
<td><?= number_format($row['amount']) ?></td>
<td><?= $row['payment_date'] ?></td>
</tr>

<?php } ?>

</table>

</div>

</div>
</body>
</html>