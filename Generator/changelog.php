<?php 	include("includes/header.php"); ?>

<h1>Changelog</h1>
<br>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">20180615</h3>
	</div>
	<div class="panel-body">
		<li>Updated Promos (child) generator to updated template template</li>
		<li>Updated Table Building in Promo (child) and Generic (L4) page
			<ul>
				<li>Using Table class for ease of reproducibility</li>
				<li>Added [center], [left] and [right] alignment for columns</li>
				<li>Updated code for buy button.  Now just add '[BUY]' to column, will take the item code from the 'Item Code' column automatically</li>
			</ul>
		</li>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Not datestamped</h3>
	</div>
	<div class="panel-body">
		<li>Dependencies checked on index page</li>
		<li>Require/Create folder 'files' -> for zip, html, txt, sql files</li>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">20171102</h3>
	</div>
	<div class="panel-body">
		<li>Updated instructions for Items in Promo Page Generator</li>
		<li>Changed Promo Page to have H1 rather than a div for the page header</li>
		<li>Changed image lister to PHP from jQuery (using SimpleHTMLDOM in __vendors folder)</li>
		<li>Export "Get File" now downloads zip file with html + images</li>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">20171013</h3>
	</div>
	<div class="panel-body">
		<li>In promo pod editor page fixed import button</li>
		
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">20171012</h3>
	</div>
	<div class="panel-body">
		<li>In promo page generator, hide Items table(s) if no items listed</li>
		<li>In promo pods export, change to show exported code in box</li>	
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">20170905</h3>
	</div>
	<div class="panel-body">
		<li>Added link to StyleGuide</li>
		<li>Updated <i>Export</i> to display code that can be copy/pasted into CRM</li>
		<li>Added feature to show all images from Exported code for easy download/packaging</li>	
		<li>Level 3 Page Editor added <i class="fa fa-flask" style="color: #00FF00" title="EXPERIMENTAL BUT REASONABLY FUNCTIONAL"></i> </li>	
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">20170602</h3>
	</div>
	<div class="panel-body">
		<li>Fix for floating bullet points</li>		
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">20170530</h3>
	</div>
	<div class="panel-body">
		<li>Fixed Promo Pods tabs for PDF vs Non-PDF</li>
		<li>Fixed missing &lt;/td&gt; on promo pods</li>
		<li>Fixed Promo Pages items open in same tab</li>
		<li>Fixed Promo Pages List pagination</li>
		<li>Added optional hidden header code to Promo Pods</li>

		
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">20170524</h3>
	</div>
	<div class="panel-body">
		<li>Fixed Save on Promo Pods</li>
		<li>Added Clear All button to Promo Pods</li>
		<li>Added Upload and Download features to Promo Pods</li>
		<li>Added some instructions to Promo Pods</li>
		<li>Updated Promo Pods from EXPERIMENTAL - DONT USE (<i class="fa fa-flask" style="color: #FF0000;" title="EXPERIMENTAL"></i>) to EXPERIMENTAL - HAVE A PLAY! (<i class="fa fa-flask" style="color: #00FF00;" title="EXPERIMENTAL"></i>)</li>
		<li>Moved Promo Pods menu item to Webpages</li>
		<li>Removed "Add Promo Page" from menu</li>
		<li>Added Bug Report/Change Request</li>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">20170522</h3>
	</div>
	<div class="panel-body">
		<li>Added Request Link Generator</li>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">20170519</h3>
	</div>
	<div class="panel-body">
		<li>Added Changelog</li>
		<li>Added New Button to Promo Pages Index</li>
		<li>Added Pagination to Promo Pages Index</li>
		<li>Tidied up Generator Index</li>
		<li>Added basic Term and Conditions to Promo Page Editor (info button, copy and paste)</li>
		<li>Added meh Favicon to preview pages</li>
		<li>Added Help Menu</li>
		<li>Added link to HTML Entities Cheat Sheet</li>
		<li>Added Basic HTML Help</li>
		<li>Experimental Icon Added (<i class="fa fa-flask" style="color: #FF0000;" title="EXPERIMENTAL"></i>)</li>

	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Previous</h3>
	</div>
	<div class="panel-body">
		<li>Added Promo Pods generator page</li>
		<li>Promo page tracking on items and resources/related</li>
		<li>p['image'] when creating promo page</li>
		<li>Delete button on promo page list</li>
		<li>last_modified on create</li>
		<li>Image Uploader</li>
		<li>Trademark and Registered Trade Mark Issues on edit</li>
		<li>Favicon</li>
		
	</div>
</div>







<?php	include("includes/footer.php"); ?>