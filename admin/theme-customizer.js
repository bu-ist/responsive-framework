jQuery( document ).ready(function($) {


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
	
	$(".wp-color-result").on("click", function(){
		$(this).siblings(".color-picker").show();
		$(this).siblings(".iris-picker").show();
		$(this).siblings(".wp-color-close").show();
	});
	$(".wp-color-close").on("click", function(){
		$(this).siblings(".iris-picker").hide();
		$(this).siblings(".color-picker").hide();
		$(this).hide();
	});
	
	
	$("#burf_section_colors input").on("change", function(){
		$value = $(this).val().split(',');
		console.log($value);
		
		$("#burf_section_custom li").each(function(index){
			console.log($value[index]);
			$(this).find(".color-picker").iris('color', $value[index]);
		});
		
		
	});

	
	$("#advanced-color, #basic-color").on("click", function(){
		$("#burf_section_colors").toggle();
		$("#burf_section_custom").toggle();
		
		$("#basic-color").toggle();
		$("#advanced-color").toggle();
	});
	
	
	
	/*
	$("#burf_section_colors input").on("change", function(){
		$value = $(this).val().split(',');
		
		$("#accordion-section-burf_section_colors .customize-control-color").each(function(index, el){
			$(el).find(".color-picker-hex").iris('color', $value[index]);
		});
	});
*/

});