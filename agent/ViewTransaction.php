<?php
include '../Controller.php';
if (isset($_SESSION['id'])) {
    $id=trim( $_SESSION['id']);
      $data= loadAgentData($id);
   if (count($data)>0) {
       $obj=$data[0];
       $agentName=$obj->agentName;
       $balance=$obj->tillBalance;	  
       $cusData= loadAgentTransList($id);
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
              <div id="mainContent">
                <div style="font-size: 30px; margin-left: 20px; margin-bottom: 10px; color:Black; font-weight:bolder;">  View Transactions</div>
                <table width="100%" cellspacing="1" class="viewdata"  >
                  <tr class="viewdataHeader" >
                    <td width="6%" >S/N</td>
                    <td width="21%">Customer ID</td>
                    <td width="21%"> Agent ID</td>
                    <td width="23%">Amount</td>
                    <td width="29%">Action</td>
                  </tr>
                  <?php
		  $i=0;
		  if(count($cusData)>0){
		  foreach ($cusData as $trans) {
    		if($i%2==0)
		  {
			  $bg="oddRow";
		  }
		  else{
			  $bg="evenRow";
		  } 
          $i++;
		  ?>
                  <tr class="<?php echo $bg; ?>">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $trans->customer; ?></td>
                    <td><?php echo $trans->agentId; ?></td>
                    <td><?php echo $trans->amount; ?></td>
                    <td><a href="<?php echo "ViewTransRecord.php?transId=$trans->transId"; ?>"> View </a></td>
                  </tr>
                  <?php
		  }
		  }
		  else{
		  ?>
                  <tr bgcolor="#96CA1D">
                    <td colspan="5" align="center">No Record Found</td>
                  </tr>
                  <?php
		  }
		  ?>
                </table>
              </div>
           
            </div>
            <div id="footer" >&copy; 2012 CeLLulant Nigeria</div>
        </div>
    </body>
</html>
