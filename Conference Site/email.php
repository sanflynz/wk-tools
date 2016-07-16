<?php 

include("includes/db.php");
if(isset($_GET['conference'])){
    $ac = $conn->query("SELECT * FROM conferences WHERE id='" . $_GET['conference'] . "'");
    $conn->error;
    $rowAc = $ac->fetch_assoc();
 }


    if(isset($_GET['id'])){
        $sql = "SELECT * FROM products WHERE id = " . $_GET['id'];
        $r = $conn->query($sql);
        if($r){
            if($r->num_rows > 0){

                while($row = $r->fetch_assoc()){
                    $p = $row;
                }
            }
            else{
                $error = "Unable to find product with id = " . $_GET['id'];
            }
        }
        else{
            $error = "Unable to extract product details: " . $conn->error;
        }

        $sql = "SELECT * FROM conference WHERE id = '1'";
        $r = $conn->query($sql);
        if($r){
            if($r->num_rows > 0){

                while($row = $r->fetch_assoc()){
                    $c = $row;
                }
            }
            else{
                $error = "Unable to find conference";
            }
        }
        else{
            $error = "Unable to extract conference details: " . $conn->error;
        }


    }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
		<title>Subject line goes here in sentence case</title>
</head>
        
<body>
 
	<table cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="font-family: Arial, sans-serif; font-size: 13px; line-height: 22px; color: #333333;">
		<!--########################### Tribal Bar ##################################-->	
        <tbody><tr>
          <td colspan="2" class=""><a target="_blank" href="http://www.thermofisher.co.nz/?elqTrackId=45956DA5FBB82C668490AA449212FE59&elqTrack=true" data-targettype="webpage" title="Thermo Fisher Scientific New Zealand"><img border="0" width="600" height="50" style="color:#1A2155" alt="Invitrogen by Thermo Fisher Scientific" src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7B74d7ea28-5471-4038-a17d-d9ab0d42424f%7D_q215-TribalBar1-TFS.jpg" class=""></a></td>
		</tr>
		  
		<!--########################### Header image ##################################-->    
		<tr>
		  <td colspan="2" class=""><a target="_blank" href="http://www.thermofisher.co.nz/?elqTrackId=537D764BA507B2863487BA6B69B71943&elqTrack=true" data-targettype="webpage" title="Thermo Fisher Scientific New Zealand"><img border="0" width="600" style="color:#6caae3" alt="Thermo Fisher Scientific" src="<?php echo $rowAc['hero_img']; ?>" class=""></a></td>
		</tr>
	</table>

<!--###################### START OF DYNAMIC section ###########################--> 

	<table cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="font-family: Arial, sans-serif; font-size: 13px; line-height: 22px; color: #333333;">	  
		<!--####### SPACE BELOW Header image ADJUST height if necessary ######-->    
		<tr><td height="10" colspan="2"></td></tr> 

		<!--########################### Sub-Headline & button ################-->

		<tr style="line-height:20px">
			<td width="375" valign="top" height="100%" style="color: #ee3134; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold; padding-left: 25px; padding-top: 10px; padding-bottom: 10px; padding-right:15px;">
				<?php echo nl2br($p['heading']); ?>
			</td>
        
		<!--####################### Call to action Button ###############-->  

			<td align="right" width="225" style="padding-right: 25px;">			 
				<table cellspacing="0" cellpadding="0" width="100%" style="background-color: #ee3134;">
				<tbody><tr>    
				<td align="center" width="100%" height="40">
					<a style="font-family: Arial, sans-serif; font-size: 18px; color: #ffffff; text-decoration: none; font-weight: bold;" target="_blank" href="<?php echo $p['btn_email_link']; ?>"><?php echo $p['btn_email']; ?></a></td>
				</tr>
				</tbody></table>
			</td>
		</tr>
          
		<!--########### Greeting by First Name (activate if applies) ##################-->
        
		<!--<tr>
			<td height="25" colspan="2" style="padding-left: 10px; font-weight: bold;">
			Dear <UAEpf n="FIRST_NAME"/>,
			</td>
			</tr>--> 
	  
		<!--###################### BODY section ###########################--> 
		   
		<tr>
		<td colspan="2">
		   	<table cellspacing="0" border="0" width="100%" style="font-family: Arial, sans-serif; font-size: 13px; color: #333333;">
		  		<tbody>
		  			<tr>
						<td valign="top" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 10px; mso-line-height-rule: exactly;line-height:150%;">
							<a target="_blank" href="#"><img border="0" align="right" width="150" height="150" style="margin: 0px 0px 0px 15px" alt="Thermo Fisher Scientific" src="<?php echo $p['main_img_email']; ?>"></a>		

							<?php echo nl2br($p['desc_email']); ?><br>

							<?php if($p['findoutmore']){ ?>
				            <br>
				            <a style="color: #6caae3; text-decoration:underline;" target="_blank" href="<?php echo $p['findoutmore']; ?>">Find out more »</a>    
				        <?php } ?>

				 

						</td>		
					</tr>	  
				</tbody>
			</table>
		</td>
	</tr>
</table>

<!--###################### END OF DYNAMIC section ###########################--> 

<table cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="font-family: Arial, sans-serif; font-size: 13px; line-height: 22px; color: #333333;">	  

		
<tr><td height="10" colspan="2"></td></tr>  
               

		<!--########### Secondary Message two column - Left column ###################-->
    
              	      <tr>
			<td bgcolor="#f3f3f3" width="50%" valign="top" style="border-right-width: 4px; border-right-style: solid; border-right-color: #FFF; padding: 10px; font-family: Arial, sans-serif; font-size: 12px; line-height:18px; color: #333333;padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 10px;">
                       
<a target="_blank" href="https://www.thermofisher.com/au/en/home/industrial/food-beverage.html"><img border="0" align="right" width="85" height="120" style="margin: 0px 0px 0px 5px" alt="Thermo Fisher Scientific" src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b2d3a658e-6740-4b2f-a275-64ba5e64fdb0%7d_ANZ_Conference_watermelon.jpg"></a>	

		<span style="color: #ee3134; font-weight: bold; font-size: 14px">The future starts here</span>
        <br>
		Thermo Scientific™ offers a range of innovative products, workflow solutions, and educational 
		resources that help our customers maintain their focus where it should be—delivering safe, 
		high-quality food products.
	          <br>
		  <a style="color: #6caae3;text-decoration:underline;" target="_blank" href="https://www.thermofisher.com/au/en/home/industrial/food-beverage.html">Find out more »</a>
          </td>
          
		<!--########### Secondary Message two column - Right column ###################-->	
    		
            <td bgcolor="#f3f3f3" width="50%" valign="top" style="border-left-width: 4px; border-left-style: solid; border-left-color: #FFF; padding: 10px; font-family: Arial, sans-serif; font-size: 12px; line-height:18px; color: #333333;padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 10px;">
            
			<a target="_blank" href="http://thermofisher.com.au/Uploads/file/Scientific/Offers/1456120000_ELED_brochure.pdf"><img border="0" align="right" width="85" height="120" style="margin: 0px 0px 0px 5px" alt="Thermo Fisher Scientific" src="http://img.en25.com/EloquaImages/clients/ThermoFisherScientificLPG/%7b19cffa44-1f45-4f2a-8c52-78646a5fc4d2%7d_ANZ_Conference_ELED_Cover.jpg"></a>	

		<span style="color: #ee3134; font-weight: bold; font-size: 14px">Every Lab, Every Day</span>
        <br>
		Save on essential equipment for your lab... These essential products help you to produce
			consistent, optimal work...in every lab, every day –
			all backed by the quality, value and expertise you’ve
			come to expect from us.
          <br>
		  <a style="color: #6caae3;text-decoration:underline;" target="_blank" href="http://thermofisher.com.au/Uploads/file/Scientific/Offers/1456120000_ELED_brochure.pdf">Download Brochure »</a>
          </td>
		  </tr>



		

<!--########################### Break ##############################-->  
<tr><td height="10" colspan="2"></td></tr>





	

</tbody></table></body></html>