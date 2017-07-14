<?php
include '../Controller.php';
if (isset($_SESSION['id'])) {
    $id=trim( $_SESSION['id']);
      $data= loadAgentData($id);
   if (count($data)>0) {
       $obj=$data[0];
       $agentName=$obj->agentName;
       $balance=$obj->tillBalance;
   }
}
 else {
  //header('Location:../index.php');  
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
            <div style="font-size: 30px; margin-left: 20px; margin-bottom: 10px; color:Black; font-weight:bolder;">  Create New Customer </div>
            <form id="form1" name="form1" method="post" action="../Controller.php">
              <table width="500px" class="agentTabe">
                    <?php
                   if (isset($_SESSION['info'])) {
                       ?>
                   <div id="infoDetail">  Customer account was successfully created.   </div>
                    <?php
                    unset($_SESSION['info']);
                    }
                    else if (isset($_SESSION['errorlist'])) {
                        ?>
                   <div id="errorDetail">  Please fix the following input errors:
                       <ul>
                    <?php
                    $errorlist=$_SESSION['errorlist'];
                    unset($_SESSION['errorlist']);
                    foreach ($errorlist as $value) {
                     $control=$value;
                     if ($control=='AgentName') {
                     echo '<li> Customer Name can not be blank. </li>'    ;
                        }
                        if ($control=='Address') {
                     echo '<li> Address can not be blank. </li>'    ;
                        }
                        if ($control=='PhoneNo') {
                     echo '<li> PhoneNo can not be blank. </li>'    ;
                        }
                        if ($control=='Email') {
                     echo '<li> Email can not be blank. </li>'    ;
                        }
                       
                    }
                    ?>
                   </ul>
                   </div>
                    <?php                                      
                    }
                    ?>
                   
                <tr class="oddRow">
                  <td width="178">Name</td>
                  <td width="408"><input type="text" name="name" size="50px"/>
                    <input name="corpID" type="hidden" id="corpID" value=""></td>
                </tr>
                <tr class="oddRow">
                  <td>Phone No</td>
                  <td><input name="PhoneNo" type="text" size="50" id="PhoneNo"/></td>
                </tr>
                <tr class="evenRow">
                  <td>Email</td>
                  <td><input name="email" type="text" size="50" id="email"/></td>
                </tr>
                <tr align="right" class="oddRow">
                  <td  colspan="2"><input type="submit" value="Submit" name="CreateCustomer" id="CreateCustomer"/></td>
                </tr>
              </table>
            </form>
              </div>
           
            </div>
            <div id="footer" >&copy; 2012 CeLLulant Nigeria</div>
        </div>
    </body>
</html>
