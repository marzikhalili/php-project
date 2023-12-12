<?php

    // Common includes for main PHP pages (controllers)
    require_once "includes/common.php";

    // Config
    $title = "Add products";

    // Start output buffering (capture output, don't display it yet)
    ob_start();

    // Check if form has been submitted
    if (isset($_POST["submitAddProduct"])) {

        // Form has been submitted - process form data

        // Get data passed to this page (in the $_POST super global array)
        $itemName = $_POST["itemName"] ?? "";
        $photo = null; // photo is NOT in the $_POST array... it's in $_FILES
        $price = $_POST["price"] ?? "";
        $salePrice = $_POST["salePrice"] ?? "";
        $description = $_POST["description"] ?? "";
        $featured = $_POST["featured"] ?? null;
        $categoryId = $_POST["categoryId"] ?? null;

        // Clean up input data (e.g. trim)
        $itemName = trim($itemName);
        $description = trim($description);

        // Collection of all errors for this form (empty by default)
        $errors = [];

        
        // $errors["fieldName"] = "Error message for field";

        // Validate first name (2-10 characters)
        if (strlen($itemName) < 2 || strlen($itemName) > 150) {
            $errors["itemName"] = "item name must be between 2-150 characters";
        }

        // Validate last name (2-20 characters)
        if (empty($description)) {
            $errors["description"] = "description is required";
        } else if (strlen($description) > 2000) {
            $errors["description"] = "description must be no more than 2000 characters";
        }



        /* 
         * Photo file upload
         */

        // Location where photos are saved
        $targetDirectory = "photos/";

        // If file is NOT required, skip processing if no file is given
        $fileUploadOptional = true;

        if (!($fileUploadOptional && $_FILES["photo"]["error"] === "UPLOAD_ERR_NO_FILE")) {

            // Get the filename of the uploaded file
            $fileName = basename($_FILES["photo"]["name"]);

            // Make sure file is an image
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $validExtensions = ["jpg", "jpeg", "png", "gif"];
            if (!in_array($fileExtension, $validExtensions)) {
                
                // Invalid file extension!
                $errors["photo"] = "Invalid file extension, must be: " . implode(", ", $validExtensions);

            }

            // Check file size
            // The uploaded file exceeds the 
            if (
                $_FILES["photo"]["error"] === UPLOAD_ERR_INI_SIZE ||
                $_FILES["photo"]["error"] === UPLOAD_ERR_FORM_SIZE
            ) {
                // File too big
                $errors["photo"] = "File is too large.";
            }

            

            // Make sure we DON'T have any file errors
            if (empty($errors)) {

                // OPTIONAL: Change the file name
                // $fileName = "xxxxxxxx.$fileExtension";

                $moveFrom = $_FILES["photo"]["tmp_name"];
                $moveTo = $targetDirectory . $fileName;
                
                // Move uploaded file from the temp location to the target directory
                if (move_uploaded_file($moveFrom, $moveTo)) {

                    // Success - change the photo to match the uploaded file name
                    $photo = $fileName;

                } else {

                    // Error
                    $errors["photo"] = "Uploaded file could not be moved.";
                }

            }
        }


        // Check for invalid data (errors)
        if (!empty($errors)) {

            // Invalid: Display the form with error messages
            
            // Include the form template
            include_once "templates/_addProductForm.html.php";

        } else {

            // Valid: Insert the employee into the database & display confirmation

            // Insert statement for employee
            $sql = <<<SQL
                INSERT INTO item (itemName, photo, price, salePrice, description, featured,categoryId)
                VALUES           (:itemName, :photo, :price, :salePrice, :description, :featured, :categoryId)
            SQL;

            // Prepare the SQL statement
            $stmt = $db->prepareStatement($sql);

            // Add/bind parameter values
            $stmt->bindValue(":itemName", $itemName, PDO::PARAM_STR);
            $stmt->bindValue(":photo", $photo, PDO::PARAM_STR);
            $stmt->bindValue(":price", $price, PDO::PARAM_INT);
            $stmt->bindValue(":salePrice", $salePrice, PDO::PARAM_INT);
            $stmt->bindValue(":description", $description, PDO::PARAM_STR);
            $stmt->bindValue(":featured", $featured, PDO::PARAM_BOOL);
            $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);


            // Insert the employee
            // The "true" parameter returns the ID of the new employee (that has been auto-generated)
            $newItemId = $db->executeNonQuery($stmt, true);
            
            // Display success message
            $successMessage = "item added successfully, new ID: $newItemId";
            include_once "templates/_success.html.php";

        }

    } else {

        // Form not submitted (first load of the page) - just show the form

        // Include the form template
        include_once "templates/_addProductForm.html.php";

    }
    
    // Stop output buffering - store output in the $output variable
    $output = ob_get_clean();

    // Include the layout template (and inject content via $output)
    include_once "templates/_layout.html.php";
    