<?php 
	
	include ("includes/db.php");

	// GET BRANDS
		$rB = $conn->query("SELECT * FROM brands ORDER BY name");
	
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

		
		

	}


	if($_POST){

		$p = $_POST;
		$fields = "country,name,heading,btn_landing,btn_email,btn_email_link,main_img_landing,main_img_email,desc_landing,desc_email,findoutmore,questions,specialist_email,redirect_url,brand_id,sign_name,sign_desc,sign_short_url,sign_size";
			
		if($p['id'] == ""){
			// ADD
			//$fields = "country,name,heading,btn_landing,btn_email,btn_email_link,main_img_landing,main_img_email,desc_landing,desc_email,findoutmore,questions,product_email,specialist_email,redirect_url,brand_id,sign_name,sign_desc,sign_short_url,sign_size";
			$values = "'" . $p['country'] . "','" . $p['name'] . "','" . $p['heading'] . "','" . $p['btn_landing'] . "','" . $p['btn_email'] . "','" . $p['btn_email_link'] . "','" . $p['main_img_landing'] . "','" . $p['main_img_email'] . "','" . $p['desc_landing'] . "','" . $p['desc_email'] . "','" . $p['findoutmore'] . "','" . $p['questions'] . "','" . $p['specialist_email'] . "','" . $p['redirect_url'] . "','" . $p['brand_id'] . "','" . $p['sign_name'] . "','" . $p['sign_desc'] . "','" . $p['sign_short_url'] . "','". $p['sign_size'] . "'";
			$sql = "INSERT INTO products (" . $fields . ") VALUES (" . $values . ")";
			$r = $conn->query($sql);
			if($r){
				// redirect
				if(isset($_SESSION['activeConference'])){
					header("location: conference_v.php?id=" . $_SESSION['activeConference']);
				}
				else{
					header("location: product_i.php#" . $p['id']);
				}
			}
			else{
				$error = "Unable to add product: " . $conn->error;
			}
		}
		else{
			//UPDATE
			//$fields = "country,name,heading,btn_landing,btn_email,main_img_landing,main_img_email,desc_landing,desc_email";
			//$values = "country = '" . $p['country'] . "', `name` = '" . $p['name'] . "', heading = '" . $p['heading'] . "', btn_landing = '" . $p['btn_landing'] . "', btn_email = '" . $p['btn_email'] . "', btn_email_link = '" . $p['btn_email_link'] . "', main_img_landing = '" . $p['main_img_landing'] . "', main_img_email = '" . $p['main_img_email'] . "', desc_landing = '" . $p['desc_landing'] . "', desc_email = '" . $p['desc_email'] . "', findoutmore = '" . $p['findoutmore'] . "',  questions = '" . $p['questions'] . "', product_email = '" . $p['product_email'] . "', specialist_email = '" . $p['specialist_email'] . "', redirect_url = '" . $p['redirect_url'] . "'";
			$values = "";
			$i = 1;
			foreach(explode(",", $fields) as $f){
				$values .= $f . "='" . $p[$f] . "'";
				if($i < count(explode(",",$fields))){
					$values .= ",";
				}
				$i++;
			}
			$sql = "UPDATE products SET $values WHERE id = " . $p['id'];
			$r = $conn->query($sql);
			if($r){
				// redirect
				if(isset($_SESSION['activeConference'])){
					header("location: conference_v.php?id=" . $_SESSION['activeConference']);
				}
				else{
					header("location: product_i.php#" . $p['id']);
				}
			}
			else{
				$error = "Unable to update product: " . $conn->error;
			}
		}
	}

	include("includes/header.php");


?>

			<h1 class="text-center">Editor</h1>
			
	<?php
		if(isset($error)){ ?>
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>ERROR:</strong> <?php echo $error; ?>
			</div>
<?php	}
	?>		

			<form action="" method="POST" role="form">

				<input type="hidden" name="id" id="id" class="form-control" value="<?php if(isset($p)){ echo $p['id']; } ?>">
			
			<div class="row">
				<div class="col-md-9">
					<div class="formgroup">
						<label for="country">Country</label>
						<select name="country" id="country" class="form-control" required="required">
							<option value="">-- PLEASE SELECT --</option>
							<option value="AU" <?php if(isset($p) && $p['country'] == "AU"){ echo "selected"; } ?> >Australia</option>
							<option value="NZ" <?php if(isset($p) && $p['country'] == "NZ"){ echo "selected"; } ?>>New Zealand</option>
						</select>
						<br>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="name">Product Name</label>
						<input type="text" class="form-control" name="name" id="name" <?php if(isset($p)){ echo "value='" . $p['name'] . "'"; } ?> >
					</div>
				</div>
				<div class="col-md-3">
					&nbsp;
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12">
					<h3>Product Sign<hr></h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="name">Size</label>
						<select name="sign_size" id="" class="form-control">
							<option value="A6" <?php if(isset($p) && $p['sign_size'] == "A6"){ echo "selected"; } elseif(!isset($p)){ echo " selected"; } ?>>A6</option>
							<option value="Card" <?php if(isset($p) && $p['sign_size'] == "Card"){ echo "selected"; } ?>>Card</option>
						
						</select>
					</div>
				</div>
				<div class="col-md-3">
					&nbsp;
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="name">Brand</label>
						<select name="brand_id" id="" class="form-control">
							<option value="">--- SELECT BRAND ---</option>
						<?php 	while($rowB = $rB->fetch_assoc()){ ?>
							<option value="<?php echo $rowB['id']; ?>" <?php if(isset($p) && $p['brand_id'] == $rowB['id']){ echo "selected"; } ?>><?php echo $rowB['name']; ?></option>
						<?php	}	?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					&nbsp;
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="name">Sign Name</label>
						<input type="text" class="form-control" name="sign_name" id="sign_name" <?php if(isset($p)){ echo "value='" . $p['sign_name'] . "'"; } ?> >
					</div>
				</div>
				<div class="col-md-3">
					&nbsp;
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="name">Sign Description</label>
						<textarea class="form-control" name="sign_desc" rows="3"><?php if(isset($p)){ echo $p['sign_desc']; } ?></textarea>
					</div>
				</div>
				<div class="col-md-3">
					&nbsp;
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="name">Sign Short URL</label>
						<input type="text" class="form-control" name="sign_short_url" id="sign_short_url" <?php if(isset($p)){ echo "value='" . $p['sign_short_url'] . "'"; } ?> >
					</div>
				</div>
				<div class="col-md-3">
					&nbsp;
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="btn_email">Redirect URL</label>
						<input type="text" name="redirect_url" id="redirect_url" class="form-control" value="<?php if(isset($p)){ echo $p['redirect_url']; } ?>" >
					</div>
				</div>
				<div class="col-md-3">
					<br>
					&nbsp;
				</div>
			</div>
			<br>
			<br>
			<div class="row">
				<div class="col-xs-12">
					<h3>Landing Page</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="heading">Heading</label>
						<textarea name="heading" id="heading" class="form-control" rows="3"><?php if(isset($p)){ echo $p['heading']; } ?></textarea>
					</div>	
				</div>
				<div class="col-md-3">
					&nbsp;
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="btn_landing">Button Text - Landing Page</label>
						<input type="text" name="btn_landing" id="btn_landing" class="form-control" value="<?php if(isset($p)){ echo $p['btn_landing']; } ?>">
					</div>
				</div>
				<div class="col-md-3">
					&nbsp;
				</div>
			</div>

			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="btn_email">Main Image - Landing Page</label>
						<input type="text" name="main_img_landing" id="main_img_landing" class="form-control" value="<?php if(isset($p)){ echo $p['main_img_landing']; } ?>">
					</div>
				</div>
				<div class="col-md-3">
					<br>
					Stuff here about specs
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="">Description - Landing Page</label>
						<textarea name="desc_landing" id="desc_landing" class="form-control" rows="10"><?php if(isset($p)){ echo $p['desc_landing']; } ?></textarea>
					</div>
				</div>
				<div class="col-md-3">
					&nbsp;
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="btn_email">Find Out More link</label>
						<input type="text" name="findoutmore" id="findoutmore" class="form-control" value="<?php if(isset($p)){ echo $p['findoutmore']; } ?>">
					</div>
				</div>
				<div class="col-md-3">
					<br>
					
				</div>
			</div>
<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="">Key Questions</label>
						<textarea name="questions" id="questions" class="form-control" rows="5"><?php if(isset($p)){ echo $p['questions']; } ?></textarea>
					</div>
				</div>
				<div class="col-md-3">
					<br>
					
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="btn_email">Specialist Email</label>
						<input type="text" name="specialist_email" id="specialist_email" class="form-control" value="<?php if(isset($p)){ echo $p['specialist_email']; } ?>" >
					</div>
				</div>
				<div class="col-md-3">
					<br>
					&nbsp;
				</div>
			</div>
			
			


			<br>
			<br>
			<div class="row">
				<div class="col-xs-12">
					<h3>Email</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="btn_email">Button Text - Email Page</label>
						<input type="text" name="btn_email" id="btn_email" class="form-control" value="<?php if(isset($p)){ echo $p['btn_email']; } ?>">
					</div>
				</div>
				<div class="col-md-3">
					<br>
					<button type="button" class="btn btn-default" id="copyBtnText">Copy from Landing Page</button>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="btn_email">Button Link - Email Page</label>
						<input type="text" name="btn_email_link" id="btn_email_link" class="form-control" value="<?php if(isset($p)){ echo $p['btn_email_link']; } ?>">
					</div>
				</div>
				<div class="col-md-3">
					<br>
					&nbsp;
				</div>
			</div>

			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="btn_email">Main Image - Email</label>
						<input type="text" name="main_img_email" id="main_img_email" class="form-control" value="<?php if(isset($p)){ echo $p['main_img_email']; } ?>">
					</div>
				</div>
				<div class="col-md-3">
					<br>
					Stuff here about specs<br>
				</div>
			</div>
			

			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="">Description - Email</label>
						<textarea name="desc_email" id="desc_email" class="form-control" rows="10"><?php if(isset($p)){ echo $p['desc_email']; } ?></textarea>
					</div>
				</div>
				<div class="col-md-3">
					<br>
					<button type="button" class="btn btn-default" id="copyDesc">Copy from Landing Page</button>
				</div>
			</div>

			
			

			


				<button type="submit" class="btn btn-primary">Submit</button>
				<br>
				<br>
			</form>
		</div>
		
<?php

	include("includes/footer.php");
?>		