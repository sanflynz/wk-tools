</div>
		<!-- jQuery -->
		<script src="../__resources/js/jquery-2.1.4.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="../__resources/js/bootstrap.min.js" ></script>	
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
 		<script>
 			$(document).ready(function() {

 				
 				
 				// CONFERENCE_I PAGE
 				$('.setActiveConference').click(function() {
 					var cid = $(this).attr("data-conferenceId");
 					$.ajax({

 						type: "GET",
 						url: "ajax.php?activeConference=" + cid,
 						success: function(response){
 							window.location.href = "conference_v.php?id=" + cid;
 						}
 						
 					});
 				});

 				// CONFERENCE_I PAGE
 				$('#unsetActiveConference').click(function() {
 					$.ajax({

 						type: "GET",
 						url: "ajax.php?unsetActiveConference=true",
 						success: function(response){
 							location.reload();
 						}
 						
 					});
 				});


 				// CONFERENCE_V PAGE
 				$('#orderDownCp').click(function() {
					alert("raaaa");
					// $.ajax({

					// 	//type: "GET",
					// 	url: "ajax.php?cpOrder",
					// 	success: function(response){
					// 		$('#environmentToggle').html(response.toUpperCase());
					// 	}
						
					// });
				});	

 				$('#showAddGroup').click(function(){
 					$('#addGroupDiv').toggle();
 				});

 				$('.showAddProduct').click(function(){ // NOTEL class not id
 					var cg = $(this).attr("data-conferenceGroup");
 					$('[data-cgDivFor=' + cg + ']').toggle();
 					
 				});


 				$('#environmentToggle').click(function() {
 					$.ajax({

 						//type: "GET",
 						url: "ajax.php?environment=toggle",
 						success: function(response){
 							$('#environmentToggle').html(response.toUpperCase());
 						}
 						
 					});
 				});


 				// PRODUCT_E PAGE
 				$('#copyBtnText').click(function(){
 					var txt = $('#btn_landing').val();
 					$('#btn_email').val(txt);
 				});

 				$('#copyDesc').click(function(){
 					var txt = $('#desc_landing').val();
 					$('#desc_email').val(txt);
 				});
 				




 			});

 			


 		</script>
	</body>
</html>