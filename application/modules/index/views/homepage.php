<!-------- banner ---------->
	<?php echo  $this->load->view('banners');?>
	<!-------- End banner ---------->
<script src="<?php echo BASE_URL;?>scripts/homefunctions.js"></script>


    <!------------------------------------------->
	
   <div class="inner-wrapper">
    <div class="container">
		<div class="featured-itms">
			<div class="row">

				<!-- Filter-->
				<div class="col-md-3 col-sm-4 col-xs-12">
                	<div class="filter-products">
						<h6>Filter Products</h6>
						<div class="filter-cont-padd">
							<div class="filter-options">
                            	<!--Categories-->
								<h4>Categories</h4>
                                <div class="accordian-base">
									<div class="custom-scroll-div" id="jqcatlisting">
										 Loading Categories
									</div>
								</div>
                                
                                <!--DESIGNERS-->
								<h4>Designers</h4>
                                <div class="accordian-base">
									<div class="custom-scroll-div" id="jqdesignerlisting">
										Loading Designers
									</div>
								</div>
                                
                                <!--SIZE-->
								<h4>Size</h4>
                                <div class="accordian-base">
									<div class="custom-scroll-div">
										<div class="filter-size-div" id="jqsizelisting">
											Loading Size
										</div>
									</div>
								</div>
                                
                                <!--COUNTRY-->
								<h4>Country</h4>
                                <div class="accordian-base">
									<div class="custom-scroll-div">
										<ul id="jqulcounty">
											<?php
											foreach($countryList as $key=>$country) {
												echo '<li><a href="#" id="'.$key.'" class="jqcountryitem">'.$country.'</a></li>';
											}
											?>
										 
										</ul>
									</div>
								</div>
                                
                                <!--PRICE-->
								<h4>Price</h4>
                               <div class="accordian-base">
                                	<div class="rangeslidervalues">
                                    	<span id="value-lower"></span> - <span id="value-higher"></span>
                                    </div>
									<div class="range-slider">
										
									</div>
								</div>
								
                                <input type="hidden" id="pricestart" name="pricestart" value="0">
								<input type="hidden" id="priceend" name="priceend" value="5000">
                                
                                
                                <!-- Clear All-->
                                <div class="clear-feilds">
                                    <a href="javascript:void(0)" id="jqclearfilter">Clear All filters</a>
                                </div>
                            </div>
                        </div>
                   </div>
                </div>
                <!-- Filter ends-->
                
                <!-- Product List-->
				<div class="col-md-9 col-sm-8 col-xs-12">
				<!-- Sort and search-->
					<div class="sortNsearch">
						<div class="row">
							<div class="col-sm-6 pull-right">
								<!-- Search -->
								<div class="search">
									<input type="text" name="jqsearchtext" id="jqsearchtext" placeholder="Enter Keyword to Search" >
									<div class="searchBut"><input type="button" name="jqsearchbtn" id="jqsearchbtn" value="Search"></div>
								</div>  
							</div>
							<div class="col-sm-6">
								<div class="sort">
									<label>Sort by : </label>
									<select name="select" id="jqitemsorting">
									  <option value="">DEFAULT</option>
									  <option value="date">DATE ADDED</option>
									  <option value="lowprice">LOW PRICE</option>
									  <option value="highprice">HIGH PRICE</option>
									</select>
								</div>
							</div>
							
						</div>
					</div>
				
                <div id="jqitemlisting" class="prdt-list">
                	
                    
                    <!-- Load the content -->
					<center><img src="<?php echo BASE_URL;?>assets/img/loading.gif" /></center>
                </div>
                
                
                
                <input type="hidden" name="loadpagecount" id="loadpagecount" value="1">
<!--Loader-->
                <div id="loadmoreajaxloader" style="display:none;padding:30px 0;">
                    <center><img src="<?php echo BASE_URL;?>assets/img/loaderitem.gif" /></center>
                </div>
                
                </div>
                <!-- Product List ends-->
               </div>
              </div>
             </div>
             </div>
	 

 	
 