/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function wrap(tag) {
    var sel, range;
    var selectedText;
    if (window.getSelection) {
        sel = window.getSelection();

        if (sel.rangeCount) {
            range = sel.getRangeAt(0);
            selectedText = range.toString();
            range.deleteContents();
            range.insertNode(document.createTextNode('[' + tag + ']' + selectedText + '[/' + tag + ']'));
        }
    }
    else if (document.selection && document.selection.createRange) {
        range = document.selection.createRange();
        selectedText = document.selection.createRange().text + "";
        range.text = '[' + tag + ']' + selectedText + '[/' + tag + ']';
    }

}

$(document).ready(function(){

$.fn.selectRange = function(start, end) {
    return this.each(function() {
        if(this.setSelectionRange) {
            this.focus();
            this.setSelectionRange(start, end);
        } else if(this.createTextRange) {
            var range = this.createTextRange();
            range.collapse(true);
            range.moveEnd('character', end);
            range.moveStart('character', start);
            range.select();
        }
    });
};

   $('.newDoc').click(function(){
       window.location = '/app_dev.php/documancer/document/new';
   });

   $('#switch_user').click(function(){
       return false;
   });

   $('#switch_user_submit').click(function(){
       window.location = '/app_dev.php/?_change_user='+$('#switch_user').val();
       return false;
   });

   $('#newClientButton').click(function(){
       $('#newClientForm').stop().slideToggle();
       return false;
   });

   $('#loadClientButton').click(function(){
       window.location = '/app_dev.php/wizard/client/'+$('#listClientButton').val();
       return false;
   });

   $('#editClientButton').click(function(){
       $('#editClientForm').stop().slideToggle();
   });

   $('#newDesignButton').click(function(){
       $('#newDesignForm').stop().slideToggle();
       return false;
   });

   $('#loadDesignButton').click(function(){
       window.location = '/app_dev.php/wizard/design/'+$('#listDesignButton').val();
       return false;
   });

   $('#editDesignButton').click(function(){
       $('#editDesignForm').stop().slideToggle();
   });

   $('#newTemplateButton').click(function(){
       $('#newTemplateForm').stop().slideToggle();
       return false;
   });

   $('#loadTemplateButton').click(function(){
       window.location = '/app_dev.php/wizard/template/'+$('#listTemplateButton').val();
       return false;
   });

   $('#editTemplateButton').click(function(){
       $('#editTemplateForm').stop().slideToggle();
   });

   $('#changeClientButton').click(function(){
       $('#selectClientForm').stop().slideToggle();
   });
   $('#changeDesignButton').click(function(){
       $('#selectDesignForm').stop().slideToggle();
   });
   $('#changeTemplateButton').click(function(){
       $('#selectTemplateForm').stop().slideToggle();
   });

   $('#fontBold').click(function(){
       
    });
});

