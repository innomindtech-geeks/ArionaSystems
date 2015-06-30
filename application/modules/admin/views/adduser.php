<?php error_reporting(0); ?>
<div class="span9" id="content">
 <?php echo $message; ?>
<!-- morris stacked chart -->
	<div class="row-fluid">
			<!-- block -->
			<div class="block">
				<div class="navbar navbar-inner block-header">
					<div class="muted pull-left"><?php echo lang('add_edit_user'); ?></div>
				</div>
				<div class="block-content collapse in">
					<div class="span12">
					 <form class="form-horizontal" method="post" name="user-form" id="user-form"  action="<?php echo base_url('admin/index/adduser/'); ?>" >
					  <fieldset>
						<legend><?php echo lang('user_add'); ?></legend>
						<div class="control-group">
						  <label class="control-label"><?php echo lang('user_fname'); ?><span class="red">*</span></label>
						  <div class="controls">
							<input name="txt_fname" class="input-xlarge focused" id="txt_fname" type="text">
						  </div>
						</div>
						<div class="control-group">
						  <label class="control-label" for="focusedInput"><?php echo lang('user_lname'); ?><span class="red">*</span></label>
						  <div class="controls">
							<input name="txt_lname" class="input-xlarge focused" id="txt_lname" type="text">
						  </div>
						</div>
						<div class="control-group">
						  <label class="control-label" for="focusedInput"><?php echo lang('user_email'); ?><span class="red">*</span></label>
						  <div class="controls">
							<input name="txt_email" class="input-xlarge focused" id="txt_email" type="text">
						  </div>
						</div>
						<div class="control-group">
						  <label class="control-label" for="focusedInput"><?php echo lang('user_username'); ?><span class="red">*</span></label>
						  <div class="controls">
							<input name="txt_username" class="input-xlarge focused" id="txt_username" type="text">
						  </div>
						</div>
						<div class="control-group">
						  <label class="control-label" for="focusedInput"><?php echo lang('user_password'); ?><span class="red">*</span></label>
						  <div class="controls">
							<input name="txt_password" class="input-xlarge focused" id="txt_password" type="password">
						  </div>
						</div>
						<div class="control-group">
						  <label class="control-label" for="optionsCheckbox"><?php echo lang('user_paid'); ?></label>
						  <div class="controls">
							<label class="uniform">
							  <input class="uniform_on" type="checkbox" id="optionsCheckbox" value="1" name="paid">
							 <?php echo lang('common_yes'); ?>
							</label>
						  </div>
						</div>
						<div class="control-group">
						  <label class="control-label" for="optionsCheckbox"><?php echo lang('common_active'); ?></label>
						  <div class="controls">
							<label class="uniform">
							  <input class="uniform_on" type="checkbox" id="optionsCheckbox" value="1" name="active">
							 <?php echo lang('common_yes'); ?>
							</label>
						  </div>
						</div>
						
						<div class="form-actions">
						  <button type="submit" name="btnUpdate" class="btn btn-primary"><?php echo lang('common_save_changes'); ?></button>
						  <button type="reset" class="btn" onclick="window.location='<?php echo base_url('admin/user');?>'"><?php echo lang('common_cancel'); ?></button>
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