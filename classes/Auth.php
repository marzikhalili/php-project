<?php

/**
 * The Auth class handles authentication and authorisation tasks such as logging in, logging out, checking if user is logged in, etc. This class is designed to be used statically (without creating an instance), e.g. Auth::protect()
 * 
 * __Auth::LOGIN_PAGE_URL__ - The relative URL of the login page, e.g. login.php
 * 
 * __Auth::SUCCESS_PAGE_URL__ - The relative URL of the success page (redirected after login), e.g. protected.php
 * 
 * __Auth::createUser($username, $password)__ - Create a new user in the database, returns their ID.
 * 
 * __Auth::login($username, $password)__ - Login using the supplied username and password.
 * On success, user is redirected to SUCCESS_PAGE_URL, otherwise returns false.
 * 
 * __Auth::logout()__ - Logout. Session is forgotten, user is redirected to LOGIN_PAGE_URL.
 * 
 * __Auth::protect()__ - Protect a page against unauthorised access (users that are not logged in).
 * If a user is not logged in, they will be redirected to LOGIN_PAGE_URL.
 * 
 * __Auth::isLoggedIn()__ - Check if a user is currently logged in.
 * 
 */
class Auth
{
	#region Properties

	// Settings defined as constants (unchanging values)
	/** @var string The relative URL of the login page, e.g. login.php */
	const LOGIN_PAGE_URL = "login.php";

	/** @var string The relative URL of the success page (redirected after login), e.g. protected.php */
	const SUCCESS_PAGE_URL = "protected.php";

	private static $_db;

	#endregion

	#region Methods


	/**
	 * Opens a connection to the database. DBAccess instance stored in self::$_db
	 *
	 * @return void
	 */
	private static function openDatabaseConnection()
	{
		try {
			// Check if no existing DBAccess instance
			if (is_null(self::$_db)) {

				// Create database connection and store into _db property so other methods can use DBAccess
				require "includes/database.php";
				self::$_db = $db;
			}

			// Open connection
			self::$_db->connect();
		} catch (PDOException $e) {
			die("Unable to connect to database, " . $e->getMessage());
		}
	}


	/**
	 * Start session if it's not already started.
	 *
	 * @return void
	 */
	private static function sessionStart()
	{
		// Start session (if it's not already started)
		if (!isset($_SESSION)) {
			session_start();
		}
	}


	/**
	 * Create a new user in the database.
	 *
	 * @param  string $username The user's username.
	 * @param  string $password The user's plaintext (unhashed) password.
	 * @return int The new user's ID.
	 */
	public static function createUser($username, $password)
	{
		// Hash the password (using PHP default suggested hashing algorithm and settings)
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

		// Open database connection
		// NOTE: static methods are called using self::method() instead of $this->method()
		self::openDatabaseConnection();

		// Add user to the database
		try {
			// Define SQL query, prepare statement, bind parameters
			$sql = <<<SQL
				INSERT INTO user 	(username, password)
				VALUES 						(:username, :password)
			SQL;
			$stmt = self::$_db->prepareStatement($sql);
			$stmt->bindParam(":username", $username, PDO::PARAM_STR);
			$stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);

			// Execute query
			$newUserId = self::$_db->executeNonQuery($stmt, true);

			// Check for bad result from INSERT
			if ($newUserId === false) {
				throw new Exception("Error adding user to database.");
			}
		} catch (PDOException $e) {
			throw $e;
		}

		// Return new user's ID
		return $newUserId;
	}


	/**
	 * Login using the supplied username and password. On success, user is redirected to SUCCESS_PAGE_URL, otherwise returns false.
	 *
	 * @param  string $username The user's username.
	 * @param  string $password The user's plaintext (unhashed) password.
	 * @return bool	False if login credentials are not valid, otherwise redirected to SUCCESS_PAGE_URL.
	 */
	public static function login($username, $password)
	{
		// Make sure session is started
		self::sessionStart();

		// Where the user's hashed password will be stored after retrieval from the database
		$hashedPassword = "";

		// Open database connection
		// NOTE: static methods are called using self::method() instead of $this->method()
		self::openDatabaseConnection();

		// Get user's password from the database (if they exist)
		try {
			// Define SQL query, prepare statement, bind parameters
			$sql = <<<SQL
				SELECT 	password
				FROM 		user
				WHERE		username = :username
			SQL;
			$stmt = self::$_db->prepareStatement($sql);
			$stmt->bindParam(":username", $username, PDO::PARAM_STR);

			// Execute query - get hashed password
			$hashedPassword = self::$_db->executeSQLReturnOneValue($stmt);
		} catch (PDOException $e) {
			throw $e;
		}

		// If user exists, check if the password matches
		if ($hashedPassword && password_verify($password, $hashedPassword)) {

			// ✔ Success! Store the username into the session data (as proof they're logged in)
			$_SESSION["username"] = $username;

			// Redirect the user to the success page (change header and exit)
			header("Location: " . self::SUCCESS_PAGE_URL);
			exit;
		}

		// Invalid login credentials
		return false;
	}


	/**
	 * Logout. Session is forgotten, user is redirected to LOGIN_PAGE_URL.
	 *
	 * @return void
	 */
	public static function logout()
	{
		// Make sure session is started
		self::sessionStart();

		// Remove username from the session data (don't destroy the entire session!)
		unset($_SESSION["username"]);

		// Redirect the user to the login page
		header("Location: " . self::LOGIN_PAGE_URL);
		exit;
	}


	/**
	 * Protect a page against unauthorised access (users that are not logged in). If a user is not logged in, they will be redirected to LOGIN_PAGE_URL.
	 *
	 * @return void
	 */
	public static function protect()
	{
		// Make sure session is started
		self::sessionStart();

		if (empty($_SESSION["username"])) {

			// Redirect the user to the login page
			header("Location: " . self::LOGIN_PAGE_URL);
			exit;
		}
	}


	/**
	 * Check if a user is currently logged in.
	 *
	 * @return bool True if logged in, otherwise false.
	 */
	public static function isLoggedIn()
	{
		// Make sure session is started
		self::sessionStart();

		// Check if "username" is stored in session
		return !empty($_SESSION["username"]);
	}

	#endregion

}

class ChangePassword
{
	private $dbAccess;

	public function __construct(DBAccess $dbAccess)
	{
		$this->dbAccess = $dbAccess;
	}

	public function changePassword($username, $currentPassword, $newPassword, $confirmPassword)
	{
		// Check if the current password is correct
		$storedPassword = $this->getStoredPassword($username);

		// var_dump($storedPassword);

		if ($storedPassword === null) {
			return "User not found.";
		}

		if (!password_verify($currentPassword, $storedPassword)) {
			return "Current password is incorrect.";
		}

		// Check if the new password is the same as the stored password
		if (password_verify($newPassword, $storedPassword)) {
			return "Please enter a new password.";
		}

		// if (trim($currentPassword) != trim($storedPassword)) {
		//     return "Current password is incorrect.";
		// }

		// Validate the new password
		$validationResult = $this->validatePasswordChange($newPassword, $confirmPassword);
		if ($validationResult !== true) {
			return $validationResult;
		}

		// Update the password in the database
		$updateResult = $this->updatePassword($username, $newPassword);

		if ($updateResult === true) {
			return true; // Password change successful
		} else {
			return "Error updating password: " . $updateResult;
		}
	}

	private function getStoredPassword($username)
	{
		$sql = "SELECT password FROM user WHERE userName = :username";
		$stmt = $this->dbAccess->prepareStatement($sql);
		$stmt->bindParam(':username', $username, PDO::PARAM_STR);

		$rows = $this->dbAccess->executeSQL($stmt);

		if (count($rows) > 0) {
			return $rows[0]['password'];
		} else {
			return null;
		}
	}


	private function validatePasswordChange($newPassword, $confirmPassword)
	{
		// Check if the new password and confirm password match
		if ($newPassword !== $confirmPassword) {
			return "New password and confirm password do not match.";
		}

		// Implement additional password strength checks as needed
		// Example: Check if the new password meets a minimum length requirement
		if (strlen($newPassword) < 8) {
			return "New password must be at least 8 characters long.";
		}


		// Add more validation rules as necessary

		// Password change is valid
		return true;
	}

	private function updatePassword($username, $newPassword)
	{
		$sql = "UPDATE user SET password = :newPassword WHERE userName = :username";
		$stmt = $this->dbAccess->prepareStatement($sql);
		$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
		$stmt->bindParam(':newPassword', $hashedPassword, PDO::PARAM_STR);
		$stmt->bindParam(':username', $username, PDO::PARAM_STR);

		return $this->dbAccess->executeNonQuery($stmt);
	}
}
