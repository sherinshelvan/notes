var formData = new FormData($('#calendar_form')[0]);
formData.append('type', type);
formData.append('action', action);
$.ajax({
	url    		: url,
	data 		: formData,
	cache 		: false,
processData : false,
contentType : false,
type 		: 'POST',
xhr: function(){
		//upload Progress
		var xhr = $.ajaxSettings.xhr();
		if (xhr.upload) {
			xhr.upload.addEventListener('progress', function(event) {
				var percent = 0;
				var position = event.loaded || event.position;
				var total = event.total;
				if (event.lengthComputable) {
					percent = Math.ceil(position / total * 100);
				}
				// update progressbar
				//$(".calender-loading").css("width", + percent +"%");
				//$(".calender-loading").text(percent +"%");
			}, true);
		}
		return xhr;
	},
	mimeType:"multipart/form-data"
})
.done(function(res){
	res = JSON.parse(res);

}); 