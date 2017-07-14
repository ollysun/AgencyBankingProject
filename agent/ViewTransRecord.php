<?php
include '../Controller.php';
if (isset($_SESSION['id'])) {
    $id=trim( $_SESSION['id']);
      $data= loadAgentData($id);
   if (count($data)>0) {
       $obj=$data[0];
       $agentName=$obj->agentName;
       $balance=$obj->tillBalance;	  
	  $transId=$_GET['transId'];
	   $transData= loadAgentTrans($transId);
       
      		 $trans=$transData[0];
		
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
                   <li> <a href="ViewAgent.php"> View Agent</a></li>
                   <li> <a href="ViewTransaction.php"> View Transaction</a></li>
                   <li> <a href="CreateAgent.php"> Create Agent</a></li>
                   <li><a href="../index.php"> Log out</a></li>
                 </ul>
               </div>
               <div id="mainContent">
                 <div style="font-size: 30px; margin-left: 20px; margin-bottom: 10px; color:black; font-weight:bolder;"> View Transaction Record</div>
                 <form id="form1" name="form1" method="post" action="../Controller.php"> 
                   <table width="500px" class="agentTabe">
                    <tr class="evenRow">
                            <td>Agent ID</td>
                            <td><?php echo $trans->agentId;?></td>
                      </tr>
                        <tr class="oddRow">
                            <td width="178">Customer ID</td>
                            <td width="408"><?php echo $trans->customer;?></td>
                        </tr>    
                        <tr class="evenRow">
                            <td>Amount</td>
                            <td><?php echo $trans->amount;?></td>
                        </tr> 
                       <tr class="oddRow">
                            <td>Action</td>
                            <td><?php echo $trans->actionX;?></td>
                        </tr> 
                       <tr class="evenRow">
                            <td>Transaction Time</td>
                            <td><?php echo $trans->trxDate;?></td>
                        </tr> 
                        <tr class="oddRow">
                            <td>Remark</td>
                            <td><?php echo $trans->remarks;?></td>
                        </tr>
                        
                         <tr class="evenRow">
                            <td>Status</td>
                            <td><?php echo $trans->status;?></td>
                        </tr> 
                        <tr class="oddRow">
                            <td>Transaction Ref</td>
                            <td><?php echo $trans->transId;?></td>
                        </tr>
                 </table>
                    </form>
                </div>
           
            </div>
            <div id="footer" >&copy; 2012 CeLLulant Nigeria</div>
        </div>
    </body>
</html>
