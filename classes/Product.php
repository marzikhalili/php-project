<?php

/**
 * Defines a Product
 * NOTE: THIS IS ONLY A PARTIAL IMPLEMENTATION - NO INSERT, UPDATE, DELETE, ETC
 */
class Product
{

  #region Properties (private)

  private $_itemId;
  private $_productName;
  private $_unitPrice;
  private $_photo;
  private $_salePrice;
  private $_price;
  private $_selectedCategoryId;
  private $_featured;
  private $_description;
  private $_db;

  #endregion

  #region Constructor - sets up the database connection (using DBAccess)

  public function __construct()
  {
    // Create database connection and store into _db property so other methods can use DBAccess
    require "includes/database.php";
    $this->_db = $db;
  }

  #endregion

  #region Getter and setter methods

  /**
   * Get product ID (there is NO setter for product ID to make it read-only)
   *
   * @return int The product ID
   */
  public function getProductId()
  {
    return $this->_itemId;
  }
  public function getItemId()
  {
    return $this->_itemId;
  }
  public function setItemId()
  {
    return $this->_itemId;
  }

  /**
   * Get product name
   *
   * @return string The product name
   */
  public function getProductName()
  {
    return $this->_productName;
  }

  /**
   * Set product name
   *
   * @param  string $productName The new product name
   * @return void
   */
  public function setProductName($itemName)
  {
    // Remove spaces
    $value = trim($itemName);

    // Check string length (between 1 & 40)
    if (strlen($value) < 1 || strlen($value) > 40) {

      // Invalid new value - throw an exception
      throw new Exception("Product name must be between 1 and 40 characters.");
    } else {

      // Store new value in private property
      $this->_productName = $value;
    }
  }

  /**
   * Get photo path
   *
   * @return string The photo path
   */
  public function getPhoto()
  {
    return $this->_photo;
  }


  /**
   * Get product price
   *
   * @return string The product price
   */
  public function getUnitPrice()
  {
    return $this->_unitPrice;
  }
  public function setPrice($price)
  {
    $this->_price = $price;
  }


  /**
   * Set price
   *
   * @param  string $unitPrice The new price
   * @return void
   */
  public function setUnitPrice($price)
  {
    $this->_unitPrice = $price;
  }


  public function getSalePrice()
  {
    return $this->_salePrice;
  }


  /**
   * Set price
   *
   * @param  string $salePrice The new price
   * @return void
   */
  public function setSalePrice($salePrice)
  {
    $this->_salePrice = $salePrice;
  }

  public function setDescription($description)
  {
    // You can add validation for description if needed
    $this->_description = $description;
  }

  public function setFeatured($featured)
  {
    // Validate $featured as needed
    // For example, ensure it's a valid boolean value
    $this->_featured = $featured === true || $featured === '1' ? '1' : '0';
  }

  public function setSelectedCategoryId($selectedCategoryId)
  {
    // Validate $selectedCategoryId as needed
    // For example, ensure it's a positive integer
    if (!is_numeric($selectedCategoryId) || $selectedCategoryId <= 0) {
      throw new Exception("Invalid selected category ID.");
    }

    // Store new value in private property
    $this->_selectedCategoryId = $selectedCategoryId;
  }

  #endregion

  #region Methods

  /**
   * Get a product by ID and populate the object's properties
   *
   * @param  int $id The ID of the product to get
   * @return void
   */
  public function getProduct($id)
  {
    try {

      // Open database connection
      $this->_db->connect();

      // Define SQL query, prepare statement, bind parameters
      $sql = <<<SQL
          SELECT  itemId, itemName, price, salePrice, photo
          FROM    item
          WHERE   itemId = :itemId
        SQL;
      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindParam(":itemId", $id, PDO::PARAM_INT);

      // Execute query
      $rows = $this->_db->executeSQL($stmt);

      // Get the first (and only) row - we are searching by a unique primary key
      $row = $rows[0];

      // Populate the private properties with the retrieved values
      $this->_itemId = $row["itemId"];
      $this->_productName = $row["itemName"];
      $this->_unitPrice = $row["price"];
      $this->_salePrice = $row["salePrice"];
      $this->_photo = $row["photo"];
    } catch (PDOException $e) {

      // Throw the exception back up a level (don't handle it here)
      throw $e;
    }
  }

  /**
   * Get all products
   *
   * @return array The collection of products
   */
  public function getProducts()
  {
    try {

      // Open database connection
      $this->_db->connect();

      // Define SQL query, prepare statement, bind parameters
      $sql = <<<SQL
          SELECT  *
          FROM    item
        SQL;
      $stmt = $this->_db->prepareStatement($sql);

      // Execute SQL
      $rows = $this->_db->executeSQL($stmt);
      return $rows;
    } catch (PDOException $e) {
      throw $e;
    }
  }

  /**
   * Get the total number of products (COUNT)
   *
   * @return int The number of products
   */
  public function getNumberOfProducts()
  {
    try {

      // Open database connection
      $this->_db->connect();

      // Define SQL query, prepare statement, bind parameters
      $sql = <<<SQL
          SELECT  COUNT(*)
          FROM    item
        SQL;
      $stmt = $this->_db->prepareStatement($sql);

      // Execute SQL
      $value = $this->_db->executeSQLReturnOneValue($stmt);
      return $value;
    } catch (PDOException $e) {
      throw $e;
    }
  }

  #endregion


  public function deleteProduct($itemId)
  {
    try {
      // Open database connection
      $this->_db->connect();

      // Define SQL query, prepare statement, bind parameters
      $sql = <<<SQL
        DELETE 
        FROM    item
        WHERE   itemId = :itemId
      SQL;
      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);

      // Execute SQL
      $value = $this->_db->executeNonQuery($stmt, false);
      return $value;
    } catch (PDOException $e) {
      throw $e;
    }
  }

  public function updateProduct($itemId)
  {
    try {
      // Open database connection
      $this->_db->connect();

      $photo = null;
      $targetDirectory = "images/";

      // Handle file upload...

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
        if (empty($errors)) {

          // OPTIONAL: Change the file name
          // $fileName = "xxxxxxxx.$fileExtension";

          $moveFrom = $_FILES["photo"]["tmp_name"];
          $moveTo = $targetDirectory . $fileName;

          // Move uploaded file from the temp location to the target directory
          if (move_uploaded_file($moveFrom, $moveTo)) {

            // Success - change the photoPath to match the uploaded file name
            $photo = $fileName;
          } else {

            // Error
            $errors["photo"] = "Uploaded file could not be moved.";
          }
        }
      }
      if ($_FILES["photo"]["error"] !== UPLOAD_ERR_NO_FILE) {
        // Perform file upload and update $photoPath
      }

      // Define SQL query, prepare statement, bind parameters
      $sql = <<<SQL
              UPDATE item
              SET itemName = :itemName,
                  photo = :$photo,
                  price = :price,
                  salePrice = :salePrice,
                  description = :description,
                  featured = :featured,
                  categoryId = :categoryId
              WHERE itemId = :productId
          SQL;
      $stmt = $this->_db->prepareStatement($sql);

      $stmt->bindParam(":productId", $this->_itemId, PDO::PARAM_INT);

      $stmt->bindParam(":itemName", $this->_productName, PDO::PARAM_STR);
      $stmt->bindValue(":photo", $photo, PDO::PARAM_STR);
      $stmt->bindParam(":price", $this->_price, PDO::PARAM_STR);
      $stmt->bindParam(":salePrice", $this->_salePrice, PDO::PARAM_STR);
      $stmt->bindParam(":description", $this->_description, PDO::PARAM_STR);
      $stmt->bindParam(":featured", $this->_featured, PDO::PARAM_STR);
      $stmt->bindParam(":categoryId", $this->_selectedCategoryId, PDO::PARAM_INT);


      // Execute the SQL statement
      $this->_db->executeNonQuery($stmt);
    } catch (PDOException $e) {
      throw $e;
    }
  }
}




