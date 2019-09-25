(function($){
    
 $(document).ready(function(){
    $('.sidenav').sidenav();
		$('.dropdown-trigger').dropdown();
		$('.tabs').tabs();
		$('select').formSelect();
  });
    
    
    
  
	var message = localStorage.getItem("messages");
	if(message !== null && message != '' && JSON.parse(message).message){
		message = JSON.parse(message);
		M.toast({html: message.message, classes: message.type});
		localStorage.setItem("messages", '');
	}
	function previewImage(input, element = '.preview-image', width = '200px') {
	  if (input.files && input.files[0]) {
	  	var file = input.files[0];
	  	if (file.type.match('image.*')) {
		    var reader = new FileReader();
		    reader.onload = function (e) {
		    	$(element).html('<img src="'+e.target.result+'" width="'+width+'" alt="" />');
		    }
	      reader.readAsDataURL(input.files[0]);
	    }
	  }
	}
	$(".close-wrapper .close").on("click", function(e){
		$(this).parents(".close-wrapper").slideUp(400, function() {
		  $(this).remove();
		});
	});
		
		
		
		
		
	 
})(jQuery);