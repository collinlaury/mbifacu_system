<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: ../index.php");
    exit();
}

// SUMMARY DATA
$members = $conn->query("SELECT COUNT(*) as total FROM members")->fetch_assoc()['total'];
$coffee = $conn->query("SELECT SUM(kilos) as total FROM coffee")->fetch_assoc()['total'] ?? 0;
$payments = $conn->query("SELECT SUM(amount) as total FROM payments")->fetch_assoc()['total'] ?? 0;
$expenses = $conn->query("SELECT SUM(amount) as total FROM expenses")->fetch_assoc()['total'] ?? 0;

$profit = $payments - $expenses;
?>

<!DOCTYPE html>
<html>
<head>
<title>Reports</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">

<style>
@media print {
    .sidebar, button { display:none; }
    body { background:white; }
}
</style>

</head>

<body>

<?php include("sidebar.php"); ?>

<div class="main">

<h1>📄 MBIFACU Official Report</h1>

<button onclick="window.print()">🖨️ Print Report</button>

<div class="card">
    <h3>👥 Members</h3>
    <h2><?= $members ?></h2>
</div>

<div class="card">
    <h3>☕ Coffee (KG)</h3>
    <h2><?= $coffee ?></h2>
</div>

<div class="card">
    <h3>💰 Payments</h3>
    <h2>TZS <?= number_format($payments) ?></h2>
</div>

<div class="card">
    <h3>💸 Expenses</h3>
    <h2>TZS <?= number_format($expenses) ?></h2>
</div>

<div class="card">
    <h3>📊 Profit</h3>
    <h2>TZS <?= number_format($profit) ?></h2>
</div>

</div>

</body>
</html>