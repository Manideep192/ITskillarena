<?php
// Change connection details as needed
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get submitted email
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    $email = $conn->real_escape_string($_POST["email"]);
    
    // Simple validation
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Avoid duplicate emails
        $sql = "SELECT id FROM subscribers WHERE email='$email'";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows == 0) {
            // Insert email
            $sql = "INSERT INTO subscribers (email) VALUES ('$email')";
            if ($conn->query($sql) === TRUE) {
                echo "Thank you for subscribing!";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "This email is already registered.";
        }
    } else {
        echo "Invalid email address.";
    }
}
$conn->close();
?>
