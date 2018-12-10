<?php

include('lib/common.php');
// written by GTusername4

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}

     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	 array_push ($error_msg, "and");
	     $Keyword = mysqli_real_escape_string($db, $_POST['Keyword']);
         $MinimalPrice = mysqli_real_escape_string($db, $_POST['MinimalPrice']);  
         $MaximumPrice = mysqli_real_escape_string($db, $_POST['MaximumPrice']);		 
         $Category = mysqli_real_escape_string($db, $_POST['Category']);
         $Condition = mysqli_real_escape_string($db, $_POST['Condition']);	
         $now = date("Y-m-d H:i:s");		 
         //array_push ($error_msg, "$Condition");
         if (empty($Keyword)) {
             array_push($error_msg,  "Please enter a keyword for searching.");
         }
         if (empty($MinimalPrice)) {
            array_push($error_msg,  "Please enter a minimum search price.");
         }
         if (empty($MaximumPrice)) {
            array_push($error_msg,  "Please enter a maximum search price.");
         }
         if ($MaximumPrice<$MinimalPrice) {
            array_push($error_msg,  "Maximum search price has to be higher than minimum search price.");
         }		 
		 
		
         if ( !empty($Keyword) && !empty($MinimalPrice) && !empty($MaximumPrice) && !($MaximumPrice<$MinimalPrice) )   { 
			//array_push($query_msg, "Searching items for you ...");
			//$query = "SELECT catname From cat";
			$query = "SELECT A.itemid as ID, A.itemname AS Item_Name, max(B.bidprice) AS Current_Bid,a.getitnowprice as Get_it_Now_Price, a.auctionendtime AS Auction_Ends ".
			"FROM `auctionitem` as A Left Join `bid` AS B on A.itemid = B.itemid ".
			"WHERE A.itemname like '%$Keyword%' AND  ".
			"A.contype >= $Condition and A.catname = '$Category' and A.startbidvalue >= $MinimalPrice and A.startbidvalue <= $MaximumPrice ".
			"And a.auctionendtime>'$now' AND (b.bidprice is null OR a.getitnowprice is null OR b.bidprice < a.getitnowprice) ". 
			"group by A.itemid, A.itemname,a.getitnowprice, a.auctionendtime ";
			$result2 = mysqli_query($db, $query);   
            include('lib/show_queries.php');			
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

					    <div class="profile_section">
							<div class="subtitle">Search for Item </div>   
                            
							<form name="searchform" action="search_item.php" method="POST">
								<table>								
									<tr>
										<td class="item_label">Keyword</td>
										<td><input type="text" name="Keyword" /></td>
									</tr>
				
									<tr>
										<td class="item_label">MinimumPrice</td>
										<td><input type="text" name="MinimalPrice" /></td>
									</tr>
                                                                        <tr>
										<td class="item_label">MaximumPrice</td>
										<td><input type="text" name="MaximumPrice" /></td>
									</tr>
									<tr>
										<td class="item_label">Category</td>
										<td>
											<select name="Category">
												<?php
													$query = "SELECT catname From cat";
													$result = mysqli_query($db, $query);                                                                             
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
									<tr>
										<td class="item_label">Condition at least</td>
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

                                 
									
								</table>
								<a href="javascript:searchform.submit();" class="fancy_button">Search</a> 
							</form>
							
						</div>
						
						<div class='profile_section'>
						<div class='subtitle'>Search Results</div>
						<table>
								<tr>
									<td class="heading">ID</td>
									<td class="heading">Item Name</td>
									<td class="heading">Current Bid</td>
									<td class="heading">High Bidder</td>
									<td class="heading">Get It Now Price</td>
									<td class="heading">Auction Ends</td>
									
								</tr>
							<?php
									if (isset($result2)) {
										while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
                                        print "<tr>";
                                        print "<td>". $row['ID']. "</td>";
										print "<td><a href='GTBay_Item_for_Sale.php?view_item={$row['ID']}'>{$row['Item_Name']}</a></td>";
                                        print "<td>". $row['Current_Bid']. "</td>";
										$query3 = "SELECT username FROM `bid` where itemid = ".$row['ID'] ." and bidprice = ".$row['Current_Bid'];
										        include('lib/show_queries.php');
										$result3 = mysqli_query($db, $query3);
										$row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);
                                        print "<td>". $row3['username']. "</td>";
                                        print "<td>". $row['Get_it_Now_Price']. "</td>";
                                        print "<td>". $row['Auction_Ends']. "</td>";
                                        print "</tr>";	
										}
									}	?>
							</table>
							</div>
							
							
						</div>
				</div>
                        

                    
						
                
                <?php include("lib/error.php"); ?>
                    
				<div class="clear"></div> 		
			</div>    

               <?php include("lib/footer.php"); ?>
				 
		</div>
	</body>
</html>
