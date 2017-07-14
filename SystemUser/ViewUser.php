<?php
include '../Controller.php';
Model::checkvalidation();
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$limit = 20;
$startpoint = ($page * $limit) - $limit;
//$agentList = search($startpoint, $limit);
$query = "select * from user_tab";
$agentList = populateAllUser($startpoint, $limit);
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
            
            </div>
       <div id="contentWrapper">
         <div id="menu">
               <h1>User Administrator</h1>
                  <ul>
                    <?php echo UserManagementRole(); ?>
                  </ul>
                <div id="slidingjpg">
                    <img src="../images/system.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
         <div id="mainContent">
             <div id="requesthead"><p>User Information</p></div>
             <table class="reqtable">
                 <tr><th>Fullname</th>
                     <th>Email</th>
                     <th>PhoneNumber</th><th>UserType</th><th>CreateTime</th>
                     <th>Remark</th>
                     <th>Actions</th></tr>
                 <?php 
                        if (count($agentList) > 0)
                        {
                            foreach ($agentList as $obj) 
                            {
                                echo '<tr>';
                                echo '<td>' . $obj->fullname. '</td>';
                                echo '<td>' . $obj->email . '</td>';
                                echo '<td>' . $obj->phonenumber . '</td>';
                                echo '<td>' . $obj->usertype . '</td>';
                                echo '<td>' . $obj->createtime . '</td>';
                                echo '<td>' . $obj->remark . '</td>';
				echo  '<td><a href=displayUsers.php?userId=' . $obj->userid . '>manage User</a></td>';
				echo '</tr>';
                            }
                        }else{
                            echo "<tr><td colspan=3>No Record Found<td></tr>";
                        }
                 ?>
             </table>
             <?php echo pagination($query,$limit,$page); ?>
         </div>
       </div>
          </div>
        </div>
        <div id="footer"></div>
    </body>
</html>

