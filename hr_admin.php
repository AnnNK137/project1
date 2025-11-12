<?php
session_start();
require_once "settings.php"; // make sure this connects to your database

// Check if the user is logged in
if (!isset($_SESSION['ID'])) {
    header("Location: hr_login.php");
    exit();
}

// Handle form submission to update HR info
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['position'] as $hr_id => $position) {
        $hr_id = (int)$hr_id;
        $position = mysqli_real_escape_string($conn, $position);

        // Update the position in the database
        mysqli_query($conn, "UPDATE HR SET position='$position' WHERE hr_ID=$hr_id");
    }
}

// Optional filter
$firstName = $_GET['first_name'] ?? '';
$lastName  = $_GET['last_name'] ?? '';

// Build query
$query = "SELECT * FROM HR";
$conditions = [];

if ($firstName != '') { $conditions[] = "firstName LIKE '%$firstName%'"; }
if ($lastName != '')  { $conditions[] = "lastName LIKE '%$lastName%'"; }

if (count($conditions) > 0) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HR MANAGEMENT</title>
<link rel="stylesheet" href="styles/styles.css">
<link rel="stylesheet" href="styles/manage.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php include "header_hr.php"; ?>

<!-- FILTER FORM -->
<form action="manage.php" method="GET" class="filter">
    <input type="text" name="first_name" placeholder="First Name" value="<?= htmlspecialchars($firstName) ?>">
    <input type="text" name="last_name" placeholder="Last Name" value="<?= htmlspecialchars($lastName) ?>">
    <button type="submit" class="btn">Filter</button>
</form>

<!-- HR TABLE -->
<form method="POST" action="hr_admin.php">
    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Position</th>
            <th>Favorite Color</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['hr_ID'] ?></td>
            <td><?= htmlspecialchars($row['firstName']) ?></td>
            <td><?= htmlspecialchars($row['lastName']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
                <?php if ($_SESSION['position'] == 'admin'): ?>
                    <select name="position[<?= $row['hr_ID'] ?>]">
                        <option value="staff" <?= $row['position']=='staff'?'selected':'' ?>>Staff</option>
                        <option value="admin" <?= $row['position']=='admin'?'selected':'' ?>>Admin</option>
                    </select>
                <?php else: ?>
                    <?= $row['position'] ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if ($_SESSION['position'] == 'admin'): ?>
    <button type="submit" class="btn"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
    <?php endif; ?>
</form>
</body>
</html>
