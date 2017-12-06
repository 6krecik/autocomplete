$(document).ready(function(){
   $(document).on('submit', '.autocomplete-form', function(e){
      if (true === $(this).hasClass('autocomplete-ajax')){
          e.preventDefault();
          var form = $(this)[0]
          var action = form.action;
          console.log($(form));
          console.log(action);
          var formData = new FormData(form);
          sendAjax(action, formData);
      }
   });

   function sendAjax(action, formData){
       $.ajax({
           type: "POST",
           url: action,
           data: formData,
           dataType: 'json',
           processData: false,
           contentType: false,
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
           }
       })
   }
});