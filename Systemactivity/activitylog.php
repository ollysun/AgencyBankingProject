<?php
include '../Controller.php';
unset($_SESSION['query']);
Model::checkvalidation();

//print_r($agentList);
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$limit = 20;
$startpoint = ($page * $limit) - $limit;
//$agentList = search($startpoint, $limit);
$activitylist = searchActivity($startpoint, $limit);
if (!isset($_SESSION['query']))
{
    $query = "select * from  activityLog";
}  else {
    $query = trim($_SESSION['query']);
    //unset($_SESSION['query']);
}

sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Activity Log</title>
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
                           <?php topmenumodule(); ?>
               </ul>
              </div>
              </div>            
       <div id="contentWrapper">
           <div id="menu">
                <h1>Activity Management</h1>
                  <ul>
                    <?php echo SystemActivityRole();?>
                  </ul>
                <div id="slidingjpg">
                    <img src="../images/corporate.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
         <div id="mainContent">
            <div class="searchcriteria">
             <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                 
                 <table class="search">
                     <tr>
                         <td>
                             <input type="text" name="username" placeholder =" Search By Username" size="18px" value =""/>
                         </td>
                         <td>&nbsp;</td><td>&nbsp;</td>
                         <td>
                             <input type="text" name="status" placeholder =" Search By Status" size="18px" value =""/>
                         </td>
                         <td>&nbsp;</td><td>&nbsp;</td>
                         <td>
                             <input type="text" name="phone" placeholder =" Search By Phone" size="16px" value =""/>
                         </td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                         <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                         <td><input type="submit" name="searchusername" value="GO"/></td>
                    </tr>
                 </table>
                 <div class="clearfix"></div>
                  </form>
            </div>
             <table width="745px" class="tbagent">
                      <tr class="oddRow">
                            <th>Activity</th>
                            <th>CreatedDate</th>
                            <th>PhoneNumber</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th>Username</th>
                            
                        </tr> 
                        <?php 
                        if (count($activitylist) > 0)
                        {
                            foreach ($activitylist as $obj) 
                            {
                                echo '<tr>';
                                echo '<td>' . $obj->activity . '</td>';
                                echo '<td>' . $obj->createDate. '</td>';
                                echo '<td>' . $obj->phone. '</td>';
                                echo '<td>' . $obj->remarks . '</td>';
                                echo '<td>' . $obj->status . '</td>';
                                echo '<td>' . $obj->username . '</td>';
                            }
                         echo '</tr>';
                        }  else {
                            echo "<tr><td>No Records</td></tr>";
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
