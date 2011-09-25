<?php

require_once("include/utility.php");
require_once("include/config.php");
require_once("include/model.php");

/* datadump?p=<poll_id>
 * Prints out the options for the given poll and
 * all of the vote tokens for each option.
 */

if (!isset($_GET['p']) || !is_numeric($_GET['p'])) {
	header("Location: /");
}

header("Content-type: text/plain");

$poll_id = (int)$_GET['p'];

$poll;
$votes;

try
{
	$model = Model::getInstance();
	$model->connect();
	$poll = $model->fetchPoll($poll_id);
	$options = $model->getPollOptions($poll_id);

	//$votes = $model->fetchVotesForPollForOption($poll_id);
	//$model->close();
}
catch (ModelConnectException $e)
{
	array_push($ERR, "Server error - please try again later.");
}
catch (ModelFetchException $e)
{
	array_push($ERR, "Error fetching poll information.");
}
catch (ModelCloseException $e)
{
	// Not the best of outcomes, but
	// at least we got the data into
	// the model.
}

echo "Poll: " . $poll->title . " (" . count($votes) . " total votes)\n\n";

//$options = $poll->options;
//sort($options);

foreach ($options as $option) {
	echo "$option\n";
	try
	{
		$votes = $model->fetchVotesForPollForOption($poll_id, $option);
		foreach ($votes as $vote) {
			echo "$vote\n";
		}
	}
	catch (ModelFetchException $e)
	{
		array_push($ERR, "Error fetching poll information.");
	}
	echo "\n\n";
}

?>