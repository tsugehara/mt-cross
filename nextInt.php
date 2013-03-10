<?php
require_once('php/mt.class.php');
$min = (int)$_GET['min'];
$max = (int)$_GET['max'];
$mt = new MT((int)$_GET['seed']);
$cnt = empty($_GET['cnt']) ? 1 : (int)$_GET['cnt'];
for ($i=1; $i<$cnt; $i++)
	$mt->nextInt($min, $max);
echo $mt->nextInt($min, $max);
?>