jQuery(function($) {
	/* Side Nav Toggler */
	$(".navToggle").on("click", function(e){
		e.preventDefault();
		$(this).toggleClass("is-open");
		$("nav").toggleClass("is-open");
		$("body").toggleClass("nav-open");
		
		$(".searchToggle, #quicksearch").removeClass("is-open");
		
	});
	
	$(".searchToggle").on("click", function(e){
		e.preventDefault();
		$(this).toggleClass("is-open");
		$("#quicksearch").toggleClass("is-open");
		
		$("nav, .navToggle").removeClass("is-open");
		$("body").removeClass("nav-open");
	});
});