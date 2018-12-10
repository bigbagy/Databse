<?php

include('lib/common.php');

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}

?>

<?php include("lib/header.php"); ?>
		<title>GTBay Auction Result</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
					<div class="title_name"><?php print $user_name; ?></div>          
					
					<div class="features">   	
						<div class="profile_section">
                        	<div class="subtitle">View Results</div>   
							<table>
							<tr>
							<th>category</th><th>total_item</th><th>min_price</th><th>maxprice</th><th>average_price</th>
							</tr>
							<?php
							$querya="SET @@sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION";
							$R= mysqli_query($db, $querya);
							$query="SELECT
    AA.seller,
    AA.itemid,
    item_name,
    bidprice AS saleprice,
    buyer AS winner,
    IFNULL(auctionended, AA.auctionendtime) AS auction_ended
FROM
    (
        (
        SELECT
            username AS seller,
            itemid,
            itemname AS item_name,
            auctionendtime
        FROM
            USER
        NATURAL JOIN auctionitem
    ) AS AA
    )
LEFT JOIN(
    SELECT
        seller,
        SELLER_ITEM_BUYER_ITEMMAXBID.itemid,
        getitnowprice,
        auctionendtime,
        minimumsaleprice,
        itemname,
        username AS buyer,
        bidtime,
        MAX(bidprice) AS bidprice,
        maxbid,
        IF(
            maxbid = getitnowprice,
            bidtime,
            auctionendtime
        ) AS auctionended
    FROM
        (
            (
            SELECT
                username AS seller,
                itemid,
                getitnowprice,
                auctionendtime,
                minimumsaleprice,
                itemname
            FROM
                USER
            NATURAL JOIN AUCTIONITEM
        ) AS SELLER_ITEM
        )
    NATURAL JOIN BID AS SELLER_ITEM_BUYER
    NATURAL JOIN(
        SELECT
            itemid,
            MAX(bidprice) AS maxbid
        FROM
            bid
        GROUP BY
            itemid
    ) AS SELLER_ITEM_BUYER_ITEMMAXBID
WHERE
    bidprice = getitnowprice OR(
        bidprice = maxbid AND maxbid > minimumsaleprice AND CURRENT_TIMESTAMP > auctionendtime
    )
GROUP BY
    buyer
) AS BB
ON
    AA.itemid = BB.itemid";

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