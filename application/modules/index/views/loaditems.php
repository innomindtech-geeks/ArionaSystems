<?php
	$prodlist	= $prodInfo->records;

$i= 0;
							if(sizeof($prodlist) > 0 ) {
							echo '<div class="row">';
								foreach($prodlist as $items) {
									if($i == 4) {
										$i=0;
										echo '</div><div class="row">';
									}
									
							?>
                            
                            
								<div class="col-md-3 col-sm-6">
									<div class="item-base">
										<div class="thumb-image">
											<a href="<?php echo BASE_URL.'product/'.$items->pr_id;?>"><img src="<?php showimage('list_'.$items->pr_image,'list');?>" class="img-responsive" alt="" /></a>
                                            
											<?php if($this->session->userdata('user_id')!=''&& $this->session->userdata('user_id') != $items->pr_addedby){ 
													$now = time(); 
													$upvotedate = strtotime($items->up_addedon);
													$datediff = $now - $upvotedate;
													$days =  floor($datediff/(60*60*24));	?>                                            
											<?php echo '<a href="javascript:;" id="jqhomepvote'.$items->pr_id.'" class="upvote jqupvote '. (($items->pr_id==$items->up_prodid&&$this->session->userdata('user_id')==$items->up_userid&&$days < 5)?'upvoted':'').' " data-attr="'. $items->pr_id.'">'.(($items->pr_id==$items->up_prodid&&$this->session->userdata('user_id')==$items->up_userid &&$days < 5)?'Upvoted':'Upvote').'<i class="cf"></i></a>'; ?>
                                            <?php } ?>
											
                                            <div class="item-description">
                                                <h6><a href="<?php echo BASE_URL.'product/'.$items->pr_id;?>"><?php  echo (($items->de_name == '')? $items->pr_designer:$items->de_name);?></a></h6>
												<p> <?php echo stripslashes($items->pr_title); ?> </p>
                                            </div>											
										</div>                                        
                                         <div class="forTouch">
											<?php if($this->session->userdata('user_id')!=''&& $this->session->userdata('user_id') != $items->pr_addedby){ 
													$now = time(); 
													$upvotedate = strtotime($items->up_addedon);
													$datediff = $now - $upvotedate;
													$days =  floor($datediff/(60*60*24));	?>                                            
											<?php echo '<a href="javascript:;" id="jqhomepvote'.$items->pr_id.'" class="upvote jqupvote '. (($items->pr_id==$items->up_prodid&&$this->session->userdata('user_id')==$items->up_userid&&$days < 5)?'upvoted':'').' " data-attr="'. $items->pr_id.'">'.(($items->pr_id==$items->up_prodid&&$this->session->userdata('user_id')==$items->up_userid &&$days < 5)?'Upvoted':'Upvote').'<i class="cf"></i></a>'; ?>
                                            <?php } ?>
											<div class="item-description">
                                                <h6><a href="<?php echo BASE_URL.'product/'.$items->pr_id;?>"><?php  echo (($items->de_name == '')? $items->pr_designer:$items->de_name);?></a></h6>
												<p> <?php echo stripslashes($items->pr_title); ?> </p>
                                            </div>											 
										 </div>
                                        <div class="item-size">
                                            <div class="item-p">
                                            	<?php 
												$priceClass = '';
												if($items->pr_lastprice != '' && $items->pr_lastprice > 0 && $items->pr_lastprice > $items->pr_prize){
													echo '<span class="old-price">'.DEFAULT_CURRENCY.$items->pr_lastprice.'</span>';
													$priceClass = 'new-';
												}
												?>
                                                <span class="<?php echo $priceClass;?>price"><?php echo DEFAULT_CURRENCY.$items->pr_prize; ?></span>
                                            </div>
											
											<?php if($items->sz_value!=""){ ?>
                                            <div class="item-s">   
                                                <span><?php echo $items->sz_value; ?></span>
                                            </div>
                                            <?php } ?>
											<!--Add to selections-->
											<?php
												if($userid != '' )
												echo '<a href="#addselection'.$items->pr_id.'" id="jqhomesel_'.$items->pr_id.'"  class="more '. (($items->sel_userid==$userid )?'select':'').' pop-up-img" data-attr="'. $items->pr_id.'"></a>';
											?>
                                        </div>			  
											<!-- Add to selections-->
											<div id="addselection<?php echo $items->pr_id;?>" class="pop-up-content popup-img">
												<div class="popuphead">
													<h2>Add to My Selections+</h2>
												</div>
												
												<div class="row">
													<div class="popup-img-lftCol">
														<img src="<?php showimage('list_'.$items->pr_image,'list');?>" class="img-responsive" alt="" />
													</div>
													<div class="popup-img-rhtCol">
														<div class="item-description">
															<h6><a href="#"><?php  echo (($items->de_name == '')? $items->pr_designer:$items->de_name);?></a></h6>
															<p><?php echo stripslashes($items->pr_title); ?></p>
														</div>														
													   <p>Add this item to My Selections+</p>
														<div class="pop-up-button"> 											
															<?php 
															echo '<a href="javascript:;"  class="commen-button-black '. (($items->sel_userid==$userid )?'select':'').' jqmyselections" data-attr="'. $items->pr_id.'">'.(($items->sel_userid==$userid )?'Added':'Add Now').'</a>';
															?>
														</div>
													</div>
												</div>
											</div>
											<!-- Add to selections pop up ends -->
									</div>
								</div>
                                <?php
									$i++;
										if($i==2){
											echo '<div class="clearfix visible-xs"></div>';
										}
									}
									echo '</div>';
									
								}
								?>