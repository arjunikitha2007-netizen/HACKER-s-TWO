<?php
// login.php - System Access and Authentication

// Include the central configuration and database connection
require_once 'config.php';

$username = $password = "";
$username_err = $password_err = $login_err = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // 2. Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // 3. Check credentials only if inputs are valid
    if (empty($username_err) && empty($password_err)) {
        
        // Prepare a SELECT statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes, verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        // NOTE: You MUST use password_verify() with hashed passwords stored via password_hash()
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to a dashboard/welcome page
                            header("location: welcome.php");
                            exit;

                        } else {
                            // Password is not valid
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Access - Login</title>
    <style>
        /* Define the new primary accent color */
        :root {
            --primary-accent: #FFD700; /* Gold/Yellow */
            --secondary-accent: #E0E0E0; /* Light Gray */
            --background-dark: #0c0c0c; /* Near black */
            --header-dark: #1a1a1a;
        }

        body {
            font-family: 'Space Mono', 'Consolas', monospace;
            margin: 0;
            background-color: var(--background-dark);
            color: var(--secondary-accent);
        }
        
        /* Centered Login Container */
        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 20px;
        }

        .login-box {
            background-color: var(--header-dark);
            padding: 40px 50px;
            border: 2px solid var(--primary-accent); /* Gold border */
            border-radius: 4px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 25px rgba(255, 215, 0, 0.2); /* Subtle glow */
        }

        .login-box h2 {
            color: var(--primary-accent);
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            letter-spacing: 2px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--secondary-accent);
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #444;
            background-color: #222;
            color: var(--secondary-accent);
            font-size: 16px;
            border-radius: 2px;
            box-sizing: border-box; /* Include padding in the element's total width and height */
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-accent);
            outline: none;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }

        .btn-primary {
            width: 100%;
            background-color: var(--primary-accent); /* Gold/Yellow */
            color: var(--background-dark);
            padding: 15px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            border-radius: 2px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-primary:hover {
            background-color: #fff; /* White hover */
            transform: scale(1.01);
            color: var(--background-dark);
        }

        .alert-danger {
            color: #ff6347; /* Tomato red for errors */
            background-color: rgba(255, 99, 71, 0.1);
            border: 1px solid #ff6347;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 2px;
            font-size: 14px;
            text-align: center;
        }

        .help-block {
            color: #ff6347;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: var(--primary-accent);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-box">
            <h2>SYSTEM ACCESS REQUIRED</h2>

            <?php 
            if(!empty($login_err)){
                echo '<div class="alert-danger">' . $login_err . '</div>';
            }        
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="username">USERNAME</label>
                    <input type="text" name="username" id="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                
                <div class="form-group">
                    <label for="password">PASSWORD</label>
                    <input type="password" name="password" id="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                
                <div class="form-group">
                    <input type="submit" class="btn-primary" value="LOG IN">
                </div>
            </form>
            
            <div class="back-link">
                <a href="index.php">Abort Protocol and Return to Index</a>
            </div>
        </div>
    </div>

</body>
</html>
