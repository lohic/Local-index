<?php
$directory  = "";
$baseURL 	= '//localhost:8888';
$basePATH 	= dirname(".");	 
$PATH 		= realpath($basePATH . $_GET['uri']);

$htaccess = '';
$htaccess.= "<IfModule mod_rewrite.c>\n";
$htaccess.= "RewriteCond %{REQUEST_FILENAME} !-f\n";
$htaccess.= "RewriteCond %{REQUEST_FILENAME} !-l\n";
$htaccess.= "RewriteEngine On\n";
$htaccess.= "RewriteCond %{REQUEST_URI} !^/index.php\n";
$htaccess.= "RewriteRule ^(.*)$ /index.php?host=http://%{HTTP_HOST}&uri=%{REQUEST_URI} [L,QSA]\n";
$htaccess.= "</IfModule>\n";

if( !is_file( '.htaccess' ) ){

	file_put_contents('.htaccess', $htaccess);

}
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>HOME | <?php echo $_GET['host']?><?php echo $_GET['uri']; ?></title>
	<style type="text/css" media="screen">

		html{
			font-size: 50px;
		}
		body{
			font-family: sans-serif;
			margin: 1rem;
		}
		h1{
			font-size: .5rem;
			font-weight: normal;
			margin: 0;
			width: 100%;
			background: #FFF;
			box-sizing: border-box;
			border-bottom:solid 3px #000;
			padding: 0.5rem 1rem .25rem ;
			left: 0;
			top: 0;
			position: fixed;
		}
		a{
			color:#000;
			text-decoration: none;
		}
		a:hover{
			color:blue;
		}
		ul{
			list-style-position: inside;
			margin: 0;
			padding: 0;
			list-style: none;
			margin-top: 2.5rem;
			font-size: 1rem;
		}
		ul>li{
			margin: 0;
			padding: 0;
		}
		input{
			font-size: .5rem;
			float: right;
			border: solid 1px blue;
			position: relative;
			top: -.1rem;
		}

	</style>
</head>
<body>
	<!-- https://css-tricks.com/snippets/html/autocomplete-off/ -->
	<h1>MAMP / <a href="<?php echo $_GET['host']?>"><?php echo $_GET['host']?></a><?php echo $_GET['uri']; ?> <input type="text" id="searchfor" autocomplete="off"></h1>
	<ul>
		<?php
		$files = glob($PATH . "/*");
		foreach($files as $file)
		{
			$folder = basename($file);
			$uri = str_replace("/Users/loic/Sites", "", $file);

			$sep = is_dir($file)?"/":'';

			if($_GET['host'].$_GET['uri'] == 'http:'.$baseURL.'/')
			{
				if(is_dir($folder)){
					echo "<li><a href='{$baseURL}{$uri}'>$folder".$sep."</a></li>\n";
				}				
			}else{
				echo "<li><a href='{$baseURL}{$uri}'>$folder".$sep."</a></li>\n";
			}
		}
		?>
	</ul>

	<script>
		// http://youmightnotneedjquery.com
		// https://jsfiddle.net/lohic/7s5xejh5/
		var search = document.getElementById("searchfor");
		var elements = document.querySelectorAll('li');
		search.onkeyup = function() {
			Array.prototype.forEach.call(elements, function(el, i) {
				var tosearch = el.innerHTML.toLowerCase();
				if (tosearch.indexOf( search.value.toLowerCase() ) != -1) {
					el.style.display = '';
				} else {
					el.style.display = 'none';
				}
			});
		};
	</script>
</body>
</html>
