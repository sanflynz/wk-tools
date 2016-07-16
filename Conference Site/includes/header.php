<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Conference Resource Builder</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
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
					<a class="navbar-brand" href="index.php">Conference Products</a>
				</div>
		
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">PRODUCTS <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="">Brands</a></li>
								<li><a href="product_i.php">All Products</a></li>
								<li><a href="product_e.php">Add Product</a></li>

							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">CONFERENCES <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="conference_i.php">Conferences</a></li>
								<li><a href="conference_e.php">Add Conference</a></li>

							</ul>
						</li>
				<?php 	if(isset($_SESSION['activeConference'])){
							$ac = $conn->query("SELECT * FROM conferences WHERE id='" . $_SESSION['activeConference'] . "'");
							$conn->error;
							$rowAc = $ac->fetch_assoc();
						 ?>		
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $rowAc['name']; ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="conference_v.php?id=<?php echo $_SESSION['activeConference']; ?>">Details</a></li>
								<li><a href="home.php?conference=<?php echo $_SESSION['activeConference']; ?>" target="_blank">Local Home Page</a></li>
								<li><a href="">Production Home Page</a></li>
								<li><a href="#" id="unsetActiveConference">Unset</a></li>
							</ul>
						</li>
				<?php 	} ?>		
					</ul>
					<!--
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search">
						</div>
						<button type="submit" class="btn btn-default">Submit</button>
					</form> -->
					<ul class="nav navbar-nav navbar-right">
						<li class="active"><a href="#" id="environmentToggle" class=""><?php echo strtoupper($_SESSION['environment']); ?></a></li>
						<li><a href="../">TOOLS</a></li>
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
