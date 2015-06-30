
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script src="<?php echo BASE_URL;?>scripts/userfunctions.js"></script>

<header class="header">
    	<div class="header-base">
            
            <div class="container">
				<div class="row">
                	<div class="col-sm-4">
						<h1 class="logo">
                            <a href="<?php echo BASE_URL;?>"><img src="<?php echo BASE_URL;?>assets/img/img-logo.png" alt="" /></a>
                        </h1>
			        </div>
                    
                    <div class="col-sm-8">
                    	<div class="nav">
                            <ul id="main-nav">
                            <?php if(!$this->session->userdata('user_id')){?>
                                <li><a href="#login" class="pop-up">Enter</a></li>
					  			<li><a href="#login" class="pop-up">Sell</a></li>
                                
                             <?php }
						 else
							echo '<li><a href="'.BASE_URL.'sell">Sell</a></li>';
							
						 if($this->session->userdata('user_id')){
							 $notifications	=	Notifications::notificationcount();
							$notification_count =  $notifications->countnotification; 
						 ?>
                         
                                
                                <li><a href="<?php echo BASE_URL;?>my-selections" class="my-section">My Selections</a></li>
                                <li><a href="<?php echo BASE_URL;?>notifications">Notifications <span>(<?php echo $notification_count; ?>)</span></a></li>
                                                                
                                <li><a href="<?php echo BASE_URL;?>my-account">My Account <i class="cf icon-angle-down"></i></a>
                                    <ul>
                                        <li class="user-name"><a href="<?php echo BASE_URL;?>my-account"><?php echo ucfirst($this->session->userdata('name')); ?></a></li>
                                    
                                        <li><a href="<?php echo BASE_URL;?>notifications">Messages</a></li>
                                        <li><a href="<?php echo BASE_URL;?>history">History</a></li>
                                        <li><a href="<?php echo BASE_URL;?>myitems">My Items</a></li>
                                        <li><a href="<?php echo BASE_URL;?>index/users/logout">Logout</a></li>
                                    </ul>
                                </li>
                                 <?php }?>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="stick-nav-div"></div>
			        </div>
            
            
            <!----------------------------->
            
            
            
          <!--------------------------------------->  
                </div>
             </div>
        </div>
    </header>
	
	
	
	
	
	
	
	
	<div id="login" class="pop-up-content login-content">
	
					<h2>login</h2>
					<div id="log_result"></div>
					<div class="login-div">
						<form name="login-form" id="login-form" method="POST" action="">
							<ul>
								<li>
									<label>username</label>
									<input type="text" class="form-control commen-textfeild" name="login_email" id="login_email">
								</li>
								<li>
									<label>password</label>
									<input type="password" class="form-control commen-textfeild" name="login_password" id="login_password">
								</li>
								<li>
									<div class="commen-sheck-box">
										<label>
											<input type="checkbox" class="check-box" value="" name="remember">
											Remember Me
										</label>
									</div>
								</li>
							</ul>
							<div id="loading" style="display:none;">
								  <p><img src="<?php echo BASE_URL;?>assets/img/loadersml.gif" /> </p>
							</div>
							<div class="pop-up-button">
								<button class="commen-button-black" id="login">login</button>
							</div>
							
							<div class="user-links">
								<a href="#creat-account" class="pop-up">Create an account</a><br>
								<a href="#forgot-password" class="pop-up">Forgot Password?</a>
							</div>
						</form>
					</div>					
				</div>
				
				<div id="creat-account" class="pop-up-content login-content">				
					<h2>Become a member</h2>
					<div id="result"></div>
					<div class="login-div">
						<form name="register-form" id="register-form" method="POST" action="">
							<ul>
								<li>
									<label>username<span class="mandatory">*</span></label>
									<input type="text" class="form-control commen-textfeild" name="username" id="username">
								</li>
								<li>
									<label>email<span class="mandatory">*</span></label>
									<input type="text" class="form-control commen-textfeild" name="email" id="email">
								</li>
								<li>
									<label>password<span class="mandatory">*</span></label>
									<input type="password" class="form-control commen-textfeild" name="password" id="password">
								</li>
								<li>
									<label>country<span class="mandatory">*</span></label>
									<select class="dropdown1" name="country" id="country">
									<?php $countrylist	=	$this->config->item('countryList');								
									foreach($countrylist as $key=>$country){
									?>
										<option value="<?php  echo $key; ?>"><?php echo $country; ?></option>
									<?php } ?>
									</select>
								</li>
								
								<li>
									<div class="commen-sheck-box">
										<label>
											<input type="checkbox" class="check-box" value="1" name="subscribe_newsletter" id="subscribe_newsletter">
											Subscribe to Newsletter
										</label>
									</div>
								</li>								
							</ul>
							<div class="pop-up-button">
								<button class="commen-button-black" id="singup" name="singup">sign up now</button>
							</div>
							<div id="signup-loading" style="display:none;">
								  <p><img src="<?php echo BASE_URL;?>assets/img/loadersml.gif" /> </p>
							</div>
							<div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo BASE_URL;?>assets/img/loadingGif.gif' width="64" height="64" /></div>
							<div class="have-account">
								<p>Have an account? <a href="#login" class="pop-up" id="jqlogin">login here</a></p>
							</div>							
						</form>
					</div>
				</div>
				
				<div id="forgot-password" class="pop-up-content login-content">
					<h2>Forgot password?</h2>
					<div class="login-div">
						<p>Please enter your email address below. We will send you a link to reset the password</p>
						<form name="forgot-form" id="forgot-form" method="POST" action="">
							<ul>
								<li><div id="counter_result"></div>
									<label>Enter your Email address<span class="mandatory">*</span></label>
									<input type="text" class="form-control commen-textfeild" name="forgot_email" id="forgot_email">
								</li>
								<div id="forgot_result"></div>
								<div id="forgot-loading" style="display:none;">
								  <p><img src="<?php echo BASE_URL;?>assets/img/whiteloader.gif" /> </p>
								</div>
								<li>
									<div class="pop-up-button">
										<button class="commen-button-black" id="reset_pwd">Reset Password</button>
									</div>
								</li>
							</ul>
						</form>
					</div>	
				</div>