/*
this js page is for home page content loading
*/
var loadoption='1';
var isprocessing = true;
$(function(){

	loaditems('clear');
	// load the categories and designers
	$('#jqcatlisting').load(BASE_URL+'items/loadcategories', function(){
        $('#jqdesignerlisting').load(BASE_URL+'items/loaddesigners', function(){         
            $('#jqsizelisting').load(BASE_URL+'items/loadsize', function(){
				$(".custom-scroll-div").mCustomScrollbar("destroy");
				$(".custom-scroll-div").mCustomScrollbar({ scrollInertia:200});
            });
        });
	});
	
	// trigger the category click event
	$( document ).on( "click", "a.jqcatitem", function() {
		var catval='';
		$(this).toggleClass('selected');
		loadoption = '1';
		loaditems('clear');
		// code to find the active categories
		$( "#jqulcategories li a" ).each(function( i ) {
			if ( $(this).hasClass('selected') )
				catval += $(this).attr('id')+';';  
		});
		$('#jqdesignerlisting').load(BASE_URL+'items/loaddesigners/?catid='+catval, function(){  
			$('#jqsizelisting').load(BASE_URL+'items/loadsize/?catid='+catval, function(){
				$(".custom-scroll-div").mCustomScrollbar("destroy");
				$(".custom-scroll-div").mCustomScrollbar({ scrollInertia:200});
            });
			$(".custom-scroll-div").mCustomScrollbar("destroy");
			$(".custom-scroll-div").mCustomScrollbar({ scrollInertia:200});
		});
		
		return false;
	});
	
	
	
	// clear the filters
	$( document ).on( "click", "a#jqclearfilter", function() {
		$('#jqcatlisting').load(BASE_URL+'items/loadcategories', function(){
			   $('#jqdesignerlisting').load(BASE_URL+'items/loaddesigners', function(){         
					$('#jqsizelisting').load(BASE_URL+'items/loadsize', function(){
						
						$( "#jqulcounty li a" ).each(function( i ) {
							$(this).removeClass('selected');	  
						});
						
						//$("#slider-range").slider("option", "values", [0, 5000]);
						$(".range-slider").noUiSlider({
							range: {
								'min': Number(0),
								'max': Number(5000)
							}
						}, true);
						$(".range-slider").val([0, 5000]);
						//$( "#amount" ).val( "$0 - $5000" );
						$( "#value-lower" ).html( "0" );
						$( "#value-higher" ).html( "5000" );
						loadoption = '1';
						$('#pricestart').val('0');
						$('#priceend').val('5000');
						alert($('#pricestart').val());
						loaditems('clear');
						$(".custom-scroll-div").mCustomScrollbar("destroy");
						$(".custom-scroll-div").mCustomScrollbar({ scrollInertia:200});
					});
				});
		});
		return false;
	});
	
	// trigger the designer clicks
	$( document ).on( "click", "a.jqdesigneritem", function() {
		$(this).toggleClass('selected');
		loadoption = '1';
		loaditems('clear');
		return false;
	});
	
	// trigger the size clicks
	$( document ).on( "click", "a.jqsizeitem", function() {
		$(this).toggleClass('selected');
		loadoption = '1';
		loaditems('clear');
		return false;
	});
	
	// trigger the country clicks
	$( document ).on( "click", "a.jqcountryitem", function() {
		$(this).toggleClass('selected');
		loadoption = '1';
		loaditems('clear');
		return false;
	});
	
	// trigger the sorting
	$( document ).on( "change", "#jqitemsorting", function() {
		$('#jqitemsorting').removeClass('selected');
		$(this).toggleClass('selected');
		loadoption = '1';
		loaditems('clear');
		return false;
	});
	
	// trigger when click search
	$( document ).on( "click", "#jqsearchbtn", function() {
		//$('a.jqitemsorting').removeClass('selected');
		//$(this).toggleClass('selected');
		loadoption = '1';
		loaditems('clear');
		return false;
	});
	
	// trigger when enter key press on search
	$( "#jqsearchtext" ).keypress(function( event ) {
	  if ( event.which == 13 ) {
			loadoption = '1';
			loaditems('clear');
			return false;
		}
	});
	
		
	/*
	// add to myselections checking
	$( document ).on( "click", "a.jqmyselections", function() {
		var prodid = $(this).attr('data-attr');
		if($(this).hasClass('select'))	{
			$(this).removeClass('select');
			var type = 'remove';
		} 
		else	{
			$(this).addClass('select');
			var type = 'add';
		}
		$.ajax({
			url: BASE_URL+"items/changemyselections/"+prodid+'/'+type,
			success: function(html){}
		});
	});
	*/
	
});
 
	 
	 
	// function to load the items 
	function loaditems(action) {
		//alert('hello');
	
		isprocessing = false;
		if(loadoption == 0)
			return false;
		//console.log('loading:'+loadoption);
		if(action == 'clear' ){	// only for scrolling we are appending the data 
		$('#loadpagecount').val('1');
			$("#jqitemlisting").html('');
		}
		// find the active items
		var catval='&catids=';
		$( "#jqulcategories li a" ).each(function( i ) {
			if ( $(this).hasClass('selected') )
				catval += $(this).attr('id')+';';  
		});
		
		var desval='&des=';
		$( "#jquldesigners li a" ).each(function( i ) {
			if ( $(this).hasClass('selected') )
				desval += $(this).attr('id')+';';  
		});
		
		var sizeval='&size=';
		$( "a.jqsizeitem" ).each(function( i ) {
			if ( $(this).hasClass('selected') )
				sizeval += $(this).attr('id')+';';  
		});
		
		var countryval='&country=';
		$( "#jqulcounty li a" ).each(function( i ) {
			if ( $(this).hasClass('selected') )
				countryval += $(this).attr('id')+';';  
		});
		
		var sortval='&sort=';
		$( "#jqitemsorting" ).each(function( i ) {
			if ( $(this).hasClass('selected') )
				sortval += $('#jqitemsorting').val();  
		});
		
		// get search text
		var searchtexr = '&searchtext='+ $('#jqsearchtext').val();
		
		
		
		
		// get the price
		var startPrice = '&startprice='+$('#pricestart').val();
		var endPrice = '&endPrice='+$('#priceend').val();
		
		// get page
		var loadpage =parseInt( $('#loadpagecount').val());
		
		var params=catval+desval+sizeval+countryval+sortval+'&page='+loadpage+startPrice+endPrice+searchtexr;
		// active item finding ends
		
		$.ajax({
			url: BASE_URL+"items/loaditems?="+params,
			success: function(html){
				if(html){
					$("#jqitemlisting").append(html);
					$('#loadpagecount').val(loadpage+1)
					$('div#loadmoreajaxloader').hide();
					loadoption = '1';
				}else{
					loadoption = '0';
					$('div#loadmoreajaxloader').html('<p class="nomoreitem"><span>No more items to show</span></p>');
					 
				}
				
				isprocessing = true;
			}
		});
	}
	
	// function to load the items
	$(window).scroll(function(){
		var newhe = $(document).height() - $(window).height();
	
		//console.log($(document).height()+':'+$(window).height());
		//console.log($(window).scrollTop()+':'+newhe);
		if(($(window).scrollTop()+200 >= $(document).height() - $(window).height()) || $(window).scrollTop() == $(document).height() - $(window).height()-1    ){
			$('div#loadmoreajaxloader').show();
			if(isprocessing == true)
				loaditems('append');
			
		}
	});
		
	