<?php

include('lib/common.php');

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}

?>

<?php include("lib/header.php"); ?>
		<title>GTBay Category Report</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
					<div class="title_name"><?php print $user_name; ?></div>          
					
					<div class="features">   	
						<div class="profile_section">
                        	<div class="subtitle">View Report</div>   
							<table>
							<tr>
							<th>category</th><th>total_item</th><th>min_price</th><th>maxprice</th><th>average_price</th>
							</tr>
							<?php
							$query="SELECT catname AS category, COUNT(*) AS total_item, MIN(getitnowprice) AS min_price, MAX(getitnowprice) AS max_price, AVG(getitnowprice) AS average_price FROM auctionitem NATURAL JOIN cat GROUP BY catname";

							$result = mysqli_query($db, $query);


							while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
							?>
 <tr>
 <td><?php echo $row["category"]?></td>
 <td><?php echo $row["total_item"]?></td>
 <td><?php echo $row["min_price"]?></td>
 <td><?php echo $row["max_price"]?></td>
 <td><?php echo $row["average_price"]?></td>
 </tr>

<?php
}
?>
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