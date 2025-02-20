<?php
include 'db.php';

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./submit.css\">";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameerr = $emailerr = $messageerr = "";
    $scriptErr = "";  // Variable to store script error message

    // Retrieve and sanitize input
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Check for <script> tags in the input fields
    if (preg_match("/<script.*?>.*?<\/script>/is", $username) || preg_match("/<script.*?>.*?<\/script>/is", $email) || preg_match("/<script.*?>.*?<\/script>/is", $message)) {
        $scriptErr = "You cannot use <script> tags in the username, email, or message!";
    }

    // Validation
    if (empty($username)) {
        $usernameerr = "Please enter a username";
    }

    if (empty($email)) {
        $emailerr = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailerr = "Invalid email format";
    }

    if (empty($message)) {
        $messageerr = "Please enter a message";
    }

    // If no validation errors, insert into the database
    if (empty($usernameerr) && empty($emailerr) && empty($messageerr) && empty($scriptErr)) {
        $username = mysqli_real_escape_string($conn, $username);
        $email = mysqli_real_escape_string($conn, $email);
        $message = mysqli_real_escape_string($conn, $message);

        // Check if username exists
        $check_sql = "SELECT id FROM contacts WHERE username = '$username'";
        $result = mysqli_query($conn, $check_sql);
        if (mysqli_num_rows($result) > 0) {
            header("Location: index.php?error=username_exists");
            exit();
        }

        // Insert query
        $sql = "INSERT INTO contacts (username, email, message) VALUES ('$username', '$email', '$message')";

        if (mysqli_query($conn, $sql)) {
            // Redirect to prevent resubmission
            header("Location: submit.php?success=1");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Show validation errors
        echo "<h3 style='color:red;'>$usernameerr<br>$emailerr<br>$messageerr<br>$scriptErr</h3>";
    }
}

// Display success message if redirected
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<h3 style='color:green; text-align:center;'>Data inserted successfully!</h3>";
}

if (isset($_GET['error']) && $_GET['error'] == 'username_exists') {
    echo "<h3 style='color:red; text-align:center;'>Error: Username already exists!</h3>";
}

// Fetch and display all stored data
$sql = "SELECT * FROM contacts ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Stored Data:</h2>";
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Message</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["message"]) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No data found in the database.</p>";
}

// Close the database connection
mysqli_close($conn);
?>
