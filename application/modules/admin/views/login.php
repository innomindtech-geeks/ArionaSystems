<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Admin Login</title>
    <!-- Bootstrap -->
    <link href="<?php echo BASE_URL.ADMIN_TEMPLATE;?>bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo BASE_URL.ADMIN_TEMPLATE;?>bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo BASE_URL.ADMIN_TEMPLATE;?>assets/styles.css" rel="stylesheet" media="screen">
	<!--<script src="<?php echo BASE_URL.ADMIN_TEMPLATE;?>vendors/jquery-1.9.1.min.js"></script>-->
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="<?php echo BASE_URL.ADMIN_TEMPLATE;?>vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
    <div class="container">
	<span style="width:150px;"><?php echo $message; ?></span>
    
      <div class="loginHeader"><img src="<?php echo base_url('images/emailogo.png');?>" class="logo"></div>
      <form class="form-signin" name="sign-in" id="sign-in" method="post" action="<?php echo base_url('admin/do_login');?>">
       <!-- <h2 class="form-signin-heading">Please sign in</h2>-->
	   <span class="legend">&nbsp;</span>
        <input type="text" class="input-block-level" placeholder="User Name" name="username" autofocus>
        <input type="password" class="input-block-level" placeholder="Password" name="password">
       <!-- <label class="checkbox">
          <input type="checkbox" value="1" name="remember_me"/> Remember me
	   </label>-->        
        <div class="row-fluid">
            <div class="span6"><button class="btn button-submit" type="submit" value="login">Sign in</button></div>
            <div class="span6" align="right"><a href="#myModal" data-toggle="modal" class="password">Forgot Password?</a></div>
        </div>
      </form>
	  <!-- forgot password section--->
		<div id="myModal" class="modal hide">
			<div class="modal-header">
				<button data-dismiss="modal" class="close" type="button">&times;</button>
				<h3>Enter Your Email</h3>
			</div>
			<div class="modal-body">
				 <form class="form-horizontal" name="forgot_password" id="forgot_password" method="post" action="<?php echo base_url('admin/index/forgotten_password');?>">
				 <fieldset>
					<div class="control-group">
					  <label class="control-label" for="focusedInput">Email</label>
					  <div class="controls">
						<input class="input-xlarge focused" required id="email" type="email" name="email" value="">
					  </div>
					</div>
					 <div class="form-actions">
					  <button type="submit" class="btn btn-primary">Submit</button>
					  <button type="reset" class="btn">Cancel</button>
					</div>
				</fieldset>
				</form>			
			</div>
		</div><!---- end forgot password---->
    </div> <!-- /container -->
    <script src="<?php echo BASE_URL.ADMIN_TEMPLATE;?>vendors/jquery-1.9.1.min.js"></script>
    <script src="<?php echo BASE_URL.ADMIN_TEMPLATE;?>bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>