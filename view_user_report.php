<?php

include('lib/common.php');

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}

?>

<?php include("lib/header.php"); ?>
		<title>GTBay View User Report</title>
	<head> THIS IS A HEAD !!!</head>
	
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
									<td class="heading">User Name</td>
									<td class="heading">Listed</td>
									<td class="heading">Sold</td>
									<td class="heading">Purchased</td>
									<td class="heading">Rated</td>									
								</tr>
																
								<?php								
                                    $query = "SET
    @@sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
SELECT
    HH.username,
    listed,
    sold,
    COUNT(seller) AS purchased,
    rated
FROM
    (
    SELECT
        FF.username,
        listed,
        rated,
        COUNT(buyer) AS sold
    FROM
        (
        SELECT
            DD.username,
            listed,
            rated
        FROM
            (
            SELECT
                AA.username,
                rated
            FROM
                (
            SELECT
                username
            FROM
                USER
            ) AS AA
        LEFT JOIN(
            SELECT
                username,
                COUNT(*) AS rated
            FROM
                auctionitem
            NATURAL JOIN(
                    (SELECT username
                FROM
                    review) AS BB
                )
            GROUP BY
                username
        ) AS CC
    ON
        AA.username = CC.username
        ) AS DD
    LEFT JOIN(
        SELECT
            username,
            COUNT(*) AS listed
        FROM
            auctionitem
        NATURAL JOIN USER GROUP BY username
    ) AS EE
ON
    DD.username = EE.username
    ) AS FF
LEFT JOIN(
    SELECT
        seller AS username,
        username AS buyer
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
) AS GG
ON
    FF.username = GG.username
GROUP BY
    FF.username
) AS HH
LEFT JOIN(
    SELECT
        seller,
        username
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
    username
) AS II
ON
    HH.username = II.username
GROUP BY
    HH.username";                                                                                   
                                             
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "SELECT ERROR: find item <br>" . __FILE__ ." line:". __LINE__ );
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td>{$row['username']}</td>";
                                        print "<td>{$row['listed']}</td>";
                                        print "<td>{$row['sold']}</td>";
										print "<td>{$row['purchased']}</td>";
										print "<td>{$row['rated']}</td>";
                                        print "</tr>";							
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