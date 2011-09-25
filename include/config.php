<?php
/* OpenVote - configuration file */

/* Database settings */

//define("DATABASE_HOST", "localhost");
//define("DATABASE_USER", "root");
//define("DATABASE_PASSWORD", "pass");
define("DATABASE_HOST", "localhost");
define("DATABASE_DB", "gpittare_ovote");
define("DATABASE_USER", "gpittare_ovote");
define("DATABASE_PASSWORD", "ovote123!");

/* Date Format */

define("DATE_FORMAT", "m-d-y h:i:s");

/* Email */
define("EMAIL_HEADERS", "Content-Type: text/html; charset=ISO-8859-1\r\n");

define("EMAIL_ADMIN_SUBJECT", "You created an OpenVote poll: %s");
$EMAIL_ADMIN_ = <<<EMAIL
Thank you, %s, for starting a new OpenVote poll - the secure way to
hold transparent elections.

You can administer your poll <a href="openvote.gpittarelli.com/adminvote?t=%s">here</a>.
EMAIL;

define("EMAIL_ADMIN", $EMAIL_ADMIN_ );

define("EMAIL_INVITE_SUBJECT", "OpenVote poll invite from %s");
$EMAIL_INVITED_ = <<<EMAIL
%s has requested that you vote in an OpenVote poll.<br />

Poll: "%s"<br />
Description: %s<br />

To vote now, <a href="openvote.gpittarelli.com/vote?t=%s">click here.</a><br />

Your vote is completely confidential; and you will be able to verify at the end
of the election that your vote was counted.<br />

Your unique identifier is: %s<br />

This number is important because you are the <strong>ONLY PERSON IN THE WORLD</strong>
who knows that it represents your vote.  As soon as this email as sent, we at
OpenVote immediately forget that the number was assigned to you.  When the
election is complete, you will be able to download a list of the identifiers of
everyone who voted in the election and verify that your vote is on the list and was
properly counted.
EMAIL;
define("EMAIL_INVITE", $EMAIL_INVITED_ );



?>