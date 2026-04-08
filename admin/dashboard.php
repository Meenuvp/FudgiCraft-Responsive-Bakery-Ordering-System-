<?php
  $host = "localhost";
  $user = "root"; 
  $pass = "";     
  $db   = "fudgicraft"; 
  $conn = new mysqli($host, $user, $pass, $db);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $totalOrders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
  $totalCustomers = $conn->query("SELECT COUNT(DISTINCT phone) as count FROM orders")->fetch_assoc()['count'];
  $totalContacts = $conn->query("SELECT COUNT(*) as count FROM contacts")->fetch_assoc()['count'];
  $sql_orders = "SELECT * FROM orders ORDER BY created_at DESC";
  $result_orders = $conn->query($sql_orders);
  $sql_contacts = "SELECT * FROM contacts ORDER BY created_at DESC";
  $result_contacts = $conn->query($sql_contacts);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <mete name="viewport"content="width=device-width,initial-scale=1.0"></mete>
    <title>Admin Dashboard - FudgiCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light">
    <div class="container my-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📊 FudgiCraft Admin Dashboard</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card text-white bg-primary shadow">
            <div class="card-body">
              <h4>Total Orders</h4>
              <p class="fs-3"><?php echo $totalOrders; ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-white bg-success shadow">
            <div class="card-body">
              <h4>Total Customers</h4>
              <p class="fs-3"><?php echo $totalCustomers; ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-white bg-info shadow">
            <div class="card-body">
              <h4>Total Contacts</h4>
              <p class="fs-3"><?php echo $totalContacts; ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
          <h5 class="mb-0">📦 Recent Orders</h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Brownies</th>
                <th>Assorted Box</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result_orders->num_rows > 0) : ?>
              <?php while ($row = $result_orders->fetch_assoc()) : ?>
                <tr>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo htmlspecialchars($row['name']); ?></td>  <!-- Fixed: was customer_name -->
                  <td><?php echo htmlspecialchars($row['phone']); ?></td>
                  <td><?php echo nl2br(htmlspecialchars($row['address'])); ?></td>
                  <td><?php echo htmlspecialchars($row['brownies']); ?></td>
                  <td>
                    <?php 
                      $assorted = $row['assorted'];
                      echo $assorted;
                    ?>
                  </td>
                  <td><?php echo $row['created_at']; ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else : ?>
              <tr>
                <td colspan="7" class="text-center text-muted">No orders yet</td>
              </tr>
            <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card shadow">
        <div class="card-header bg-secondary text-white">
          <h5 class="mb-0">📧 Recent Contacts</h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <thead class="table-secondary">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result_contacts->num_rows > 0) : ?>
                <?php while ($row = $result_contacts->fetch_assoc()) : ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                  </tr>
              <?php endwhile; ?>
            <?php else : ?>
              <tr>
                <td colspan="5" class="text-center text-muted">No contacts yet</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
<?php $conn->close(); ?>