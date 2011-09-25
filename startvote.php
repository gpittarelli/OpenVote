<?php $JQUERY = true;
	  $STARTVOTEJS = true;
	  $DATEJS = true;
	  require('include/header.php');

$INPUT_FIELDS = Array('title' => 'Title',
					  'author' => 'Author',
					  'author_email' => 'Admin email',
				 	  'description' => 'Description',
					  'mailing_list' => 'Mailing list',
					  'options' => 'Options',
					  'end_date' => 'End date');

function preserve_field($key, $default = "") {
	echo " name=\"" . $key . "\" id=\"" . $key . "\"";

	if (isset($SANITIZED) && isset($SANITIZED[$key])) {
		echo " value=\"" . $SANITIZED[$key] . "\"";
	} else if ($default !== "") {
		echo " value=\"" . $default . "\"";
	}
}

function preserve_textarea($key) {
	if (isset($SANITIZED) && isset($SANITIZED[$key])) {
		echo $SANITIZED[$key];
	}
}


if (isset($_POST['submit'])) {
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
			echo "ERROR ERROR ERRROR ".$user_friendly_name;
			error($user_friendly_name . " is a required field.");
		}
	}

	/* Sanitize fields that need it. */
	if (isset($SANITIZED['admin_email']) && !validate_email($SANITIZED['admin_email'])) {
		error("Admin email is invalid.");
		unset($SANITIZED['admin_email']);
	}

	if (isset($SANITIZED['mailing_list'])) {
		/* Split mailing list into lines. */
		$SANITIZED['mailing_list'] = preg_split("/[ \r\n\t,;]+/", $SANITIZED['mailing_list']);
		if (count($SANITIZED['mailing_list']) <= 1) {
			// Mailing list too short
			error("A vote needs at least 2 participants.");
			unset($SANITIZED['mailing_list']);
		}
		else {
			// Verify each entry in list is an actual email
			foreach ($SANITIZED['mailing_list'] as $email) {
				if (strlen($email) > 3 && !validate_email($email)) {
					error("Email list contains an invalid email.");
					unset($SANITIZED['mailing_list']);
				}
			}
		}
	}
	if (isset($SANITIZED['options'])) {
		/* Split mailing list into lines. */
		$SANITIZED['options'] = preg_split("/[ \r\n\t,;]+/", $SANITIZED['options']);
		if (count($SANITIZED['options']) <= 1) {
			// Mailing list too short
			error("A vote needs at least 2 options.");
			unset($SANITIZED['options']);
		}
	}

	if (isset($SANITIZED['end_date']) && !validate_date($SANITIZED['end_date'])) {
	}
	if (($timestamp = strtotime($SANITIZED['end_date'])) === false) {
		error("End time invalid.");
		unset($SANITIZED['end_date']);
	} else {
	    $SANITIZED['end_date'] = date(DATE_FORMAT, $timestamp);
	}

	if (!error_occurred())
	{
		$admin_token = generateToken();
		$vote_tokens = Array();
		for ($n=0; $n < count($SANITIZED['mailing_list']); ++$n)
		{
			array_push($vote_tokens, generateToken());
		}
	 	try
	 	{
	 		$model = Model::getInstance();
			$model->connect();
			$model->insertPoll($SANITIZED['title'], $SANITIZED['author'],
							   $SANITIZED['author_email'], $SANITIZED['description'],
							   $SANITIZED['options'], $SANITIZED['mailing_list'],
							   $SANITIZED['end_date'], $admin_token,
							   $vote_tokens);
		}
		catch (ModelConnectException $e)
		{
			error("Server error - please try again later");
		}
		catch (ModelInsertException $e)
		{
			error("Error creating vote");
		}

		if (!error_occurred())
		{
			$admin_subject = sprintf(EMAIL_ADMIN_SUBJECT,
								$SANITIZED['title']);

			$admin_body = sprintf(EMAIL_ADMIN,
								$SANITIZED['author'],
								$admin_token);

			mail($email, $admin_subject, $admin_body, EMAIL_HEADERS);

			$n =0;
			foreach ($SANITIZED['mailing_list'] as $email)
			{
				$token = $vote_tokens[$n];
				++$n;

				$subject = sprintf(EMAIL_INVITE_SUBJECT,
									$SANITIZED['author']);

				$body = sprintf(EMAIL_INVITE,
									$SANITIZED['author'],
									$SANITIZED['title'],
									$SANITIZED['description'],
									$token,
									$token);

				mail($email, $subject, $body, EMAIL_HEADERS);
			}

			/* Success message */
			?>
		<section id="startvote">
			<h2>
				Great success!
			</h2>
			<p>
				Your new poll (<?php echo htmlspecialchars($SANITIZED['title']); ?>) has been created
				and emails have been sent to the following people:
				<ul>
					<?php
					foreach ($SANITIZED['mailing_list'] as $email)
					{
						echo "<li>".$email."</li>";
					}
					?>
				</ul>
			</p>
		</section>
			<?php
		}
	}
}

if (!isset($_POST['submit']) || error_occurred()) { ?>
    <section id="startvote">
    	<h2>
    		Create a New Vote:
    	</h2>
    	<?php
    	if (error_occurred()) {
    		echo "<ul id=\"errors\">";
			foreach ($ERR as $err) {
				echo "<li>" . $err . "</li>";
			}
    		echo "</ul>";
    	}
    	?>
		<form action="startvote" name="startvote_form" method="post">
			<table>
				<tbody>
					<tr>
						<td><label for="title">Title:</label></td>
						<td><input type="text"<?php echo preserve_field("title"); ?> /></td>
					</tr>
					<tr>
						<td><label for="author">Author Name:</label></td>
						<td><input type="text"<?php echo preserve_field("author"); ?> /></td>
					</tr>
					<tr>
						<td><label for="author_email">Author E-Mail:</label></td>
						<td><input type="text"<?php echo preserve_field("author_email"); ?> /></td>
					</tr>
					<tr>
						<td><label for="description">Description:</label></td>
						<td><textarea name="description" id="description"><?php echo preserve_textarea("description"); ?></textarea></td>
					</tr>
					<tr>
						<td><label for="options">Options:</label></td>
						<td><textarea name="options" id="options"><?php echo preserve_textarea("options"); ?></textarea></td>
					</tr>
					<tr>
						<td><label for="mailing_list">Participants:</label></td>
						<td><textarea name="mailing_list" id="mailing_list"><?php echo preserve_textarea("mailing_list"); ?></textarea></td>
					</tr>
					<tr>
						<td><label for="end_date">End Date:</label><br />(YYYY-MM-DD)</td>
						<td><input type="text"<?php echo preserve_field("end_date", date(DATE_FORMAT)); ?> /></td>
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

require('include/footer.php'); ?>