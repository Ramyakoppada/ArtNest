<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <title>Art Upload Form</title>
    <style>
        body {
            background: url('background.jpeg') no-repeat;
            background-size: cover;
            background-position: center;
            backdrop-filter: blur(10px);
        }
        .heading {
            text-align: center;
            margin-bottom: 20px;
            color: black;
        }
        .form-label {
            color: black;
            font-size: 18px;
        }
        #other-type-input {
            display: none;
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 m-5">
                    <form class="row shadow-lg p-3 needs-validation" action="updateArt.php" method="post" enctype="multipart/form-data" novalidate>
                        <div class="heading">
                            <h1 class="">EDIT ART DETAILS</h1>
                        </div>
                        <?php
                        session_start();
                        $servername = "localhost";
                        $username = "root";
                        $password = "Praneetha@1";
                        $dbname = "artgallery";
                        
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        
                        if (isset($_GET['art_id'])) {
                            $art_id = $_GET['art_id'];
                            $sql = "SELECT * FROM art_uploads WHERE product_id = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $art_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $art_name = $row['art_name'];
                                $description = $row['description'];
                                $date = $row['date'];
                                $type_of_art = $row['type_of_art'];
                                $other_type = $row['other_type'];
                                $price = $row['price'];
                                $picture = $row['picture'];

                                $other_selected = ($type_of_art == 'other') ? true : false;
                            } else {
                                echo '<div class="col-md-12"><p class="text-center">Art piece not found.</p></div>';
                                exit(); 
                            }
                            $stmt->close();
                        } else {
                            echo '<div class="col-md-12"><p class="text-center">Art ID not specified.</p></div>';
                            exit(); 
                        }
                        ?>
                       
                        <input type="hidden" name="art_id" value="<?php echo $art_id; ?>">
                        
                        
                        <div class="col-md-12 m-2">
                            <label for="art-name" class="form-label">Art Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Art Name" id="art-name" name="art_name" value="<?php echo $art_name; ?>" required />
                            <div class="valid-feedback">Art Name validated</div>
                            <div class="invalid-feedback">Please enter a valid Art Name</div>
                        </div>
                      
                        <div class="col-md-12 m-2">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" placeholder="Description" id="description" name="description" cols="30" rows="5" required><?php echo $description; ?></textarea>
                            <div class="valid-feedback">Description validated</div>
                            <div class="invalid-feedback">Please enter a description</div>
                        </div>
                      
                        <div class="col-md-12 m-2">
                            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date" name="date" value="<?php echo $date; ?>" required />
                            <div class="valid-feedback">Date validated</div>
                            <div class="invalid-feedback">Please enter a valid date</div>
                        </div>
                 
                        <div class="col-md-12 m-2">
                            <label for="type-of-art" class="form-label">Type of Art <span class="text-danger">*</span></label>
                            <select class="form-select" id="type-of-art" name="type_of_art" required>
                                <option value="" disabled>Select Type of Art</option>
                                <option value="sculpture" <?php echo ($type_of_art == 'sculpture') ? 'selected' : ''; ?>>Sculpture</option>
                                <option value="painting" <?php echo ($type_of_art == 'painting') ? 'selected' : ''; ?>>Painting</option>
                                <option value="print" <?php echo ($type_of_art == 'print') ? 'selected' : ''; ?>>Print</option>
                                <option value="scripture" <?php echo ($type_of_art == 'scripture') ? 'selected' : ''; ?>>Scripture</option>
                                <option value="digital" <?php echo ($type_of_art == 'digital') ? 'selected' : ''; ?>>Digital Art</option>
                                <option value="photography" <?php echo ($type_of_art == 'photography') ? 'selected' : ''; ?>>Photography</option>
                                <option value="other" <?php echo ($other_selected) ? 'selected' : ''; ?>>Other</option>
                            </select>
                            <div class="valid-feedback">Type of Art validated</div>
                            <div class="invalid-feedback">Please select a Type of Art</div>
                        </div>
                        
                        <div class="col-md-12 m-2" id="other-type-input" <?php echo ($other_selected) ? 'style="display: block;"' : ''; ?>>
                            <label for="other-type" class="form-label">Please specify <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="other-type" name="other_type" placeholder="Specify type of art" value="<?php echo $other_type; ?>" />
                            <div class="valid-feedback">Other type validated</div>
                            <div class="invalid-feedback">Please specify the type of art</div>
                        </div>
                        
                        <div class="col-md-12 m-2">
                            <label for="picture" class="form-label">Upload Picture</label>
                            <input type="file" class="form-control" id="picture" name="picture" accept="image/*" />
                            <div class="valid-feedback">Picture validated</div>
                            <div class="invalid-feedback">Please upload a picture of your art</div>
                        </div>
                      
                        <div class="col-md-12 m-2">
                            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Price" min="0" step="0.01" value="<?php echo $price; ?>" required />
                            <div class="valid-feedback">Price validated</div>
                            <div class="invalid-feedback">Please enter a valid price</div>
                        </div>

                        <div class="col-md-12 m-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox" required />
                                <label for="checkbox" class="form-check-label">The information provided is genuine and correct</label>
                                <div class="invalid-feedback">Please agree to the terms and conditions</div>
                            </div>
                        </div>
                        <div class="col-md-12 m-2">
                            <button id="submitBtn" class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const form = document.querySelector("form");
        const typeOfArtSelect = document.getElementById("type-of-art");
        const otherTypeInput = document.getElementById("other-type-input");
        const otherType = document.getElementById("other-type");

        // Initial check for Other type
        if (typeOfArtSelect.value === "other") {
            otherTypeInput.style.display = "block";
            otherType.setAttribute("required", "");
        }

        // Toggle Other type input based on selection
        typeOfArtSelect.addEventListener("change", function() {
            if (typeOfArtSelect.value === "other") {
                otherTypeInput.style.display = "block";
                otherType.setAttribute("required", "");
            } else {
                otherTypeInput.style.display = "none";
                otherType.removeAttribute("required");
            }
        });

        // Form validation using Bootstrap's native validation
        form.addEventListener("submit", function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add("was-validated");
        });
    </script>
</body>
</html>
