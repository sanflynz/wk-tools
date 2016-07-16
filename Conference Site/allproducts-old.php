<?php 
    include("includes/db.php");
    include("includes/header_" . $_SESSION['environment'] . ".php"); 

    function getGroup($id, $conn){
        $r = $conn->query("SELECT * FROM groups WHERE id = " . $id);
        $g = $r->fetch_assoc();

        return $g;

    }

    $sql = "SELECT * FROM `conferences` c WHERE c.id = " . $_GET['id'];
    $r = $conn->query($sql);
    $c = $r->fetch_assoc();
    //while($row = $r->fetch_assoc()){
    //  $c = $row;
    //}

    $sqlCG = "SELECT cg.id as cgid, g.id as gid, g.name FROM conference_groups cg LEFT JOIN groups g ON cg.group_id = g.id WHERE cg.conference_id = " . $_GET['id'] . " ORDER BY cg.`order`";
    $rCG = $conn->query($sqlCG);


    if($rCG->num_rows > 0){
        
    //  //$conference_group = array();
    //  //$conference_product = array();
    //  //$group = array();
    //  $product = array();
        while( $rowCG = $rCG->fetch_assoc() ){
            $p['conference_group'][$rowCG['cgid']]['group']['id'] = $rowCG['gid'];
            $p['conference_group'][$rowCG['cgid']]['group']['name'] = $rowCG['name'];
            
    //      // get conference
    //      $p['group'][$row['group_id']] = getGroup($row['group_id'],$conn);
        }

        foreach($p['conference_group'] as $k => $v){
            $sqlCP = "SELECT cp.id as cpid, p.id as pid, cp.*, p.* FROM conference_products cp LEFT JOIN products p on cp.product_id = p.id WHERE conference_id = '" . $_GET['id'] . "' AND cp.conference_group_id = '" . $k . "' ORDER BY cp.order";
            $rCP = $conn->query($sqlCP);
            while($rowCP = $rCP->fetch_assoc()){
                $p['conference_group'][$k]['products'][] = $rowCP;  
    //          //$r3 = $conn->query("SELECT * FROM products WHERE");
            }
            
        }
        echo "<pre>";
        print_r($p);
        echo "</pre>";

    }   










   // $sql = "SELECT * FROM products";
    //$r = $conn->query($sql); 
    ?>

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

<?php   

    $r = $conn->query("SELECT * FROM conference_groups cg LEFT JOIN groups g ON cg.group_id = g.id WHERE cg.conference_id = " . $_GET['conference']);   
    while($row = $r->fetch_assoc()){ ?>
        <div class="row">
            <div class="col-xs-12">
                <h3><?php echo $row['name']; ?> </h3>
                <hr>
            </div>
        </div>
        <div class="row">
 <?php  $r2 = $conn->query("SELECT cp.*,p.heading,p.btn_email_link,p.main_img_landing,p.redirect_url FROM conference_products cp LEFT JOIN products p ON cp.product_id = p.id WHERE cp.conference_id = " . $_GET['conference'] . " AND cp.group_id = " . $row['id']);
        $i = 1;
        while($row2 = $r2->fetch_assoc()){ ?>
            <div class="col-md-3 col-xs-12">
                <div style="color: #ee3134; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;" class="text-center"><?php echo $row2['heading']; ?></div> 
                <br>
                <center><img src="<?php echo $row2['main_img_landing']; ?>" class="img-responsive" style="max-width: 70%";  alt=""></center>  <br>
                <a href="<?php echo $row2['redirect_url']; ?>" class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">More Details</a>
                <a href="<?php echo $row2['btn_email_link']; ?>" class="btn btn-default" style="width: 100%;" target="_blank">Brochure</a><br>
                <br>
            </div>


    <?php   if($i == 4){ $i = 1; ?>
                  
                <div class="clearfix"></div>
    <?php   }    
            else { $i++;  }
       }

   ?>
        

 </div>       
    
<?php }

?>    



    

<?php include("includes/footer_" . $_SESSION['environment'] . ".php");  ?>
