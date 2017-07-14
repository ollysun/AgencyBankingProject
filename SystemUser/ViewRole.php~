<?php
include '../Controller.php';
Model::checkvalidation();
$agentList = populateAllRoles();
sessiontimeout();
logmeout();

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
          <div id="banner">
              <div id="bannertxt">
                    <?php userinfo(); ?>
                    <div id="changepassword">
                        <a href="../changepassword.php">Change Password</a>
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
             <div id="requesthead"><p>Roles Information</p></div>
             <table class="reqtable" width="100%">
                 <tr><th>Id</th><th>CreatedDate</th>
                     <th>Description</th><th>Roles</th><th>Role Permission</th></tr>
                 <?php 
                        if (count($agentList) > 0)
                        {
                            foreach ($agentList as $obj) 
                            {
                                echo '<tr>';
                                echo '<td>' . $obj->roleId . '</td>';
                                echo '<td>' . $obj->roledate. '</td>';
                                echo '<td>' . $obj->roledescription. '</td>';
                                echo '<td>' . $obj->rolename . '</td>';
                                echo '<td>' . str_replace('|', ',  ', ucfirst($obj->rolepermission)) . '</td>';
                            }
                            echo '</tr>';
                        }else{
                            echo "<tr><td colspan=3>No Record Found<td></tr>";
                        }
                 ?>
             </table>
         </div>
       </div>
          </div>
        </div>
        <div id="footer"></div>
    </body>
</html>

