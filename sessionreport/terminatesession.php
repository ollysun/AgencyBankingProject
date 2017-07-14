<?php
include '../Controller.php';
Model::checkvalidation();
if (isset($_REQUEST['sessionid']))
{
    $id = $_GET['sessionid'];
}
$agentList = TerminateSession($id);//please remember to turn ME TO array(json_decode(json_encode($agentList), 1));

$objdecode = json_decode(json_encode($agentList), 1);
//var_dump($objdecode);die();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Terminate Session</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
        
    </head>
    <body>
        <div id="wrapper">
          <div id="banner">
              <div id="bannertxt">
                    <ul>
                       <li>username: <?  if (isset($_SESSION['adminusername'])){
                            echo 'Admin';
                        }else{
                            echo $_SESSION['status'];
                        }
                            ?> </li> |
                        <li> <? 
                        if (isset($_SESSION['adminpassword'])){
                            echo "Admin";
                        }else{
                            echo $_SESSION['roles'];
                        }?></li> |
                        <li class="logout"><a href="../index.php"> Log out</a></li>
                    </ul>
                    <div id="changepassword">
                        <a href="../changepassword.php"> Change Password</a>
                    </div>
                </div>
          </div>
          <div id="content">
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
                <h1>Session Management</h1>
                   <ul>
                        <?php echo SystemSession();?>
                  </ul>
            </div>
           <div id="mainContent">
         <div id="agentcontent">
             <div class="caption">User Session Detail</div>
             <div id="agentdiv">
             <table class="agentform" width="530px">
              <? foreach($objdecode as $ag){?>
               <input type="hidden" value="<? echo $ag['sessionId']; ?>" name="hiddenid"/>
               <tr>
                 <td id="key">User FirstName</td>
                 <td id="value"><?php echo $ag['firstname']; ?></td>
               </tr>
               <tr>
                 <td id="key">User LastName</td>
                 <td id="value"><?php echo $ag['lastname']; ?></td>
               </tr>
                 <tr>
                     <td id="key">RoleName</td>
                     <td id="value"><?php echo $ag['role']; ?></td>
                 </tr>
                 <tr>
                     <td id="key">Login Date</td>
                     <td id="value"><?php echo $ag['logindate']; ?></td>
                 </tr> 
                 <tr>
                     <td id="key">Logout Date</td>
                     <td id="value"><?php echo $ag['logoutdate']; ?></td>
                 </tr>
                 <tr>
                     <td id="key">User Status</td>
                     <td id="value"><?php $status = $ag['status']; 
                            if (isset($status))
                            {
                                if($status == 'A')
                                {
                                    echo 'User Active';
                                }elseif ($status == 'X') {
                                    echo 'User InActive';
                                }elseif ($status == 'T') {
                                    echo 'User Terminate';
                                }
                            }
                     ?></td>
                 </tr>
                 <tr>
                     <td id="key">&nbsp;</td>
                     <td id="value"><input type="submit" value="TerminateUser" name="terminateuser" onClick="return confirm('Are you sure you want to Disable User?')"/></td>
                 </tr>
             </table>
                 </div>
           </div>
           <?}?>
       </div> 
         </div>
       </div>
         </div> 
        <div id="footer"></div>
    </body>
</html>
