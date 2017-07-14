<?php
include '../Controller.php';
Model::checkvalidation();
if (isset($_GET['agentID']))
{
    $name = $_GET['agentID'];
}
$agentList = populateAgentdetail($name);//please remember to turn ME TO array(json_decode(json_encode($agentList), 1));

$ag = json_decode(json_encode($agentList), 1);
//var_dump($ag);die();
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>View Agent Record</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
        
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
                <h1>Corporate Menu</h1>
                   <ul>
                        <?php echo quickuserRole(); ?>
                  </ul>
            </div>
           <div id="mainContent">
         <div id="agentcontent">
             <div class="caption">Agent Detail</div>
             <div id="agentdiv">
             <table class="agentform" width="530px">
              <?php 
		 //var_dump($objdecode)die();
		 //foreach($objdecode as $ag){?>
               <tr>
                 <td id="key">Agent FirstName</td>
                 <td id="value"><?php echo $ag[0]['agentfullname']; ?></td>
               </tr>
               <tr>
                 <td id="key">Agent LastName</td>
                 <td id="value"><?php echo $ag[0]['agentlName']; ?></td>
               </tr>
                 <tr>
                     <td id="key">Agent Phone</td>
                     <td id="value"><?php echo $ag[0]['agentPhone']; ?></td>
                 </tr>
                 <tr>
                     <td id="key">Agent Email ID</td>
                     <td id="value"><?php echo $ag[0]['email']; ?></td>
                 </tr> 
                 <tr>
                     <td id="key">Created Date </td>
                     <td id="value"><?php echo $ag[0]['DOB']; ?></td>
                 </tr> 
                 <tr>
                     <td id="key">Agent Type </td>
                     <td id="value"><?php echo $ag[0]['agentType']; ?></td>
                 </tr> 
             </table>
                 </div>
           </div>
               
           <?php 
             if (isset($_SESSION['adminusername']) && isset($_SESSION['adminpassword']))
             {
           ?>
               <div id="fundAccount">
               <ul>
                   <li><a href=fundagent.php?fullname=<?php echo $ag[0]["agentfullname"] . "&phone=" . $ag[0]["agentPhone"] . "&id=" . $ag[0]["agentID"]; 
                    $_SESSION['id'] = $ag[0]["agentID"]; ?>>Fund Account</a></li>
                   <li><a href=viewagentTransaction.php?agentphone=<?php 
           echo $ag[0]["agentPhone"] . "&agentid=" . $ag[0]["agentID"]; 
         $_SESSION['agentPhone'] = $ag[0]["agentPhone"]; ?>>View Agent Transaction</a></li>
                   <li><a href=reconcileagent.php?agentphone=<?php echo $ag[0]["agentPhone"] . "&agentid=" . $ag[0]['agentID'];?>>Reconcile Agent Acct</a></li>
                   <li><a href=disableagent.php?agentid=<?php echo $ag[0]['agentID']?>>Disable Agent</a></li>
               </ul>
           </div>
           <?php 
             }elseif(isset($_SESSION['perm'])){
                        foreach($_SESSION['perm'] as $valsession){
                            if (strcmp($valsession, 'ManageAgent') == 0){
           ?>
           <div id="fundAccount">
               <ul>
                   <li><a href=fundagent.php?fullname=<?php echo $ag[0]["agentfullname"]."&phone=" .$ag[0]["agentPhone"] . "&id=" . $ag[0]["agentID"];
                       $_SESSION['id'] = $ag[0]["agentID"]; ?>>Fund Account</a></li>
                   <li><a href=viewagentTransaction.php?agentphone=<?php 
           echo $ag[0]["agentPhone"] . "&agentid=" . $ag[0]["agentID"]; 
         $_SESSION['agentPhone'] = $ag[0]["agentPhone"]; ?>>View Agent Transaction</a></li>
                   <li><a href=reconcileagent.php?agentphone=<?php echo $ag[0]["agentPhone"] . "&agentid=" . $ag[0]['agentID'];?>>Reconcile Agent Acct</a></li>
                   <li><a href=disableagent.php?agentid=<?php echo $ag[0]['agentID']?>>Disable Agent</a></li>
               </ul>
           </div>
             <?php 
                            }
                        }
                }
             ?>
       </div> 
         </div>
       </div>
         </div> 
        <div id="footer"></div>
    </body>
</html>
