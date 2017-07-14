<?php
include '../Controller.php';
Model::checkvalidation();
unset($_SESSION['query']);
$transtype = getTransType();
//print_r($transtype);

$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$limit = 20;
$startpoint = ($page * $limit) - $limit;
$translist = searchTransaction($startpoint, $limit);
if (!isset($_SESSION['query']))
{
    $query = "SELECT * FROM transactions";
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
        <title>Banking Agency</title>
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
		$("#startDate").datepicker({
			defaultDate: "+1w",
			changeMonth: true,
                        dateFormat: "yy-mm-dd",
			onSelect: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$("#endDate").datepicker({
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
                             <input type="text" name="customer" placeholder="Search by Customer" size="20px" value =""/>
                         </td>
                         <td>
                             <select name="transactionType">
                                 <option value="">---Select Transaction Type---</option>
                                 <?php 
                                 foreach ($transtype as $value) {
                                     echo "<option>$value</option>";
                                 }
                                 ?>
                             </select>
                         </td>
                         <td>
                             <input type="text" name="agentID" placeholder="Search by AgentID" size="20px" value =""/>
                         </td>
                     </tr>
                     <tr>
                         <td>
                             <input type="text" name="transactionID" placeholder="Search by Transaction ID" size="20px" value =""/>
                         </td>
                         <td>
                             <input type="text" name="startDate" placeholder="From Transaction Date" size="20px" value ="" id="startDate"/>
                         </td>
                         <td>
                             <input type="text" name="endDate" placeholder="To Transaction Date" size="20px" value ="" id="endDate"/>
                         </td>
                         <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                         <td><input type="submit" name="searchtransaction" value="GO"/></td>
                     </tr>
                     <tr>
                         
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
                            <th>Remarks</th>
                            <th>Status</th>
                        </tr> 
                        <?php 
                        if (count($translist) > 0)
                        {
                            foreach ($translist as $obj) 
                            {
                                echo '<tr>';
                                echo '<td>' . $obj->customer . '</td>';
                                echo '<td>' . $obj->transId. '</td>';
                                echo '<td>' . $obj->trxDate. '</td>';
                                echo '<td>' . $obj->actionX . '</td>';
                                echo '<td>' . $obj->agentId . '</td>';
                                echo '<td>' . $obj->amount . '</td>';
                                echo '<td>' . $obj->remarks . '</td>';
                                echo '<td>' . $obj->status . '</td>';
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
        </div>
        <div id="footer"></div>
    </body>
</html>
