<?php
include '../Controller.php';
Model::checkvalidation();
$requestid = '';
if (isset($_GET['customerID']))
{
    $requestid = $_REQUEST['customerID'];
}
$resultval = populateCustomerDetail($requestid);
//unset($_REQUEST['requestId']);
$result = json_decode(json_encode($resultval), 1);
//var_dump($result); die();
if (isset($_SESSION['username']))
{
    $sessionuser = $_SESSION['username'];
     //unset($_SESSION['username']);
}
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banking Agency</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
        <link rel="stylesheet" href="../jquery/development/themes/base/jquery.ui.all.css" />
        <link rel="stylesheet" href="../jquery/development/demos/demos.css"/>
        <script src="../jquery/development/jquery-1.8.2.js"></script>
        <script src="../jquery/development/ui/jquery.ui.core.js"></script>
        <script src="../jquery/development/ui/jquery.ui.widget.js"></script>
        <script src="../jquery/development/ui/jquery.ui.datepicker.js"></script>
        <link href="../jquery/css/bvalidator/bvalidator.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../jquery/js/jquery.bvalidator.js"></script>
        <script>
                $(function() {
                    $("#dob").datepicker({
                        defaultDate: "+1w",
                        dateFormat: "yy-mm-dd"
                    });
                    
                     $('#form1').bValidator();
                    
                });
        </script>
    </head>
    <body>
        <div id="wrapper">
          <div id="banner">
              <div id="bannertxt">
                    <?php userinfo(); ?>
                    <div id="changepassword">
                        <a href="../changepassword.php"> Change Password</a>
                    </div>
                </div>
          </div>
          <div id="content" >
                <div id="userDetail">
               <div id="topmenu">
               <ul>
                 <li><a href='../superadmin/index.php'>Home</a></li>
                           <?php topmenumodule(); ?>
               </ul>
              </div>
              </div>
              <div id="contentWrapper">
            <div id="menu">
                <h1>Corporate Menu</h1>
                   <ul>
                   <?php echo quickuserRole(); ?>
                  </ul>
                <div id="slidingjpg">
                    <img src="../images/system.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
         <div id="mainContent">
           <div id="formcontainer">
           <form name="form1" method="POST" action="../Controller.php">
      <input type="hidden" value="<?php echo $requestid; ?>" name="hiddenid"/>
               <div class="caption" style="width: 530px;">
               <?php
	     if (sizeof($result)> 0){
		foreach($result as $ag){
                   $remarkstatus = $ag['remark']; 
                 if (isset($remarkstatus))
                 { echo 'This Request has been sent for Approval';
                 }else{ echo 'Disable This Customer'; }
	        }
	   }
                 ?>
               </div>
               <?php 
                if (isset($_GET['wmerror']))
                {
     echo '<div id="response"><span class="statuserror"></span><span class="statustext">Your Request not delivered or Interrupted. </span></div>';
                    unset($_GET['wmerror']);
                }elseif(isset ($_GET['wmdisable']))
                {
    echo '<div id="error"><span class="statusSuccess"></span><span class="successtext">Your Request has been sent for Approval. </span></div>';
		 unset($_GET['wmdisable']);
                }
            ?>
               <div id="agentdiv">
                <table class="agentform" width="100%">
  	    <?php
		 if (sizeof($result)> 0){
                foreach($result as $ag){
               echo '<tr>
               <td id="key">Customer FirstName</td>
               <td id="value">' . $ag['firstName'] . '</td></tr>';
               echo '<tr>
               <td id="key">Customer LastName</td>
               <td id="value">' .  $ag['lastName'] . '</td>
               </tr>';
               echo '<tr>
               <td id="key">AccountType</td>
               <td id="value">' . $ag['acctType'] . '</td>
               </tr>';
               echo '<tr>
                   <td id="key">Created Date and Time</td>
                   <td id="value">' . $ag['dateCreated'] . '</td>
               </tr>';
               echo '<tr>
                <td id="key">Address</td>
                <td id="value">'. $ag['address'] . '</td>
               </tr>';
               echo '<tr>
               <td id="key">Email</td>
               <td id="value">' . $ag['custEmail'] . '</td>
               </tr>';
               echo '<tr>
               <td id="key">Phone Number</td>
               <td id="value">' . $ag['custPhone'] . '</td>
               </tr>'; 
               if (!isset($ag['remark'])){
               echo '<tr>
               <td id="key">Comment</td>
               <td id="value"><textarea name="comment" rows="6" cols="26"></textarea></td>
               </tr>';
               echo '<tr>
                   <td id="key">&nbsp;</td>
                   <td id="value"><input type="submit" value="DisableCustomer" name="disableuser" onClick="return confirm("Are you sure 			you want to Disable this Customer?")"/></td></tr>';
                  }
	  }
    }?> 
                </table>
               </div>
           </form>
           </div>
           </div>
         </div>
        </div>
          </div>
        </div>
        <br><br>
        <div id="footer"></div>
    </body>
</html>
