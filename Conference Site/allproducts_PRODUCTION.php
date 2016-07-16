<?php
    include("includes/db.php");
    $r = $conn->query("SELECT name,btn_email_link FROM products");
    $p = array();
    while($row = $r->fetch_assoc()){
        $p[$row['name']] = $row['btn_email_link'];
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
    <link href="http://img.en25.com/Web/ThermoFisherScientificLPG/{46d61cfd-cb3e-4527-bfb8-3a39a82de07d}_third-header-footer.css" rel="stylesheet"/>
    <!-- application specific scripts here -->

    <link rel="stylesheet" href="http://img.en25.com/Web/ThermoFisherScientificLPG/{637784f1-8e5d-48bf-8fb7-f99d1feea92e}_ftqld2016.css">

    
</head>
<body class="bootstrap-noconflict">
<div id="main-header">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <hgroup>
                    <div id="brand-logo">
                        <a class="thermo-fisher-scientifc logo" href="http://www.thermofisher.com.au"><img src="http://img.en25.com/Web/ThermoFisherScientificLPG/{7813dd0d-526a-4027-a251-86d246df0c97}_thermo-fisher-logo-retina.png" width="160" height="39"/> </a>
                        <!--Uncomment the logo you need and remove the others-->
                        <!--<a  class="corporate-sprite thermo-fisher logo" href="/"></a>-->
                        <!--<a  class="corporate-sprite applied-biosystems float-left" href="/"></a>-->
                        <!--<a  class="corporate-sprite invitrogen logo" href="/"></a>-->
                        <div class="brand">Food Tech Queensland 2016</div>
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
                        <li><a href="http://info.thermofisher.com.au/FoodTechQLD2016">Home</a></li>
                        <li><a href="http://info.thermofisher.com.au/LP=3930">Products</a></li>
                        <li><a href="http://info.thermofisher.com.au/LP=3931">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="main-content">

    <div class="row">
        <div class="col-md-8 col-xs-12">
            <h2>Our Products</h2>
        </div>
        <div class="col-md-4 col-xs-12">
            <br>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-hidden"><br></div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h3>Product Inspection</h3>
            <hr>
        </div>
    </div>
    <div class="row">    

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Thermo Scientific&trade; NextGuard&trade; X-Ray Detection Systems</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7bd2eeb667-3054-45da-a05f-49ceee5d961a%7d_ANZ_Conference_NextGuard_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3937 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="<?php echo $p['NextGuard']; ?>" class="btn btn-default" style="width: 100%;" target="_blank">Brochure</a><br>
            <br>
        </div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Thermo Scientific™ Global VersaWeigh™ Checkweigher</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b29e31266-90a6-4cfd-8f8a-6a0264809a9c%7d_ANZ_Conference_VersaWeigh_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3954 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Thermo Scientific APEX 300 Flexible Metal Detector</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b03a8c2de-ef11-4405-a63e-0e8a300fd60e%7d_ANZ_Conference_APEX300_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3955 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>
    
    </div>  

    <div class="row">
        <div class="col-xs-12">
            <h3>Plant Maintenance & Productivity</h3>
            <hr>
        </div>    
    </div>
    <div class="row">         

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">dataTaker DT 80</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7becb185f4-1775-41ab-90d8-907ffe271936%7d_ANZ_Conference_Datataker_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3944 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>            

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">GE Druck DPI620 Genii</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7be0fb2a8d-c0fb-46af-b4cf-93b2ad1ce555%7d_ANZ_Conference_DPI-620_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3946 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">GE TransPort PT878 Panametrics Flow meter</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b18fe2c9e-77f5-4106-8e1a-153ea1ef6787%7d_ANZ_Conference_GE_Flow_Meter_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3956 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

    </div>


     <div class="row">
        <div class="col-xs-12">
            <h3>Physical Characterisation</h3>
            <hr>
        </div>    
    </div>
    <div class="row">

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Konica Minolta Chroma Meter CR-400</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7bd131e718-8e5d-4cc0-b843-48c97770ed14%7d_ANZ_Confernce_CR-400_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3948 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Fungilab EVO Expert Rotational Viscometer</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b28a76f3d-06e4-46f9-a0b4-b9233ecf24fb%7d_ANZ_Conference_Evo_Expert_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3949 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        
        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Bellingham and Stanley RFM300+ Refractometer Series</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b9ccae142-f359-4b7f-99ca-27a2a5a02871%7d_ANZ_Conference_RFM340_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3953 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

    </div>
    

     <div class="row">
        <div class="col-xs-12">
            <h3>Lab Products</h3>
            <hr>
        </div>
    </div>
    <div class="row">       
    
        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Thermo Scientific Multiskan<sup>TM</sup> GO Microplate Spectrophotometer</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b7591aab2-70cc-473d-b0fa-92beb89750f5%7d_ANZ_Conference_Multiskan_GO_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3935 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Thermo Scientific Orion Star A329 Water Quality Meter</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7bb7d098e2-79e3-4961-9a1b-a65756a6cf8a%7d_ANZ_Conference_STARA329_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3936 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">LabServ Plasticware</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b5e92e18a-42ba-4efb-8a45-4ff12a2e4426%7d_ANZ_Conference_LabServ_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3958 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Thermo Fisher Scientific Glassware</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b3d178251-6fa2-4fcf-8efc-4f8ea4531562%7d_ANZ_Conference_Glassware_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3959 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="clearfix"></div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Fisherbrand Traceable®</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b6cec516a-d302-42f5-bd08-ccf6299acdac%7d_ANZ_Conference_Traceable_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3960 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

    </div>
    

     <div class="row">
        <div class="col-xs-12">
            <h3>Microbiology</h3>
            <hr>
        </div>
    </div>
    <div class="row">    

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Thermo Scientific™ SureTect™ System</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7ba8be6b5f-433e-42c6-a0f7-e648dbb7c562%7d_ANZ_Conference_Suretect_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3942 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">DuPont  BAX® System</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b133c188c-b039-4e7d-afcf-501de2a53d06%7d_ANZ_Conference_BAX_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3943 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Thermo Scientific™ Dip-Slides</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7bc63838ae-7f12-464b-84f8-7221b212ecf2%7d_ANZ_Conference_Dip-slides_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3945 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Thermo Scientific™ Dry-Bags™</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b4d454089-29fe-43f0-969a-e7ca6011e832%7d_ANZ_Conference_Dry-bags_LP.gif" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3947 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="clearfix"></div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Neogen AccuPoint Advanced</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b902049cd-1dd1-42f5-90de-0405de21b4fe%7d_ANZ_Conference_Accupoint_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3950 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">3M™ Petrifilm™ Rapid Yeast and Mould</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b602205e1-c017-43e7-b0cc-d04930bbcdf9%7d_ANZ_Conference_Petrifilm_RYM_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3951 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">3M™ Petrifilm™ Rapid Aerobic Plate Count</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7bcb0f381a-520f-4d05-b17c-d09aedff4641%7d_ANZ_Conference_Petrifilm_RAC_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3952 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>

        <div class="col-md-3 col-xs-12">
            <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center">Thermo Scientific™ Heratherm™ Compact Microbiological Incubator</div> 
            <br>
            <img src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b33472d98-5a77-4e6b-b28a-911ba48fac01%7d_ANZ_Conference_Heratherm_Compact_LP.jpg" class="img-responsive"  alt="">  <br>
            <a href="http://info.thermofisher.com.au/LP=3957 " class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
            <a href="" class="btn btn-default" style="width: 100%;">Brochure</a><br>
            <br>
        </div>
        
    </div>
</div>
<div id="footer" class="text-center">
    <small>
        <ul class="footer-links inline-line-items">
            <li><a href="http://www.thermofisher.com.au/show.aspx?page=/ContentAUS/Top-Menu/Footer/Terms-And-Conditions-Australia.html">Terms of Service</a></li> | 
            <li><a href="http://www.thermofisher.com.au/show.aspx?page=/ContentAUS/Top-Menu/Footer/Privacy-Policy-Australia.html">Privacy Policy</a></li>
            
        </ul>
        <div class="legal-text">&copy; 2016 Thermo Fisher Scientific Inc. All Rights Reserved.</div>
    </small>
</div>
<script>
    !function ($) {
        $(window).load(function () {
            // toggle mobile menu
            $('#mobile-menu-toggle').on('click', function () {
                $('#main-header .navbar-responsive-collapse').toggle();
            })
        })
    }(window.$j);
</script>
</body>
</html>
