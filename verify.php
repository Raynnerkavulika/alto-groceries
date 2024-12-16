<?php
// Check if the token is in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token']; // Token passed via URL
} else {
    // If token is missing, show error and exit
    echo "Invalid verification request.";
    exit();
}

// If form is submitted, handle verification logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted verification code and token
    $verification_code = $_POST['verification_code'];

    // Include database connection
    include('config.php');

    // Query the database for the user with the provided token
    $query = "SELECT * FROM users WHERE token = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        // Check if the verification code is correct
        if ($verification_code == $user['verification_code']) {
            // Check if the token has expired
            if (time() < $user['token_expiry']) {
                // Token is valid, proceed with verification
                $updateQuery = "UPDATE users SET verified = 1, token = NULL WHERE token = ?";
                $conn->prepare($updateQuery)->execute([$token]);

                // Redirect to login page with a success message
                header("Location: login.php?status=verified");
                exit();
            } else {
                // Token has expired
                echo "The verification token has expired. Please request a new one.";
            }
        } else {
            // Invalid verification code
            echo "Invalid verification code.";
        }
    } else {
        // Invalid token
        echo "Invalid verification request.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="verification-container">
        <h2>Email Verification</h2>
        <p>Enter the verification code sent to your email address.</p>
        
        <!-- Form to input the verification code -->
        <form action="verify.php?token=<?php echo htmlspecialchars($token); ?>" method="post">
            <!-- Input field for the verification code -->
            <input type="text" name="verification_code" placeholder="Enter verification code" required>
            
            <!-- Submit button -->
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html>
