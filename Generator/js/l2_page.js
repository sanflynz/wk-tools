console.log("Loaded L2 page js");

// function toggleFeatureArrows(table){
// 	var fCount = table.find('tr').length;
	
// 	table.find('tr').each(function(i){
// 		var x = i + 1;
// 		if(x == 1){
// 			$(this).find(".feature-up").addClass("disabled");
// 		}
// 		if(fCount > 1 && x > 1){
// 			$(this).find(".feature-up").removeClass("disabled");
// 		}
// 		if(fCount > 1 && x < fCount){
// 			$(this).find(".feature-down").removeClass("disabled");
// 		}
// 		if(x == fCount){
// 			$(this).find(".feature-down").addClass("disabled");
// 		}
		
// 	});
// }
// function reorderFeatures(table){
// 	table.find('tr').each(function(i){
// 		var x = i + 1;
// 		var old = $(this).find('.category-list-order').val();
// 		console.log('reordering: ' + old + ' to ' + x);
// 		$(this).find(".category-list-order").val(x);
// 	});
// }
// 
function toggleSectionArrows(){
	var fCount = $('#sections').find('.section').length;
	
	$('#sections').find('.section').each(function(i){
		console.log(fCount + ":" + i);
		//var x = i + 1;
		if(i == 0){
			$(this).find(".section-up").addClass("disabled");
		}
		if(fCount > 1 && i > 0){
			$(this).find(".section-up").removeClass("disabled");
		}
		if(fCount > 1){
			console.log("removed disabled down");
			$(this).find(".section-down").removeClass("disabled");
			//$(this).find(".section-down").addClass("btn-danger");
		}
		if(i == (fCount - 1)){
			$(this).find(".section-down").addClass("disabled");
		}
		
	});
}
function reorderSections(){
	$('#sections').find('.section').each(function(i){
		//console.log("reordering..." + i)
		// var x = i + 1;
		// var old = $(this).find('.category-list-order').val();
		// console.log('reordering: ' + old + ' to ' + x);
		$(this).find('.section-order').val(i);
	});
}

// TODO:  Add scrolling: https://www.abeautifulsite.net/smoothly-scroll-to-an-element-without-a-jquery-plugin-2
$("#sections").on("click",".section-up", function(){
	console.log("Clicked section up!");
  	var $current = $(this).closest('.section');
  	var $previous = $current.prev('.section');
  	if($previous.length !== 0){
    	$current.insertBefore($previous);
    	
    	//var table = $(this).closest('.table');
    	reorderSections();
    	toggleSectionArrows();
  	}
  	return false;
});
$("#sections").on("click",".section-down", function(){
	console.log("Clicked section down!!");
  	var $current = $(this).closest('.section');
  	var $next = $current.next('.section');
  	if($next.length !== 0){
    	$current.insertAfter($next);
    	
		//var table = $(this).closest('.table');
    	reorderSections();
    	toggleSectionArrows();
  	}
  	return false;
});		


// $(".section").on("click",".feature-up", function(){
// 	console.log("Clicked up!");
//   	var $current = $(this).closest('tr')
//   	var $previous = $current.prev('tr');
//   	if($previous.length !== 0){
//     	$current.insertBefore($previous);
    	
//     	var table = $(this).closest('.table');
//     	//reorderFeatures(table);
//     	toggleFeatureArrows(table);
//   	}
//   	return false;
// });

// $(".section").on("click",".feature-down", function(){
// 	console.log("Clicked down!!");
//   	var $current = $(this).closest('tr')
//   	var $next = $current.next('tr');
//   	if($next.length !== 0){
//     	$current.insertAfter($next);
    	
// 		var table = $(this).closest('.table');
//     	//reorderFeatures(table);
//     	toggleFeatureArrows(table);
//   	}
//   	return false;
// });					


// $(".section").on("click", ".feature-delete", function(){
// 	//console.log ("deleting stuff...");
// 	if(confirm('Are you sure you want to delete this feature?')){
// 		var $current = $(this).closest('tr')
// 		var table = $(this).closest('.table');

// 		$current.remove();
		
//     	//reorderFeatures(table);
//     	toggleFeatureArrows(table);
// 	}			
// });

$("#add-category-list").click(function(){
	console.log("adding list item");

	var catN = $(this).closest('.table').prev('.table').find('tr').length + 1;
	var sN = $(this).closest('.section').find('.section-order').val();

	var cat = '<tr><td>' +
			'Item ' + catN + '<br>' + 
			'<button type="button" class="btn btn-default btn-sm feature-up" title="Move up"><i class="fa fa-arrow-up"></i></button> ' +
			'<button type="button" class="btn btn-default btn-sm feature-down" title="Move down"><i class="fa fa-arrow-down"></i></button> ' +
			'<button type="button" class="btn btn-default btn-sm feature-delete" title="Delete"><i class="fa fa-trash"></i></button>' +
			'</td><td>' +
			'<div class="row" >' +
				'<div class="col-md-6">' +
					'<div class="input-group" style="margin-bottom: 5px; !important;">' +
						'<span class="input-group-addon">Heading</span>' +
						'<input type="text" name="section[' + sN + '][content][items][' + catN + '][heading]" class="form-control" value="">' + 
					'</div>' +
					
					'<div class="input-group" style="margin-bottom: 5px; !important;">' + 
						'<span class="input-group-addon">URL</span>' + 
						'<input type="text" name="section[' + sN + '][content][items][' + catN + '][url]" class="form-control" value="">' +
					'</div>' +
					'<div class="input-group" style="margin-bottom: 5px; !important;">' +
						'<span class="input-group-addon">tab</span>' +
						'<select name="section[' + sN + '][content][items][' + catN + '][tab]" id="" class="form-control">' +
							'<option value="parent">Parent</option>' +
							'<option value="new">New</option>' +
						'</select>' +
					'</div>' +
				'</div>' +
				'<div class="col-md-6">' +
					'<textarea name="section[' + sN + '][content][items][' + catN + '][copy]" id="" rows="5" class="form-control" placeholder="Copy..."></textarea>' +
				'</div>' +
			'</div>' +
			'</td></tr>';



		$(this).closest(".table").prev('.table').append(cat);

		var table = $(this).closest('.table').prev('.table');
	    //reorderFeatures(table);
	    toggleFeatureArrows(table);
});


$('.add-resource-link').click(function(){
	console.log("adding link");
	var sid = $(this).closest('.section').find('.section-order').val();
	var cid = $('.add-resource-link').index(this);
	var lid = $(this).siblings('.resource-links').find('.resource-link-item').length;
	console.log("cid: " + cid);
	var link = '<div class="resource-link-item">' +
			'<input type="text" name="section['+sid+'][content]['+cid+'][link]['+lid+'][icon]" value="" size="10" placeholder="icon">' +
			'<input type="text" name="section['+sid+'][content]['+cid+'][link]['+lid+'][name]" value="" size="10" placeholder="name" autocomplete="foo">' +
			'<input type="text" name="section['+sid+'][content]['+cid+'][link]['+lid+'][url]" value="" size="10" placeholder="url">' + 
			'<input type="text" name="section['+sid+'][content]['+cid+'][link]['+lid+'][tab]" value="" size="10" placeholder="tab">' +
			'<input type="text" name="section['+sid+'][content]['+cid+'][link]['+lid+'][tracking][category]" value="" size="10" placeholder="trk category">' + 
			'<input type="text" name="section['+sid+'][content]['+cid+'][link]['+lid+'][tracking][action]" value="" size="10" placeholder="trk caction">' +
			'<input type="text" name="section['+sid+'][content]['+cid+'][link]['+lid+'][tracking][label]" value="" size="10" placeholder="trk label">' + 
			'' +
			'</div>';
	$(this).siblings('.resource-links').append(link);
	// launch modal
	// 
});

// L3 INDEX PAGE

// toggle import-old-container
// $("#l1-import-old-toggle").click(function(){
// 	$("#import-old-container").toggle();
// });

// toggle import-old-container
$('.import-toggle').click(function(){
	console.log("clicked!!");
	//$('#import-type').val($(this).data('type'));
	$('#import-container').toggle();


});

$("#import-container").on("change","#import-type", function(){
	
	console.log("changing!");
	$('.import-settings').hide();
	$('#' + $(this).val() + '-settings').show();

});

// // redirect to the edit page and import
// $("#l1-import-old-button").click(function(){
// 	var url = encodeURIComponent($("#l1-import-old-url").val());
// 	window.location.href = "l2page_e.php?import=old&url=" + url;
// });

// // redirect to the edit page and import
// $("#l2-import-old-button").click(function(){
// 	var url = encodeURIComponent($("#l2-import-old-url").val());
// 	window.location.href = "l2page_e.php?import=old&url=" + url;
// });