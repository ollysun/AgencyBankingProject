<?php
include '../Controller.php';
Model::checkvalidation();
    if(isset($_SESSION['agentPhone']))
    {
        $agentphone = $_SESSION['agentPhone'];
    }
 $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$limit = 20;
$startpoint = ($page * $limit) - $limit;
$agentTrans = populateAgentTransaction($startpoint,$limit,$agentphone);
if (!isset($_SESSION['query']))
{
    $query = "select * from transactions where agentId = (select username from userlogin where phoneNumber = '{$agentphone}')";
}  else {
    $query = trim($_SESSION['query']);
    //unset($_SESSION['query']);
}
if (isset($_GET['agentid']))
{
    $agentid = $_GET['agentid'];
    $_SESSION['balance'] = getAgentRecordBalance($agentid);
}
$type = getTransType();
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>View Agent Transaction</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
        <link rel="stylesheet" href="../jquery/development/themes/base/jquery.ui.all.css" />
        <link rel="stylesheet" href="../jquery/development/demos/demos.css"/>
        <link href="../pagination.css" rel="stylesheet" type="text/css" />
	<link href="../B_black.css" rel="stylesheet" type="text/css" />
        <script src="../jquery/development/jquery-1.8.2.js"></script>
        <script src="../jquery/development/ui/jquery.ui.core.js"></script>
        <script src="../jquery/development/ui/jquery.ui.widget.js"></script>
        <script src="../jquery/development/ui/jquery.ui.datepicker.js"></script>
        <script>
            $(function() {
		$("#fromdate").datepicker({
			defaultDate: "+1w",
			changeMonth: true,
                        dateFormat: "yy-mm-dd",
			onSelect: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$("#todate").datepicker({
			defaultDate: "+1w",
			changeMonth: true,
                        dateFormat: "yy-mm-dd",
			onSelect: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
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
                            <input type="text" name="customer" placeholder =" Search By Customer" size="18px" value =""/>
                         </td>
                         <td>
                            <select name="transactiontype">
                                <option value="">--Select  By Transaction Type-</option>
                                 <?php 
                                 if (sizeof($type) > 0){
                                    foreach ($type as $value) {
                                        echo "<option value=$value>$value</option>";
                                    }
                                 }  else {
                                     echo "<option value=''></option>";
                                 }
                                 ?>
                            </select>
                         </td>
                         <td>
                            <input type="text" name="status" placeholder =" Search By Status" size="18px" value =""/>
                         </td>
                         <td><input type="submit" name="searchagent" value="GO"/></td>
                     </tr>
                       <tr>
                         <td>
                             <input type="text" id="fromdate" placeholder ="From Transaction Date" name="fromdate" size="20px" value =""/>
                         </td>
                         <td>
                             <input type="text" id="todate" placeholder ="To Transaction Date" name="todate" size="20px" value =""/>
                         </td><td>&nbsp;</td>
                         <td id="stylebalance" style="width: 200px;">Agent Balance: N<?php if (!empty($_SESSION['balance'])){ echo $_SESSION['balance']; } ?></td> 
                     </tr>
                
                 </table>
                 </form>
            </div>
             <table width="745px" class="tbagent">
                      <tr class="oddRow">
                            <th> Customers</th>
                            <th>Transaction ID</th>
                            <th>Transaction Date</th>
                            <th>Transaction Type</th>
                            <th>AgentID</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr> 
                        <?php 
                        if (count($agentTrans) > 0)
                        {
                            foreach ($agentTrans as $obj) 
                            {
                                echo '<tr>';
                                echo '<td>' . $obj->customer . '</td>';
                                echo '<td>' . $obj->transId. '</td>';
                                echo '<td>' . $obj->trxDate. '</td>';
                                echo '<td>' . $obj->actionX . '</td>';
                                echo '<td>' . $obj->agentId . '</td>';
                                echo '<td>' . $obj->amount . '</td>';
                                echo '<td>' . $obj->status . '</td>';
                                echo '</tr>';
                            }
                        }  else {
                            echo "<tr><td colspan=100%>No Records</td></tr>";
                        }
                            
                        ?>
                    </table>
               
           <?php echo pagination($query,$limit,$page);?>
           </div>
         </div>
       </div>
          </div>
        </div>
        <div id="footer"></div>
    </body>
</html>
