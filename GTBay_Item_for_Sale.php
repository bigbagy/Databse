<?php

include('lib/common.php');
// written by GTusername4

if (!isset($_SESSION['email'])) {
	header('Location: login.php');
	exit();
}

 $query = "SELECT Firstname, Lastname " .
		 "FROM User " .
		 "WHERE User.email = '{$_SESSION['email']}'";

    $result = mysqli_query($db, $query);
    include('lib/show_queries.php');
 
    if (!is_bool($result) && (mysqli_num_rows($result) > 0) ) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        array_push($error_msg,  "Query ERROR: Failed to get user information...<br>" . __FILE__ ." line:". __LINE__ );
    }

    // ERROR: demonstrating SQL error handlng, to fix
    // replace 'sex' column with 'gender' below:
	$ID="Location:search_item.php?Itemid=$REQUEST[Itemid];
	
    $query = "SELECT Itemid, Itemname, Description, Catname, Contype, Returnable, Getitnowprice, Auctionendtime" .
		 "FROM auctionitem WHERE Itemid='$ID'" . // ID is the itemid in figure 5
	     
    $result = mysqli_query($db, $query);
    include('lib/show_queries.php');
 
    if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        array_push($error_msg,  "Query ERROR: Failed to get User profile...<br>" . __FILE__ ." line:". __LINE__ );
    }

	
	header(REFRESH_TIME.'url=Item_Ratings.php');
		
	// bid information
    $query = "SELECT Bidprice, Bidtime, Username" .
		 "FROM Bid WHERE Itemid='$ID'"
		 "ORDER BY Bidtime DESC LIMIT 4" .
	
    $result = mysqli_query($db, $query);
    include('lib/show_queries.php');
 
    if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        array_push($error_msg,  "Query ERROR: Failed to get User profile...<br>" . __FILE__ ." line:". __LINE__ );
    }	


	// Edit Description	
	if (!empty($_GET['edit_description'])) {
	
    $query = "SELECT Description FROM auctionitem WHERE itemid='$ID'" .

    $result = mysqli_query($db, $query);
    include('lib/show_queries.php');
    
    if (!is_bool($result) && (mysqli_num_rows($result) > 0) ) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        array_push($error_msg,  "Query ERROR: Failed to get Item Description... <br>".  __FILE__ ." line:". __LINE__ );
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
        $Description = mysqli_real_escape_string($db, $_POST['Description']);
        
        if (empty($Description)) {
                array_push($error_msg,  "Please enter Description.");
        } 

        if ( !empty($Description))   { 
            $query = "UPDATE auctionitem " .
                     "SET Description ='$Description', " .
                     "WHERE Itemid='$ID'";

            $result = mysqli_query($db, $query);
            include('lib/show_queries.php');
            
             if (mysqli_affected_rows($db) == -1) {
                 array_push($error_msg,  "UPDATE ERROR: auctionitem... <br>".  __FILE__ ." line:". __LINE__ );
                 //array_push($error_msg,  'Error# '. mysqli_errno($db) . ": " . mysqli_error($db));
             }  

         }
	}
		 
	// bid on the item
	
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$Bidprice = mysqli_real_escape_string($db, $_POST['Bidprice']);

	if (empty($Bidprice)&&('$Bidprice'<=(SELECT Max(Bidprice) Bidprice from bid WHERE Itemid='$ID')){ //how to express not bigger than
	    if (!empty(Getitnowprice))&& $Bidprice<=(Getitnowprice+1)){
		    array_push($error_msg,  "Error: Invalid bid price. "); }
		else (empty(Getitnowprice)){
			array_push($error_msg,  "Error: Invalid bid price. "); }	 
	}
	else{
		$query = "INSERT INTO Bid (Username, Itemid, Bidtime, Bidprice) " .
					 "VALUES ('$_SESSION['username']','$ID', NOW(), '$Bidprice')";//how to get the username of current user
					 
		$commentID = mysqli_query($db, $query);

        include('lib/show_queries.php');

        if (mysqli_affected_rows($db) == -1) {
             array_push($error_msg, "Error: Failed to add Comment: '" . $Comment .  "'<br>" . __FILE__ ." line:". __LINE__ );
        } 
            
	}
}

    // cancel
	if (!empty($_GET['cancel_request'])) {

	$email = mysqli_real_escape_string($db, $_GET['cancel_request']);
    
     if (mysqli_affected_rows($db) == -1) {
        array_push($error_msg,  "DELETE ERROR: cancel request...<br>" . __FILE__ ." line:". __LINE__ );
	}
}


	
?>

<?php include("lib/header.php"); ?>
<title>GTBay Item</title>
</head>

<body>
		<div id="main_container">
    <?php include("lib/menu.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
			<!--not know what does the next line mean-->
                <?php print $row['first_name'] . ' ' . $row['last_name']; ?>
            </div>          
            <div class="features">   
            
                <div class="profile_section">
                    <div class="subtitle">GTBay Item for Sale</div>   
                    <table>
                        <tr>
                            <td class="item_label">Item ID</td>
                            <td>
                                <?php print ID ?> <!--need to link to the view rating page, do not know how-->
								<?php print '<td><a href="//GTBay_Item_for_Sale.php?view_ratings='$row['Description']']).'//">View Ratings</a></td>';?>
								<?php header(REFRESH_TIME.'url=Item_Ratings.php');?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Item Name</td>
                            <td>
                                <?php print $row['Itemname'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Description</td>
                            <td>
                                <?php print $row['Description'];?>
								<?php print '<td><a href="//GTBay_Item_for_Sale.php?edit_description='$row['Description']']).'//">Edit Description</a></td>';?>
                            </td>
                        </tr>

                        <tr>
                            <td class="item_label">Category</td>
                            <td>
                                <?php print $row['Catname'];?>
                            </td>
                        </tr>
						<tr>
                            <td class="item_label">Condition</td>
                            <td>
                                <?php print $row['Contype'];?>
                            </td>
                        </tr>
							<tr>
                            <td class="item_label">Returns Accepted?</td>
                            <td>
							    <select name="Returnable">
							        <option value=0 <?php if ($row['Returnable'] == 0) { print '';} ?>><!-- 怎么显示一个单选框-->
						            <option value=1 <?php if ($row['Returnable'] == 1)?> <input type="checkbox" name="">
                            </td>
                        <tr>
                            <td class="item_label">Get It Now price</td>
                            <td>
                                <?php print $row['Getitnowprice'];?>
								<a href="javascript:insertform.submit();" class="fancy_button">Get It Now!</a> 
                            </td>
                        </tr>                               						
					    <tr>
                            <td class="item_label">Auction Ends</td>
                            <td>
                                <?php print $row['Auctionendtime'];?>
                            </td>
                        </tr>		

                <div class="bid_section">
                    <div class="subtitle">Latest Bids</div>  
                    <table>
                        <tr>
                            <td class="heading">Bid Amount</td>
                            <td class="heading">Time of Bid</td>
							<td class="heading">Username</td>
                        </tr>							

                        <?php
									    $query = "SELECT Bidprice, Bidtime, Username" . 
											 "FROM bid " .
											 "WHERE email='{$_SESSION['email']}' " .
											 "ORDER BY Bidtime DESC";
									    $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');
                                        
                                        if (is_bool($result) && (mysqli_num_rows($result) == 0) ) {
                                                    array_push($error_msg,  "Query ERROR: Failed to get Bid information...<br>" . __FILE__ ." line:". __LINE__ );
                                             } 
                                             
									while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
										print "<tr>";
										print "<td>" . $row['Bidprice'] . "</td>";
										print "<td>" . $row['Bidtime'] . "</td>";
										print "<td>" . $row['Username'] . "</td>";
										print "</tr>";
									}
								?>
                    </table>						
                </div>	

            </div> 			
        </div>         
                        <div class="features">                         
                            <div class="item_section">					
                                <form name="insertform" action="GTBay_Item_for_Sale.php" method="POST">
                                    <table >								
                                        <tr>
                                            <td class="item_label">Your bid  $</td>
                                            <td><input type="textbox" name="Comment" /></td>
                                        </tr>
                                    </table>
                                    <a href="javascript:insertform.submit();" class="fancy_button">Bid on This Item</a> 
                                    <a href="javascript:insertform.submit();" class="fancy_button">Cancel</a> 										
                                    </form>							
                            </div>
                        	
		
                <?php include("lib/error.php"); ?>
                    
				<div class="clear"></div> 		
			</div>    

               <?php include("lib/footer.php"); ?>
				 
		</div>
	</body>
</html>