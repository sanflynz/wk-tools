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

 				// CONFERENCE _E PAGE
 				$('#base-email-footer').click(function(){
 					var footerBase = '<table align="center" border="0" cellpadding="0" cellspacing="0" style="font-family: Arial, sans-serif; font-size: 13px; line-height: 22px; color: #333333;" width="600">\n';
					footerBase = footerBase + '\t<tbody>\n';
					footerBase = footerBase + '\t\t<tr>\n\n';
					footerBase = footerBase + '<!--########### Secondary Message two column - Left column ###################-->\n\n';
					footerBase = footerBase + '\t\t\t<td bgcolor="#f3f3f3" style="border-right-width: 4px; border-right-style: solid; border-right-color: #FFF; padding: 10px; font-family: Arial, sans-serif; font-size: 12px; line-height:18px; color: #333333;padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 10px;" valign="top" width="50%">\n';
					footerBase = footerBase + '\t\t\t\t<a href="#" target="_blank"><img align="right" alt="Thermo Fisher Scientific" border="0" height="120" src="#" style="margin: 0px 0px 0px 5px" width="85" /></a>';
					footerBase = footerBase + '<span style="color: #ee3134; font-weight: bold; font-size: 14px">Sub-heading Here</span><br />\n';
					footerBase = footerBase + '\t\t\t\tlorem ipsum here.<br />\n';
					footerBase = footerBase + '\t\t\t\t<a href="#" style="color: #6caae3;text-decoration:underline;" target="_blank">Find out more »</a>\n';
					footerBase = footerBase + '\t\t\t</td>\n\n';
					footerBase = footerBase + '<!--########### Secondary Message two column - Right column ###################-->\n\n';
					footerBase = footerBase + '\t\t\t<td bgcolor="#f3f3f3" style="border-left-width: 4px; border-left-style: solid; border-left-color: #FFF; padding: 10px; font-family: Arial, sans-serif; font-size: 12px; line-height:18px; color: #333333;padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 10px;" valign="top" width="50%">\n';
					footerBase = footerBase + '\t\t\t\t<a href="#" target="_blank"><img align="right" alt="Thermo Fisher Scientific" border="0" height="120" src="#" style="margin: 0px 0px 0px 5px" width="85" /></a>';
					footerBase = footerBase + '<span style="color: #ee3134; font-weight: bold; font-size: 14px">Sub-heading Here</span><br />\n';
					footerBase = footerBase + '\t\t\t\tlorem ipsum here.<br />\n';
					footerBase = footerBase + '\t\t\t\t<a href="#" style="color: #6caae3;text-decoration:underline;" target="_blank">Find out more »</a>\n';
					footerBase = footerBase + '\t\t\t</td>\n\n';
					footerBase = footerBase + '\t\t</tr>\n\n';
					footerBase = footerBase + '\t</tbody>\n';
					footerBase = footerBase + '\t</table>\n';

					$('#email_footer').html(footerBase);
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