<?php
include '../Controller.php';
Model::checkvalidation();

$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$limit = 20;
$startpoint = ($page * $limit) - $limit;
$query = "select * from systemuserrequest";
$agentList = populateManageRequest($startpoint,$limit);
$objectdetail = json_decode(json_encode($agentList), 1);
//var_dump($objectdetail); die();
sessiontimeout();
logmeout();
?> 
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banking Agency</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
         <link href="../pagination.css" rel="stylesheet" type="text/css" />
	<link href="../B_black.css" rel="stylesheet" type="text/css" />
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
                        <img src="../images/corporate.jpg"  alt="" title="branchless banking"/>
                    </div> 
            </div>
         <div id="mainContent">
             <div id="requesthead"><p>Manage Requests</p></div>
             <table class="reqtable">
                 <tr><th>Initiator</th><th>AgentName</th>
                     <th>Value</th><th>Approval Time</th><th>Approval</th>
                     <th>PhoneNumber</th><th>RequestType</th><th>Status</th>
                     <th>Manage Requests</th></tr>
                 <?php 
                        if (sizeof($objectdetail) > 0)
                        {
                            foreach ($objectdetail as $key=>$obj) 
                            {
                                echo '<tr>';
                                echo '<td>' . $obj['initiator'] . '</td>';
                                echo '<td>' . $obj['agentname']. '</td>';
                                echo '<td>' . $obj['amount']. '</td>';
                                echo '<td>' . $obj['approvalTime'] . '</td>';
                                echo '<td>' . $obj['approval'] . '</td>';
                                echo '<td>' . $obj['phone'] . '</td>';
                                echo '<td>' . $obj['requestType'] . '</td>';
                                echo '<td>' . $obj['status'] . '</td>';
				echo '<td><a href=manageRequestResponse.php?requestId=' . $obj['Id'] .">manage Request</a></td>"; 
				echo '</tr>';
			  }
                        }else{
                            echo "<tr><td colspan=7>No Record Found<td></tr>";
                        }
                 ?>
             </table>
             <?php echo pagination($query,$limit,$page);?>
         </div>
       </div>
          </div>
        </div>
        <div id="footer"></div>
    </body>
</html>

