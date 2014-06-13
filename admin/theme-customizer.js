jQuery( document ).ready(function($) {

	/* - - - - - Section: Font Colors - - - - - */ 
	
	/* Initializing the color pickers */
	if($('.color-picker').length > 0){
		$('.color-picker').iris({
			color: $(this).val(),
			change: function(event, ui){
				$(event.target).val(ui.color.toString()).change();
				$(this).prev(".wp-color-result").css("background-color", ui.color.toString());
				
				
				var tempArray = [];
				$("#burf_section_custom .color-picker").each(function(el, le){
					//console.log(le);
					tempArray.push($(this).val());
				});
				$("#hiddenColor").attr("value", tempArray.join(",")).change();
			}
		});
	}
	
	/* Open the color pickers on Resultbox Click*/
	$(".wp-color-result").on("click", function(){
		$(this).siblings(".color-picker").show();
		$(this).siblings(".iris-picker").show();
		$(this).siblings(".wp-color-close").show();
	});
	/* And close them with the close button */
	$(".wp-color-close").on("click", function(){
		$(this).siblings(".iris-picker").hide();
		$(this).siblings(".color-picker").hide();
		$(this).hide();
	});
	
	/* Generate the hidden input's string */
	$("#burf_section_colors input").on("change", function(){
		$value = $(this).val().split(',');
				
		$("#burf_section_custom li").each(function(index){
			console.log($value[index]);
			$(this).find(".color-picker").iris('color', $value[index]);
		});
	});

	/* Toggling between Baic and Advanced */
	$("#basic-color").on("click", function(){
		$("#burf_section_colors").show();
		$("#burf_section_custom").hide();
		
		$("#basic-color").hide();
		$("#advanced-color").show();
	});
	$("#advanced-color").on("click", function(){
		$("#burf_section_colors").hide();
		$("#burf_section_custom").show();
		
		$("#basic-color").show();
		$("#advanced-color").hide();
	});
	
	


	/* - - - - - Section: Background Options - - - - - */ 
	/* Pre-opened color picker */
	if($('.color-picker-open').length > 0){
		$('.color-picker-open').iris({
			color: $(this).val(),
			hide: false,
			change: function(event, ui){
				$(event.target).val(ui.color.toString()).change();
				$(this).prev(".wp-color-result").css("background-color", ui.color.toString());
			}
		});
		
	}

	$("#bg-toggle-color").on("click", function(){
		$("#bg-toggle-image").removeClass("active");
		$(this).addClass("active");
		$("#accordion-section-burf_section_background li:gt(0)").hide();
		$("#accordion-section-burf_section_background #bg-color").show();
	});
	
	$("#bg-toggle-image").on("click", function(){
		$("#bg-toggle-color").removeClass("active");
		$(this).addClass("active");
		$("#accordion-section-burf_section_background li:gt(0)").show();
		$("#accordion-section-burf_section_background #bg-color").hide();
	});


});