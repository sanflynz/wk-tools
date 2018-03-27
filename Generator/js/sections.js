// Sections
// 

$("#addSection").click(function(){
	
	// count how many sections exist
	var count = 0;
	$("div.section").each(function(){
		count = count + 1;
	});
	
	// get the data from the modal
	var sectiontype = $("#sectiontype").val();
	var sectionname = $("#sectionname").val();
	
	if(sectiontype != "" && sectionname != ""){
		// var types = {
		// 	"HDI":"Templates/sections/edit/hdi.php",
		// };


		// if not the first section...
		if(count > 0){
			nextcount = count + 1;
			$("#sections div.section:last-child").after($('<div class="section" data-section="' + nextcount + '">').load("Templates/sections/edit/" + sectiontype + ".php?sid=" + nextcount, function(){
				//console.log($("#sections").html());
				$("div[data-section=" + nextcount + "] h4").text(sectionname);
				$("#section-" + nextcount + "-name").val(sectionname);
				$("#section-" + nextcount + "-type").val(sectiontype);

				$(".section-layout-hdi-selector").click(function(){
					var layout = $(this).data("layout");
					var sectionid = $(this).data("sectionid");
					//console.log("layout: " + layout + ", sectionid: " + sectionid);
					$("#section-" + sectionid + "-settings-layout").val(layout);
					$("#section-" + sectionid + "-settings-layout-text").text(layout);

					$("#section-layout-hdi").modal('toggle');
				});
			}));
		}
		else{
			nextcount = 1;
			$("#sections").html($('<div class="section" data-section="' + nextcount + '">').load("Templates/sections/edit/" + sectiontype + ".php?sid=" + nextcount, function(){
				//console.log($("#sections").html());
				$("div[data-section=" + nextcount + "] h4").text(sectionname);
				$("#section-" + nextcount + "-name").val(sectionname);
				$("#section-" + nextcount + "-type").val(sectiontype);

				$(".section-layout-hdi-selector").click(function(){
					var layout = $(this).data("layout");
					var sectionid = $(this).data("sectionid");
					//console.log("layout: " + layout + ", sectionid: " + sectionid);
					$("#section-" + sectionid + "-settings-layout").val(layout);
					$("#section-" + sectionid + "-settings-layout-text").text(layout);

					$("#section-layout-hdi").modal('toggle');
				});
			}));

		}


		
		


		// close the modal
		$('#addSectionDialog').modal('toggle');
	}
}); 



// Section type = hdi

