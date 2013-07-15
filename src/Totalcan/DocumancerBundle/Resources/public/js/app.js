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
});

