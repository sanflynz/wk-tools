$("textarea.wysiwyg-editor").each(function() {
  var textareaid = $(this).attr("id");
  var toolbar = $(this).data("type");

  // insert the toolbar
  $(this).before('<div class="wysiwyg-toolbar">raaa</div>');

  $(this).parent().find(".wysiwyg-toolbar").load('Templates/toolbars/' + toolbar + '.php');
    
    // insert an editable div before the textarea
    $(this).before("<div class=\"wysiwyg-editor\" data-editortarget=\"" + textareaid + "\" contenteditable></div>");
    if($("#wysiwyg-modals").length == 0){
      $("body").prepend("<div id=\"wysiwyg-modals\"></div>");
    }
    $(this).hide();
  
  
});

$("div.wysiwyg-editor").focus(function(){
  activeEditor = $(this).data("editortarget");
  console.log("active editor: " + activeEditor);
});

$("div.wysiwyg-editor").mouseout(function(e){
  if($(this).is(':focus')){
    // upadate the textarea
    var target = $(this).data('editortarget');
    $("#" + target).html($(this).html());
  
    // get the caret position
    caretPos = 0;
    var sel, range;
    var el = document.querySelector("div[data-editortarget=" + activeEditor + "]");
    sel = window.getSelection();
    if (sel.rangeCount) {
      range = sel.getRangeAt(0);
      node = sel.anchorNode;
      //if (range.commonAncestorContainer.parentNode == el) {
        caretPos = range.endOffset;
      //}
    }
  }
});


$('.toolbar .tool').click(function(e) {

  var command = $(this).data('command');
   
  if (command == 'h1' || command == 'h2' || command == 'h3' || command == 'h4' || command == 'bold' || command == 'italic' || command == 'underline') {
    document.execCommand('formatBlock', false, command);
  }
   
  if (command == 'createlink' || command == 'insertimage') {
    url = prompt('Enter the link here: ','http:\/\/');
    document.execCommand($(this).data('command'), false, url);
  }

  if (command == 'insert-link') {
    command = 'insertHTML';

    $("#wysiwyg-modals").load("Templates/modals/wysiwyg-insert-link.php", function(){

      $("#wysiwyg-insert-link").modal('toggle');
      $("#insert-link-action").click(function(){
        var text = $("#insert-link-text").val();
        var url = $("#insert-link-url").val();
        var target = $("#insert-link-target").val();
        var type = $("#insert-link-type").val();
        var size = $("#insert-link-size").val();
        
        var html = '<a href="' + url + '"';
        if(type != ""){ html += 'class="btn ' + type + size + '"'; }
        if(target == "_blank") { html += ' target="_blank"'; } 
        html += '>' + text + '</a>';

        var range = document.createRange();
        var sel = window.getSelection();  //gets current position of caret
        range.setStart(node, caretPos);
        range.collapse(true);
        range.endOffset = caretPos;
        sel.removeAllRanges();
        sel.addRange(range);
            
        document.execCommand(command, false, html);
        console.log(html);
        $("#wysiwyg-insert-link").modal('toggle');

      });
    });
  }
   
  else document.execCommand($(this).data('command'), false, null);
   
});


// does this have to go last?
$('div[contenteditable]').keydown(function(e) {
    // trap the return key being pressed
    if (e.keyCode === 13) {
      // insert 2 br tags (if only one br tag is inserted the cursor won't go to the next line)
      document.execCommand('insertHTML', false, '<br>\n<br>\n');
      // prevent the default behaviour of return key pressed
      return false;
    }
  });

