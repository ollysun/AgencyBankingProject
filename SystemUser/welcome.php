<?php
include '../Controller.php';
//Model::checkvalidation();
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Home - Super Administrator</title>
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
           <div id="menu">
                <h1>User Administrator</h1>
                  <ul>
                    <?php echo UserManagementRole(); ?>
                  </ul>
                <div id="slidingjpg">
                    <img src="../images/system.jpg"  alt="" title="branchless banking"/>
                </div>
           </div>
       </div>
          </div>
            
        </div>
        <div id="footer"></div>
    </body>
</html>
