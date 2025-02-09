<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Gallery Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="h.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <div class="backimg">
            <img src="back1.jpg" width="1471" height="500">
        </div>
        <div class="info">
            <br>
            <i class="fas fa-phone" style="color:deeppink"></i> 9603968422
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="fas fa-envelope" style="color:deeppink;"></i> 22b01a0570@svecw.edu.in
        </div>
        <div class="name">
            <span>Art Nest</span>
            <div>
                <?php if (isset($_SESSION['username'])): ?>
                <div class="dropdown">
                    <button class="btn mx-1 dropdown-toggle no-border" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style ="color: white;">
                        Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </button>
                    <div id="userMenu" class="dropdown-menu" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="Userprofile.php">My Profile</a>
                        <a class="dropdown-item" href="userLogout.php">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="dropdown">
                    <button class="btn mx-1 dropdown-toggle no-border" type="button" id="loginDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Login
                    </button>
                    <div id="login" class="dropdown-menu" aria-labelledby="loginDropdown">
                        <a class="dropdown-item" href="userLogin.html">User</a>
                        <a class="dropdown-item" href="artistLogin.html">Artist</a>
                    </div>
                </div>
            <?php endif; ?>
            </div>
        </div>
        <div class="top-bar">
            <br>
            <a id="home" href="h.php">HOME</a>
            <a id="about" href="#aboutus">ABOUT</a>
            <a href="arts.php" id="artType">BROWSE ARTS</a>
            <a id="contact" href="#contactus">CONTACT</a>
            <a id="admin" href="adminLogin.html">ADMIN</a>
        </div>
    </header>
    <br><br>
    <p style="font-size:40px; position:relative;left:530px; font-weight:bold;">WE BELIEVE</p>
    <p style="font-size:20px; position:relative;left:417px;">ART CAN MAKE THIS WORLD A BETTER PLACE</p>
    <button id="explore"><a href="arts.php" style="text-decoration:none; color:whitesmoke; font-weight:bold;"><p style="position:relative;left:10px;top:10px;">Search an Art Work</p>
        <p style="position:relative;left:545px;top:-23px;background-color:white;color:black;width:34.5px; height:31px;padding-top:8px;padding-left:10px;"><i class="fas fa-search" style="font-size:15px;"></i></p>
    </a></button>
    <button id="viewArtists" class="btn btn-primary" style="position:relative; left:50px; top:30px;"><a href="viewArtists.php" style="text-decoration:none; color:white;">View Artist Profiles</a></button>
    <p style="font-size:40px; position:relative;left:490px; top:100px;font-weight:bold;">BEST PRODUCTS</p>
    <div class="container" style="position:relative; left:80px; top:120px;">
        <div class="card">
            <img src="sculpture.png" alt="Image 1">
            <div class="card-content">
                <h4>Sculptures</h4>
            </div>
        </div>
        <div class="container" style="position:relative; left:350px; top:-320px;">
            <div class="card" style="height:320px;">
                <img src="painting.png" alt="Image 1">
                <div class="card-content">
                    <h4>Paintings</h4>
                </div>
            </div>
            <div class="container" style="position:relative; left:350px; top:-350px;">
                <div class="card" style="height:380px;">
                    <img src="porcelian.png" alt="Image 1" height="50">
                    <div class="card-content">
                        <h4>Porcelian</h4>
                    </div>
            <div class="container" style="position:relative; left:-783px; top:65px;">
                <div class="card" style="height:310px;">
                    <img src="streetart.png" alt="Image 1">
                    <div class="card-content">
                        <h4>Street Art</h4>
                    </div>
                </div>
                <div class="container" style="position:relative; left:380px; top:-300px;">
                    <div class="card" style="height:290px;">
                        <img src="fabric.png" alt="Image 1">
                        <div class="card-content">
                            <h4>Fabric Art</h4>
                        </div>
                        <div class="container" style="position:relative; left:320px; top:-250px;">
                            <div class="card" style="height:290px;">
                                <img src="print.png" alt="Image 1">
                                <div class="card-content">
                                    <h4>Prints</h4>
                                </div>
            <p style="position:relative;top:-550px;left:-350px; padding:90px;width:600px;background-color:rgb(0,0,0,0.7); font-weight:bold;color:white;font-size:20px;text-align:center;">GET UPTO <span class="highlight" style="color:deeppink;">50% OFF</span> ON SELECTED <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Art</p>      
    <div class="holder"></div>
    <div class="about-section">
        <div class="about-content">
            <h2 style="text-align:center;font-size:50px;" id="aboutus">About Us</h2>
            <pre>
            <h4><b>-----Welcome to ArtNest!-----</b><h4>
            <h5>We are a passionate group of third-year Computer Science and Engineering students from Shri Vishnu Engineering College for Women.Our team is dedicated to <br> fostering creativity and providing a platform for artists to showcase their talents.
Our mission is to create an inclusive and vibrant online community where artists from all backgrounds can connect, share their work, and inspire one another. At <br> ArtNest, we believe that art has the power to bring people together, transcend boundaries, and spark meaningful conversations.</h5>
            </pre>
        </div>
    </div>
    <div class="contact-section">
        <div class="contact-content">
            <h2 style="text-align:center;font-size:50px;font-weight:bold;"id ="contactus" >Contact Us</h2>
            <i class="fas fa-phone" style="color:deeppink;"></i>
            <br><br>9603968422<br><br>
            <i class="fas fa-envelope" style="color:deeppink;"></i>
            <br><br>csehod@svecw.edu.in
        </div>
    </div>
</body>
</html>
