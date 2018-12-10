<?php

include('lib/common.php');
// written by GTusername4

if (!isset($_SESSION['email'])) {
	header('Location: login.php');
	exit();
}

    $query = "SELECT Firstname, Lastname " .
		 "FROM User " .
		 "INNER JOIN normaluser ON user.email = normaluser.email " .
		 "WHERE user.email = '{$_SESSION['email']}'";

    $result = mysqli_query($db, $query);
    include('lib/show_queries.php');
 
    if (!is_bool($result) && (mysqli_num_rows($result) > 0) ) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        array_push($error_msg,  "Query ERROR: Failed to get User Profile...<br>" . __FILE__ ." line:". __LINE__ );
    }
?>

<?php include("lib/header.php"); ?>
<title>GTBay Item Ratings</title>
</head>

<body>
		<div id="main_container">
    <?php include("lib/menu.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
                <?php print $row['Firstname'] . ' ' . $row['Lastname']; ?>
            </div>          
            <div class="features">   
            
                <div class="rating_section">
                    <div class="subtitle">Item Ratings</div>   
                    <table>
					    <tr>
                            <td>
                                <ul>
                                    <?php
                                            $query = "SELECT Itemid, Itemname, avg(Rating) AS ar FROM review WHERE Itemid='$ID'";
                                            $result = mysqli_query($db, $query);
                                            
                                            include('lib/show_queries.php');
											
											if (!empty($result) && (mysqli_num_rows($result) > 0) ) {
                                               $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
}                                           else {
                                               array_push($error_msg,  "SELECT ERROR: User profile <br>" . __FILE__ ." line:". __LINE__ );
}
										?>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Item ID</td>
                            <td>
                                <?php print $row['Itemid'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Item Name</td>
                            <td>
                                <?php print $row['Itemname'];?>
                            </td>
                        </tr>
						<tr>
                            <td class="item_label">Average Rating</td>
                            <td>
                                <?php print $row['ar'];?>
                            </td>
                        </tr>
                           </div>
						   
						<div class="rating_section">
							<div class="subtitle">Item Ratings</div>
							<table>
								<tr>
									<td class="heading">Rated by:</td>
									<td class="heading">Date:</td>
								</tr>
								<!-- review part-->								
								<?php								
                                    $query = "SELECT Username, Time, Comment, Rating FROM review WHERE Itemid='$ID'" .
                                         "ORDER BY Time DESC LIMIT 2";
                                
                                    $result = mysqli_query($db, $query);
								    include('lib/show_queries.php');
                                    if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "SELECT ERROR: find review <br>" . __FILE__ ." line:". __LINE__ );
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td>{$row['Username']} </td>";
										print "<td>{$row['Rating']}</td>";
                                        print "<td>{$row['Time']}</td>";
                                        print "<td>{$row['Comment']}</td>";										
                                        print "</tr>";							
                                    }									
                                ?>
						
						<!--rating part-->
						</div>	
                       <?php
					        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	                        $review = mysqli_real_escape_string($db, $_POST['review']);

	                        if (empty($review)) {
		                         array_push($error_msg,  "Error: You must provide a Comment ");
	                        }
	                        else{
		                         $query = "INSERT INTO review (Username, Itemid, Comment,Rating,Time) " .
					             "VALUES ('{$_SESSION['username']}','$ID','$Comment','$rating',NOW())";

                                 include('lib/show_queries.php');

                            if (mysqli_affected_rows($db) == -1) {
                            array_push($error_msg, "Error: Failed to add review: '" . $review.  "'<br>" . __FILE__ ." line:". __LINE__ );
        } 
            
	}
}?>


                        <!--delete rating-->
                        </div>
                        <?php
							$query = "SELECT Username, Time, Comment, Rating FROM review WHERE Username=$_SESSION['username']" ;
							$result = mysqli_query($db, $query);
							include('lib/show_queries.php');
												 
                            if (is_bool($result) && (mysqli_num_rows($result) == 0) ) {
                                 array_push($error_msg,  "Query ERROR: Failed to get User rating... <br>" . __FILE__ ." line:". __LINE__ );
                                 }                                              
                                                 
							while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
								 print "<li>{$result} <a href='Item_Ratings.php?delete_rating=" . 
								 urlencode($result) . "'>Delete My Rating</a></li>";
								}
						 ?>

</div>         
                        <div class="features">                         
                            <div class="item_section">					
                                <form name="insertform" action="Item_Ratings.php" method="POST">
                                    <table >								
                                        <tr>
										    <td class="item_label">My Rating</td>
											<td><input type="textbox" name="my_rating" /></td>  <!--rating from stars to number, cannot use stars-->
                                            <td class="item_label">Comments</td>
                                            <td><input type="textbox" name="Comment" /></td>
                                        </tr>
                                    </table>
                                    <a href="javascript:insertform.submit();" class="fancy_button">Rate This Item</a> 
                                    <a href="javascript:insertform.submit();" class="fancy_button">Cancel</a> 										
                                    </form>							
                            </div>

               <?php include("lib/footer.php"); ?>

		</div>
	</body>
</html>