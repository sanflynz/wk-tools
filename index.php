<html>
<head>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700,600' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<style>
		body{
			font-family: 'Open Sans', sans-serif;
			font-size: 14px;
			line-height: 180%;
		}
		
		a:link.dir, a:visited.dir, a:active.dir{
			font-weight: bold;
			text-decoration: none;
			color: #246BB2;
		}
		a:hover.dir{
			font-weight: bold;
			text-decoration: none;
			color: #3399FF;
		}
		
		a:link.file, a:visited.file, a:active.file{
			text-decoration: none;
			color: #FF4719;
		}
		a:hover.file{
			text-decoration: none;
			color: #FF8533
		}
		
		a:link.folder, a:visited.folder, a:active.folder{
			font-weight: bold;
			text-decoration: none;
			color: #3399FF;
		}
		a:hover.folder{
			font-weight: bold;
			text-decoration: none;
			color: #85C2FF;
		}
	</style>
</head>
<body>
<?php
$dir =  getcwd();

$lastPath = explode("www\\",$dir);
$filePath = explode("www",$dir);
$filePath = str_replace('\\','/',$filePath[1]);

$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}
echo "<h1>" . $lastPath[1] . "</h1>";

foreach($files as $f){
	if(is_dir($f)){
		echo "<a class='dir' href='" . $filePath . "/" . $f . "'><i class='fa fa-folder fa-lg'></i>&nbsp;&nbsp;" . $f . "</a><br>";
	}
	
}
foreach($files as $f){
	if(!is_dir($f)){
		echo "<a class='file' href='" . $filePath . "/" . $f . "'><i class='fa fa-file-text fa-lg'></i>&nbsp;&nbsp;" . $f . "</a><br>";
	}
	
}

?>

</body>
</html>