<?php
/* OpenVote - Utility functions */

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
	throw new Exception("$key is required.");
}

/**
 * Generates a 44 character token guaranteed to have at least
 * 256 bits of entropy
 *
 * @author Scott
 */
function generateToken()
{
	$out = array();
	$base = array( 0 => "A", 1 => "B", 2 => "C", 3 => "D",
				4 => "E",5 => "F",6 => "G",7 => "H",8 => "I",
				9 => "J",10=> "K",11=> "L",12=> "M",13=> "N",
				14=> "O",15=> "P",16=> "Q",17=> "R",18=> "S",
				19=> "T",20=> "U",21=> "V",22=> "W",23=> "X",
				24=> "Y",25=> "Z",26=> "a",27=> "b",28=> "c",
				29=> "d",30=> "e",31=> "f",32=> "g",33=> "h",
				34=> "i",35=> "j",36=> "k",37=> "l",38=> "m",
				39=> "n",40=> "o",41=> "p",42=> "q",43=> "r",
				44=> "s",45=> "t",46=> "u",47=> "v",48=> "w",
				49=> "x",50=> "y",51=> "z",52=> "0",53=> "1",
				54=> "2",55=> "3",56=> "4",57=> "5",58=> "6",
				59=> "7",60=> "8",61=> "9",62=> "+",63=> "/",);

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
	$re = array();
foreach($out as $value)
{
array_unshift($re,$base[$value]);
}
return $re;
}

?>