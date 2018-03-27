<?php 
	if(!isset($s['id'])){
		if(isset($_GET['sid'])){
			$s['id'] = $_GET['sid'];
		}
	} 
	
	
	?>
	<!-- Modal -->
<div id="section-layout-hdi" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title">HDI Layout</h4>
      	</div>
      	<div class="modal-body">
        	<table width="100%">
        		<tr>
        			<td width="50%" align="center"><span class="section-layout-hdi-selector" data-layout="Heading beside image" data-sectionid="<?php echo $s['id']; ?>"><img src="images/components/hdi-a.jpg" alt="" class="img-responsive"><br>Heading beside image</span></td>
        			<td width="50%" align="center"><span class="section-layout-hdi-selector" data-layout="Heading above image" data-sectionid="<?php echo $s['id']; ?>"><img src="images/components/hdi-b.jpg" alt="" class="img-responsive"><br>Heading above image</span></td>
        		</tr>
        		
        	</table>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      	</div>
    </div>

  </div>
</div>

	<div class="section-heading">
		<h4>Section name</h4> 
		<div>
		<?php include("actions.php"); ?>
		</div>
	</div>
	<input type="text" name="data[section][<?php echo $s['id']; ?>][order]" id="section-<?php echo $s['id']; ?>-order" value="<?php echo $s['id']; ?>" autocomplete="foo">
	<input type="hidden" name="data[section][<?php echo $s['id']; ?>][name]" id="section-<?php echo $s['id']; ?>-name" value="">
	<input type="hidden" name="data[section][<?php echo $s['id']; ?>][type]" id="section-<?php echo $s['id']; ?>-type" value="">
	<table class="table table-hover table-edit-components">
		<tr>
			<td><strong>Layout</strong></td>
			<td>
				<span id="section-<?php echo $s['id']; ?>-settings-layout-text"></span>&nbsp;&nbsp;<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#section-layout-hdi">Select layout</button>
				<input name="data[section][<?php echo $s['id']; ?>][settings][layout]" id="section-<?php echo $s['id']; ?>-settings-layout" type="hidden" value="">
			</td>
		</tr>
		<tr>
			<td><strong>Page Heading</strong></td>
			<td>
				<input name="data[section][<?php echo $s['id']; ?>][content][name]" id="" type="text" value="" class="form-control" autocomplete="foo">
			</td>
		</tr>
		<tr>
			<td><strong>Description</strong></td>
			<td>
				
				<textarea name="data[section][<?php echo $s['id']; ?>][content][description]" id="section-<?php echo $s['id']; ?>-content-description" value="" class="form-control wysiwyg-editor" data-type="basic" autocomplete="foo"></textarea>
			</td>
		</tr>
		<tr>
			<td><strong>Image</strong></td>
			<td>
				<table width="100%">
					<tr>
						<td style="width: 300px; text-align: left;">
							<img src="http://via.placeholder.com/230x230">
						</td>
						<td class="file-upload-controls" valign="top">
							<h5>Existing image</h5>
								<input name="data[section][<?php echo $s['id']; ?>][content][image]" id="" type="text" value="" class="form-control">
								
							<br>
							<h5>Upload a new image</h5>
							<div class="input-group file-upload-group">
				                <input type="text" class="form-control" readonly>
				                <label class="input-group-btn">
				                    <span class="btn btn-primary">
				                        <i class="fa fa-folder-open"></i><input name="data[section][<?php echo $s['id']; ?>][content][image]" type="file" style="display: none;">
				                    </span>
				                </label>				                
				            </div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>


