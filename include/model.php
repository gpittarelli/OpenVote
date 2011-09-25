<?php
/* OpenVote - Model definition

Written to be fairly abstract, but currently uses MySQL
as a data provider.
TODO: Use PDO instead of mysql_* functions

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
//define("DATABASE_HOST", "localhost");
//define("DATABASE_USER", "root");
//define("DATABASE_PASSWORD", "pass");
define("DATABASE_HOST", "localhost");
define("DATABASE_DB", "gpittare_ovote");
define("DATABASE_USER", "gpittare_ovote");
define("DATABASE_PASSWORD", "ovote123!");

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

	private $connection = false;

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
							$password = DATABASE_PASSWORD,
							$db = DATABASE_DB) {
		$this->connection = mysql_connect($host, $user, $password);
		if (!$this->connection) {
			throw new ModelConnectException();
		}

		if (!mysql_select_db($db, $this->connection)) {
			throw new ModelConnectException();
		}
	}

	/**
	 * Closes connection to the data provider.
	 *
	 * @throws ModelCloseException
	 */
	public function close() {
		if (!mysql_close($this->connection)) {
			throw new ModelCloseException();
		}
	}

	/**
	 * Checks if this connection to the data
	 * provider is currently connected.
	 *
	 * @return boolean true if this is connected, else false
	 */
	public function isConnected() {
		return $this->connection !== false;
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
		// Example query
		$query = <<<SQL
		INSERT INTO `gpittare_ovote`.`Votes`
             (`id` , `token` , `poll_id` , `option` )
        VALUES (NULL , '%s', '%d', '%s')
SQL;
		// Insert parameters into the query
		$query = sprintf($query, $token, $poll_id, $option);

		// Run query
		$result = mysql_query($query, $this->connection);

		// Test if it went through.
		if (!$result) {
			throw new ModelFetchException("Error registering vote.");
		}
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
		$query = sprintf("SELECT * FROM `Polls` WHERE `id`='%d'", $id);

		$result = mysql_query($query, $connection);

		if (!$result) {
			throw new ModelFetchException("Error fetching poll information.");
		}

		$data = mysql_fetch_object($result);

		if (!$data) {
			throw new ModelFetchException("Error fetching poll information.");
		}

		return new Poll($data.id, $data.title, $data.author,
						$data.admin_email, $data.desciption,
						$data.options, $data.mailing_list,
						$data.end_date);
	}

	/**
	 * Fetches a vote by its token.
	 *
	 * @param string $token token associated with the vote
	 * @return vote the vote with the specified token
	 * @throws ModelFetchException
	 */
	public function fetchIsPollFinished($poll_id) {
		$query = sprintf("SELECT end_date > now() as finished FROM `Polls` WHERE `id`='%d'", $id);

		$result = mysql_query($query, $connection);

		if (!$result) {
			throw new ModelFetchException("Error fetching poll information.");
		}

		$data = mysql_fetch_object($result);

		if (!$data) {
			throw new ModelFetchException("Error fetching poll information.");
		}

		return !!$data.finished;

	}

	/**
	 * Fetches a vote by its token.
	 *
	 * @param string $token token associated with the vote
	 * @return vote the vote with the specified token
	 * @throws ModelFetchException
	 */
	public function fetchVote($token) {
		$query = sprintf("SELECT * FROM `Votes` WHERE `token`='%s'",
					mysql_real_escape_string($token, $connections));

		$result = mysql_query($query, $connection);

		if (!$result) {
			throw new ModelFetchException("Error fetching poll information.");
		}

		$data = mysql_fetch_object($result);

		if (!$data) {
			throw new ModelFetchException("Error fetching poll information.");
		}

		return new Poll($data.id, $data.title, $data.author,
						$data.admin_email, $data.desciption,
						$data.options, $data.mailing_list,
						$data.end_date);
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