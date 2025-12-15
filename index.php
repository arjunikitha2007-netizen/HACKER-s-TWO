<?php
// index.php - Main Homepage for HACKER's-TWO (Model 4)
$site_name = "HACKER's-TWO";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> - System Access</title>
    <style>
        /* Define the new primary accent color */
        :root {
            --primary-accent: #FFD700; /* Gold/Yellow */
            --secondary-accent: #E0E0E0; /* Light Gray */
            --background-dark: #0c0c0c; /* Near black */
            --header-dark: #1a1a1a;
        }

        /* Minimalist / Futuristic Dark Styling */
        body {
            font-family: 'Space Mono', 'Consolas', monospace; /* Futuristic font choice */
            margin: 0;
            background-color: var(--background-dark); /* Near black */
            color: var(--secondary-accent); /* Light gray text */
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 80px;
            background-color: var(--header-dark);
            /* CHANGED: Used Gold accent for border */
            border-bottom: 2px solid var(--primary-accent); 
        }
        .logo a {
            /* CHANGED: Primary accent for logo */
            color: var(--primary-accent); 
            text-decoration: none;
            font-size: 30px;
            font-weight: bold;
            letter-spacing: 3px;
        }
        .nav-links {
            display: flex;
            align-items: center;
        }
        .nav-links a {
            color: var(--secondary-accent);
            text-decoration: none;
            margin-left: 40px;
            font-size: 16px;
            padding: 5px 0;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            /* CHANGED: Primary accent for hover */
            color: var(--primary-accent); 
        }
        /* Login Button - Prominent Gold accent (already this color, but adjusted hover) */
        .nav-login-btn {
            background-color: var(--primary-accent); /* Gold/Yellow */
            color: var(--background-dark);
            padding: 10px 25px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 2px; /* Minimalist sharp corners */
            margin-left: 40px;
            transition: background-color 0.3s, box-shadow 0.2s;
            border: 1px solid var(--primary-accent);
        }
        .nav-login-btn:hover {
            /* Adjusted hover color to use the dark background with accent shadow */
            background-color: var(--background-dark); 
            color: var(--primary-accent);
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.5);
        }

        /* Main Content Styling */
        .main-hero {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 120px 80px;
            min-height: 70vh;
            text-align: left; 
            /* Subtle background grid/texture: CHANGED: Used Gold accent for grid */
            background-image: linear-gradient(0deg, transparent 24%, rgba(255, 215, 0, 0.05) 25%, rgba(255, 215, 0, 0.05) 26%, transparent 27%, transparent 74%, rgba(255, 215, 0, 0.05) 75%, rgba(255, 215, 0, 0.05) 76%, transparent 77%, transparent), linear-gradient(90deg, transparent 24%, rgba(255, 215, 0, 0.05) 25%, rgba(255, 215, 0, 0.05) 26%, transparent 27%, transparent 74%, rgba(255, 215, 0, 0.05) 75%, rgba(255, 215, 0, 0.05) 76%, transparent 77%, transparent);
            background-size: 50px 50px;
        }
        .hero-text {
            max-width: 700px;
            position: relative;
            /* Added an angular border element for futuristic flair */
            padding-left: 30px; 
            /* CHANGED: Used Gold accent for hero border */
            border-left: 4px solid var(--primary-accent); 
        }
        .hero-text h1 {
            font-size: 80px; 
            color: #fff;
            margin: 0 0 20px 0;
            line-height: 1.0;
            letter-spacing: -2px;
        }
        .hero-text h1 span {
            /* CHANGED: Primary accent for headline emphasis */
            color: var(--primary-accent); 
        }
        .hero-text p.tagline {
            /* Tagline remains Gold/Yellow */
            color: var(--primary-accent); 
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .hero-text p.description {
            font-size: 20px; 
            color: #a8a8a8;
            margin-bottom: 50px;
            line-height: 1.5;
        }
        .main-cta {
            /* CHANGED: Primary CTA button color is now Gold/Yellow */
            background-color: var(--primary-accent); 
            color: var(--background-dark); 
            padding: 18px 45px; 
            text-decoration: none;
            font-weight: bold;
            border-radius: 2px;
            font-size: 20px;
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            display: inline-block;
        }
        .main-cta:hover {
            /* CHANGED: Hover effect to white background with Gold shadow */
            background-color: #fff;
            transform: scale(1.03);
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.7);
        }

    </style>
</head>
<body>

    <div class="header">
        <div class="logo">
            <a href="#"><?php echo $site_name; ?></a>
        </div>
        <div class="nav-links">
            <a href="#">Labs Access</a>
            <a href="#">Contact</a>
            <a href="login.php" class="nav-login-btn">LOGIN</a>
        </div>
    </div>

    <div class="main-hero">
        
        <div class="hero-text">
            <p class="tagline">[SYSTEM: SECURE PERIMETER ONLINE]</p>
            <h1>
                INITIATE <br>
                <span>CYBER</span> PROTOCOL.
            </h1>
            <p class="description">
                Access the next generation of threat response training. Join the elite who are building the firewalls of tomorrow. Access requires authorized credentials.
            </p>
            <a href="#" class="main-cta">ENGAGE TRAINING MODE</a>
        </div>

    </div>

</body>
</html>
