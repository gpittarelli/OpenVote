<?php
/* OpenVote - Utility functions */

/* Cumulative error tracking - useful for forms */
$ERR = null;
function error($error) {
	global $ERR;
	if ($ERR === null) {
		$ERR = Array($error);
	} else {
		array_push($ERR, $error);
	}
}
function error_occurred() { global $ERR; return !is_null($ERR); }

/**
 * Safely extracts a value from the given array.  This
 * is useful for values like $_POST which are based
 * on user supplied input.  It will throw an exception
 * with a friendly error message.
 *
 * @param array $array array to extract a value from
 * @param string $key key to extract from array
 * @throws Exception
 * @return $array[$key], if it exists.
 */
function safe_extract($array, $key)
{
	if (isset($array[$key]))
	{
		return $array[$key];
	}
	throw new Exception();
}

/**
 * Checks wether an email is valid or not.
 *
 * @param String $email email to validate
 * @return boolean true if $email is a valid email, else false
 */
function validate_email($email)
{
	return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Checks wether a date is valid or not.
 *
 * @param String $date date to validate
 * @return boolean true if $date is a valid date, else false
 */
function validate_date($date)
{
	return true; //DateTime::createFromFormat(DATE_FORMAT, $date) !== false;
}

$BASE64_CHARS = array("A","B","C","D","E","F","G","H","I","J","K","L",
					  "M","N","O","P","Q","R","S","T","U","V","W","X",
					  "Y","Z","a","b","c","d","e","f","g","h","i","j",
					  "k","l","m","n","o","p","q","r","s","t","u","v",
					  "w","x","y","z","0","1","2","3","4","5","6","7",
					  "8","9",",",";");

/**
 * Checks wether a given token is valid - that is, it meets
 * the output specification of generateToken()
 *
 * @param string $token token to validate
 * @return boolean true if $token is a valid token, else false
 */
function validate_token($token)
{
	global $BASE64_CHARS;
	$chars = str_split($token);
	if (count($chars) !== 44)
	{
		return false;
	}
	foreach ($chars as $char)
	{
		if (!in_array($char, $BASE64_CHARS))
		{
			return false;
		}
	}
	return true;
}

/**
 * Generates a 44 character token guaranteed to have at least
 * 256 bits of entropy
 *
 * @author Scott
 */
function generateToken()
{
	global $BASE64_CHARS;
	$out = array();

	for($x = 0; $x < 44; $x++)
	{
		//this generates 6 bits
		$r = array();
		for($y = 0; $y < 6; $y = $y + 1)
		{
			array_unshift($r,mt_rand(0,1));
		}
		$q = (array_pop($r) * 32) + (array_pop($r) * 16) + (array_pop($r) * 8) + (array_pop($r) * 4)
		+ (array_pop($r) * 2) + (array_pop($r) * 1);

		array_unshift($out,$q);
	}
	$re = "";
	foreach($out as $value)
	{
		$re .= $BASE64_CHARS[$value];
	}
	return $re;
}

?>