<div class="span9" id="content">
 <?php echo $message; ?>
<!-- morris stacked chart -->
	<div class="row-fluid">
			<!-- block -->
			<div class="block">
				<div class="navbar navbar-inner block-header">
					<div class="muted pull-left"><?php echo lang('add_edit_banners'); ?></div>
				</div>
				<div class="block-content collapse in">
					<div class="span12">
					 <form class="form-horizontal" method="post" id="editcms"  action="<?php echo base_url('admin/banners/add/'.$banner_id); ?>" enctype="multipart/form-data">
					  <fieldset>
					  <?php if($banner_id!=""){ $page_head=lang('banner_edit'); } else { $page_head=lang('banner_add'); }?>
						<legend><?php echo $page_head; ?></legend>
						
						<div class="control-group">
						  <label class="control-label"><?php echo lang('common_title'); ?></label>
						  <div class="controls">
							  <input type="text" class="span6" id="txttitle" name="txttitle" value="<?php echo $title;?>">
						  </div>
						</div>
						<div class="control-group">
						  <label class="control-label"><?php echo lang('common_file'); ?></label>
						  <div class="controls">
							  <input type="file" id="banner_image" name="banner_image">
						  </div>
						</div>
						<!--
						<div class="control-group">
						  <label class="control-label" for="optionsCheckbox"><?php echo lang('common_active'); ?></label>
						  <div class="controls">
							<label class="uniform">
							  <input class="uniform_on" type="checkbox" id="optionsCheckbox" value="1" name="active" <?php if($active==1){ echo 'checked="checked"'; }?>>
							  <?php echo lang('common_yes'); ?>
							</label>
						  </div>
						</div>
						-->
						
						<?php if($filepath!=""){?>
						<div class="control-group">
						  <label class="control-label" for="optionsCheckbox"><?php echo lang('current_image')?></label>
						  <div class="controls">
							
								<div style="height:250px;width:765px;">
									<img src="<?php echo BASE_URL.'/files/'.$filepath;?>"></img>
									<input type="hidden" name="old_image" id="old_image" value="<?php echo $filepath;?>" >
									<input type="hidden" name="banner_file_id" id="banner_file_id" value="<?php echo $banner_file_id;?>" >
								</div>
							
						  </div>
						</div>
						<?php } ?>
						
						<div class="form-actions">
						  <button type="submit" name="btnUpdate" class="btn btn-primary"> <?php echo lang('common_save_changes'); ?></button>
						  <button type="reset" class="btn" onclick="window.location='<?php echo base_url('admin/banners');?>'"><?php echo lang('common_cancel'); ?></button>
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