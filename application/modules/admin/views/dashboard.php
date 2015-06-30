<div class="span9" id="content">
                    <div class="row-fluid">
                        <div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left"><a href="<?php echo base_url('admin/user');?>">Users</a></div>
                                    
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('common_sl_no'); ?></th>                                                
                                                <th><?php echo lang('common_username'); ?></th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										
										if(sizeof($user->records > 0)) {
										$i=1;
										foreach($user->records as $user){
										?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $user->u_username;?></td>
                                                <td><?php echo $user->u_email;?></td>                                                
                                            </tr>
										<?php }
										
										}?>                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
                        <div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left"><a href="<?php echo base_url('admin/products');?>">New Products Listing</a></div>
                                     
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('common_sl_no'); ?></th>
                                                <th><?php echo lang('common_name'); ?></th>
                                                <th>Category</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
										if(count($seminars->records)>0){
                                           $i=1;
										foreach($seminars->records as $seminar){
										?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $seminar->pr_title;?></td>
                                                <td><?php echo $seminar->cat_name;?></td>
                                                <td>$<?php echo $seminar->pr_prize;?></td>                                      
                                            </tr>
										<?php }
										
										}?>          
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
                    </div>
                    <div class="row-fluid">
                    <div class="span6">
                        <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left"><a href="<?php echo base_url('admin/payments');?>">Payment Transactions</a></div>
                                     
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('common_sl_no'); ?></th>
                                                <th>Paid by</th>
                                              
                                                <th>Amount</th>
                                                <th>Paid on</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											
										if(count($paymentlist->records)>0){
                                           $i=1;
										foreach($paymentlist->records as $payment){
										?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $payment->u_username;?></td>
                                     
                                                <td>$<?php echo $payment->tr_amount;?></td>
                                                <td><?php echo date('d M Y',strtotime($payment->tr_date));?></td>                                      
                                            </tr>
										<?php }
										
										}?>          
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div></div>
							
							 <div class="span6 chart">
							 
							 
							 <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left"> Products Sold</div>
                                     
                                </div>
                                    <div id="hero-bar" style="height: 215px;"></div>
                                </div>
							</div>
                      
                    </div>
                 
                </div></div>
			 <?php //echopre1($paymentgraph); ?>
		
				
<link rel="stylesheet" href="<?php echo BASE_URL;?>application/templates/admin/bootstrap/vendors/morris/morris.css">
<script src="<?php echo BASE_URL;?>application/templates/admin/bootstrap/vendors/raphael-min.js"></script>
<script src="<?php echo BASE_URL;?>application/templates/admin/bootstrap/vendors/morris/morris.min.js"></script>
	
<script>
        $(function() {

			function doPlot(position) {
				$.plot("#timechart"  );
			}

			doPlot("right");

        });

        // Morris Bar Chart
        Morris.Bar({
            element: 'hero-bar',
            data: [
			<?php
			if(sizeof($paymentgraph) > 0) {
				foreach($paymentgraph as $payitems) {
					echo "{device: '".$payitems->ldate."', sells: ".$payitems->lsum."},";
				}
			}
			?>
               
            ],
            xkey: 'device',
            ykeys: ['sells'],
            labels: ['Sells'],
            barRatio: 0.4,
            xLabelMargin: 10,
            hideHover: 'auto',
            barColors: ["#3d88ba"]
        });


       

  

        // Build jQuery Knobs
        $(".knob").knob();

        function labelFormatter(label, series) {
            return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
        }
        </script>