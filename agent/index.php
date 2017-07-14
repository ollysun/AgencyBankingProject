<?php
include '../Controller.php';
if (isset($_GET['id'])) {
    $id=trim($_GET['id']);
     $_SESSION['id']=$id;
     
   $data= loadAgentData($id);
   if (count($data)>0) {
       $obj=$data[0];
       $agentName=$obj->agentName;
       $balance=$obj->tillBalance;
   }
}
 else {
  header('Location:../index.php');  
}



?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banking Agency</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
        
    </head>
    <body>
        <div id="wrapper">
          <div id="header" >
            <div style="float:left;"> <img src="../images/cellulant.jpg" alt="" width="200px" /> </div>
            <div style="float:left; margin-left:100px;"> Agency Banking </div>
            <div style="float:right;"> <img src="../images/paymee.png" alt="" width="100px"  height="80px" /></div>
          </div>
          <div id="content" >
              <div id="userDetail"> Agent Name:
                <?php  echo '  '.ucfirst($agentName); ?>
                <div class="balance">Balance:<font color="darkgreen"><img src="../images/nigerian.gif" alt="" width="12" height="17">
                  <?php  echo $balance ;?>
                </font></div>
              </div>
              <div id="menu" >
                  <ul>
                    <li><a href="ViewTransaction.php"> View Transaction</a></li>
                    <li> <a href="CreateCustomer.php"> Create Customer</a></li>
                    <li><a href="../index.php"> Log out</a></li>
                  </ul>
              </div>
                <div id="corporateIndex">
                   Welcome Agent <?php  //echo '  '.ucfirst($username); ?> to Demo Agency Baking.</div>
            </div>
            <div id="footer" ></div>
        </div>
    </body>
</html>
