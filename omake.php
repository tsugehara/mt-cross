<?php
function md5_to_seed($md5) {
	return hexdec(substr($md5, 0, 8));
}
if (isset($_GET['seed'])) {
	echo md5_to_seed(md5($_GET['seed']));
	die;
}
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Seed generator</title>
<link rel="stylesheet" href="http://code.jquery.com/qunit/qunit-git.css">
<script type="text/javascript" src="jquery-1.8.3.js"></script>
<script type="text/javascript" src="md5.js"></script>
<script type="text/javascript">
function md5_to_seed(md5) {
	var first4byte = new Number("0x"+md5.substr(0, 8));
	return first4byte;
}
function generate() {
	var seed_seed = $("#seed_seed").val();
	var js = $("#js-seed");
	var php = $("#php-seed");
	$.get(
		"omake.php?seed="+seed_seed,
		function(ret) {
			php.html(ret);
		}
	);
	setTimeout(function() {
		var str = md5.hex_md5(seed_seed);//CybozuLabs.MD5.calc(seed_seed);
		js.html(md5_to_seed(str).toString());
	}, 1);
}
</script>
</head>
<body>
<div>
	<input type="text" name="seed_seed" id="seed_seed" value="元文字列" />
	<input type="button" value="generate" onclick="generate()"/>
</div>
<div>
	js: <span id="js-seed"></span>
</div>
<div>
	php: <span id="php-seed"></span>
</div>
</body>
</html>