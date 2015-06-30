/*
this js page is for user registration and login functionality 
*/
 
	
	
	
	
	$(document).ready(function() {

        $.validator.addMethod("alphanumeric", function(value, element) {
          return this.optional(element) || (value.match(/[a-zA-Z]/) && value.match(/[0-9]/));
    },
    'Password must be alphanumeric.');

			 
	$( "#singup" ).click(function() { 	
			
			// Setup form validation on the #register-form element
			$("#register-form").validate({    
				// Specify the validation rules
				rules: {
					username: "required",
					email: {
						required: true,
						email: true
					},           
					password: {
						required: true,
						minlength: 6,						
						alphanumeric: true						
					},
					country: "required"
				},        
				// Specify the validation error messages
				messages: {
					username: "Please enter your name",
					email: "Please enter a valid email address",          
					password: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long",
						
					},
					country: "Please enter your country"
				},
				
				submitHandler: function(form) {						
						
						$('#signup-loading').show();
					   var url = BASE_URL+"index/users/register";
					   $.ajax({
								type: "POST",
								url: url,
								data: $("#register-form").serialize(), // serializes the form's elements.
								success: function(data)  
								{ 
									
									$('#signup-loading').hide();							
									
									$("#result").html("<div id='divSuccessMsg'></div>");
									$('#divSuccessMsg').html(data);
									$("#divSuccessMsg").fadeOut(5000);	
									regformclear();
									// $.fancybox("#login");
									setTimeout(function() {
									  $("#jqlogin").trigger( "click" );
									  }, 5000);								
									
								}
						});
				}
			
			});
		});	//////end click event
		
		
	
	$( "#login" ).click(function() {			
				
			// Setup form validation on the #login-form element
			$("#login-form").validate({ 
			
				// Specify the validation rules
				rules: {				
					login_email: {
						required: true,
					},           
					login_password: {
						required: true,
						
					}
				},        
				// Specify the validation error messages
				messages: {
					login_email: "Please enter your username",          
					login_password: {
						required: "Please provide a password"
					}				
				},
				
				submitHandler: function(form) {
		   
						$('#loading').show();
						
					   var url = BASE_URL+"index/users/loggin";
					   $.ajax({
								type: "POST",
								url: url,
								data: $("#login-form").serialize(), // serializes the form's elements.
								success: function(data)  
								{ 
									
									if(data==1){
									
										window.location.replace(window.location);
										
									}else if (data==2){				
										
											$('#loading').hide();
																			 
										var result = "Username or password incorrect";
										$("#log_result").html(result);
									}else{
										$("#log_result").html(result);
									}
								}
						});
				}
			
			});
			 
		}); /*end click event */
		
		
		/*script for logout*/
		$("#logout").click(function(){
			var url = BASE_URL+"index/users/logout";
				   $.ajax({
							type: "POST",
							url: url,
							data: '', // serializes the form's elements.
							success: function(data)  
							{ 
								if(data==1){
									window.location.replace(BASE_URL); 
								}
							}
					});
	
		});
		
		/*ajax function for edit user account*/
		$("#edit-account").click(function(){
			
			$('#save-loading').show();
			var url = BASE_URL+"index/users/editaccount";
	
				   $.ajax({
							type: "POST",
							url: url,
							data: $("#edit-form").serialize(), // serializes the form's elements.
							success: function(data)  
							{ 
								$('#save-loading').hide();
								$("#edit_result").html("<div id='divSuccessMsg'></div>");
								$('#divSuccessMsg').html(data);
								$("#divSuccessMsg").fadeOut(5000);	
							}
					});
		return false;
		});
		
		// Setup form validation on the change password element
		$("#changepassword-form").validate({    
			// Specify the validation rules
			rules: {				
				old_password: {
					required: true					
				},           
				new_password: {
					required: true					
				},
				confirm_password: {
					required: true,
					equalTo: '#new_password'
				}
			},        
			// Specify the validation error messages
			messages: {
				old_password: "Please enter your current password",          
				new_password: {
					required: "Please enter your new password"
					},
				confirm_password: {
					required: "Please confirm your password",
					equalTo: 'New password and confirm password are not match'
				}					
			},
			
			submitHandler: function(form) {
					$('#password-loading').show();
					var url = BASE_URL+"index/users/changepassword";	
					$.ajax({
							type: "POST",
							url: url,
							data: $("#changepassword-form").serialize(), // serializes the form's elements.
							success: function(data)  
							{ 	
								$('#password-loading').hide();
								$("#change_result").html("<div id='divSuccessMsg'>"+data+"</div>");
								//$('#divSuccessMsg').html(data);
								$('#old_password').val('');
								$('#new_password').val('');
								$('#confirm_password').val('');
								$("#divSuccessMsg").fadeOut(5000);	
							}
					});
					return false;
			}
		
		});
		
		/*ajax function for subscribe newsletter from user account*/
		$("#subscribe").change(function(){		
			
			 $('#news-loading').show();
			var url = BASE_URL+"index/users/subscribenewsletter";

			if($(this).is(':checked')){
				var subscribe = 1;
			}else{
				var subscribe = 0;
			}
				  $.ajax({
							type: "POST",
							url: url,
							data: {subscribe: subscribe}, // serializes the form's elements.
							success: function(data)  
							{ 
								$('#news-loading').hide();
								$("#subscribe_result").html("<div id='divSuccessMsg'></div>");
								$('#divSuccessMsg').html(data);
								$("#divSuccessMsg").fadeOut(5000);	
							}
					});
		return false;
		}); //// end subscribe newsletter
	
	
		/* for ask question */
		$( "#ask-button").click(function() {			
			 
			// Setup form validation on the ask a question 
			$("#askquestion-form").validate({    
				rules: {				
					question: {
						required: true					
					},           
				},        
				// Specify the validation error messages
				messages: {
					question: "Please type your question"			
				},			
				submitHandler: function(form) {
						
						 $('#ask-loading').show();
						 
						var url = BASE_URL+"index/index/askquestion";	
						$.ajax({
								type: "POST",
								url: url,
								data: $("#askquestion-form").serialize(), // serializes the form's elements.
								success: function(data)  
								{ 
									$('#ask-loading').hide();
									$("#ask_result").html("<div id='divSuccessMsg'></div>");
									$('#divSuccessMsg').html(data);
									$("#divSuccessMsg").fadeOut(5000);						
									$("#question").val('');	
								}
						});
						return false;
				}
			
			});
		});////// end ask button click event		
		/* End for ask question */
		
		/* for make an offer */
		
		$( "#offer-button").click(function() {
		
					// Setup form validation on the make an offer
					$("#offer-form").validate({    
						rules: {	
							offer_price: {
								required: true,
								number:true
							}        
						},        
						// Specify the validation error messages
						messages: {
							offer_price: {
								required: "Please enter your offer price",
								number:"Offer price must be numeric"
							}		
						},			
						submitHandler: function(form) {
				   
								 $('#offer-loading').show();
								 
								var url = BASE_URL+"index/index/makeoffer";	
								$.ajax({
										type: "POST",
										url: url,
										data: $("#offer-form").serialize(), // serializes the form's elements.
										success: function(data)  
										{ 
											$('#offer-loading').hide();											
											$("#offer_result").html("<div id='divSuccessMsg'></div>");
											$('#divSuccessMsg').html(data);
											$("#divSuccessMsg").fadeOut(5000);											
											$("#offer_price").val('');	
											$("#description").val('');
											setTimeout("parent.$.fancybox.close()", 1000);
										}
								});
								return false;
						}
					
					});
			});////// end ask button click event
		
			/* End make an offer */
			
		/* For offer form from notifications */
		$( document ).on( "click", "#reply-button", function() {
		//$( "#reply-button").click(function() {
		 
			// Setup form validation on the make an offer
			$("#reply-form").validate({    
				rules: {					
					reply: {
						required: true					
					},           
				},        
				// Specify the validation error messages
				messages: {
					reply: "Please type your reply"			
				},			
				submitHandler: function(form) {
		   
						 $('#reply-loading').show();
						 
						var url = BASE_URL+"index/index/reply";	
						$.ajax({
								type: "POST",
								url: url,
								data: $("#reply-form").serialize(), // serializes the form's elements.
								success: function(data)  
								{ 
									$('#reply-loading').hide();
									
									$("#reply_result").html("<div id='divSuccessMsg'></div>");
									$('#divSuccessMsg').html(data);
									$("#divSuccessMsg").fadeOut(5000);
									$("#reply").val('');	
								}
						});
						return false;
				}
			
			});////// end offer button click event
		
		});
		
		
		/* End reply form */
		
		
		
		/* For counter */
		//$( "#counter-button").click(function() {
		$( document ).on( "click", "#counter-button", function() {
			var prodid 	= $(this).attr('data-attr');
			// Setup form validation on the ask a question 
			$("#counter-form").validate({    
				rules: {
					offer_price: {
								required: true,
								number:true
							} 
				},        
				// Specify the validation error messages
				messages: {
					offer_price: {
								required: "Please enter your price",
								number:"Price must be numeric"
							}			
				},			
				submitHandler: function(form) {
						
						$('#counter-loading').show();
						
						var url = BASE_URL+"index/index/counter";	
						$.ajax({
								type: "POST",
								url: url,
								data: $("#counter-form").serialize(), // serializes the form's elements.
								success: function(data)  
								{ 
									$('#counter-loading').hide();
				
									$("#counter_result").html("<div id='divSuccessMsg'></div>");
									$('#divSuccessMsg').html(data);
									$("#divSuccessMsg").fadeOut(5000);
									$("#noticounterbox_"+prodid+" .jqofferprice").val('');	

									$("#counter_reply").val('');									
								}
						});
						return false;
				}
			
			});
		});////// end ask button click event
		
		/* End counter */
		
		/* For forgot pawwsord*/
		$( "#reset_pwd").click(function() {
		
			// Setup form validation on the ask a question 
			$("#forgot-form").validate({    
				rules: {				
					forgot_email: {
						required: true,
						email:true	
					}           
				},        
				// Specify the validation error messages
				messages: {
					forgot_email: {
						required: "Please enter email",
						email:"Please enter valid email"	
					}           	
				},			
				submitHandler: function(form) {
						
						$('#forgot-loading').show();
						
						var url = BASE_URL+"index/users/forgot_password";	
						$.ajax({
								type: "POST",
								url: url,
								data: $("#forgot-form").serialize(), // serializes the form's elements.
								success: function(data)  { 
									$('#forgot_email').val('');
									 $("#forgot_result").show();
									$('#forgot-loading').hide();
									
									$("#forgot_result").html("<div id='divSuccessMsg'>"+data+"</div>");
									//$('#divSuccessMsg').html(data);
									$("#divSuccessMsg").fadeOut(5000);									
								}
						});
						return false;
				}
			
			});
		});////// end ask button click event
		
		/* End counter */
		
		
		
		// function to delete the item from myitems
		//$( ".jqrmvmyselitem" ).on( "click", function() {
		$( document ).on( "click", "a.jqrmvmyselitem", function() {
				var prodid 	= $(this).attr('data-attr');				
				$.ajax({
					url: BASE_URL+"items/changemyselections/"+prodid+'/remove',
					success: function(html){
						// remove the item from listing
						$('#jqmyselitem_'+prodid).html('Successfully removed the item');
						
						// for reloading myselection after delete an item
						$.ajax({
							url: BASE_URL+"index/users/myselectionReload",
							success: function(response){					
								$('.selection-div').html(response);
							}
						});
					}
				});
				return false;
			});
		
		// fucntion to enable or disable the pricedrop
		$('.jqmyselpricedrop').click(function(){
			var prodid 	= $(this).attr('data-attr');
			if($(this).is(':checked'))
				var subscribe = 1;
			else
				var subscribe = 0;
				
			$.ajax({
				url: BASE_URL+"items/pricedropupdate/"+prodid+'/'+subscribe,
				success: function(html){
					 
				}
			});
			
			 
		});
		
		// show the buy box
		$( document ).on( "click", ".jqshowbuybox", function() {	

			var prodid 		= $(this).attr('data-attr');
			/*
			// get the product necessary details
			$.ajax({
				url: BASE_URL+"index/users/loadshippingform/"+prodid,
				success: function(html){
					// alert(html);
				}
			});
			*/
			
			$.fancybox({
				'width': '100%',
				 'height': '80%',
				 'autoScale': true,
				//'transitionIn': 'fade',
				//'transitionOut': 'fade',
				'href': 'index/users/loadshippingform/'+prodid,
				'type': 'ajax',
				//'href': '#buy-it-now',
				//'type': 'inline',
				'onClosed': function() {
					//window.location.href = "f?p=&APP_ID.:211:&SESSION.::&DEBUG.::";
				}

			});

			return false;
		
		});
		/* for accept offer button */
		//$( "#accept-button").click(function() {	
		$( document ).on( "click", "#accept-button", function() {		
				var notifyid 	= $(this).attr('data-val');
				var prodid 		= $(this).attr('data-prod');
				$('#accept-loading').show();
			
					var url = BASE_URL+"index/index/accept_offer";	
					$.ajax({
							type: "POST",
							url: url,
							data: $("#accept-form").serialize(), // serializes the form's elements.
							success: function(data)  
							{ 
								 
								$('#accept-loading').hide();
								
								//$("#accept_result").html("<div id='divSuccessMsg'></div>");
								//$('#divSuccessMsg').html(data);
								// $("#divSuccessMsg").fadeOut(5000);		
								 
								// hide the accept offer option
								$('#notiofferbox_'+notifyid).html('<button class="commen-button btn-block">Offer Accepted</button>');
								if(data == '2' )
									$('#noticounterbox_'+notifyid).html('<a href="'+BASE_URL+'product/'+prodid+'" data-attr="'+prodid+'" class="commen-button btn-block noborder jqshowbuybox">Buy it now</a>');
								else {
									$('#noticounterbox_'+notifyid).html('');
									$('#noticounterbox_'+notifyid).removeClass('rply-div');
								}
						}
					});
					return false;			
		});////// end ask button click event
		
		/* End accept offer */
		
		/* For buy product */
		$( "#pay-paypal" ).click(function() { 
		
			// Setup form validation on the #buy-form element
			$("#buy-form").validate({    
				// Specify the validation rules
				rules: {
					name: "required",
					street1: "required",					
					city: "required",
					state: "required",
					zip: "required",
					country: "required"
				},        
				// Specify the validation error messages
				messages: {
					name: "Please enter your name",
					street1: "Please enter your street1",					
					city: "Please enter your city",
					state: "Please enter your state",
					zip: "Please enter your zip",
					country: "Please enter your country"
				},
				
				submitHandler: function(form) {						
						
						$('#buy-loading').show();
						form.submit();
					   // var url = BASE_URL+"index/index/buy";
					   // $.ajax({
								// type: "POST",
								// url: url,
								// data: $("#buy-form").serialize(), // serializes the form's elements.
								// success: function(data)  
								// { 
									
									// $('#buy-result').html(data);
									
								// }
						// });
				}
			
			});
		});	//////end click event
		
		
		
		
		
		
		
		
	// add to myselections checking
	$( document ).on( "click", "a.jqmyselections", function() {
		var prodid = $(this).attr('data-attr');
		if($(this).hasClass('select'))	{
			$(this).removeClass('select');
			var type = 'remove';
			$(this).html('ADD NOW');
			$('#jqhomesel_'+prodid).removeClass('select');
			$('#jqpdtsel').removeClass('select');
			$('#jqpdtsel'+prodid).html('Add to Selection');
		} 
		else	{
			$(this).addClass('select');
			var type = 'add';
			$(this).html('ADDED');
			$('#jqhomesel_'+prodid).addClass('select');
			$('#jqpdtsel').addClass('select');	
			$('#jqpdtsel'+prodid).html('Added to Selection');
				
		}
		$.ajax({
			url: BASE_URL+"items/changemyselections/"+prodid+'/'+type,
			success: function(html){
			setTimeout("parent.$.fancybox.close()", 1000);
			}
		});
		return false;
	});
	
	// upvote checking
	$( document ).on( "click", "a.jqupvote", function() {
		var prodid = $(this).attr('data-attr');

		if($(this).hasClass('upvoted'))	{
			$(this).removeClass('upvoted');
			$(this).addClass('upvote');
			var type = 'remove';
			$('#jqpdtupvote'+prodid).html('Upvote');
			$('#jqhomepvote'+prodid).html('Upvote<i class="cf"></i>');
		} 
		else	{			
			$(this).removeClass('upvote');
			$(this).addClass('upvoted');
			var type = 'add';
			$('#jqpdtupvote'+prodid).html('Upvoted');
			$('#jqhomepvote'+prodid).html('Upvoted<i class="cf"></i>');
		}		
		$.ajax({
			url: BASE_URL+"items/changeupvote/"+prodid+'/'+type,
			success: function(html){
			
			}
		});
		return false;
	});
	
	// function to bumb the product
	$( document ).on( "click", "a#jqprodbumb", function() {
		$('#jqbumbresult').html('<img src="'+BASE_URL+'assets/img/loading.gif">');
		var prodid = $(this).attr('data-attr');
		$.ajax({
			url: BASE_URL+"index/products/bumb/"+prodid,
			success: function(html){
				$('#jqbumbresult').html(html);
			}
		});
		return false;
	});
	

		
		/* for subscribe newsletter */
		$( "#subscribe_news").click(function() {			
			
			var email = $('#newsletter_email').val();
			
			if(email==""){
				var data = '<label class="error">Please enter your email id</label>';
				$("#subscribe-result").html("<div id='divSuccessMsg'></div>");
				// $('#divSuccessMsg').html(data);
				// $("#divSuccessMsg").fadeOut(5000);
				$('#divSuccessMsg').html(data).show().delay(2000).fadeOut(5000);
				return false;
				
			}
			$('#subscribe-loading').show();
				var url = BASE_URL+"index/users/subscribe";		
			
						$.ajax({
								type: "POST",
								url: url,
								data: 'email='+email, // serializes the form's elements.
								success: function(data)  
								{ 
									$('#subscribe-loading').hide();
							
									$("#subscribe-result").html("<div id='divSuccessMsg'></div>");
									// $('#divSuccessMsg').html('<span >'+data+'</span>');
									// $("#divSuccessMsg").fadeOut(5000);
									$('#divSuccessMsg').html('<span >'+data+'</span>').show().delay(2000).fadeOut(5000);
									$('#newsletter_email').val('');
								}
						});
						return false;			
			
		});////// end subscribe button click event
		
			
			/* for rating */
		$( ".feedrating").click(function() {		
			
			var rateval =  $(this).attr('data-val');
			$('#rateval').val(rateval);
			return false;
			
		});////// end subscribe button click event
			/* for read unread status for notifications */
			$.each($(".jqread"),function (index){				
				 $(this).click( function() {
						var id =  $(this).attr('data-val');
						var url = BASE_URL+"index/users/readstatus";	
						$.ajax({
								type: "POST",
								url: url,
								data: 'id='+id, // serializes the form's elements.
								success: function(data)  
								{ 
									$('[data-val="'+id+'"]').removeClass("un-read");
									return true;
								}
						});
						return false;
					
					
					})
				});

		////// end subscribe button click event
		
			// show the profile uploading box
		$( document ).on( "click", "#profile-img", function() {	

			$.fancybox({
				'width': '100%',
				 'height': '80%',
				 'autoScale': true,
				'transitionIn': 'fade',
				//'transitionOut': 'fade',
				'href': 'showUpload',
				'type': 'ajax',
				//'href': '#buy-it-now',
				//'type': 'inline',
				'onClosed': function() {
					window.location.reload();
				}

			});

			return false;
		
		});
		
		/*function to save changes on profile page*/
		$("#savechange").click(function(){
			
			$('#preview').html('<img src="'+BASE_URL+'assets/img/loading.gif">');
			var url = BASE_URL+"index/index/savechages";
	
				   $.ajax({
							type: "POST",
							url: url,
							data: $("#changeform").serialize(), // serializes the form's elements.
							success: function(data)  
							{ 
								$(".jqimgsucs").html('<div id="divSuccessMsg" style="display:block;"></div>');								
								$('#divSuccessMsg').html(" Profile image updated successfully").show().delay(2000).fadeOut(5000);		
								$("#preview").hide();	
							}
					});
		return false;
		});
	
	
});	
	function regformclear(){		
		$("#username").val('');
		$("#email").val('');
		$("#password").val('');	
	}
