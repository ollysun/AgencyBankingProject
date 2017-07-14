<?php
include '../Controller.php';
Model::checkvalidation();
$all = populateCorporate();
//var_dump($allcorporate); die();
$allcorporate = json_decode(json_encode($all), 1);
//var_dump($allcorporate); die();
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
                   <?php echo quickuserRole();?>
                  </ul>
            </div>
           <div id="mainContent">
         <div id="agentcontent">
             <div class="caption">Corporate Account Detail</div>
             <div id="agentdiv">
             <table  width="auto" class="tbagent">
               <tr><th>Corporate Name</th><th>AccountName</th>
                     <th>Account No</th><th>Account Type</th><th>Created Date & Time</th>
                  </tr>
                 <?php 
                        if (count($allcorporate) > 0)
                        {
                            foreach ($allcorporate as $obj) 
                            {
                                echo '<tr>';
                                echo '<td>' . $obj['corpname'] . '</td>';
                                echo '<td>' . $obj['acctName']. '</td>';
                                echo '<td>' . $obj['acctNo'] . '</td>';
                                echo '<td>' . $obj['acctType'] . '</td>';
                                echo '<td>' . $obj['createdatetime'] . '</td>';
				echo '</tr>';
                            }
                        }  else {
                            echo "<tr><td colspan =7>No Records</td></tr>";
                        }
                            
                   ?>
             </table>
                 </div>
           </div>
               <?php 
             if (isset($_SESSION['adminusername']) && isset($_SESSION['adminpassword']))
             {
           ?>
           <div id="fundAccount">
               <ul>
                   <li><a href="<?php echo "corporateacct.php"?>">Add New</a></li>
               </ul>
           </div>
            <?php }else if (isset($_SESSION['perm'])) {
                        foreach($_SESSION['perm'] as $valsession){
                            if (strcmp($valsession, 'CreateCorporateActt') == 0){          
            ?>
           <div id="fundAccount">
               <ul>
                   <li><a href="<?php echo "corporateacct.php"?>">Add New</a></li>
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
