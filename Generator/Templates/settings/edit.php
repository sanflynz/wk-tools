<table class="table table-edit-components" style="width: 50%;">
	<tr>
		<td><strong>Country</strong></td>
		<td>
			<select name="country" id="country" class="form-control" required autocomplete="foo">
				<option></option>
				<option value="Australia" <?php if(isset($p['country']) && $p['country'] == "Australia") {echo " selected"; } ?> >Australia</option>
				<option value="New Zealand" <?php if(isset($p['country']) && $p['country'] == "New Zealand") {echo " selected"; } ?>>New Zealand</option>
			</select>
		</td>
	</tr>
	<tr>
		<td><strong>Page Type</strong></td>
		<td>
			<select name="type" id="type" class="form-control" required autocomplete="foo">
				<option></option>
				<option value="Sub-category" <?php if(isset($p['type']) && $p['type'] == "Sub-category") {echo " selected"; } ?> >L3 Sub-category</option><option value="Promo (child)" <?php if(isset($p['type']) && $p['type'] == "Promo (child)") {echo " selected"; } ?> >L4 Promo (child)</option>
				<option value="Generic (child)" <?php if(isset($p['type']) && $p['type'] == "Generic (child)") {echo " selected"; } ?> >L4 Generic (child)</option>
			</select>
		</td>
	</tr>
	<tr>
		<td><strong>Page Name</strong></td>
		<td><input name="name" id="name" type="text" value="<?php if(isset($p)) { echo $p['name']; } ?>" class="form-control" autocomplete="foo"></td>
	</tr>
	<tr>
		<td><!-- OTHER SETTINGS CAN GO HERE LATER --></td>
		<td><input name="settings" id="settings" type="hidden" value="" class="form-control"></td>
	</tr>
	
	
</table>