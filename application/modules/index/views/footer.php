 
<?php
 if($this->session->userdata('user_id')){
	  
	$ses	= $this->session->userdata('user_id');
	if($ses == '') $ses = '1';
	if(!function_exists("freichatx_get_hash")){
		function freichatx_get_hash($ses){
 
		   if(is_file(SITEPATH."chatapp/hardcode.php")){
				   require SITEPATH."chatapp/hardcode.php";
				   $temp_id =  $ses . $uid;
				   return md5($temp_id);
		   }
		   else {
				   echo "<script>alert('module freichatx says: hardcode.php file not found!');</script>";
		   }
		   return 0;
		}
	}
	?>
	<script type="text/javascript" language="javascipt" src="<?php echo BASE_URL;?>chatapp/client/main.php?id=<?php echo $ses;?>&xhash=<?php echo freichatx_get_hash($ses); ?>"></script>
	<link rel="stylesheet" href="<?php echo BASE_URL;?>chatapp/client/jquery/freichat_themes/freichatcss.php" type="text/css">

	<?php
	addtoChatList($ses);

}
?>
 
<!--===========================FreiChatX=======END=========================-->                
<script>
$ = jQuery;
</script>

<div class="footer">
	<div class="container">
            <div class="row">
            	<div class="col-xs-12">
                    <div class="footer-over">
                        <div class="f-social">
                            <ul>
                                <li><a href="https://www.facebook.com/shopsonnet?ref=hl" target="_blank"><i class="cf icon-facebook"></i></a></li>
                                <li><a href="http://sonnetvibes.tumblr.com" target="_blank"><i class="cf icon-tumblr"></i></a></li>
                                <li><a href="http://instagram.com/__sonnet__" target="_blank"><i class="cf icon-instagram"></i></a></li>
                            </ul>
                        </div>
                        
                        <div class="news-subscribe">
                            <div id="subscribe-result"></div>		
                             <div id="subscribe-loading" style="display:none;">
                                <span><img src="<?php echo BASE_URL;?>assets/img/whiteloader.gif" /> Please Wait</span>
                            </div>
                                <form name="newsletter_subscription" id="newsletter_subscription" method="post" action="">
                                    <input type="text" class="news-text-feild" placeholder="Please enter your email" name="newsletter_email" id="newsletter_email">
                                    <button id="subscribe_news" type="submit">SUBSCRIBE</button>
                                </form>
                            <div class="clear"></div>
                        </div>
                        <div class="footer-metta">
                            <ul>
                                <li><a href="<?php echo BASE_URL;?>about">ABOUT</a></li>
                                <li><a href="mailto:support@thrnprf.com">CONTACT US</a></li>         
                                <li><a href="<?php echo BASE_URL;?>faq">faq</a></li>
                                <li><a href="<?php echo BASE_URL;?>privacy">Privacy Policy</a></li>
                            </ul>
                            <p>&copy;2014 sōnnet</p>
                        </div>
                    </div>
                   </div>
                  </div>
                 </div>
	</div>
	
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-51512652-1', 'auto');
ga('require', 'displayfeatures');
ga('send', 'pageview');

</script>
