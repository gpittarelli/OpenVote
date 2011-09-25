<?php $JQUERY = true;
	  $STARTVOTEJS = true;
	  $DATEJS = true;
	  require('include/header.php');

$ERR = Array(); /* Tracks errors. */
function error($error) {
	array_push($ERR, $error);
}

function error_occurred() { return empty($ERR); }

if (isset($_POST['submit'])) {
	try
	{
		$title = safe_extract($_POST, "title");
		$author = safe_extract($_POST, "author");
		$admin_email = safe_extract($_POST, "admin_email");
		$description = safe_extract($_POST, "description");
		$mailing_list = safe_extract($_POST, "mailing_list");
		$options = safe_extract($_POST, "options");
		$end_time = safe_extract($_POST, "end_time");
	}
	catch (Exception $e)
	{
		echo $e;
	}

 	try
 	{
 		$model = Model::getInstance();
		$model.connect();
		$model.insertPoll();
		$model.close();
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
}

if (!isset($_POST['submit']) || error_occurred()) { ?>
    <section id="startvote">
    	<?php
    	if (error_occurred()) {
    		echo "<ul>";
			foreach ($ERR as $err) {
				echo "<li>" . $err . "</li>";
			}
    		echo "</ul>";
    	}
    	?>
		<form action="createvote" name="startvote_form">
			<table>
				<tbody>
					<tr>
						<td><label for="title">Title:</label></td>
						<td><input type="text" name="title" id="title" /></td>
					</tr>
					<tr>
						<td><label for="author">Author Name:</label></td>
						<td><input type="text" name="author" id="author" /></td>
					</tr>
					<tr>
						<td><label for="author_email">Author E-Mail:</label></td>
						<td><input type="text" name="author_email" id="author_email" /></td>
					</tr>
					<tr>
						<td><label for="description">Description:</label></td>
						<td><textarea name="description" id="description"></textarea></td>
					</tr>
					<tr>
						<td><label for="options">Options:</label></td>
						<td><textarea name="options" id="options"></textarea></td>
					</tr>
					<tr>
						<td><label for="participants">Participants:</label></td>
						<td><textarea name="participants" id="participants"></textarea></td>
					</tr>
					<tr>
						<td><label for="end_date">End Date:</label><br />(MM-DD-YYYY hh:mm:ss)</td>
						<td><input type="text" name="end_date" id="end_date" /></td>
					</tr>
					<tr>
						<td><input type="reset" name="reset" id="reset" /></td>
						<td><input type="submit" name="submit" id="submit" /></td>
					</tr>
				</tbody>
			</table>
		</form>
    </section>
<?php
}
else { /* $_POST['submit'] isset, handle POST data */

}

require('include/footer.php'); ?>