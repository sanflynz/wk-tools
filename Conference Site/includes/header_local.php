<?php
    if(isset($_GET['conference'])){
        $ac = $conn->query("SELECT * FROM conferences WHERE id='" . $_GET['conference'] . "'");
        $conn->error;
        $rowAc = $ac->fetch_assoc();
     }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thermo Fisher Scientific</title>
    <!--<link href="http://img.en25.com/Web/ThermoFisherScientificLPG/{d6115365-2748-4293-bf91-4cd68a60b6b4}_global.css" rel="stylesheet"/>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!--[if lte IE 8]>
    <link href="http://img.en25.com/Web/ThermoFisherScientificLPG/{6a846eea-80be-4e70-9fff-578d3dcce341}_ie.css" rel="stylesheet"/><![endif]--><!-- application specific styles here -->
    <script src="http://img.en25.com/Web/ThermoFisherScientificLPG/{4b5ec9d7-dbba-4171-80b8-8a6cf6f109c9}_base.js"></script>
    <!-- the following scripts call on jQuery 1.4.2 -->
    <script src="http://img.en25.com/Web/ThermoFisherScientificLPG/{c17a8f33-28c6-40e8-b0e9-58bc3822d70c}_global.js"></script>
    <!-- <link href="http://img.en25.com/Web/ThermoFisherScientificLPG/{46d61cfd-cb3e-4527-bfb8-3a39a82de07d}_third-header-footer.css" rel="stylesheet"/>
    application specific scripts here -->
    <link href="css/third-header-footer.css" rel="stylesheet"/>
    
    <link rel="stylesheet" href="css/ftqld2016.css">
    
    
</head>
<body class="bootstrap-noconflict">
<div id="main-header">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <hgroup>
                    <div id="brand-logo">
                        <a class="thermo-fisher-scientifc logo" href="/"><img src="http://img.en25.com/Web/ThermoFisherScientificLPG/{7813dd0d-526a-4027-a251-86d246df0c97}_thermo-fisher-logo-retina.png" width="160" height="39"/> </a>
                        <!--Uncomment the logo you need and remove the others-->
                        <!--<a  class="corporate-sprite thermo-fisher logo" href="/"></a>-->
                        <!--<a  class="corporate-sprite applied-biosystems float-left" href="/"></a>-->
                        <!--<a  class="corporate-sprite invitrogen logo" href="/"></a>-->
                        <div class="brand"><?php echo $rowAc['name']; ?></div>
                    </div>
                </hgroup>
                <div id="mobile-icons" class="mobile-show">
                    <!--Uncomment the icons you need and remove the others - Only the menu is set up to work at this time-->
                    <!--<div id="mobile-cart" class="float-right  mobile-icon corporate-sprite "></div>-->
                    <!--<div id="mobile-search" class="float-right  mobile-icon  corporate-sprite "></div>-->
                    <div id="mobile-menu-toggle" class=" float-right mobile-icon mobile-show"><img src="http://img.en25.com/Web/ThermoFisherScientificLPG/{d6115993-8328-41bb-93a5-17dbf3fe019a}_menu-icon.png" width="40" height="34"/> </div>
                </div>
               <div class="nav-collapse navbar-responsive-collapse collapse">
                    <ul class="nav">
                        <li><a href="home.php?conference=<?php echo $_GET['conference']; ?>">Home</a></li>
                        <li><a href="allproducts.php?conference=<?php echo $_GET['conference']; ?>">Products</a></li>
                        <li><a href="database.php?conference=<?php echo $_GET['conference']; ?>">Database</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="main-content">
