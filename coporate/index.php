<?php
include '../Controller.php';
Model::checkvalidation();
if (isset($_SESSION['adminusername']) && isset($_SESSION['adminpassword']))
{
    $userRole = $_SESSION['adminusername'];
    $userpass = $_SESSION['adminpassword'];
    
}elseif(isset($_SESSION['status']) && isset($_SESSION['roles'])) {
     $stat = $_SESSION['status'];
     $roleman = $_SESSION['roles'];
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
                    <?php echo quickuserRole();?>
                  </ul>
                <div id="slidingjpg">
                    <img src="../images/corporate.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
       </div>
          </div>
        </div>
        <div id="footer"></div>
    </body>
</html>
