jQuery(function($) {
	/* Side Nav Toggler */
	$(".navToggle").on("click", function(){
		$(this).toggleClass("open");
		$("nav").toggleClass("open");
		
		$(".searchToggle, .quicksearch").removeClass("open");
	});
	
	$(".searchToggle").on("click", function(){
		$(this).toggleClass("open");
		$(".quicksearch").toggleClass("open");
		
		$("nav, .navToggle").removeClass("open");
	});
});