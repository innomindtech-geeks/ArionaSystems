<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title> <?php  echo $title_for_layout;?> </title>
        <!-- Bootstrap -->
        <link href="<?php echo BASE_URL.ADMIN_TEMPLATE;?>bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo BASE_URL.ADMIN_TEMPLATE;?>bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo BASE_URL.ADMIN_TEMPLATE;?>vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
        
        <link href="<?php echo BASE_URL.ADMIN_TEMPLATE;?>assets/styles.css" rel="stylesheet" media="screen">
      	<link href="<?php echo BASE_URL.ADMIN_TEMPLATE;?>assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/slicknav.css">
        <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/jquery.bxslider.css">
           
      	  <script src="<?php echo BASE_URL.ADMIN_TEMPLATE;?>vendors/jquery-1.9.1.min.js"></script>
      	   <script src="<?php echo BASE_URL;?>application/helpers/js/jquery.validate.js"></script>
      	     <script src="<?php echo BASE_URL;?>application/helpers/js/admin-functions.js"></script>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script>
        var BASE_URL = '<?php echo BASE_URL;?>';
        </script>
        
<script>
$(document).ready(function(){
    $(".alert").fadeOut(5000);
});
</script>
       </head>
    
    <body>
         <?php echo  $this->load->view('topmenu');?>
        <div class="container-fluid">
            <div class="row-fluid">
                 <?php echo  $this->load->view('leftmenu');?>
                
                <!--/span-->
                <?php echo $content_for_layout;?>
            </div>
            <hr>
             <?php echo  $this->load->view('footer');?>
        </div>
        <!--/.fluid-container-->
         <link href="<?php echo BASE_URL.ADMIN_TEMPLATE;?>vendors/uniform.default.css" rel="stylesheet" media="screen">
           <script src="<?php echo BASE_URL.ADMIN_TEMPLATE;?>vendors/jquery.uniform.min.js"></script>
		    <script src="<?php echo BASE_URL.ADMIN_TEMPLATE;?>vendors/bootstrap-datepicker.js"></script>
         
        <script src="<?php echo BASE_URL.ADMIN_TEMPLATE;?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo BASE_URL.ADMIN_TEMPLATE;?>vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="<?php echo BASE_URL.ADMIN_TEMPLATE;?>assets/scripts.js"></script>
     	<script src="<?php echo BASE_URL.ADMIN_TEMPLATE;?>vendors/ckeditor/ckeditor.js"></script>
		<script src="<?php echo BASE_URL.ADMIN_TEMPLATE;?>vendors/ckeditor/adapters/jquery.js"></script>
         
 

         
        <script>
        $(function() {
			 $(".datepicker").datepicker();
		   $(".uniform_on").uniform();
            $('.chart').easyPieChart({animate: 1000});
			$( 'textarea#ckeditor_full' ).ckeditor({width:'98%', height: '150px'});
			
			 // Ckeditor standard
            $( 'textarea#ckeditor_standard' ).ckeditor({width:'98%', height: '150px', toolbar: [
				{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
				[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],			// Defines toolbar group without name.
				{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Styles', 'Format', 'Font', 'FontSize' ] }
			]});
        });
        </script>
    </body>

</html>