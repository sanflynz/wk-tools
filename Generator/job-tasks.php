<?php 

function makeTime($date){

	$d = explode("-",$date);

	$newDate = mktime(0,0,0,$d[1],$d[0],"20" . $d[2]);

	return $newDate;
}

if($_FILES){

	$row = 1;
	if (($handle = fopen($_FILES['uploadfile']['tmp_name'], "r")) !== FALSE) {
		$jobs = array();
		$tasks = array();
	    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	        $jobs[] = $data;

	        if($row > 1){
	        	$trows = explode("<br>",$data[3]);
	        	foreach($trows as $t){
	        		if(!empty($t)){
	        			$tCreated = substr($data[0],0,8);
	        			//$tCreated = $data[0];
	        			$tType = substr($t,0,strpos($t,"-")-1);
	        			$tStatus = substr($t,strpos($t,"-")+2);
	        			switch($tType){
	        				case "Digital Media":
	        					$tDue = $data[7];
	        					$days = 9;
	        					break;
	        				case "Web":
	        					$tDue = $data[8];
	        					$days = 9;
	        					break;
	        				case "Email":
	        					$tDue = $data[9];
	        					$days = 12;
	        					break;
	        				case "Print":
	        					$tDue = $data[10];
	        					$days = 12;
	        					break;
	        				default:
	        					$tDue = "";

	        			}

	        			
	        			$tOverdue = (makeTime(date("d-m-y")) > makeTime($tDue)) ? "true" : "false";

	        			$tUrgent = (((makeTime($tDue) - makeTime($tCreated)) / 86400) < $days) ? "true" : "false";

	        			// if(makeTime(date("d-m-y")) > makeTime($tDue)){
	        			// 	$tOverdue = "true";
	        			// }
	        			// else{
	        			// 	$tOverdue = "false";
	        			// }
	        			




	        			$tasks[] = array("name" => $data[2],"created" => date("d/m/Y", makeTime($tCreated)), "type" => $tType, "status" => $tStatus, "due" => date("d/m/Y", makeTime($tDue)), "overdue" => $tOverdue, "urgent" => $tUrgent);
	        		}
	        	}
	        }
	        // $num = count($data);
	        // echo "<p> $num fields in line $row: <br /></p>\n";
	        $row++;
	        // for ($c=0; $c < $num; $c++) {
	        //     echo $data[$c] . "<br />\n";
	        // }
	    }
	    fclose($handle);

	    $jOpen = 0;
	    $jUrgent = 0;

	    foreach($jobs as $j){
	    	if(strpos($j[3],"New") || strpos($j[3],"To Be Assigned") || strpos($j[3],"Review") || strpos($j[3],"In Progress") || strpos($j[3],"Hold") || strpos($j[3],"Final")){
	    		$jOpen++;
	    	}
	    	if($j[6] == "Yes"){
	    		$jUrgent++;
	    	}
	    }

	    $tOpen = 0;
	    $tOverdue = 0;
	    $tUrgent = 0;
	    $tNew = 0;
	    foreach ($tasks as $t){
	    	if($t['status'] != "Completed"){
	    		$tOpen++;
	    	}
	    	if($t['overdue'] == "true" && $t['status'] != "Completed"){
	    		$tOverdue++;
	    	}
	    	if($t['urgent'] == "true"){
	    		$tUrgent++;
	    	}


	    }

	    

	    echo "<pre>";
	    print_r($tasks);
	    echo "</pre>";

	    echo "<pre>";
	    print_r($jobs);
	    echo "</pre>";
	   
	}


	

}



//include("includes/db.php");
//include("includes/db.php");
include("includes/header.php"); 



?>
<style>
	.panel-counter {
		font-size: 30;
	}
</style>


<h1>Job Tasks</h1>


<div class="row">
	<div class="col-md-6">
		<form action="job-tasks.php?action=upload" method="post" enctype="multipart/form-data">
			<input type="file" name="uploadfile" class="form-control">
			<input type="submit" value="Upload" name="uploadxml" class="btn btn-primary">
		</form>
	</div>
</div>

<?php 
	if($_FILES){ ?>
	<br>
	<br>
	
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title text-center">New Tasks Last Week</h3>
			  </div>
			  <div class="panel-body panel-counter text-center">
			    14
			  </div>
				<div class="panel-footer text-center">12 Jobs</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title text-center">Open Tasks</h3>
			  </div>
			  <div class="panel-body panel-counter text-center">
			    <?php echo $tOpen; ?>
			  </div>
			  <div class="panel-footer text-center"><?php echo $jOpen ?> Jobs</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title text-center">Urgent Tasks</h3>
			  </div>
			  <div class="panel-body panel-counter text-center">
			    <?php echo $tUrgent; ?>
			    
			  </div>
			  <div class="panel-footer text-center"><?php echo $jUrgent; ?> Jobs</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title text-center">Overdue Tasks</h3>
			  </div>
			  <div class="panel-body panel-counter text-center">
			    <?php echo $tOverdue; ?>
			  </div>
			  <div class="panel-footer text-center">6 Jobs</div>
			</div>
		</div>

		
	</div>

	<table class="table">
		<thead>
			<tr>
				<th>Date</th>
					<th>Job</th>					
						<th>Type</th>
							<th>Status</th>
								<th>Due</th>
									<th>Overdue</th>
										<th>Urgent</th>
			</tr>
		</thead>
		<tbody>
<?php 	foreach($tasks as $t){ ?>
			<tr <?php if($t['overdue'] == "true" && $t['status'] != "Completed"){ echo "class=\"danger\" "; } ?>>
				<td><?php echo $t['created']; ?></td>
					<td><?php echo $t['name'];?></td>
						<td><?php echo $t['type']; ?></td>
							<td><?php echo $t['status']; ?></td>
								<td><?php echo $t['due']; ?></td>
									<td><?php echo ($t['overdue'] == "true" && $t['status'] != "Completed") ? "Yes" : ""; ?></td>
										<td><?php echo ($t['urgent'] == "true") ? "Yes" : ""; ?></td>
					

			</tr>
<?php	}
	
?>
		</tbody>
	</table>
	

<?php	
	}?>


<?php

include("includes/footer.php"); ?>