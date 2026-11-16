<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: ../index.php");
    exit();
}

include("../config/db.php");

/* MEMBERS */
$total_members = 0;
$result1 = $conn->query("SELECT COUNT(*) AS total FROM members");

if($result1 && $row1 = $result1->fetch_assoc()){
    $total_members = $row1['total'];
}

/* COFFEE */
$total_coffee = 0;
$result2 = $conn->query("SELECT COALESCE(SUM(kilos),0) AS total FROM coffee");

if($result2 && $row2 = $result2->fetch_assoc()){
    $total_coffee = $row2['total'];
}

/* PAYMENTS */
$total_payments = 0;
$result3 = $conn->query("SELECT COALESCE(SUM(amount),0) AS total FROM payments");

if($result3 && $row3 = $result3->fetch_assoc()){
    $total_payments = $row3['total'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <button onclick="toggleDarkMode()" class="btn-dark">
    🌙 Toggle Dark Mode
</button>
<title>Dashboard</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

<div class="sidebar">

<h2>☕ MBIFACU</h2>

<a href="dashboard.php">Dashboard</a>
<a href="members.php">Members</a>
<a href="coffee.php">Coffee</a>
<a href="payments.php">Payments</a>
<a href="reports.php">Reports</a>
<a href="users.php">Users</a>
<a href="../logout.php">Logout</a>

</div>

<div class="main">
    <div class="premium-header">

    <div>
        <h1>☕ MBIFACU Dashboard</h1>
        <p>Welcome back, <?= $_SESSION['user']; ?></p>
    </div>

    <div class="top-right">
        <div id="clock"></div>
    </div>

</div>

<h1>Dashboard Overview</h1>

<div class="cards">

<div class="card glass">
    <h4>👥 Members</h4>
    <h2 class="counter" data-target="<?= $total_members ?>">0</h2>
    <small>Total registered farmers</small>
</div>

<div class="card glass">
    <h4>☕ Coffee KG</h4>
    <h2 class="counter" data-target="<?= $total_coffee ?>">0</h2>
    <small>Total production</small>
</div>

<div class="card glass">
    <h4>💰 Payments</h4>
    <h2 class="counter" data-target="<?= $total_payments ?>">0</h2>
    <small>Total income</small>
</div>
<div class="card">

<h3>⚡ Quick Actions</h3>

<button onclick="location.href='members.php'">+ Add Member</button>
<button onclick="location.href='coffee.php'">+ Add Coffee</button>
<button onclick="location.href='payments.php'">+ Payment</button>
<button onclick="location.href='reports.php'">🖨️ Reports</button>

</div>
<div class="card">

<h3>📈 Monthly Targets</h3>

<p>Coffee Collection</p>
<progress value="75" max="100"></progress>

<p>Payments Completed</p>
<progress value="60" max="100"></progress>

<p>Members Growth</p>
<progress value="85" max="100"></progress>

</div>

</div>

<!-- CHART SECTION -->
<div class="card">
    <h3>📊 System Analytics</h3>

    <canvas id="myChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
var ctx = document.getElementById('myChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Members', 'Coffee', 'Payments'],
        datasets: [{
            label: 'MBIFACU Stats',
            data: [
                <?= $total_members ?>,
                <?= $total_coffee ?>,
                <?= $total_payments ?>
            ],
            backgroundColor: ['green','brown','blue']
        }]
    }
});
</script>
</div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
var ctx = document.getElementById('myChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Members', 'Coffee', 'Payments'],
        datasets: [{
            label: 'MBIFACU Overview',
            data: [
                <?= $total_members ?>,
                <?= $total_coffee ?>,
                <?= $total_payments ?>
            ],
            backgroundColor: ['#2e7d32','#6d4c41','#1565c0']
        }]
    }
});
</script>

<script>
function toggleDarkMode(){
    document.body.classList.toggle("dark-mode");

    // save preference
    if(document.body.classList.contains("dark-mode")){
        localStorage.setItem("theme","dark");
    } else {
        localStorage.setItem("theme","light");
    }
}

// load saved theme
window.onload = function(){
    if(localStorage.getItem("theme") === "dark"){
        document.body.classList.add("dark-mode");
    }
}
</script>
<script>
function updateClock(){
    const now = new Date();
    document.getElementById("clock").innerHTML =
        now.toLocaleTimeString();
}

setInterval(updateClock,1000);
updateClock();
</script>
</body>
</html>