    <footer>
     <p>&copy; Copyright 2011</p>
    </footer>
  </div>
</body>
</html><?php

$db = Model::getInstance();
if ($db.isConnected()) {
	try
	{
		$db.close();
	}
	catch (ModelCloseException $e)
	{
		// Who really cares?
	}
}

?>