<?php

include('lib/common.php');
// written by GTusername4

     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	 
	     $Firstname = mysqli_real_escape_string($db, $_POST['Firstname']);
         $Lastname = mysqli_real_escape_string($db, $_POST['Lastname']);  
         $Username = mysqli_real_escape_string($db, $_POST['Username']);
         $Password = mysqli_real_escape_string($db, $_POST['Password']);
		 
         if (empty($Firstname)) {
             array_push($error_msg,  "Please enter your first name.");
         }
         if (empty($Lastname)) {
             array_push($error_msg,  "Please enter your lastname.");
         } 
         if (empty($Username)) {
             array_push($error_msg,  "Please enter a username.");
         }
         if (empty($Password)) {
             array_push($error_msg,  "Please enter a password.");
         }		 
		
         if ( !empty($Username) && !empty($Password) && !empty($Firstname) && !empty($Lastname) )   { 
            
			$query2 = "select username from user where username = '$Username' ";
			$result = mysqli_query($db,$query2);
			include ('lib/show_queries.php');
			$count = mysqli_num_rows($result);
            if (!empty($result) && $count>0) {
                array_push($error_msg,  "Username already exist, Please enter a different one.");              
			}
			else{
				
			$query = "INSERT INTO user (Username, Password, Firstname, Lastname) " .
                     "VALUES('$Username', '$Password', '$Firstname', '$Lastname')" ;
            $result = mysqli_query($db, $query);
            include('lib/show_queries.php');
		
            if (mysqli_affected_rows($db) == -1) {
                 array_push($error_msg,  "UPDATE ERROR: Regular User... <br>".  __FILE__ ." line:". __LINE__ );	
            				 
				
			}
			header(REFRESH_TIME . 'url=login.php');
		
         }
		 }

 }
?>


<?php include("lib/header.php"); ?>
<title>GTBay Register</title>
</head>

<body>
    <div id="main_container">
	    <?php include("lib/menu.php"); ?>


			<div class="center_content">	
				<div class="center_left">
      
					<div class="features">   
						
                        <div class="profile_section">
							<div class="subtitle">Edit Registration Info </div>   
                            
							<form name="profileform" action="register.php" method="post">
								<table>

									<tr>
										<td class="item_label">First Name</td>
										<td>
											<input type="text" name="Firstname" value="" />									
										</td>
									</tr>
									<tr>
										<td class="item_label">Last Name</td>
										<td>
											<input type="text" name="Lastname"  />	
										</td>
									</tr>
									<tr>
										<td class="item_label">Username</td>
										<td>
											<input type="text" name="Username"  />	
										</td>
									</tr>									
									<tr>
										<td class="item_label">Password</td>
										<td>
											<input type="text" name="Password"  />	
										</td>
									</tr>
									
								</table>
								
								<a href="javascript:profileform.submit();" class="fancy_button">Save</a> 
							
							</form>
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


