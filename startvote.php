<?php $JQUERY = true;
	  $STARTVOTEJS = true;
	  $DATEJS = true;
	  require('include/header.php');

$INPUT_FIELDS = Array('title' => 'Title',
					  'author' => 'Author',
					  'admin_email' => 'Admin email',
				 	  'desciption' => 'Description',
					  'mailing_list' => 'Mailing list',
					  'options' => 'Options',
					  'end_time' => 'End date');

if (isset($_POST['submit'])) {
	$SAFE_INPUT =
	$SANITIZED = Array();

	/* Get values out of $_POST. */
	foreach ($INPUT_FIELDS as $field_name => $user_friendly_name)
	{
		try
		{
			$SANITIZED[$field_name] = safe_extract($_POST, $field_name);
		}
		catch (Exception $e)
		{
			error($user_friendly_name . " is a required field");
		}
	}

	/* Sanitize fields that need it. */
	if (!validate_email($SANITIZED['email'])) {
		error("Email is invalid.");
		unset($SANITIZED['email']);
	}

	if (!validate_date($SANITIZED['end_time'])) {
		error("End time invalid.");
		unset($SANITIZED['end_time']);
	}

	if (!error_occurred())
	{
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
		<form action="startvote" name="startvote_form">
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
						<td><label for="end_date">End Date:</label><noscript><br />(MM-DD-YYYY hh:mm:ss)</noscript></td>
						<td><input type="text" name="end_date" id="end_date" value="<?php echo date(DATE_FORMAT); ?>" /></td>
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