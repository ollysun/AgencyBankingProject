<?php
include '../Controller.php';
Model::checkvalidation();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Active Session</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
    </head>
    <body>
        <div id="wrapper">
          <div id="banner">
              <div id="bannertxt">
                    <ul>
                        <li>username: <?  if (isset($_SESSION['adminusername'])){
                            echo 'Admin';
                        }else{
                            echo $_SESSION['status'];
                        }
                            ?> </li> |
                        <li> <? 
                        if (isset($_SESSION['adminpassword'])){
                            echo "Admin";
                        }else{
                            echo $_SESSION['roles'];
                        }?></li> |
                        <li class="logout"><a href="../index.php"> Log out</a></li>
                    </ul>
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
                <h1>Custom Report</h1>
                <ul>
                  <?php echo CustomReport();?>
                </ul>
                <div id="slidingjpg">
                    <img src="../images/corporate.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
         <div id="mainContent">
            
         </div>
       </div>
          </div>
        </div>
        <div id="footer"></div>
    </body>
</html>
