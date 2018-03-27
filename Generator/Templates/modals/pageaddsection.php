<!-- Modal -->
<div id="addSectionDialog" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title">Add new section</h4>
      	</div>
      	<div class="modal-body">
        	<table width="100%">
        		<tr>
        			<td width="150">Type</td>
        			<td style="padding-bottom: 5px;">
        				<select name="sectiontype" id="sectiontype" class="form-control" style="width: 80%">
        					<option value=""></option>
        					<option value="hdi">Heading, Description, Image (HDI)</option>
        				</select>
        			</td>
        		</tr>
        		<!-- <tr>
        			<td width="150">After</td>
        			<td style="padding-bottom: 5px;">
        				<select name="sectionafter" id="sectionafter" class="form-control" style="width: 80%">
        					<option value=""></option>
        					
        				</select>
        			</td>
        		</tr> -->
        		<tr>
        			<td width="150">New section name</td>
        			<td style="padding-bottom: 5px;">
        				<input type="text" name="sectionname" id="sectionname" class="form-control" value="" style="width: 80%">
        			</td> 
        		</tr>
        	</table>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> <button type="button" id="addSection" class="btn btn-primary">&nbsp;&nbsp;Add&nbsp;&nbsp;</button>
      	</div>
    </div>

  </div>
</div>