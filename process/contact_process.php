<?php
include("../config/db.php");  

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

if (empty($name) || empty($email) || empty($message)) {
    header("Location: ../contact.html?error=Please+fill+all+fields");
    exit();
}

$name = htmlspecialchars(trim($name));
$email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars(trim($message));

error_log("Contact Data: name=$name, email=$email, message=$message");

$sql = "INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
        ?>
    <script>
        alert('Your message has been sent successfully');
        window.location.href="../contact.html";
    </script>
<?php
    exit();
} else {
    echo "<h2 style='color:red;text-align:center'>❌ Error: " . htmlspecialchars($stmt->error) . "</h2>";
    echo "<p><a href='../contact.html'>Go Back</a></p>";
}

$stmt->close();
$conn->close();
?>