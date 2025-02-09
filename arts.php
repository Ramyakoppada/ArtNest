<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <title>Art Gallery</title>
    <style>
        body {
    position: relative; 
    background-size: cover;
    background-position: center;
    backdrop-filter: blur(10px);
}

.home-icon {
    position: fixed; 
    top: 20px; 
    right: 20px; 
    font-size: 24px;
    color: black;
    cursor: pointer;
    z-index: 1000; 
}

.heading {
    text-align: center;
    margin-top: 20px;
    color: black;
}

.card {
    margin: 20px;
}

.card img {
    max-height: 200px;
    object-fit: cover;
}

#browse {
    position: relative;
    top: -5px;
    font-size: 24px;
    padding-left: 47px;
}

#paint {
    position: relative;
    top: 25px;
    font-size: 20px;
    padding-left: 15px;
}

.dropdown button {
    position: relative;
    left: 180px;
    top: -53px;
    border: 1px solid white;
    outline: none !important;
}

#drop {
    width: 250px;
    position: relative;
    top: -8px;
}

li {
    height: 50px;
}

.dropdown button .caret {
    display: none;
}

.dropdown-toggle::after {
    content: '\f0c9';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    font-size: 18px;
    margin-left: 5px;
    vertical-align: middle;
    color: black;
}

    </style>
</head>
<body>
    <i class="fas fa-home home-icon" onclick="window.location.href='h.php'"></i>
    <i class="fas fa-palette" id="paint"></i>
    <p id="browse">ART TYPES</p>
    <div class="dropdown show">
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"></button>
            <ul class="dropdown-menu" id="drop">
                <li><a href="#" onclick="filterArt('sculpture')">SCULPTURES</a></li>
                <li><a href="#" onclick="filterArt('painting')">PAINTINGS</a></li>
                <li><a href="#" onclick="filterArt('print')">PRINTS</a></li>
                <li><a href="#" onclick="filterArt('scripture')">SCRIPTURES</a></li>
                <li><a href="#" onclick="filterArt('digital')">DIGITAL ARTS</a></li>
                <li><a href="#" onclick="filterArt('photography')">PHOTOGRAPHY</a></li>
                <li><a href="#" onclick="filterArt('NO FILTER')"><b>NO FILTER</b></a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="heading">
            <h1>ART GALLERY</h1>
        </div>
        <div class="row" id="artGallery">
        </div>
    </div>

    <script>
        function filterArt(type) {
            $.ajax({
                url: 'fetchArts.php',
                type: 'GET',
                data: { art_type: type },
                success: function(response) {
                    console.log('AJAX request succeeded.');
                    $('#artGallery').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed: ' + status + ', ' + error);
                    console.log(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            filterArt('NO FILTER'); 
        });
    </script>
</body>
</html>
