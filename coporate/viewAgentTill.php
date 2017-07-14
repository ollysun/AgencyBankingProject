<?php
include '../Controller.php';
Model::checkvalidation();
$agentTill = populateAllAgentTill();
//var_dump($agentTill); die();
$sumAmount = 0;
if (count($agentTill) > 0){
    foreach ($agentTill as $obj) 
    {
     //echo	$obj->amount; die();
        $sumAmount = $sumAmount + $obj->amount;           
    }
}
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>View All Agent Till Balance</title>
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
           <div id ="formcontainer">
             <div class="searchcriteria">
             <form id="form1" name="form1" method="post" action="<?php  echo $_SERVER['PHP_SELF'];?>">
                 <table>
                     <tr>
                         <td>
                            <input type="text" name="from" placeholder =" From Created Date" size="18px" value =""/>
                         </td>
                         
                         <td>
                            <input type="text" name="to" placeholder ="To Created" size="18px" value =""/>
                         </td>
                         <td><input type="submit" name="searchAgentTill" value="GO"/></td>
                         <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                         <td>&nbsp;</td><td>&nbsp;</td>
                         <td id="stylebalance">Total FundAmount: N<?php echo $sumAmount;?></td>
                     </tr>
                 </table>
                 </form>
            </div>
             <table width="745px" class="tbagent">
                      <tr class="oddRow">
                            <th> Id</th>
                            <th>Amount </th>
                            <th>Created Date & Time</th>
                            <th>AgentId</th>
                            
                        </tr> 
                        <?php 
                        if (count($agentTill) > 0)
                        {
                            foreach ($agentTill as $obj) 
                            {
                                echo '<tr>';
                                echo '<td>' . $obj->Id. '</td>';
                                echo '<td>' . $obj->amount. '</td>';
                                echo '<td>' . $obj->createdDate. '</td>';
                                echo '<td>' . $obj->agentId . '</td>';
                            }
                         echo '</tr>';
                        }  else {
                            echo "<tr><td>No Records</td></tr>";
                        }
                            
                        ?>
                    </table>
               
           
           </div>
         </div>
       </div>
          </div>
        </div>
        <div id="footer"></div>
    </body>
</html>
