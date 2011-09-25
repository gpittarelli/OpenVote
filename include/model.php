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

All dates are assumed to be: MM-DD-YYYY hh:mm:ss

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
	public $author;
	public $author_email;
	public $description;
	public $options;
	public $mailing_list;
	public $end_date;
}

class Vote {
	public function __construct($id = 0, $option = "", $token = "") {
		$this->$id = $id;
		$this->$option = $option;
		$this->$token = $token;
	}

	public $id;
	public $option;
	public $token;
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

	private $connection;

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
		$connection = mysql_connect($host, $user, $password);
		if (!$connection) {
			throw new ModelConnectException();
		}
	}

	/**
	 * Closes connection to the data provider.
	 *
	 * @throws ModelCloseException
	 */
	public function close() {
		if (!mysql_close($connection)) {
			throw new ModelCloseException();
		}
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
	 * Fetches a vote by its token.
	 *
	 * @param string $token token associated with the vote
	 * @return vote the vote with the specified token
	 * @throws ModelFetchException
	 */
	public function fetchVote($token) {

	}

	/**
	 * Fetches all of the votes for a given poll.
	 *
	 * @param number $poll_id poll id to get votes from
	 * @return array an array of votes
	 * @throws ModelFetchException
	 */
	public function fetchVotesForPoll($poll_id) {

	}

};

?>