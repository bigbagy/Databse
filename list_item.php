<?php
include('lib/common.php');
// written by GTusername4
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	 
	     $Itemname = mysqli_real_escape_string($db, $_POST['Itemname']);
         $Description = mysqli_real_escape_string($db, $_POST['Description']);
         if (empty($Description)) {
         $Description = "NULL";
		 }		 
         $GetItNowPrice = mysqli_real_escape_string($db, $_POST['GetItNowPrice']);
         $StartBidPrice = mysqli_real_escape_string($db, $_POST['StartBidPrice']);			 
         $MinimumSalePrice = mysqli_real_escape_string($db, $_POST['MinimumSalePrice']);		 
         $Returnable = mysqli_real_escape_string($db, $_POST['Returnable']);	
		 
         $AuctionEndsIn = mysqli_real_escape_string($db, $_POST['AuctionEndsIn']);	 	 
		 $today = date("Y-m-d H:i:s"); 
		 $AuctionEndTime = $today;
		 if ($AuctionEndsIn == 1) {
         $AuctionEndTime = date('Y-m-d H:i:s',strtotime('+1 day',strtotime($today)));
		 }
		 if ($AuctionEndsIn == 3) {
         $AuctionEndTime = date('Y-m-d H:i:s',strtotime('+3 day',strtotime($today)));
		 }		 
		 if ($AuctionEndsIn == 5) {
         $AuctionEndTime = date('Y-m-d H:i:s',strtotime('+5 day',strtotime($today)));
		 }		 
		 if ($AuctionEndsIn == 7) {
         $AuctionEndTime = date('Y-m-d H:i:s',strtotime('+7 day',strtotime($today)));
		 }
		 
         $Category = mysqli_real_escape_string($db, $_POST['Category']);
         $Condition = mysqli_real_escape_string($db, $_POST['Condition']);		 
		 //array_push($error_msg, "$today and   $AuctionEndsIn  {$_SESSION['username']}"); // This is for debug
		 //array_push($error_msg, "$Category and $Condition");  // This is for debug
		 
         if (empty($Itemname)) {
             array_push($error_msg,  "Please enter item name.");
         }
         if (empty($StartBidPrice)) {
            array_push($error_msg,  "Please enter a start bid price.");
         }
         if (empty($MinimumSalePrice)) {
            array_push($error_msg,  "Please enter a minimum sale price.");
         }

         if ($MinimumSalePrice>$GetItNowPrice && !empty($GetItNowPrice)) {
            array_push($error_msg,  "Please enter a get it now price that is higher than MinimumSalePrice.");
         }	
         if ($StartBidPrice>$GetItNowPrice && !empty($GetItNowPrice)) {
            array_push($error_msg,  "Please enter a StartBidPrice that is higher than MinimumSalePrice.");
         }		 
		 
		
         if ( !empty($Itemname) && !empty($StartBidPrice) && !empty($GetItNowPrice) && ($MinimumSalePrice<=$GetItNowPrice) && ($StartBidPrice<=$GetItNowPrice))   { 
			$query = "INSERT INTO auctionitem (description, getitnowprice, returnable, auctionendtime, minimumsaleprice, startbidvalue, itemname, username, catname, contype) " .
                     "VALUES('$Description', $GetItNowPrice, $Returnable, '$AuctionEndTime', $MinimumSalePrice, $StartBidPrice, '$Itemname','{$_SESSION['username']}', '$Category', '$Condition')" ;
            $result = mysqli_query($db, "$query");
            include('lib/show_queries.php');
            if (mysqli_affected_rows($db) == -1) {
                 array_push($error_msg,  "Not Listed" );	            								
			}
			else {
				array_push($query_msg, "Item Listed");					 

					 
			}
		 }
		 elseif (!empty($Itemname) && !empty($StartBidPrice) && empty($GetItNowPrice)) {
			$query = "INSERT INTO auctionitem (description,  returnable, auctionendtime, minimumsaleprice, startbidvalue, itemname, username, catname, contype) " .
                     "VALUES('$Description',  $Returnable, '$AuctionEndTime', $MinimumSalePrice, $StartBidPrice, '$Itemname','{$_SESSION['username']}', '$Category', '$Condition')" ;
			$result = mysqli_query($db, "$query");
            include('lib/show_queries.php');
            if (mysqli_affected_rows($db) == -1) {
                 array_push($error_msg,  "Not Listed" );	            								
			}
			else {
				array_push($query_msg, "Item Listed");	
			
			}
		 }
		 else {
		 array_push($error_msg,  "Not Listed" );
		 }
    
	 }
 
?>

<?php include("lib/header.php"); ?>
<title>GTBay List Item</title>
</head>

<body>
    <div id="main_container">
	    <?php include("lib/menu.php"); ?>
			<div class="center_content">	
				<div class="center_left">     
					<div class="features">    						                           
							<div class="subtitle">List Item </div>   
                            
							<form name="profileform" action="list_item.php" method="post">
								<table>

									<tr>
										<td class="item_label">Item Name</td>
										<td>
											<input type="text" name="Itemname" value="" />									
										</td>
									</tr>
									<tr>
										<td class="item_label">Description</td>
										<td>
											<input type="text" name="Description"  />	
										</td>
									</tr>
									<tr>
										<td class="item_label">Start Bid Price</td>
										<td>
											<input type="text" name="StartBidPrice"  />	
										</td>
									</tr>									
									<tr>
										<td class="item_label">Get it now price (optional)</td>
										<td>
											<input type="text" name="GetItNowPrice"  />	
										</td>
									</tr>
									<tr>
										<td class="item_label">Minimum Sale Price</td>
										<td>
											<input type="text" name="MinimumSalePrice"  />	
										</td>
									</tr>									
									<tr>
										<td class="item_label">Returnable</td>
										<td>
											<select name="Returnable">
												<option value= 1>Yes</option>
												<option value= 0>No</option>
											</select>
										</td>
									</tr>		
									<tr>
										<td class="item_label">Auction ends in</td>
										<td>
											<select name="AuctionEndsIn">
												<option value= 1>1 day</option>
												<option value= 3>3 days</option>
												<option value= 5>5 days</option>
												<option value= 7>7 days</option>												
											</select>
										</td>
									</tr>											
									<tr>
										<td class="item_label">Condition</td>
										<td>
											<select name="Condition">
												<option value= 5>New</option>
												<option value= 4>Very Good</option>
												<option value= 3>Good</option>
												<option value= 2>Fair</option>
												<option value= 1>Poor</option>												
											</select>
										</td>
									</tr>
									<tr>
										<td class="item_label">Category</td>
										<td>
											<select name="Category">
												<?php
													$query = "SELECT catname From cat";
													$result = mysqli_query($db, $query);                                       
													//include('lib/show_queries.php');                                       
													if (is_bool($result) && (mysqli_num_rows($result) == 0) ) {
																array_push($error_msg,  "Query ERROR: Failed to get condition information..." . __FILE__ ." line:". __LINE__ );
														 }                                         
												while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
													print "<option value= \"" . $row['catname'] . "\">".$row['catname']."</option>";
												}
												?>											    
											</select>
										</td>
									</tr>
																			
									
								</table>
								
								<a href="javascript:profileform.submit();" class="fancy_button">Save</a> 
								<a href="javascript:profileform.cancel();" class="fancy_button">Cancel</a> 
							
							</form>
						</div>
				</div>
                        

                    
						
                
                <?php include("lib/error.php"); ?>
                    
				<div class="clear"></div> 		
			</div>    

               <?php include("lib/footer.php"); ?>
				 
		</div>
	</body>
</html>
