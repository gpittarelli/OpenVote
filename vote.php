<?php

	if (!isset($_GET['t']) || !validate_token($_GET['t'])) {
		// You shouldn't be here!
		header("Location: /");
	}

	require('include/header.php');

	$poll;
 	try
 	{
 		$model = Model::getInstance();
		$model->connect();
		//$model->insertVote();
		$model->close();
	}
	catch (ModelConnectException $e)
	{
		array_push($ERR, "Server error - please try again later");
	}
	catch (ModelInsertException $e)
	{
		array_push($ERR, "Error creating vote");
	}
	catch (ModelCloseException $e)
	{
		// Not the best of outcomes, but
		// at least we got the data into
		// the model.
	}
	?>
	<section id="vote">
		<h2>

		</h2>

		<form action="vote" method="post">


			<ul>
				<li></li>
			</ul>

		</form>

	</section>




<?php require('include/footer.php'); ?>
