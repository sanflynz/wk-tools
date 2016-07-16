<?php 

include("includes/db.php");

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

    include("includes/header_" . $_SESSION['environment'] . ".php");

?>


    <div class="row">
        <div class="col-md-8 col-xs-12" style="color: #ee3134; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;">
            <br>
            <?php echo nl2br($p['heading']); ?>
        </div>
        <div class="col-md-4 col-xs-12">
            <br>
            <table cellspacing="0" cellpadding="0" width="100%" style="background-color: #ee3134;">
                <tbody>
                    <tr>    
                        <td align="center" width="100%" height="40">
                            <a style="font-family: Arial, sans-serif; font-size: 18px; color: #ffffff; text-decoration: none; font-weight: bold;" href="#form"><?php echo $p['btn_landing']; ?></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-hidden"><br></div>
    </div>
    <div class="row">
        
        <div class="col-md-4 col-xs-12 col-md-push-8">
           <center><img src="<?php echo $p['main_img_landing']; ?> " class="img-responsive" alt=""><br>
           <button class="btn btn-allwhite" style="width: 100%;" id="questionsLink">Questions</button> 
            </center>
            <div id="questions" class="alert alert-warning" style="display: none;">
                <br>
               <?php 
                if($p['questions']){
                    $qs = explode(";", $p['questions']);
                    echo "<ol>";
                    foreach($qs as $q){
                        echo "<li>" . $q . "</li>";
                    }
                    echo "</ol>";
                }

                ?>
            </div>
        
        </div>

        <div class="col-md-8 col-xs-12 col-md-pull-4">
            <?php echo nl2br($p['desc_landing']); ?><br>
        <?php if($p['findoutmore']){ ?>
            <br>
            <a target="_blank" href="<?php echo $p['findoutmore']; ?>" class="btn btn-primary">Find out more</a>    
        <?php } ?>
        </div>
       
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-7">
            <br>
            <a name="form"></a>
            <h4>Enter your details below and we will email you the product brochure/details</h4>
            
        <form method="post" name="ANZ_CONF_Form" action="https://s642.t.eloqua.com/e/f2" id="form1742" class="elq-form" >
        <input value="ANZ_CONF_Form" type="hidden" name="elqFormName">
        <input value="642" type="hidden" name="elqSiteId">
        <input name="elqCampaignId" type="hidden">
        
        <div class="form-group">
            <label for="field0">First Name</label>
            <input type="text" class="form-control" name="firstName" id="field0" required="">
          </div>
          <div class="form-group">
            <label for="field1">Last Name</label>
            <input type="text" class="form-control" name="lastName" id="field1" required="">
          </div>
          <div class="form-group">
            <label for="field2">Email address</label>
            <input type="email" class="form-control" name="emailAddress" id="field2" required="">
          </div>
          <div class="checkbox">
            <label>
              <input name="singleCheckbox" type="checkbox" value="on"> I would like a Product Specialist to contact me to discuss this product
            </label>
          </div>

            <input type="hidden" class="form-control" name="ANZ_CONF_Identifier" id="field7" value=""> <!-- populated by JavaScript = ConfName_datetime -->

            
            <input type="hidden" class="form-control" name="ANZ_CONF_Conference" id="field4" value="<?php echo $rowAc['name']; ?>">
            <input type="hidden" class="form-control" name="ANZ_CONF_Product" id="field5" value="<?php echo $p['name']; ?>">
            <input type="hidden" class="form-control" name="ANZ_CONF_Email" id="field8" value="<?php echo $rowAc['email_to_send']; ?>">
            <input type="hidden" class="form-control" name="ANZ_CONF_Specialist" id="field6" value="<?php echo $p['specialist_email']; ?>">
            <input type="hidden" class="form-control" name="ANZ_CONF_Redirect" id="field7" value="<?php echo $p['redirect_url']; ?>">

            <br>

          <button type="submit" class="btn btn-success" style="width: 100%">Submit</button><br>
          <br>

        
    </form>
        </div>
        
    </div>

    <script>
    !function ($) {
        $(window).load(function () {
            // toggle mobile menu
            //$('#mobile-menu-toggle').on('click', function () {
            //    $('#main-header .navbar-responsive-collapse').toggle();
            //})
            
            $( "#questionsLink" ).click(function() {
                $("#questions").toggle();
            })
        })
    }(window.$j);

    
</script>

<?php include("includes/footer_" . $_SESSION['environment'] . ".php");    ?>

