<?php
include '../Controller.php';
Model::checkvalidation();
unset($_SESSION['query']);
//session_unset();
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$limit = 30;
$startpoint = ($page * $limit) - $limit;
$sessionlist = searchActivesession($startpoint, $limit);
if (!isset($_SESSION['query']))
{
    $query = "select * from  activesession";
}  else {
    $query = trim($_SESSION['query']);
    unset($_SESSION['query']);
}
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Active Session</title>
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
          <div id="content">
            <div id="userDetail">
              <div id="topmenu">
                <ul>
                 <li><a href='../superadmin/index.php'>Home</a></li>
                           <?php  topmenumodule(); ?>
               </ul>
              </div>
            </div>            
       <div id="contentWrapper">
           <div id="menu">
                <h1>Session Management</h1>
                  <ul>
                    <?php echo SystemSession();?>
                  </ul>
                <div id="slidingjpg">
                    <img src="../images/corporate.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
         <div id="mainContent">
            <div class="searchcriteria">
             <form id="form1" name="form1" method="post" action="<?php  echo $_SERVER['PHP_SELF'];?>">
                 <table class="search">
                     <tr>
                         <td>
                             <input type="text" name="username" size="20px" placeholder =" Search By UserName" value =""/>
                         </td>
                     
                          <td>
                             &nbsp;
                         </td>
                         <td>
                             <input type="text" name="rolename" size="20px" placeholder =" Search By RoleName" value =""/>
                         </td>
                     
                          <td>
                              &nbsp;
                         </td>
                         <td>
                             <input type="text" name="logindate" size="20px" placeholder =" Search By LoginDate" value =""/>
                         </td>
                         <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                         <td><input type="submit" name="searchbyrole" value="GO"/></td>
                     </tr>
                 </table>
                  </form>
            </div>
             <table width="745px" class="tbagent">
                      <tr>
                            <th>FirstName</th>
                            <th>LastName </th>
                            <th>UserName</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Login Date </th>
                            <th>Logout Date </th>
                        </tr> 
                        <?php 
                        if (count($sessionlist) > 0)
                        {
                            foreach ($sessionlist as $obj) 
                            {
                                echo '<tr>';
                                echo '<td>' . $obj->firstname . '</td>';
                                echo '<td>' . $obj->lastname. '</td>';
                                echo '<td>' . $obj->username. '</td>';
                                echo '<td>' . $obj->role . '</td>';
                                echo '<td>';
                                  $val = $obj->status;
                                  if ($val == 'A'){ 
                                    echo 'Active'; 
                                      }elseif($val == 'X'){ 
                                     echo 'Inactive';
                                   }elseif ($val == 'T') {
                                     echo 'Terminate';
                                    }
                                 echo '</td>';
                                echo '<td>' . $obj->logindate . '</td>';
                                echo '<td>' . $obj->logoutdate . '</td>';
                                echo '</tr>';
                            }
                        }  else {
                            echo "<tr><td>No Records</td></tr>";
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
