<!DOCTYPE html>
<?php
	define('HOME', "/WORK/wk-tools/Generator/");

?>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Generator</title>
		<link rel="shortcut icon" href="favicon-meh-o.ico">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="../__resources/css/bootstrap.min.css">
		<link rel="stylesheet" href="../__resources/css/font-awesome.min.css">

		<link rel="stylesheet" href="../__resources/css/pretty_file_upload.css">

		<link rel="stylesheet" href="css/generator.css">
		<link rel="stylesheet" href="css/wysiwyg-editor.css">

		<link href='https://fonts.googleapis.com/css?family=Bitter:700' rel='stylesheet' type='text/css'>

		<style>
			body{
				margin-top: 60px;
			}
			.btn-120{
				width: 120px;
			}
		</style>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php" style="font-family: Bitter; font-size: 28px; color: #000000;"><i class="fa fa-meh-o"></i>&nbsp;&nbsp;Generator</a>
				</div>
		
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
					
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">WEBPAGES <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="promopage_i.php">Promo (child) Pages</a></li>
								<li><a href="genericpage_i.php">Generic (child) Pages</a></li>
								<li><a href="l3page_i.php">Level 3 Pages &nbsp;&nbsp;<i class="fa fa-flask" style="color: #00FF00" title="EXPERIMENTAL"></i></a></li>
								<li><a href="l2page_i.php">Level 1/2 Pages &nbsp;&nbsp;<i class="fa fa-flask" style="color: #00FF00" title="EXPERIMENTAL"></i></a></li>
								<li><a href="promopods_e.php">Promo Pods &nbsp;&nbsp;<i class="fa fa-flask" style="color: #00FF00" title="EXPERIMENTAL"></i></a></li>
							<!--	<li class="divider"></li>
								<li><a href="plainpage_i.php">Plain Pages</a></li>
								<li><a href="plainpage_e.php">Add Plain Page</a></li> -->
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">TOOLS <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="https://thermofisher.sharepoint.com/sites/collaboration/ANZMarketing/Pages/Dynamic-Request-Link-Generator.aspx" target="_blank">Request Link Generator</a></li>
								<li><a href="table-generator.php" target="_blank">Table Generator</a></li>
								<!-- <li><a href="pdfcoverimage.php">PDF Cover Images</a></li> -->
							</ul>
						</li>
					</ul>
					<!--
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search">
						</div>
						<button type="submit" class="btn btn-default">Submit</button>
					</form> -->
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-question-circle-o"></i></a>
							<ul class="dropdown-menu">
								<li><a href="help_html.php" target="_blank">Basic HTML</a></li>
								<li><a href="https://dev.w3.org/html5/html-author/charref" target="_blank">HTML Entities Reference</a></li>
								<li><a href="http://www.thermofisher.com.au/show.aspx?page=/ContentAUS/StyleGuide/StyleGuide.html" target="_blank">ANZ Website StyleGuide</a></li>
							</ul>
						</li>
						<li><a href="changelog.php" title="Changelog"><i class="fa fa-file-code-o"></i></a> </li>
						<li class="dropdown">
							<a href="#" title="Bug Report/Change Request" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bug"></i></a>
							<ul class="dropdown-menu">
								<li><a href="mailto:sandie43+xz6uinln8fx5vwibzvzn@boards.trello.com?subject=[BUG%20REPORT][Generator]%20<SHORT%20DESC%20HERE>&body=Requestor%20Name:%20%0ADetail:%20%0A">Bug Report</a></li>
								<li><a href="mailto:sandie43+xz6uinln8fx5vwibzvzn@boards.trello.com?subject=[CHANGE%20REQUEST][Generator]%20<SHORT%20DESC%20HERE>&body=Requestor%20Name:%20%0ADetail:%20%0A">Change Request</a></li>
								
							</ul>
						</li>
						<li><a href="/">TOOLS</a></li>
					<!--	<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#">Action</a></li>
								<li><a href="#">Another action</a></li>
								<li><a href="#">Something else here</a></li>
								<li><a href="#">Separated link</a></li>
							</ul>
						</li> -->
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</nav>
		<div class="container">
			
		