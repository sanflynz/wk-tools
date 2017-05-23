<?php 	include("includes/header.php"); ?>
<link rel="stylesheet" href="../__resources/css/prod-buttons.css">
<h1>Basic HTML</h1>

<table class="table table-hover">
	<thead><tr>
			<th width="30%">Example</th>
			<th>Code</th>
		</tr></thead>
	<tr>
		<td><b>Bold Text</b></td>
		<td><code>&lt;b&gt;Bold Text&lt;/b&gt;</code></td>
	</tr>
	<tr>
		<td><a href="http://www.google.com">A link</a></td>
		<td><code>&lt;a href="http://www.google.com"&gt;A link&lt;/a&gt;</code></td>
	</tr>
	<tr>
		<td><a href="http://www.google.com" target="_blank">A link that opens in a new tab</a></td>
		<td><code>&lt;a href="http://www.google.com" target="_blank"&gt;A link that opens in a new tab&lt;/a&gt;</code><br>
			<span style="font-size: smaller;">Add <code>target="_blank"</code> to &lt;a> tag</span></td>
	</tr>
	<tr>
		<td>
			<ul>
				<li>Item 1</li>
				<li>Item 2</li>
				<li>Item 3</li>
			</ul>
		</td>
		<td><code>&lt;ul&gt;&lt;li&gt;Item 1&lt;/li&gt;&lt;li&gt;Item 2&lt;/li&gt;&lt;li&gt;Item 3&lt;/li&gt;&lt;/ul&gt;</code></td>
	</tr>
	<tr>
		<td>&trade; (trademark)</td>
		<td><code>&amp;trade;</code></td>
	</tr>
	<tr>
		<td><sup>&reg;</sup>  (registered trademark)</td>
		<td><code>&lt;sup&gt;&amp;reg;&lt;/sup&gt;</code></td>
	</tr>
	<tr>
		<td>Line<br>break</td>
		<td><code>Line&lt;br&gt;break</code><br>
			Or, if in a large text box, just press enter to new line.</td>
	</tr>
	<tr>
		<td><span style="font-size: smaller">Smaller Text</span> (Normal Text)</td>
		<td>
			<code>&lt;span style="font-size: smaller"&gt;Smaller Text&lt;/span&gt;</code><br>
			<span style="font-size: smaller">Useful for promo pods offer text (in red box), puts text one size down</span>
		</td>
	</tr>
	<tr>
		<td>
			<a href="http://www.google.com" class="btn btn-default">Default</a>
		</td>
		<td>
			<code>&lt;a href="http://www.google.com" class="btn btn-default"&gt;Default&lt;/a&gt;</code><br>
			<span style="font-size: smaller">Add <code>class="btn btn-default"</code> to &lt;a> tag</span>
		</td>
	</tr>
	<tr>
		<td>
			<a href="http://www.google.com" class="btn btn-primary">Primary</a>
		</td>
		<td>
			<code>&lt;a href="http://www.google.com" class="btn btn-primary"&gt;Primary&lt;/a&gt;</code><br>
			<span style="font-size: smaller">Add <code>class="btn btn-primary"</code> to &lt;a> tag</span>
		</td>
	</tr>
	<tr>
		<td>
			<a href="http://www.google.com" class="btn btn-commerce">Commerce</a>
		</td>
		<td>
			<code>&lt;a href="http://www.google.com" class="btn btn-commerce"&gt;Commerce&lt;/a&gt;</code><br>
			<span style="font-size: smaller">Add <code>class="btn btn-commerce"</code> to &lt;a> tag</span>
		</td>
	</tr>
	<tr>
		<td>
			<a href="http://www.google.com" class="btn btn-featured">Featured</a>
		</td>
		<td>
			<code>&lt;a href="http://www.google.com" class="btn btn-featured"&gt;Featured&lt;/a&gt;</code><br>
			<span style="font-size: smaller">Add <code>class="btn btn-featured"</code> to &lt;a> tag</span><br>
			NOTE: Maximum one featured button per page!!!
		</td>
	</tr>
</table>


<?php 	include("includes/footer.php"); ?>