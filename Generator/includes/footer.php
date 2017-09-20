</div>
		<!-- jQuery -->
		<script src="../__resources/js/jquery-2.1.4.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="../__resources/js/bootstrap.min.js" ></script>	
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
 		<script>
 			$(document).ready(function() {

 			// COPY CODE FOR EXPORT PAGES
 			$("#copyCode").click(function(){
 				document.execCommand("copy");
 			});		

 			// ###### PROMO PODS PAGE ######
 				// Toggle upload window to show/hide (promopods)
 				$("#upload-toggle").click(function(){
					//$("#uploadwindow").toggle();
				});



 			// ####### LEVEL 3 PAGES ########
 				
 				// TOGGLE POPULAR PRODUCTS
 				$("#p1-toggle").click(function(){
 					$("#p1-img-row").toggle();
 					$("#p1-url-row").toggle();
 				});
 				$("#p2-toggle").click(function(){
 					$("#p2-img-row").toggle();
 					$("#p2-url-row").toggle();
 				});
 				$("#p3-toggle").click(function(){
 					$("#p3-img-row").toggle();
 					$("#p3-url-row").toggle();
 				});


				// ADD FEATURED BLOCK
				//var fCount = 1;
				$("#addFeature").click(function(){
					//fCount = fCount + 1;
					var fCount = $("#fCount").attr('data-count')*1;
					//var fContent = $("#features").html();
					
					var fContent = '<div class="row"><div class="col-xs-12"><hr></div></div>\n\n';
					fContent = fContent + '<div class="row"><div class="col-xs-2">F' + fCount + ' Heading</div><div class="col-xs-10"><input type="hidden" name="featured['+ (fCount - 1) +'][id]"><input type="text" class="form-control" name="featured['+ (fCount -1) +'][heading]"></div></div>';
					fContent = fContent + '<div class="row"><div class="col-xs-2">F' + fCount + ' URL</div><div class="col-xs-8"><input type="text" class="form-control" name="featured['+ (fCount - 1) +'][url]" value=""></div><div class="col-xs-2"><select class="form-control" name="featured['+ (fCount - 1) +'][tab]"><option value="parent">Parent</parent><option value="new">New</option></select></div></div>';
					fContent = fContent + '<div class="row"><div class="col-xs-2">F' + fCount + ' Image</div><div class="col-xs-5"><input type="text" class="form-control" name="featured['+ (fCount - 1) +'][image]" value=""></div><div class="col-xs-5"><input type="file" class="form-control" name="featured['+ (fCount - 1) +'][image_file]"></div></div>';
					fContent = fContent + '<div class="row"><div class="col-xs-2">F' + fCount + ' Description</div><div class="col-xs-10"><textarea name="featured['+ (fCount - 1) +'][description]" rows="5" class="form-control"></textarea></div></div><br>';


					$("#features").append(fContent);
					$("#fCount").attr('data-count',fCount+1)

					//$("#features").html(fContent);
						
				});


				// FIND IMAGES IN FILE FOR EXPORT
				$('#listImages').click(function(){
					//$('#imagelist').html("");
					$('#imagelist').html( $( "#hiddenCode img" ).map(function() {
				    return "<div class='col-xs-3'><a href='" + $( this ).attr('src') +"' download><img src='" + $( this ).attr('src') +"' class='img-resonsive img-thumbnail' style='margin-bottom: 10px;' ></a></div>";
				  })
				  .get()
				  .join( "" )
						//$('#hiddenCode').children('img').map(function(){
				 //    	return $(this).attr('src')
					// }).get() 
					);
					//alert("were in");
				});
				
				


 			});


 		</script>
	</body>
</html>