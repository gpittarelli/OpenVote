<?php
/* OpenVote - Model definition

Example usage:

$model = Model::getInstance();
try
{
   model.connect();

   model.insertPoll(...);
   model.<other_functions(...);
   // ... etc


   model.close();
}
catch (Exception e)
{
   // ... Exception handling
}

*/

/* Constants */
define("DATABASE_HOST", "localhost");
define("DATABASE_USER", "root");
define("DATABASE_PASSWORD", "pass");

/* Exception definitions. */
class ModelConnectException extends Exception {}
class ModelCloseException   extends Exception {}
class ModelFetchException   extends Exception {}
class ModelInsertException  extends Exception {}

/* Class definitions for data objects. */

class Poll {
	public function __construct($id = 0, $title = "", $author = "",
								$admin_email = "", $description = "",
								$options = Array(), $mailing_list = Array(),
							   	$end_date = "01-01-1970 00:00:00") {
		$this->$id = $id;
		$this->$title = $title;
		$this->$author = $author;
		$this->$admin_email = $admin_email;
		$this->$description = $description;
		$this->$options = $options;
		$this->$mailing_list = $mailing_list;
		$this->$end_date = $end_date;

	}

	public $id;
	public $title;
	public $votes;
	public $description;
	public $author;
	public $author_email;
}

/**
 * Singleton that provides access to backend data storage.
 *
 * Is the "Model" of the MVC.
 */
class Model {
	// singleton instance
	private static $instance;

	// private constructor function
	// to prevent external instantiation
	private function __construct() { }

	// getInstance method
	public static function getInstance() {

		if(!self::$instance) {
		self::$instance = new self();
		}

		return self::$instance;
	}

	/*******************************************
	 * Connection Methds                       *
	 *******************************************/

	/**
	 * Connect to the data provider.  A hostname, username,
	 * and/or password may be provided, or they will default
	 * to global constants.
	 *
	 * @param $host (optional) hostname to connect to.
	 * 			    defaults to DATABASE_HOST
	 * @param $user (optional) username to login to MySQL
	 * 			    with. defaults to DATABASE_USER
	 * @param $password (optional) password to login to MySQL
	 * 			    with. defaults to DATABASE_PASSWORDs
	 *
	 * @throws ModelConnectException
	 */
	public function connect($host = DATABASE_HOST,
							$user = DATABASE_USER,
							$password = DATABASE_PASSWORD) {
	}

	/**
	 * Closes connection to the data provider.
	 *
	 * @throws ModelCloseException
	 */
	public function close() {
	}

	/*******************************************
	 * Insert methods                          *
	 *******************************************/

	/**
	 * Insert a new poll into the table.
	 *
	 * @param string $title the title of this poll
	 * @param string $author
	 * @param string $description
	 * @param array $options array of possible options
	 * 			    for this poll
	 * @param string $endDate the end date for the poll,
	 * 				 formatted as "MM-DD-YYYY HH:mm:SS"
	 *
	 * @throws ModelInsertException
	 */
	public function insertPoll($title, $author, $admin_email,
							   $description, $options, $mailing_list,
							   $end_date) {
	}

	/**
	 * Insert a new poll into the table.
	 *
	 * @param string $title the title of this poll
	 * @param string $author
	 * @param string $description
	 * @param array $options array of possible options
	 * 			    for this poll
	 * @param string $endDate the end date for the poll,
	 * 				 formatted as "MM-DD-YYYY HH:mm:SS"
	 *
	 * @throws ModelInsertException
	 */
	public function insertVote($token, $option, $poll_id) {
	}

	/*******************************************
	 * Fetcher methods                         *
	 *******************************************/

	/**
	 * Retrieves a poll from the data provider with the
	 * given id.
	 *
	 * @param $id the id of the poll we want to retrieve
	 * @return Poll the poll with id $id
	 * @throws ModelFetchException
	 */
	public function fetchPoll($id) {
	}

	/**
	 * Fetches the option that a given token has voted for
	 * in a poll.
	 *
	 * @param string $token token associated with the vote
	 * @return string the option that this
	 * @throws ModelFetchException
	 */
	public function fetchVote($token) {

	}

};

?>