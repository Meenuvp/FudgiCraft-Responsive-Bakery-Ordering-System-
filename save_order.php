<?php
include("config/db.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';

$brownies = [];
if (isset($_POST['brownies']) && isset($_POST['qty'])) {
    foreach ($_POST['brownies'] as $index => $brownie) {
        $qty = isset($_POST['qty'][$index]) ? intval($_POST['qty'][$index]) : 0;
        if ($qty > 0) {
            $brownies[] = $brownie . " x" . $qty;
        }
    }
}
$brownies_str = !empty($brownies) ? implode(", ", $brownies) : "None";

$assorted = $_POST['assorted_box'] ?? "None"; 

error_log("POST Data: " . print_r($_POST, true));
error_log("Insert Data: name=$name, phone=$phone, email=$email, address=$address, brownies=$brownies_str, assorted=$assorted");

$sql = "INSERT INTO orders (name, phone, email, address, brownies, assorted) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ssssss", $name, $phone, $email, $address, $brownies_str, $assorted);

if ($stmt->execute()) {
    ?>
    <script>
        alert('Order placed successfully');
        window.location.href="order.html";
    </script>
    <?php
} else {
    echo "<h2 style='color:red;text-align:center'>❌ Error: " . htmlspecialchars($stmt->error) . "</h2>";
    echo "<p>SQL: " . htmlspecialchars($sql) . "</p>";
    echo "<p>Data: name=$name, phone=$phone, email=$email, address=$address, brownies=$brownies_str, assorted=$assorted</p>";
}

$stmt->close();
$conn->close();
?>