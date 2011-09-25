<?php

require('include/utility.php');
require('include/model.php');

?><!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6 ie" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7 ie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 ie" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>OpenVote - Confidential Online Voting</title>

  <meta name="description" content="Simple to use confidential online voting for communities around the world." />
  <meta name="keywords" content="voting, polling, confidential, anonymous, secure, easy" />
  <meta name="author" content="George Pittarelli, Kavin Arasu, Josh Snider, Scott DeHart" />

  <link rel="stylesheet" href="include/style.css" />

  <?php

  function include_script($src) {
  	echo "<script type=\"text/javascript\" src=\"".$src."\"></script>\n";
  }

  if (isset($JQUERY)) {
	include_script("https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js");
  }

  if (isset($DATEJS)) {
	include_script("include/date.js");
  }

  if (isset($STARTVOTEJS)) {
	include_script("include/startvote.js");
  }

  ?>
  </head>

<body>
  <div>
    <header>
      <a href="index"><h1>OpenVote</h1></a>
    </header>