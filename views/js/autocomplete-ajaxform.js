$(document).ready(function(){
   $('.autocomplete-form').on('submit', function(e){
      if (true === $(this).hasClass('autocomplete-ajax')){
          e.preventDefault();
          var form = $(this)[0];
          var action = form.action;
          var formData = new FormData(form);
          sendAjax(action, formData);
      }
   });

   $(document).on('click', '#autocomplete-save-form', function(){
     var action = $(this).data('link');
     var formData = [];
      $('.autocomplete-input-form').each(function(){
         formData.push( { name: $(this).attr('name'), value: $(this).val()});
      });
     sendAjax(action, formData);
   });

   function sendAjax(action, formData){
       var obj = {};
       if(formData instanceof FormData){
           obj = {processData: false, contentType: false}
       }
       $.ajax($.extend({
           type: "POST",
           url: action,
           data: formData,
           dataType: 'json',
           async: true,
           cache: false,
           success: function(response)
           {
               if(typeof response.message !== 'undefined' ){
                   if(typeof response.status !== 'undefined' && response.status === 'ok'){
                       showSuccessMessage(response.message);
                       return;
                   }else if(typeof response.status !== 'undefined' && response.status !== 'ok'){
                       showErrorMessage(response.message);
                       return;
                   }
               }
               if(typeof response.callback !== 'undefined' && typeof window[response.callback] === "function"){
                   window[response.callback](response);
               }
           }
       }, obj))
   }
});