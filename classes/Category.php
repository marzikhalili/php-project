<?php

/**
 * Defines a category (part of the business logic layer)
 */
class Category
{
  /*
   * Private properties
   */
  private $_categoryId;
  private $_categoryName;
  private $_db;

  
  # region Constructor - sets up the database connection (using DBAccess)
  
  public function __construct()
  {
    // Create database connection and store into _db property so other methods can use DBAccess
    require ROOT_DIR . "includes/database.php";
    $this->_db = $db;
  }

  /*
   * Getter and setter methods
   */

  /**
   * Get category ID (there is NO setter for category ID to make it read-only)
   *
   * @return int The category ID
   */
  public function getCategoryId()
  {
    return $this->_categoryId;
  }

  /**
   * Get category name
   *
   * @return string The category name
   */
  public function getCategoryName()
  {
    return $this->_categoryName;
  }

  /**
   * Set category name
   *
   * @param  string $categoryName The new category name
   * @return void
   */
  public function setCategoryName($categoryName)
  {
    // Remove spaces
    $value = trim($categoryName);

    // Check string length (between 1 & 15)
    if (strlen($value) < 1 || strlen($value) > 15) {
      
      // Invalid new value - throw an exception
      throw new Exception("Category name must be between 1 and 15 characters.");

    } else {
      
      // Store new value in private property
      $this->_categoryName = $value;

    }
  }

  /**
   * Get a category by ID and populate the object's properties
   *
   * @param  int $id The ID of the category to get
   * @return void
   */
  public function getCategory($id)
  {
    try {
      // Open database connection
      $this->_db->connect();

      // Define SQL query, prepare statement, bind parameters
      $sql = <<<SQL
        SELECT  *
        FROM    category
        WHERE   categoryId = :categoryId
      SQL;
      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindParam(":categoryId", $id, PDO::PARAM_INT);

      // Execute query
      $rows = $this->_db->executeSQL($stmt);

      // Get the first (and only) row - we are searching by a unique primary key
      $row = $rows[0];

      // Populate the private properties with the retrieved values
      $this->_categoryId = $row["categoryId"];
      $this->_categoryName = $row["categoryName"];

    } catch (PDOException $e) {
      
      // Throw the exception back up a level (don't handle it here)
      throw $e;
    }
  }

  /**
   * Get all categories
   *
   * @return array The collection of categories
   */
  public function getCategories()
  {
    try {
      // Open database connection
      $this->_db->connect();

      // Define SQL query, prepare statement, bind parameters
      $sql = <<<SQL
        SELECT  *
        FROM    category
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
   * Get the total number of categories (COUNT)
   *
   * @return int The number of categories
   */
  public function getNumberOfCategories()
  {
    try {
      // Open database connection
      $this->_db->connect();

      // Define SQL query, prepare statement, bind parameters
      $sql = <<<SQL
        SELECT  COUNT(*)
        FROM    category
      SQL;
      $stmt = $this->_db->prepareStatement($sql);

      // Execute SQL
      $value = $this->_db->executeSQLReturnOneValue($stmt);
      return $value;

    } catch (PDOException $e) {
      throw $e;
    }
  }

  /**
   * Add a category using values in object's properties
   *
   * @return int The ID of the new category
   */
  public function insertCategory()
  {
    try {
      // Open database connection
      $this->_db->connect();

      // Define SQL query, prepare statement, bind parameters
      $sql = <<<SQL
        INSERT INTO category (categoryName)
        VALUES (:categoryName)
      SQL;
      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindParam(":categoryName", $this->_categoryName, PDO::PARAM_STR);

      // Execute SQL setting the second parameter to true means the primary key will be returned
      $value = $this->_db->executeNonQuery($stmt, true);
      return $value;

    } catch (PDOException $e) {
      throw $e;
    }
  }

  /**
   * Update a category by ID using values in object properties
   *
   * @param  int $id The ID of the category to update
   * @return bool True if update successful
   */
  public function updateCategory($id)
  {
    try {
      // Open database connection
      $this->_db->connect();

      // Define SQL query, prepare statement, bind parameters
      $sql = <<<SQL
        UPDATE  category
        SET     categoryName = :categoryName
        WHERE   categoryId = :categoryId
      SQL;
      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindParam(":categoryName", $this->_categoryName, PDO::PARAM_STR);
      $stmt->bindParam(":categoryId", $id, PDO::PARAM_INT);

      // Execute SQL
      $value = $this->_db->executeNonQuery($stmt, false);
      return $value;

    } catch (PDOException $e) {
      throw $e;
    }
  }
  
    
  /**
   * Delete a category by ID
   *
   * @param  int $id The ID of the category to delete
   * @return bool True if delete successful
   */
  public function deleteCategory($id)
  {
    try {
      // Open database connection
      $this->_db->connect();

      // Define SQL query, prepare statement, bind parameters
      $sql = <<<SQL
        DELETE
        FROM    category
        WHERE   categoryId = :categoryId
      SQL;
      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindParam(":categoryId", $id, PDO::PARAM_INT);

      // Execute SQL
      $value = $this->_db->executeNonQuery($stmt, false);
      return $value;

    } catch (PDOException $e) {
      throw $e;
    }
  }
}