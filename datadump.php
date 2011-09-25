<?php

/* datadump?p=<poll_id>
 * Prints out the options for the given poll and
 * all of the vote tokens for each option.
 */

if (!isset($_GET['p']) || !is_numeric($_GET['p'])) {
	header("Location: /");
}

header("Content-type: text/plain");

$poll_id = (int)$_GET['p'];

require("include/model.php");

$poll;
$votes;

try
{
	$model = Model::getInstance();
	$model->connect();
	$poll = $model->fetchPoll($poll_id);
	$votes = $model->fetchVotesForPoll($poll_id);
	$model->close();
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

$options = $poll->options;
sort($options);

foreach ($options as $option) {

}

?>