<div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                        <li <?php if($this->uri->uri_string() == 'admin/dashboard') { ?> class="active"<?php } ?> >
                            <a href="<?php echo BASE_URL;?>admin/dashboard"><i class="icon-chevron-right"></i><?php echo lang('common_dashboard'); ?></a>
                        </li>
                        <li <?php if($this->uri->uri_string() == 'admin/cms' || $this->uri->uri_string() == 'admin/index/addcontent'     || (strpos($this->uri->uri_string(), 'getCms') !== false)) { ?> class="active"<?php } ?> >
                            <a href="<?php echo BASE_URL;?>admin/cms"><i class="icon-chevron-right"></i><?php echo lang('common_cms'); ?></a>
                        </li>
						<li <?php if($this->uri->uri_string() == 'admin/banners' || $this->uri->uri_string() == 'admin/banners/add' || (strpos($this->uri->uri_string(), 'banners') !== false)) { ?> class="active"<?php } ?>>
                            <a href="<?php echo base_url('admin/banners'); ?>"><i class="icon-chevron-right"></i><?php echo lang('common_banners'); ?></a>
                        </li>
                         <li <?php if($this->uri->uri_string() == 'admin/user' || (strpos($this->uri->uri_string(), 'viewuser') !== false)) { ?> class="active"<?php } ?> >
                            <a href="<?php echo BASE_URL;?>admin/user"><i class="icon-chevron-right"></i><?php echo lang('common_users'); ?></a>
                        </li>
						 
                        <li <?php if($this->uri->uri_string() == 'admin/products' || $this->uri->uri_string() == 'admin/products/add' || (strpos($this->uri->uri_string(), 'products') !== false)) { ?> class="active"<?php } ?>>
                            <a href="<?php echo base_url('admin/products'); ?>"><i class="icon-chevron-right"></i>Products</a>
                        </li>
                        
                         <li <?php if($this->uri->uri_string() == 'admin/payments' || $this->uri->uri_string() == 'admin/payments/add' || (strpos($this->uri->uri_string(), 'payments/view_details') !== false)) { ?> class="active"<?php } ?>>
                            <a href="<?php echo base_url('admin/payments'); ?>"><i class="icon-chevron-right"></i>Payments</a>
                        </li>
              
						<li <?php if($this->uri->uri_string() == 'admin/emailtemplate' || $this->uri->uri_string() == 'admin/emailtemplate/add' || (strpos($this->uri->uri_string(), 'emailtemplate') !== false)) { ?> class="active"<?php } ?>>
                            <a href="<?php echo base_url('admin/emailtemplate'); ?>"><i class="icon-chevron-right"></i><?php echo lang('common_emailtempaltes'); ?></a>
                        </li>
						<li <?php if($this->uri->uri_string() == 'admin/newsletter/subscriberList' || $this->uri->uri_string() == 'admin/newsletter/add') { ?> class="active"<?php } ?>>
                            <a href="<?php echo base_url('admin/newsletter/subscriberList'); ?>"><i class="icon-chevron-right"></i>Newsletter Subscriber List</a>
                        </li>
					 
	 
						<li <?php if($this->uri->uri_string() == 'admin/settings') { ?> class="active"<?php } ?>>
                            <a href="<?php echo base_url('admin/settings'); ?>"><i class="icon-chevron-right"></i><?php echo lang('common_settings'); ?></a>
                        </li>
                        
                    </ul>
                </div>