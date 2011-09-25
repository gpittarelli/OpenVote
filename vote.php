<?php
	require_once("include/utility.php");

	if (isset($_POST['submit'])) {

		require_once('include/header.php');

	 	try
	 	{
	 		$model = Model::getInstance();
			$model->connect();
			$vote = $model->updateVote($_POST['token'], $_POST['option']);
		}
		catch (ModelConnectException $e)
		{
			array_push($ERR, "Server error - please try again later");
		}
		catch (ModelInsertException $e)
		{
			array_push($ERR, "Error creating vote");
		}

		if (!error_occurred()) {

			?>
			<section id="startvote">
				<h2>
					Vote successfully logged!
				</h2>

			</section>

			<?php

		}

	}
	else
	{

	if (!isset($_GET['t']) || !validate_token($_GET['t'])) {
		// You shouldn't be here!
		//header("Location: /");
		var_dump($_GET);
		var_dump(validate_token($_GET['t']));
		exit();
	}

	$token = $_GET['t'];

	require_once('include/header.php');

	$poll;
 	try
 	{
 		$model = Model::getInstance();
		$model->connect();
		$vote = $model->fetchVote($token);
		$poll = $model->fetchPoll($vote->poll_id);
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
	?>
	<section id="vote">
		<h2>
			<?php echo $poll->title; ?>
		</h2>

		<p>
			<?php echo $poll->description; ?>
		</p>


		<form action="vote" method="post">
			Options:
			<ul>
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
				<?php
				foreach ($options as $option) {
					?>
				<li><input type="radio" value="<?php echo $option; ?>" name="option"><?php echo $option; ?></li>
					<?php
				}
				?>
			</ul>
			<input type="submit" name="submit" />

		</form>

	</section>




<?php
}
 require('include/footer.php'); ?>
