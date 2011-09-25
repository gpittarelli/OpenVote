<?php
	require_once("include/utility.php");

	if (!isset($_GET['t']) || !validate_token($_GET['t'])) {
		// You shouldn't be here!
		header("Location: /");
	}

	$token = $_GET['t'];

	require_once('include/header.php');

	$poll;
 	try
 	{
 		$model = Model::getInstance();
		$model->connect();
		$vote = $model->fetchVote($token);
		$options = $model->getPollOptions($vote->poll_id);
	}
	catch (ModelConnectException $e)
	{
		array_push($ERR, "Server error - please try again later");
	}
	catch (ModelInsertException $e)
	{
		array_push($ERR, "Error creating vote");
	}
	var_dump($options);
	?>
	<section id="vote">
		<h2>
			<?php echo $poll->title; ?>
		</h2>

		<form action="vote" method="post">
			<?php echo $poll->title; ?>
			Options:
			<ul>
				<?php
				foreach ($options as $option) {
					?>
				<li><input type="checkbox" name="<?php echo $option; ?>"><?php echo $option; ?></li>
					<?php
				}
				?>
			</ul>

		</form>

	</section>




<?php require('include/footer.php'); ?>
