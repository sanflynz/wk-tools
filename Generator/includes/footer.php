</div>



<!-- jQuery -->
<script src="../__resources/js/jquery-2.1.4.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="../__resources/js/bootstrap.min.js" ></script>	
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/sections.js" ></script>	
<script src="js/wysiwyg-toolbar.js" ></script>
<!-- <script src="js/file-upload.js" ></script> -->
<script src="js/l2_page.js" ></script>
<script>
$(document).ready(function() {
	
	// FILE INPUT GROUPS
	$(".file-toggle").click(function(){
		$(this).closest('.file-group').find('.input-group').toggle();
	});

	$('.file-cancel').click(function(){
		console.log("emptying...");
		$(this).closest('.file-group').find(':file').val('');
		$(this).closest('.file-group').find('.file-text').val('');
	});

	$('.file-group').on('change', (':file'), function(){
		var target = $(this).val().replace(/\\/g, '/').replace(/.*\//, '');
		$(this).closest('.file-group').find('.file-text',0).val(target);
	});

	$('.file-dialog').click(function(){
		//console.log("Check: " + $(this).closest('.file-group').find('.file-text',0).val("Stuff and things "));
		var file = $(this).closest('.file-group').find(':file');
		file.trigger("click", function(){
			console.log("clicked!!");
			
		});
		//$("input").trigger("click");
	});



	// L3 PAGES

	function toggleFeatureArrows(){
		console.log("We're checking arrows!")
		var fCount = $(".featured-category").length;
		$(".featured-category").each(function(i){
			var x = i + 1;
			if(x == 1){
				$(this).find(".feature-up").addClass("disabled");
			}
			if(fCount > 1 && x > 1){
				$(this).find(".feature-up").removeClass("disabled");
			}
			if(fCount > 1 && x < fCount){
				$(this).find(".feature-down").removeClass("disabled");
			}
			if(x == fCount){
				$(this).find(".feature-down").addClass("disabled");
			}
		});
	}
	function reorderFeatures(){
		$(".featured-category").each(function(i){
			var x = i + 1;
			$(this).find(".feature-order").val(x);
		});
	}

	
	$("#features").on("click",".feature-up", function(){
		console.log("Clicked up!");
	  	var $current = $(this).closest('div.featured-category')
	  	var $previous = $current.prev('div.featured-category');
	  	if($previous.length !== 0){
	    	$current.insertBefore($previous);
	    	
	    	reorderFeatures();
			toggleFeatureArrows();
	  	}
	  	return false;
	});

	$("#features").on("click",".feature-down", function(){
		console.log("Clicked down!!");
	  	var $current = $(this).closest('div.featured-category')
	  	var $next = $current.next('div.featured-category');
	  	if($next.length !== 0){
	    	$current.insertAfter($next);
	    	
			reorderFeatures();
			toggleFeatureArrows();
	  	}
	  	return false;
	});					
	

	$("#features").on("click", ".feature-delete", function(){
		//console.log ("deleting stuff...");
		if(confirm('Are you sure you want to delete this feature?')){
			// get the feature id 	
			
			var $current = $(this).closest('div.featured-category');
			var featureID = $current.find(".feature-id").val();

			console.log(" Deleting feature id: " + featureID);
		  	if(featureID > 0){
		  		$.ajax({
			      url: 'l3page_feature_d.php',
			      type: 'post',
			      data: {'id': featureID },
			      success: function(data, status) {
			      	console.log("Delete data: " + data);
			        if(data == "success") {
			        	$current.remove();
			        }
			      },
			      error: function(xhr, desc, err) {
			        console.log(xhr);
			        console.log("Details: " + desc + "\nError:" + err);
			      }
			    }); 
		  		// if success remove current
        		//$current.remove();
        		
		  	}
		  	else {
		  		$current.remove();
		  	}
		  	// reorder
		  	reorderFeatures();
		  	toggleFeatureArrows();
		}			
	});

	// // Move features
	// moveFeatures();		

	// // Delete features
	// deleteFeature();

	// ADD FEATURED BLOCK
	$("#addFeature").click(function(){
		
		var fCount = $(".featured-category").length + 1;
		
		var fContent = '<div class="featured-category"><div class="row"><div class="col-xs-12"><hr></div></div>';
		fContent += '<div class="row"><div class="col-xs-2">F' + fCount + ' Heading</div><div class="col-xs-10"><input type="hidden" name="featured['+ (fCount - 1) +'][id]" class="feature-id"><input type="text" name="featured['+ (fCount - 1) +'][order]" value="'+ fCount +'" class="feature-order"><input type="text" class="form-control" name="featured['+ (fCount -1) +'][heading]"></div></div>';
		fContent += '<div class="row"><div class="col-xs-2">F' + fCount + ' URL</div><div class="col-xs-8"><input type="text" class="form-control" name="featured['+ (fCount - 1) +'][url]" value=""></div><div class="col-xs-2"><select class="form-control" name="featured['+ (fCount - 1) +'][tab]"><option value="parent">Parent</parent><option value="new">New</option></select></div></div>';
		fContent += '<div class="row"><div class="col-xs-2">F' + fCount + ' Image</div><div class="col-xs-5"><input type="text" class="form-control" name="featured['+ (fCount - 1) +'][image]" value=""></div><div class="col-xs-5"><input type="file" class="form-control" name="featured['+ (fCount - 1) +'][image]"></div></div>';
		fContent += '<div class="row"><div class="col-xs-2">F' + fCount + ' Description</div><div class="col-xs-10"><textarea name="featured['+ (fCount - 1) +'][description]" rows="5" class="form-control"></textarea></div></div>' +
			'<div class="row"><div class="col-xs-2"></div><div class="col-xs-10">' +
			'<div class="alert alert-warning">' +
			'<button type="button" class="btn btn-default btn-sm feature-delete" title="Delete"><i class="fa fa-trash"></i></button> ' +
			'<button type="button" class="btn btn-default btn-sm feature-up disabled" title="Move up"><i class="fa fa-arrow-up"></i></button> ' +
			'<button type="button" class="btn btn-default btn-sm feature-down disabled" title="Move down"><i class="fa fa-arrow-down"></i></button>' +
			'</div></div><br>';

		$("#features").append(fContent);
		console.log(fContent);
		//reorderFeatures();
		toggleFeatureArrows();					

		// // Move features
		// moveFeatures();

		// // Delete function
		// deleteFeature();
	});



// COPY CODE FOR EXPORT PAGES
 			$("#copyCode").click(function(){
 				document.execCommand("copy");
 			});		

 			// ###### PROMO PODS PAGE ######
 				// Toggle upload window to show/hide (promopods)
 				$("#upload-toggle").click(function(){
					$("#uploadwindow").toggle();
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



 				// L3 INDEX PAGE

 				// toggle import-old-container
 				$("#import-old-toggle").click(function(){
 					$("#import-old-container").toggle();
 				});

 				// redirect to the edit page and import
 				$("#import-old-button").click(function(){
 					var url = encodeURIComponent($("#import-old-url").val());
 					window.location.href = "l3page_e.php?import=old&url=" + url;
 				});

			
				// FIND IMAGES IN FILE FOR EXPORT
				// $('#listImages').click(function(){
				// 	//$('#imagelist').html("");
				// 	$('#imagelist').html( $( "#hiddenCode img" ).map(function() {
				//     return "<div class='col-xs-3'><a href='" + $( this ).attr('src') +"' download><img src='" + $( this ).attr('src') +"' class='img-resonsive img-thumbnail' style='margin-bottom: 10px;' ></a></div>";
				//   })
				//   .get()
				//   .join( "" )
				// 		//$('#hiddenCode').children('img').map(function(){
				//  //    	return $(this).attr('src')
				// 	// }).get() 
				// 	);
				// 	//alert("were in");
				// });
});
 		</script>
	</body>
</html>