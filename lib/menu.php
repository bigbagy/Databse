
			<div id="header">
                <div class="logo"><img src="img/gtbay_logo.jpg" style="opacity:0.6;background-color:E9E5E2;" border="0" alt="" title="GT Bay Logo"/></div>
			</div>
			
			<div class="nav_bar">
				<ul>       
                    <li><a href="register.php" <?php if($current_filename=='register.php') echo "class='active'"; ?>>Register</a></li>
                    <li><a href="list_item.php" <?php if($current_filename=='list_item.php') echo "class='active'"; ?>>List Item</a></li>  	
                    <li><a href="search_item.php" <?php if($current_filename=='search_item.php') echo "class='active'"; ?>>Search Item</a></li>
                    <li><a href="view_auction_results.php" <?php if($current_filename=='view_auction_results.php') echo "class='active'"; ?>>View Auction Results</a></li>  
					<li><a href="view_auction_results.php" <?php if($current_filename=='view_category_report.php') echo "class='active'"; ?>>View Category Report</a></li>
					<li><a href="view_auction_results.php" <?php if($current_filename=='view_user_report.php') echo "class='active'"; ?>>View User Report</a></li>
                    <li><a href="logout.php" <span class='glyphicon glyphicon-log-out'></span> Log Out</a></li>              
				</ul>
			</div>
