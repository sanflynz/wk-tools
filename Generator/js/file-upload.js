/* ========================================================================
 * Generator
 * File uploads
 * ======================================================================== */

 	// FILE UPLOAD BLOCK TOGGLE VIBILITY
  	// ================================

// $('[data-switch="file-upload"]').click(function() {
// 	console.log("clicked it!");
// 	$(this).closest(".file-upload-controls").children('.file-upload-group').toggle();
// });

$(document).on('change', ':file', function() {
	var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	input.trigger('fileselect', [numFiles, label]);
	console.log(label);
	$(this).closest('.input-group').children('input[readonly]').val(label);
});