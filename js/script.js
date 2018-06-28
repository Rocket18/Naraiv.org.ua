$(document).ready(function(){
	$(".img_p").hover(function(){
		$(".img_icon",this).css("display","block");
		$("img",this).animate({opacity:"0.6"},{queue:true,duration:200})},
		function(){
		$(".img_icon",this).css("display","none");
		$("img",this).animate({opacity:"1"},{queue:true,duration:300})})					
function lightboxPhoto() {
	
	$("a[rel^='prettyPhoto']").prettyPhoto({
			animationSpeed:'fast',
			slideshow:5000,
			theme:'light_rounded',
			show_title:false,
			overlay_gallery: false
		});
	
	}
	
		if($().prettyPhoto) {
	
		lightboxPhoto(); 
			
	}
	
/*	
if ($().quicksand) {

 	// Clone applications to get a second collection
	var $data = $("#gallery ul").clone();
	
	//NOTE: Only filter on the main portfolio page, not on the subcategory pages
	$('#cat_photo li').click(function(e) {
		$("#cat_photo li").removeClass("active");	
		// Use the last category class as the category to filter by. This means that multiple categories are not supported (yet)
		var filterClass=$(this).attr('class').split(' ').slice(-1)[0];
		
		if (filterClass == 'all') {
			var $filteredData = $data.find('.img_p');
		} else {
			var $filteredData = $data.find('.img_p[data-type=' + filterClass + ']');
		}
		$("#gallery ul").quicksand($filteredData, {
			duration: 600,
			adjustHeight: 'auto'
		}, function () {

				lightboxPhoto();
						});		
		$(this).addClass("active"); 			
		return false;
	});
	
}//if quicksand*/

});