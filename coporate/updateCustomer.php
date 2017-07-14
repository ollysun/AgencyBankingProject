<?php
include '../Controller.php';
Model::checkvalidation();
$requestid = 0;
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
        <script src="../jquery/development/jquery-1.8.2.js"></script>
        <link href="../jquery/css/bvalidator/bvalidator.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../jquery/js/jquery.bvalidator.js"></script>
        <script type="text/javascript">
            $(function() {
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
         <div id="menu" >
                <h1>Corporate Menu</h1>
                   <ul>
                   <?php echo quickuserRole(); ?>
                  </ul>
                  <div id="slidingjpg">
                    <img src="../images/corporate.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
         <div id="mainContent">
            <?php 
                if (isset($_GET['wmupdate']))
                {
     echo '<div id="response"><span class="statusSuccess"></span><span class="successtext">Successfully Update. </span></div>';
                    unset($_GET['wmupdate']);
                }else if(isset ($_GET['wmdecline']))
                {
    echo '<div id="error"><span class="statuserror"></span><span class="statustext">Error updating. </span></div>';
		   unset($_GET['wmdecline']);
                }
            ?>
           <div id ="formcontainer">
             <form id="form1" name="form1" method="post" action="../Controller.php">
              <input type="hidden" value="<? echo $requestid; ?>" name="hiddenid"/>
             <div class="caption" style="width:530px;">
                 <?php 
		if (sizeof($result)> 0){
                foreach($result as $ag){
                    $status = $ag['status']; 
                 if (strcasecmp($ag['status'], "C") == 0)
                 { echo 'Well Done, You have Complete Information'; 
                 }else{ echo 'Please edit and complete this Information'; }}}?>
             </div>
                 <div id="agentdiv">
                 <table class="agentform" width="100%">
		 <?php  if (sizeof($result)> 0){
                foreach($result as $ag){
                   echo '<tr>
                        <td id="key">FirstName</td>
                        <td id="value">';
                            if (isset($ag['firstName'])) { echo $ag['firstName']; }  else {
                            echo '<input type="text" value="'. $ag['firstName'] .'" placeholder ="enter your firstname" name="firstname" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your first name"/>';
			 } echo '</td></tr>';
                  echo ' <tr>
                 <td id="key">LastName</td>
                 <td id="value">';
                    if (isset($ag['lastName'])) { echo $ag['lastName']; }  else {
                    echo '<input type="text" value="' .  $ag['lastName'] . '"name="lastname" placeholder ="enter your lastname" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your last name"/>'; } echo '</td></tr>';
                 echo '<tr>
                 <td id="key">Account Type</td>
                 <td id="value">';
                     if (isset($ag['acctType'])) { echo $ag['acctType']; }  else {
                    echo ' <select name="acctType" data-bvalidator="required" data-bvalidator-msg="Please select acctType">
                        <option value=""><---Select AccountType---></option>';
                         if(isset($ag['acctType']) && $ag['acctType'] == 'saving'){
                       echo '  <option value="saving" selected >saving</option>';
                         } else if (isset($ag['acctType']) && $ag['acctType'] == 'current') {
                       echo ' <option value="current" selected>current</option>';
                         }else{
                         echo '   <option value="saving">saving</option>
                            <option value="current">current</option>
                          </select>'; }  } echo '</td></tr>';
               echo '<tr>
                 <td id="key">Phone Number</td>
                 <td id="value">';
                     if (isset($ag['custPhone'])) { echo $ag['custPhone']; }  else {
                   echo ' <input type="text" value="' . $ag['custPhone'] . '" name="phone" placeholder="please enter your phone number" data-bvalidator="number,required" data-bvalidator-msg="Please enter your phone"/> '; } echo '</td></tr>';
               echo ' <tr>
                     <td id="key">Email</td>
                     <td id="value">';
                        if (isset($ag['custEmail'])) { echo $ag['custEmail']; }  else {
               echo ' <input type="text" value="' . $ag['custEmail'] .'" name="email" placeholder="please enter your email" data-bvalidator="email,required" data-bvalidator-msg="Please enter your email"/>'; } echo '</td></tr>';
               echo ' <tr>
                     <td id="key">Identification Type</td>
                     <td id="value">';
                    if (isset($ag['IdType'])) { echo $ag['IdType']; }  else {
               echo '<select name="IdType" data-bvalidator="required" data-bvalidator-msg="Please select IdentificationType">
                        <option value=""><---Select IdentificationType---></option>';
                       if(isset($ag['IdType']) && $ag['IdType'] == 'nationalcard'){
                       echo ' <option value="nationalcard" selected >National ID Card</option>';
                       }elseif (isset($ag['IdType']) && $ag['IdType'] == 'passport') {
                       echo '<option value="passport" selected >International Passport</option>';
                       }elseif (isset($ag['IdType']) && $ag['IdType'] == 'driverlicense') {
                      echo '<option value="driverlicense" selected >Driver License</option>';
                       }else{
                       echo '<option value="nationalcard">National ID Card</option>
                        <option value="passport">International Passport</option>
                        <option value="driverlicense">Driver License</option>'; } } echo '</td></tr>';
                echo '<tr>
                     <td id="key">Identification Number</td>
                     <td id="value">';
                        if (isset($ag['IdNumber'])) { echo $ag['IdNumber']; }  else {
                 echo '<input type="text" value="' . $ag['IdNumber'] . '"name="IdNumber" placeholder="Identification Number" data-bvalidator="required" data-bvalidator-msg="Please enter your Identification Number"/>';} echo '</td></tr>';
                echo ' <tr>
                 <td id="key">Address</td>
                 <td id="value">';
                     if (isset($ag['address'])) { echo $ag['address']; }  else {
                     echo '<textarea name="address" rows="6" cols="26" placeholder="your address">' . $ag['address']. '</textarea>'; } echo '</td></tr>';
                 if (strcasecmp($ag['status'], 'C') != 0){
                echo '<tr>
                     <td id="key">
                         &nbsp;
                    </td>
                    <td id="value">
                        <input type="submit" value="Update" name="update" onClick="return confirm("Are you done editing?")" />
                    </td>
               </tr>'; 
		 }
			$id =  $ag['Id'];
		}
	}
                ?>

                 </table>
                 </div>
     </form>
           </div>
             <div id="footnav">
                   <ul>
                       <li><a href="generalUpdating.php?customerID=<?php echo $id; ?>">General Updating</a></li>
                   </ul>
               </div>
         </div>
       </div>
          </div> 
        </div>
        <div id="footer"></div>
    </body>
</html>
