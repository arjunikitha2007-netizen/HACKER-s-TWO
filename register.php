<?php
// register.php - New User Registration and Account Creation

// Include the central configuration and database connection
require_once 'config.php';

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Validate Username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        // Check if username already exists using a prepared statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // 2. Validate Password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // 3. Validate Confirm Password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // 4. Check input errors before inserting into database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        
        // Prepare an INSERT statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Hash the password for secure storage
            $param_username = $username;
            // 
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Default uses bcrypt
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: login.php?success=1");
                exit;
            } else {
                echo "ERROR: Could not execute query: " . mysqli_error($conn);
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
    <title>HACKER's-TWO - Register New User</title>
    <style>
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
        
        .register-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .register-box {
            background-color: var(--header-dark);
            padding: 40px 50px;
            border: 2px solid var(--primary-accent);
            border-radius: 4px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 0 25px rgba(255, 215, 0, 0.2);
        }

        .register-box h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            letter-spacing: 2px;
            border-bottom: 1px dashed rgba(255, 215, 0, 0.3);
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary-accent); /* Labels are gold here for registration */
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
            box-sizing: border-box;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus, .form-control.is-invalid:focus {
            border-color: var(--primary-accent);
            outline: none;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }

        .form-control.is-invalid {
            border-color: #ff6347; /* Error Red */
        }

        .btn-primary {
            width: 100%;
            background-color: var(--primary-accent);
            color: var(--background-dark);
            padding: 15px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            border-radius: 2px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #fff;
            transform: scale(1.01);
            color: var(--background-dark);
        }

        .help-block {
            color: #ff6347;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .login-link a {
            color: var(--primary-accent);
            text-decoration: none;
            transition: color 0.3s;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <div class="register-box">
            <h2>NEW USER REGISTRATION</h2>
            <p style="text-align: center; color: #a8a8a8; margin-bottom: 25px;">Enter your credentials to create a new system account.</p>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                
                <div class="form-group">
                    <label for="username">USERNAME</label>
                    <input type="text" name="username" id="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($username); ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                
                <div class="form-group">
                    <label for="password">PASSWORD</label>
                    <input type="password" name="password" id="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">CONFIRM PASSWORD</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                
                <div class="form-group">
                    <input type="submit" class="btn-primary" value="CREATE ACCOUNT">
                </div>
                
            </form>

            <div class="login-link">
                Already have an account? <a href="login.php">Login Here</a>
            </div>
        </div>
    </div>

</body>
</html>
