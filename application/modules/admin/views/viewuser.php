 <div class="span9" id="content">
                      <!-- morris stacked chart -->
                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">View user details</div>
                            </div>
                            <div class="block-content collapse in"><span style="color:#F00;">
                            <?php echo $message; ?></span>
                                <div class="span12">
                                   <form class="form-horizontal" method="post" id="edituser" >
                                      <fieldset>
                                        <legend>User Details</legend>
                                        
										
										<table class="table table-striped">
						  
						  <tbody>
						    
							 <tr>
								<td>Email </td>
                                <td> : <?php echo $userinfo->u_email;?>     </td>								
								<td> </td>
                                <td> Username</td>
                                <td> : <?php echo $userinfo->u_username;?> </td>								
								 
								
							</tr>
						 <tr>
								<td>Country </td>
                                <td> :  <?php echo $userinfo->u_country;?>     </td>								
								<td> </td>
                                <td> Rating</td>
                                <td> : <?php echo $userinfo->u_rating;?>  </td>								
								 
								
							</tr>
							 <tr>
								<td>Height </td>
                                <td> : <?php echo $userinfo->u_height;?>     </td>								
								<td> </td>
                                <td> Weight</td>
                                <td> : <?php echo $userinfo->u_weight;?>  </td>								
								 
								
							</tr>
						  </tbody>
					</table>
										
										
										
										
										<br>
							   <legend>Items added by this user</legend>
                                        
		 
				 <div class="block-content collapse in">
					<div class="span12">
					<table class="table table-striped">
						<thead>
							<tr>
							  <th><?php echo lang('common_sl_no');?></th>
                              <th>Image</th>
                              <th>Product Name</th>                              
                               <th>Category</th>
                               <th>Price</th>
							<!--  <th><?php echo lang('common_status');?></th>-->
							  <th><?php echo lang('common_action');?></th>
                             
							  <?php /*?><th><?php echo lang('common_title');?></th>
							  <th><?php echo lang('thumb_image');?></th>  */?>
							</tr>
					   </thead>
					   <tbody>
					    <?php 
							if(sizeof($postList->records) > 0)
							{
							//if($cur_page=="") $cur_page =1;
					        //  $i= ($cur_page * $per_page )- $per_page+1;
							$i=1;
							 foreach($postList->records as $list){
						  ?>
							 <tr>
									<td><?php echo $i++; ?></td>
									<td><img src="<?php showimage('list_'.$list->pr_image,'list');?>" width="100" height="100"></img></td>
                                    <td><?php echo $list->pr_title;?></td>									
                                    <td><?php echo $list->cat_name;?></td>
                                    <td>$<?php echo $list->pr_prize;?></td>
								<!--	<td><?php if( $list->pr_status==1) { echo 'Active';} else { echo "InActive"; }  ?></td>-->
									<td><a href="<?php echo base_url('admin/products/view_details/'.$list->pr_id)?>" title="Edit">View Details</i></a>
										<!--<a href="<?php echo base_url('admin/products/delete/'.$list->banner_id)?>" title="Delete" onclick="return confirm('Are You sure?')"><i class="icon-remove"></i></a>-->
									</td>
							</tr>
						 	<?php 
								}
							}
							else
							{
						?>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp; </td>
								<td><?php echo lang('common_no_result'); ?> </td>
								<td>&nbsp; </td>
								<td>&nbsp; </td><td>&nbsp; </td>
							</tr>
						<?php
							}
						?>
					   </tbody>
					</table>
					 
					</div>
				 </div>
			
		 		
										
										
										
                                  
                                         
                                        
                                        <div class=" ">
                                        
                                          <button type="reset" class="btn btn-primary" onclick="window.location='<?php echo base_url('admin/user');?>'">Back</button>
                                        </div>
                                      </fieldset>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
           

 <!-- wizard -->               

</div>
                
                  
    