<?php
include '../Controller.php';
Model::checkvalidation();
$requestid = 0;
if (isset($_GET['customerID']))
{
    $requestid = $_REQUEST['customerID'];
}
//$_SERVER['QUERY_STRING']  = " ";
//unset($_REQUEST['requestId']);

$resultval = populateCustomerDetail($requestid);
//unset($_REQUEST['requestId']);
$result = json_decode(json_encode($resultval), 1);
//var_dump($result); die();
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
                }elseif(isset ($_GET['wmdecline']))
                {
    echo '<div id="error"><span class="statuserror"></span><span class="statustext">Error updating. </span></div>';
                     unset($_GET['wmdecline']);
                }
               
            ?>
           <div id ="formcontainer">
            <? if (sizeof($result)> 0){
                foreach($result as $ag){?>
             <form id="form1" name="form1" method="post" action="../Controller.php">
              <input type="hidden" value="<? echo $requestid; ?>" name="hiddenid"/>
             <div class="caption" style="width:530px; padding: 7px;">
                 Please ensure you are authorised to change the whole Information
             </div>
                 <div id="agentdiv">
                 <table class="agentform" width="100%">
                     <tr>
                        <td id="key">FirstName</td>
                        <td id="value">
                            <input type="text" value="<?php echo $ag['firstName']; ?>" placeholder ="enter your firstname" name="firstname" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your first name"/>  
                        </td>   
                     </tr>
               <tr>
                 <td id="key">LastName</td>
                 <td id="value">
                     <input type="text" value="<?php echo $ag['lastName']; ?>" name="lastname" placeholder ="enter your lastname" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your last name"/>
                 </td>
               </tr>
               <tr>
                 <td id="key">Account Type</td>
                 <td id="value">
                     <select name="acctType" data-bvalidator="required" data-bvalidator-msg="Please select acctType">
                        <option value=""><---Select AccountType---></option>
                         <option value="saving" <? if(isset($ag['acctType']) && $ag['acctType'] == 'saving'){ echo 'selected';}?>>saving</option>
                        <option value="current" <? if(isset($ag['acctType']) && $ag['acctType'] == 'current'){ echo 'selected';}?>>current</option>
                    </select>
                 </td>
               </tr>
               <tr>
                 <td id="key">Phone Number</td>
                 <td id="value">
                     <input type="text" value="<?php echo $ag['custPhone'];?>" name="phone" placeholder="please enter your phone number" data-bvalidator="number,required" data-bvalidator-msg="Please enter your phone"/>
                 </td>                   
               </tr>
                 <tr>
                     <td id="key">Email</td>
                     <td id="value">
                         <input type="text" value="<?php echo $ag['custEmail'];?>" name="email" placeholder="please enter your email" data-bvalidator="email,required" data-bvalidator-msg="Please enter your email"/>   
                     </td>
                 </tr>
                 <tr>
                     <td id="key">Identification Type</td>
                     <td id="value"> 
                    <select name="IdType" data-bvalidator="required" data-bvalidator-msg="Please select IdentificationType">
                        <option value=""><---Select IdentificationType---></option>
                        <option value="nationalcard" <? if(isset($ag['IdType']) && $ag['IdType'] == 'nationalcard'){ echo 'selected';}?>>National ID Card</option>
                        <option value="passport" <? if(isset($ag['IdType']) && $ag['IdType'] == 'passport') { echo 'selected';}?>>International Passport</option>
                        <option value="driverlicense" <?if(isset($ag['IdType']) && $ag['IdType'] == 'driverlicense') { echo 'selected';}?>>Driver License</option>
                    </select>
                     </td>
                 </tr>
                 <tr>
                     <td id="key">Identification Number</td>
                     <td id="value">
                         <input type="text" value="<?php echo $ag['IdNumber'];?>" name="IdNumber" placeholder="Identification Number" data-bvalidator="required" data-bvalidator-msg="Please enter your Identification Number"/>
                     </td>
                 </tr>
                 <tr>
                 <td id="key">Address</td>
                 <td id="value">
                     <textarea name="address" rows="6" cols="26" placeholder="your address">
                        <?php echo $ag['address'];?>
                     </textarea>
                 </td>
                 </tr>
                 <tr>
                     <td id="key">
                         &nbsp;
                    </td>
                    <td id="value">
                        <input type="submit" value="Update" name="updateme" onClick="return confirm('Are you sure, you are authorised to change any information?')" />
                    </td>
               </tr>
                 </table>
                 </div>
           </form>
           </div>
          <? }
            }?>
         </div>
       </div>
          </div> 
        </div>
        <div id="footer"></div>
    </body>
</html>
