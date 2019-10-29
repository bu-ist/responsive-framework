jQuery( document ).ready(function() {//Getting an array of all the immigration fields we need to check

/*
now that you've done it the hard way, try it with xpath

public function parseContent()
	{
		$content = $this->getXpathContents('(//input[@class="gfield_radio"]/p)[2]');
		$this->content = trim_ws($content);
	}

*/

/**
   TODO: hide "based on our . . . messages " after a choice change. Same as unsetting form values


   */


var immigrationFieldsArray = new Array();
var startImmigrationFields = null;
function getWholeArray(startImmigrationFields) {
	//added two divs to bracket the immigration fields we need
	if (startImmigrationFields === null) {
		//this is the default starting field
		startImmigrationFields = jQuery('#field_44_473');
		if (startImmigrationFields === null) {
			startImmigrationFields = document.getElementById('field_44_473');
		}
	}
	//*[@id="field_44_473"]


	//alert(jQuery('#field_44_473'));
	//always end at this field
	//var endImmigrationFields = document.querySelector('#field_44_474');
	var endImmigrationFields = jQuery('#field_44_474');
	//endImmigrationFields.siblings().css( "background-color", "red" );
	//alert(endImmigrationFields.siblings().css( "background-color", "red" ) );
console.log(jQuery('#field_44_473').siblings());
	jQuery(startImmigrationFields).nextUntil(endImmigrationFields).each(function( index, name ) {
		//alert(startImmigrationFields + ' - ' + endImmigrationFields);
		var curChild = jQuery(name).children();
		console.log(curChild);
		var input_type;
		//some of the current looping is due to how GF lays out their forms
		//this can more than likely be refactored
		curChild.children().each(function( index, name1 ) {
		//gf also uses input fields unusually - this seems the easiest place to assess how to handle the input values as we assess them below
			if ( jQuery(name1).hasClass("gfield_radio") ) {
				input_type = 'radio';
				var getChoices = jQuery(name).find(jQuery('li'));
				var choicesArray = new Array();
				jQuery(getChoices).children('input').each(function( index, name2 ) {
					//this is the class of the individual radio choice
					choicesArray.push(jQuery(name2).prop('id'));

				});
				//our fields array is an array of many dimensions
				immigrationFieldsArray.push({
   							Name : jQuery(name).prop("id"),
    						Type : input_type,
    						Choices: choicesArray
				});

			} else {
				var choicesArray = new Array();
				//text fields may be other things so check
				if ( jQuery(name1).prop("type") == 'text'  ) {
					if ( jQuery(name1).hasClass("datepicker") ) {
						input_type = 'date';
					} else {
						input_type = jQuery(name1).prop("type");
					}
				} else {
					input_type = jQuery(name1).prop("type");
				}

				if (jQuery(name1).prop("name") !== undefined) {
						immigrationFieldsArray.push({
   							Name : jQuery(name).prop("id"),
    						Type : input_type,
    						Choices: choicesArray
						});
				}


			}

		});//hiding for the default state
		//jQuery(name).css("display", 'none');
	});


	//hide the submit button initally and any i20 messages
	hideImmgMessages();
	return immigrationFieldsArray;
	//immigrationFieldsArray is an array of the input names
}

function unsetInputs(immigrationFieldsArray, inputFieldStart){
	//as we go through, reset all fields below the starting field;
	//hide all the fields except those activated by the field choice
	var theIndex = 0;
	for (var i = 0; i < immigrationFieldsArray.length; i++) {
		if (immigrationFieldsArray[i].Name == inputFieldStart) {
			theIndex = i;
			//alert(inputFieldStart + ' ' + immigrationFieldsArray[i].Name);
			break;
		}
	}
	var start_index = jQuery.inArray(inputFieldStart, immigrationFieldsArray['name']);
	jQuery(immigrationFieldsArray).each(function( index, name ) {
	//IF INDEX is greater than the passed item index execute
	if ( index > theIndex) {
		var preserveName = name;
		jQuery.each(jQuery(name), function(index, value) {
			var input_field = value['Name'];
			var input_field = input_field.replace("field", "input");
			var input_display = value['Name'];

			if(value['Type'] == 'select-one'){
				//set the value
				jQuery(document.getElementById(input_field)).val('-- Please select --').prop('selected', true);
				//hide the field
				jQuery(document.getElementById(input_display)).css('display', 'none');
			}
			if (value['Type'] == 'text'){
				//set the value
				jQuery(document.getElementById(input_field)).prop('value', '');
				//hide the field
				jQuery(document.getElementById(input_display)).css('display', 'none');

			}
			if (value['Type'] == 'date'){
				//set the value
				jQuery(document.getElementById(input_field)).prop('value', '');
				//hide the field
				jQuery(document.getElementById(input_display)).css('display', 'none');

			}
			if (value['Type'] == 'radio'){
				//set the value
				jQuery( jQuery(value['Choices']) ).each(function( index, name ) {
					/*console.dir(jQuery('#' + name));*/
					jQuery('#' + name).prop('checked', false);
				});

				//hide the field
				jQuery(document.getElementById(input_display)).css('display', 'none');

			}

		});
	}
	});
	//hide message fields
	hideImmgMessages();
}


function hideImmgMessages() {
	//alert(jQuery('.hide_initial_content'));
	console.log(jQuery('li.hide_initial_content'));
	jQuery('.hide_initial_content').css('display', 'none');
	jQuery(document.getElementById('gform_submit_button_44')).css('display', 'none');
}

  //console.log(jQuery('li.hide_initial_content'));


console.log(jQuery('li.hide_initial_content'));
	//first, if they change the session we need to update the form
//jQuery('input:radio[name="input_330"]')
jQuery('input:radio[name="input_330"]').change(function(){
	if(jQuery('input:radio[name="input_295"]')) {
		//
	}
	unsetInputs(immigrationFieldsArray, "field_44_446");
	/*jQuery(document.getElementById('#input_44_475')).prop('value', '');
	jQuery(document.getElementById('#input_44_301')).prop('value', '');*/
				//hide the field

});

	//are you in the US - Yes!
	jQuery('input:radio[name="input_296"]'/*call this by its array name */).change(function(){
		jQuery(jQuery(this).val());
        if (jQuery(this).is(':checked') && jQuery(this).val() == 'Yes') {
        	//what is you current immigration status?
            jQuery(document.querySelector('#field_44_287')).css('display', 'block');
            //unset everything below
            unsetInputs(immigrationFieldsArray, "field_44_287");
            //hide any messages

            //what is your current immigration status
			jQuery(document.querySelector('#input_44_287')).change(function(){
				unsetInputs(immigrationFieldsArray, "field_44_287");
	        	if ( jQuery(this).val() == 'F-1' ) {
	           		jQuery(document.querySelector('#field_44_295')).css({'display': 'block', 'border-left': '5px red solid'});

	        	} else if ( jQuery(this).val() == 'F-2, H-1B, H-4, J-1, J-2, Other' ) {
	        		unsetInputs(immigrationFieldsArray, "field_44_296");
	        		//may need to check other values to what to hide

	        		jQuery(document.querySelector('#field_44_477')).css({'display': 'block', 'border-left': '5px red solid'});
	        		//show submit etc.
					jQuery(document.getElementById('field_44_95')).css('display', 'block');
					jQuery(document.getElementById('gform_submit_button_44')).css('display', 'block');
					jQuery(document.getElementById('field_44_323')).css('display', 'block');
					jQuery(document.getElementById('field_44_317')).css('display', 'block');
					jQuery(document.getElementById('field_44_348')).css('display', 'block');
					jQuery(document.getElementById('field_44_96')).css('display', 'block');
					jQuery(document.getElementById('field_44_97')).css('display', 'block');
					jQuery(document.getElementById('field_44_98')).css('display', 'block');
	       		} else if ( jQuery(this).val() == 'B-1, B-2, WB, WT (ESTA)' ) {
	        		unsetInputs(immigrationFieldsArray, "field_44_296");
	        		//may need to check other values to what to hide

	        		jQuery(document.querySelector('#field_44_476')).css({'display': 'block', 'border-left': '5px red solid'});
	        		//show submit etc.
					jQuery(document.getElementById('field_44_95')).css('display', 'block');
					jQuery(document.getElementById('gform_submit_button_44')).css('display', 'block');
					jQuery(document.getElementById('field_44_323')).css('display', 'block');
					jQuery(document.getElementById('field_44_317')).css('display', 'block');
					jQuery(document.getElementById('field_44_348')).css('display', 'block');
					jQuery(document.getElementById('field_44_96')).css('display', 'block');
					jQuery(document.getElementById('field_44_97')).css('display', 'block');
					jQuery(document.getElementById('field_44_98')).css('display', 'block');
	       		}
	    	});


	    	//Do you intend to continue your studies at the same school in Fall 2019?
			jQuery('input:radio[name="input_295"]').change(function(){

				unsetInputs(immigrationFieldsArray, "field_44_297");
        		if (jQuery(this).is(':checked') && jQuery(this).val() == 'Yes') {
        			console.log(jQuery(document.querySelector('#field_44_481')));
        			//make sure 'No' version summer session is hidden
        			jQuery(document.querySelector('#field_44_330')).css({'display': 'none'});
        			//summer session
        			jQuery(document.querySelector('#field_44_481')).css({'display': 'block', 'border-left': '5px red solid'});
           			//name of school
           			jQuery(document.querySelector('#field_44_297')).css({'display': 'block', 'border-left': '5px red solid'});
            		//sevis number
            		jQuery(document.querySelector('#field_44_298')).css({'display': 'block', 'border-left': '5px red solid'});
           			//I-20 completion date
            		jQuery(document.querySelector('#field_44_475')).css({'display': 'block', 'border-left': '5px red solid'});
            		console.log(jQuery(document.querySelector('#field_44_298')));
            		
            		//Checking I-20 dates
            		//i20DateChange();
            		//change475Function() 
					jQuery(document.querySelector("#input_44_475")).change(function(){

						unsetInputs(immigrationFieldsArray, "field_44_449");
						
						//need to hide a lot of messages and check value of 287 - current immigration status
		            	
		            	var cutOffDate = new Date('2019', '12', '01'); //Year, Month, Date
		            	var year = jQuery(document.querySelector("#input_44_475")).val().substring( 6, 10);
		            	var day = jQuery(document.querySelector("#input_44_475")).val().substring( 3, 5);
		            	var month = jQuery(document.querySelector("#input_44_475")).val().substring( 0, 2);
		       			var i20Date = new Date(year, month, day); //Year, Month, Date 
		            	//var compareDate = "01/12/2019";
						//date entered is before 12/1/2019
		            	if (Date.parse(cutOffDate) > Date.parse(jQuery(document.querySelector("#input_44_475")).val())) {
		            		//need to update
		            		//alert(i20Date + '>' + jQuery(this).val());
		            		jQuery(document.querySelector('#field_44_303')).css({'display': 'block', 'border-left': '5px red solid'});
		            		jQuery(document.querySelector('#field_44_472')).css({'display': 'block', 'border-left': '5px red solid'});
		        		} else {
		        			//alert('else ' + cutOffDate + '<' + i20Date);
		            		//good for both sessions
		            		jQuery(document.querySelector('#field_44_381')).css({'display': 'block', 'border-left': '5px red solid'});
		            		jQuery(document.querySelector('#field_44_472')).css({'display': 'block', 'border-left': '5px red solid'});
		        		}
		            //show submit etc.
					jQuery(document.getElementById('field_44_95')).css('display', 'block');
					jQuery(document.getElementById('gform_submit_button_44')).css('display', 'block');
					jQuery(document.getElementById('field_44_323')).css('display', 'block');
					jQuery(document.getElementById('field_44_317')).css('display', 'block');
					jQuery(document.getElementById('field_44_348')).css('display', 'block');
					jQuery(document.getElementById('field_44_96')).css('display', 'block');
					jQuery(document.getElementById('field_44_97')).css('display', 'block');
					jQuery(document.getElementById('field_44_98')).css('display', 'block');
		        		});

        		} else if (jQuery(this).is(':checked') && jQuery(this).val() == 'No') {
        			//unsetInputs(immigrationFieldsArray, "field_44_295");
        			//Checking I-20 dates
        			
        			console.log( jQuery( document.querySelector("#field_44_330") ).is(':checked') );
        			console.log( jQuery( document.querySelector("#field_44_330") ).val() );
        			
        			if( jQuery( document.querySelector("#field_44_330") ).val() != 0 ) {
        				//if they've checked whichsession
	        			jQuery(document.querySelector('#field_44_330')).css({'display': 'block', 'border-left': '5px red solid'});

	        			jQuery(document.querySelector('#field_44_297')).css({'display': 'block', 'border-left': '5px red solid'});
	            		//sevis number
	            		jQuery(document.querySelector('#field_44_298')).css({'display': 'block', 'border-left': '5px red solid'});
	            		//I-20 completion date
	            		jQuery(document.querySelector('#field_44_475')).css({'display': 'block', 'border-left': '5px red solid'});
	            		jQuery(document.querySelector('#field_44_301')).css({'display': 'block', 'border-left': '5px red solid'});

					} else {
        				
						jQuery(document.querySelector('#field_44_330')).css({'display': 'block', 'border-left': '5px red solid'});
	        		jQuery(document.querySelector('#field_44_297')).css({'display': 'none', 'border-left': '5px red solid'});
	            		//sevis number
	            		jQuery(document.querySelector('#field_44_298')).css({'display': 'none', 'border-left': '5px red solid'});
	            		//I-20 completion date
	            		jQuery(document.querySelector('#field_44_475')).css({'display': 'none', 'border-left': '5px red solid'});
	            		jQuery(document.querySelector('#field_44_301')).css({'display': 'none', 'border-left': '5px red solid'});
		        		//which summer session
		        		jQuery(document.querySelector("#input_44_330")).change(function(){
	        				unsetInputs(immigrationFieldsArray, "field_44_301");
		        			jQuery(document.querySelector('#field_44_330')).css({'display': 'block', 'border-left': '5px red solid'});

		        			jQuery(document.querySelector('#field_44_297')).css({'display': 'block', 'border-left': '5px red solid'});
		            		//sevis number
		            		jQuery(document.querySelector('#field_44_298')).css({'display': 'block', 'border-left': '5px red solid'});
		            		//I-20 completion date
		            		jQuery(document.querySelector('#field_44_475')).css({'display': 'block', 'border-left': '5px red solid'});
		            		/**/
		            		jQuery(document.querySelector('#field_44_301')).css({'display': 'block', 'border-left': '5px red solid'});
		            		jQuery('input[name="input_301"]').attr('value', '');
		            		jQuery('input[name="input_475"]').attr('value', '');
	        				

	        			});
					}

        			jQuery( document.querySelector("#input_44_301")).change(function (){ i20DateChange();
        			} );
        			jQuery( document.querySelector("#input_44_475")).change(function (){ i20DateChange();
        			} );

        		}
    		});

    		
/*
            //Checking I-20 dates
			jQuery(document.querySelector("#input_44_451")).change(function(){
				unsetInputs("input_451");
				console.log(jQuery(this).val());
				var compareDateStart = Date("2019-05-01");
				var compareDateEnd = Date("2019-06-09");
				//date entered is before 5/1/2019
        		if ( compareDateStart > jQuery(this).val() ) {
        			//need to update
            		jQuery(document.querySelector('#field_44_382')).css('display', 'block');

        		//date entered is between 5/1/2019 and 6/9/2019
       		 //451 and 391
        		} else if( compareDateStart < jQuery(this).val() < compareDateEnd ) {
        			//if it's in between check second date
        			//before the end date
        			if( jQuery(document.querySelector('#field_44_391')).val() < compareDateEnd ){
        				//summer 1 only
        				jQuery(document.querySelector('#field_44_304')).css('display', 'block');


        			}



        	jQuery(document.querySelector('#field_44_381')).css('display', 'block');
            jQuery(document.querySelector('#field_44_472')).css('display', 'block');
        } else {


        }
    });*/

	//no you are not in the us
        } else if (jQuery(this).is(':checked') && jQuery(this).val() == 'No') {
			//may need to check other values to what to hide
			//hide and reset everything below the current field
        	unsetInputs(immigrationFieldsArray, "field_44_296");
        	//what to test 
        	var img_status = jQuery(document.querySelector('#field_44_351'));
        	jQuery(img_status).css({'display': 'block', 'border-left': '5px red solid'});
        console.log(img_status + ' ' + jQuery(img_status).prop("checked") + ' ' + jQuery(img_status).val() );
        	//what to display

		jQuery(img_status).change(function(){
		if ( jQuery('input[name=input_351]:checked').val() == '0') {

        		//show submit etc.
        		console.log(jQuery(document.getElementById('gform_submit_button_44')));
        		jQuery(document.getElementById('field_44_340')).css('display', 'block');
				jQuery(document.getElementById('field_44_355')).css('display', 'block');
				jQuery(document.getElementById('field_44_385')).css('display', 'block');
				jQuery(document.getElementById('field_44_317')).css('display', 'block');
				jQuery(document.getElementById('field_44_323')).css('display', 'block');
				jQuery(document.getElementById('field_44_467')).css('display', 'block');
				jQuery(document.getElementById('field_44_95')).css('display', 'block');
				jQuery(document.getElementById('field_44_96')).css('display', 'block');
				jQuery(document.getElementById('field_44_97')).css('display', 'block');
				jQuery(document.getElementById('field_44_98')).css('display', 'block');
				jQuery(document.getElementById('gform_submit_button_44')).css('display', 'block');

        		
        	} 
        	if (jQuery('input[name=input_351]:checked').val() == 'I will be entering the U.S. with a B-1/B-2 visa or under WB/WT status. (Students entering under this status may only study part time.)') {

        		//show submit etc.
        		console.log(jQuery(document.getElementById('gform_submit_button_44')));
        		jQuery(document.getElementById('field_44_384')).css('display', 'block');
				jQuery(document.getElementById('field_44_317')).css('display', 'block');
				jQuery(document.getElementById('field_44_323')).css('display', 'block');
				jQuery(document.getElementById('field_44_95')).css('display', 'block');
				jQuery(document.getElementById('field_44_96')).css('display', 'block');
				jQuery(document.getElementById('field_44_97')).css('display', 'block');
				jQuery(document.getElementById('field_44_98')).css('display', 'block');
				jQuery(document.getElementById('gform_submit_button_44')).css('display', 'block');
        	
        	} 
        	if (jQuery('input[name=input_351]:checked').val() == 'Other') {

        		//show submit etc.
				jQuery(document.getElementById('field_44_317')).css('display', 'block');
				jQuery(document.getElementById('field_44_323')).css('display', 'block');
				jQuery(document.getElementById('field_44_95')).css('display', 'block');
				jQuery(document.getElementById('field_44_96')).css('display', 'block');
				jQuery(document.getElementById('field_44_97')).css('display', 'block');
				jQuery(document.getElementById('field_44_98')).css('display', 'block');
				jQuery(document.getElementById('gform_submit_button_44')).css('display', 'block');

        		
        	}


});



        }
    });

//jQuery(document).on("change", "#input_44_475", i20DateChange() );

//jQuery( "#input_44_475" ).on( "change", i20DateChange() );
//jQuery(document.querySelector("#input_44_475")).change(i20DateChange());
//
/*
needs:
input_295 - Do you intend to continue your studies at the same school in Fall 2019?

if the answer is no we need to compare input_301 and input_475 to find the earlier date, then compare the earlier date to the cutoffs

if the answer is yes check only input_475 and compare to cutoff dates



*/
function i20DateChange() {

	//i20DateChange();
	unsetInputs(immigrationFieldsArray, "field_44_301");
		if (jQuery('input[name="input_475"]').val() == '' ) {
			//alert("It's empty!");
			jQuery('input[name="input_475"]').focus();
			event.preventDefault();
			return false;
		} else if (jQuery('input[name="input_301"]').val() == '' ) {

							//jQuery('input[name="input_301"]').focus();
							event.preventDefault();
							return false;

						} else {

							var year_475 = jQuery(document.querySelector("#input_44_475")).val().substring( 6, 10);
			            	var day_475 = jQuery(document.querySelector("#input_44_475")).val().substring( 3, 5);
			            	var month_475 = jQuery(document.querySelector("#input_44_475")).val().substring( 0, 2)-1;

			            	var prog_end_date = new Date(year_475, month_475, day_475);

							var year_301 = jQuery(jQuery('input[name="input_301"]')).val().substring( 6, 10);
			            	

	var day_301 = jQuery(jQuery('input[name="input_301"]')).val().substring( 3, 5);
	var month_301 = jQuery(jQuery('input[name="input_301"]')).val().substring( 0, 2)-1;

			            	var i20Date = new Date(year_301, month_301, day_301);

			            	//use the earlier date to detemine form prompts
			            	//alert('254 ' + i20Date + ' or ' + prog_end_date);
			            	if ( i20Date > prog_end_date ){
			            		
			            		i20Date = prog_end_date;
			            	}
			            	
			            	var startCutOffDate = new Date('2019', '04', '01'); //Year, Month, Date
			            	var middleCutOffDate = new Date('2019', '05', '09');
			            	var endCutOffDate = new Date('2019', '05', '10');
			            	
			            	//var compareDate = "01/12/2019";
							//date entered is before 12/1/2019
					
			            	if ( Date.parse(i20Date) < Date.parse(startCutOffDate) ){
			            		//message
								jQuery(document.querySelector('#field_44_382')).css({'display': 'block', 'border-left': '5px red solid'});
								//financial declaration
								jQuery(document.querySelector('#field_44_355')).css({'display': 'block', 'border-left': '5px red solid'});
								/*jQuery(document.querySelector('#field_44_307')).css({'display': 'block', 'border-left': '5px red solid'});*/
								//dependent information
								jQuery(document.querySelector('#field_44_385')).css({'display': 'block', 'border-left': '5px red solid'});
								jQuery(document.querySelector('#field_44_467')).css({'display': 'block', 'border-left': '5px red solid'});

								jQuery(document.getElementById('field_44_95')).css('display', 'block');
								jQuery(document.getElementById('gform_submit_button_44')).css('display', 'block');
								jQuery(document.getElementById('field_44_323')).css('display', 'block');
								jQuery(document.getElementById('field_44_317')).css('display', 'block');
								jQuery(document.getElementById('field_44_348')).css('display', 'block');
								jQuery(document.getElementById('field_44_96')).css('display', 'block');
								jQuery(document.getElementById('field_44_97')).css('display', 'block');
								jQuery(document.getElementById('field_44_98')).css('display', 'block');

			            	} else if ((startCutOffDate < i20Date) && (i20Date < endCutOffDate ) ) {
		            			var check_session = jQuery('input:radio[name="input_330"]:checked').val();
		            			if ( check_session == 'Summer 1' ) {

			            			jQuery(document.querySelector('#field_44_304')).css({'display': 'block', 'border-left': '5px red solid'});
			            			//hide course info
			            			jQuery(document.querySelector('#field_44_273')).css({'display': 'none'});
			            			jQuery(document.querySelector('#field_44_289')).css({'display': 'none'});
			            			jQuery(document.querySelector('#field_44_269')).css({'display': 'none'});
			            			jQuery(document.querySelector('#field_44_272')).css({'display': 'none'});
			            			jQuery(document.querySelector('#field_44_345')).css({'display': 'none'});

			            		
			            		} else if (check_session == 'Summer 2' || check_session == 'Both') {

				            		jQuery(document.querySelector('#field_44_383')).css({'display': 'block', 'border-left': '5px red solid'});

				            		//financial declaration
									jQuery(document.querySelector('#field_44_355')).css({'display': 'block', 'border-left': '5px red solid'});
									jQuery(document.querySelector('#field_44_307')).css({'display': 'block', 'border-left': '5px red solid'});
									//dependent information
									jQuery(document.querySelector('#field_44_385')).css({'display': 'block', 'border-left': '5px red solid'});
									jQuery(document.querySelector('#field_44_467')).css({'display': 'block', 'border-left': '5px red solid'});

									//course info
									jQuery(document.querySelector('#field_44_272')).css({'display': 'block', 'border-left': '5px red solid'});
									jQuery(document.querySelector('#field_44_273')).css({'display': 'block', 'border-left': '5px red solid'});
									//dependent information
									jQuery(document.querySelector('#field_44_269')).css({'display': 'block', 'border-left': '5px red solid'});
									jQuery(document.querySelector('#field_44_289')).css({'display': 'block', 'border-left': '5px red solid'});

			            		}
			            		//show submit etc.
								jQuery(document.getElementById('field_44_95')).css('display', 'block');
								jQuery(document.getElementById('gform_submit_button_44')).css('display', 'block');
								jQuery(document.getElementById('field_44_323')).css('display', 'block');
								jQuery(document.getElementById('field_44_317')).css('display', 'block');
								jQuery(document.getElementById('field_44_348')).css('display', 'block');
								jQuery(document.getElementById('field_44_96')).css('display', 'block');
								jQuery(document.getElementById('field_44_97')).css('display', 'block');
								jQuery(document.getElementById('field_44_98')).css('display', 'block');
			        		} else if (i20Date > endCutOffDate) {
			            		//good for both sessions
			            		//alert('after the gold rush');
			            		jQuery(document.querySelector('#field_44_380')).css({'display': 'block', 'border-left': '5px red solid'});
			            		//show submit etc.
								jQuery(document.getElementById('field_44_95')).css('display', 'block');
								jQuery(document.getElementById('gform_submit_button_44')).css('display', 'block');
								jQuery(document.getElementById('field_44_323')).css('display', 'block');
								jQuery(document.getElementById('field_44_317')).css('display', 'block');
								jQuery(document.getElementById('field_44_348')).css('display', 'block');
								jQuery(document.getElementById('field_44_96')).css('display', 'block');
								jQuery(document.getElementById('field_44_97')).css('display', 'block');
								jQuery(document.getElementById('field_44_98')).css('display', 'block');
			            		//hide course info
		            			jQuery(document.querySelector('#field_44_273')).css({'display': 'none'});
		            			jQuery(document.querySelector('#field_44_289')).css({'display': 'none'});
		            			jQuery(document.querySelector('#field_44_269')).css({'display': 'none'});
		            			jQuery(document.querySelector('#field_44_272')).css({'display': 'none'});
		            			jQuery(document.querySelector('#field_44_345')).css({'display': 'none'});
			        		} else {
			        			//alert('I20 date in ');
			        			//alert('Line 265 ' + startCutOffDate + '>=' + i20Date + ' > ' + endCutOffDate);
			        		}
		        		}
		            
}
getWholeArray(startImmigrationFields);
console.log(immigrationFieldsArray);
});

//console.log(immigrationFieldsArray1);

