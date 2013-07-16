/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
   $('.newDoc').click(function(){
       window.location = 'http://mancer.ru/app_dev.php/documancer/document/new';
   });

   $('#switch_user').click(function(){
       return false;
   });

   $('#switch_user_submit').click(function(){
       window.location = 'http://mancer.ru/app_dev.php/?_change_user='+$('#switch_user').val();
       return false;
   });

   $('#newClientButton').click(function(){
       $('#newClientForm').stop().slideToggle();
   });

   $('#loadClientButton').click(function(){
       window.location = 'http://mancer.ru/app_dev.php/wizard/client/'+$('#appendedInputButton').val();
       return false;
   });

   $('#editClientButton').click(function(){
       $('#editClientForm').stop().slideToggle();
   });

   $('#newDesignButton').click(function(){
       $('#newDesignForm').stop().slideToggle();
   });

   $('#loadDesignButton').click(function(){
       window.location = 'http://mancer.ru/app_dev.php/wizard/client/'+$('#appendedInputButton').val();
       return false;
   });

   $('#editDesignButton').click(function(){
       $('#editDesignForm').stop().slideToggle();
   });

   $('#newTemplateButton').click(function(){
       $('#newTemplateForm').stop().slideToggle();
   });

   $('#loadTemplateButton').click(function(){
       window.location = 'http://mancer.ru/app_dev.php/wizard/client/'+$('#appendedInputButton').val();
       return false;
   });

   $('#editTemplateButton').click(function(){
       $('#editTemplateForm').stop().slideToggle();
   });

});

