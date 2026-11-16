<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: ../index.php");
    exit();
}

/* SAVE EXPENSE */
if(isset($_POST['save'])){

    $title = $_POST['title'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $note = $_POST['note'];

    $conn->query("INSERT INTO expenses(title,amount,expense_date,category,note)
    VALUES('$title','$amount',CURDATE(),'$category','$note')");
}

/* FETCH DATA */
$data = $conn->query("SELECT * FROM expenses ORDER BY id DESC");

/* TOTAL */
$total = $conn->query("SELECT SUM(amount) as total FROM expenses")
->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Expenses</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

<?php include("sidebar.php"); ?>

<div class="main">

<h1>💸 Expenses Management</h1>

<div class="cards">

<div class="card">
<h3>Total Expenses</h3>
<h2>TZS <?= number_format($total) ?></h2>
<small>All recorded expenses</small>
</div>

</div>

<br>

<!-- ADD FORM -->
<div class="card">

<h3>➕ Add Expense</h3>

<form method="POST">

<input type="text" name="title" placeholder="Expense Title" required>

<input type="number" name="amount" placeholder="Amount" required>

<select name="category" required>
<option value="">Select Category</option>
<option>Transport</option>
<option>Office</option>
<option>Fuel</option>
<option>Salary</option>
<option>Maintenance</option>
<option>Other</option>
</select>

<textarea name="note" placeholder="Note (optional)"></textarea>

<br><br>

<button name="save">Save Expense</button>

</form>

</div>

<br>

<!-- TABLE -->
<div class="card">

<h3>📋 Expense Records</h3>

<table>

<tr>
<th>ID</th>
<th>Title</th>
<th>Amount</th>
<th>Category</th>
<th>Date</th>
<th>Note</th>
</tr>

<?php while($row = $data->fetch_assoc()){ ?>

<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['title'] ?></td>
<td>TZS <?= number_format($row['amount']) ?></td>
<td><?= $row['category'] ?></td>
<td><?= $row['expense_date'] ?></td>
<td><?= $row['note'] ?></td>
</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>