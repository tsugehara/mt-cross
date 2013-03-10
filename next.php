<?php
require_once('php/mt.class.php');
$mt = new MT((int)$_GET['seed']);
$cnt = empty($_GET['cnt']) ? 1 : (int)$_GET['cnt'];
for ($i=1; $i<$cnt; $i++)
	$mt->next();
echo $mt->next();
?>