<?php
include '../Controller.php';
Model::checkvalidation();
unset($_SESSION['query']);
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$limit = 20;
$startpoint = ($page * $limit) - $limit;
$agentList = search($startpoint, $limit);
if (!isset($_SESSION['query']))
{
    $query = "select * from user_tab u inner join agent a on u.Id = a.userId";
}  else {
    $query = trim($_SESSION['query']);
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
                 <ul>
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
           <div id ="formcontainer">
            <div class="searchcriteria">
             <form id="form1" name="form1" method="post" action="<?php  echo $_SERVER['PHP_SELF'];?>">
                 <table>
                     <tr>
                        <td>
                            <input type="text" name="agentname" size="18px" placeholder =" Search By AgentName"  value=""/>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <input type="text" name="agentphone" size="18px" placeholder =" Search By Phone" size="10px"  value=""/>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <select name="agentType">
                                <option value="">---Select AgentType---</option>
                                <option value="retailAgent">Retail Agent</option>
                                <option value="corporateAgent">Corporate Agent</option>
                            </select>
                        </td>
                        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                        <td><input type="submit" name="searchagent" value="GO"/></td>
                    </tr>
                 </table>
                 
                 </form>
            </div>
             <table width="745px" class="tbagent">
                      <tr class="oddRow">
                            <th> Agent Id</th>
                            <th>Agent Name </th>
                            <th>Phone</th>
                            <th>Agent Type</th>
                            <th>Actions</th>
                        </tr> 
                        <?php 
                        if (count($agentList) > 0)
                        {
                            foreach ($agentList as $obj) 
                            {
                                echo '<tr>';
                                echo '<td>' . $obj->agentID . '</td>';
                                echo '<td>' . $obj->agentfullname. '</td>';
                                echo '<td>' . $obj->agentPhone. '</td>';
                                echo '<td>' . $obj->agentType . '</td>';
                                
                          ?>
                        <td><a href="<?php echo "viewagentRecord.php?agentID=$obj->agentID"; ?>"> View </a></td>
                       <?php
                            }
                         echo '</tr>';
                        }  else {
                            echo "<tr colspan =7><td>No Records</td></tr>";
                        }
                            
                        ?>
                    </table>
               
           <?php echo pagination($query,$limit,$page);die();?>
               
           </div>
         </div>
       </div>
          </div>
        </div>
        <div id="footer"></div>
    </body>
</html>
