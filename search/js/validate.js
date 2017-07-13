      
      // Gets the Word Count of a String
      function getWordCount(string){
        return string.match(/\S+/g).length;
      } 
      // Adds the method to check for invalid characters. 
      jQuery.validator.addMethod("invalidChar",
        function(value, element){
          return this.optional(element) || /^[^,\\\/|~`!?><'"&$%]+$/.test(value)
        }, "The following characters are not allowed: ,\\|/~`!?><'\"&$%");

      // Adds the method to check for a max word count
      jQuery.validator.addMethod("maxWordCount",
        function(value, element, params) {
          var count = getWordCount(value);
          if(count <= params) {
             return true;
          }
        }, "Your essay is too long. ");
      
      // Adds the method to check for a minimum word count      
      jQuery.validator.addMethod("minWordCount",
        function(value, element, params) {
          var count = getWordCount(value);
          if(count >= params) {
             return true;
          }
        }, "Your essay is too short. ");

      // Adds the method to check for filesize
      jQuery.validator.addMethod("maxFileSize",
        function(value, element, params){
          return this.optional(element) || (element.files[0].size <= params) 
        }, jQuery.validator.format("Maximum File Size: {0} bytes"));
      /* 
        Validates the form live, does the styling with bootstrap. 
        Validates a given input field on de-focus initially. After an input field is validated, the field is revalidated on key-up
        Uses the jQuery.validator library
      */
      $('form:not(.novalidate)').validate({
        // On Error, Add the Error glyphicon and the error class for the red highlight
        highlight: function(element) {
          $(element).closest('.form-group').removeClass('has-success').addClass('has-error has-feedback');
          if($(element).siblings('span.glyphicon').length){  
            $(element).siblings('span.glyphicon').removeClass('glyphicon-ok').addClass('glyphicon-remove');
          }
          else{
            $(element).after('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
          }
        },
        // On Success, replace Error glyphicon with Success glyphicon, and replace error class for success
        success: function(element) {
          $(element).closest('.form-group').removeClass('has-error').addClass('has-success has-feedback');
          if($(element).siblings('span.glyphicon').length){ 
            $(element).siblings('span.glyphicon').removeClass('glyphicon-remove').addClass('glyphicon-ok');
          }
          else{
            $(element).after('<span class="glyphicon glyphicon-ok form-control-feedback"></span>');
          }
        },
        // This is the fix if there is an input-group
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
          if(element.parent('.input-group').length) {
              error.insertAfter(element.parent());
          } else {
              error.insertAfter(element);
          }
        }
      });