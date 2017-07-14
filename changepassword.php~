<?php
include './Controller.php';
Model::checkvalidation();
//corporatesetup();
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Corporate SetUP</title>
        <link type="text/css" rel="stylesheet" href="./style.css"/> 
        <link href="./jquery/css/bvalidator/bvalidator.css" rel="stylesheet" type="text/css" />
        <script src="./jquery/development/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="./jquery/js/jquery.bvalidator.js"></script>
        <script type="text/javascript">
                $(function() {
                     $('#form1').bValidator();
                });
        </script>
    </head>
    <body>
        <div id="wrapper">
          <div id="banner">
              <div id="bannertxt">
                    <?php userinfo(); ?>
                    <div id="changepassword">
                        <a href="./AgencyBanking/changepassword.php"> Change Password</a>
                    </div>
                </div>
          </div>
          <div id="content" >
              <div id="userDetail"> 
                 <div id="topmenu">
                <ul><li><a href='./AgencyBanking/superadmin/index.php'>Home</a></li>
                    <?php passmodule();?>
<!--                    <li><a href="./coporate/index.php"> Quick Menu</a></li>
                <li><a href="./SystemUser/welcome.php"> User Management</a></li>
        <li><a href="./Systemactivity/activitylog.php"> System Activities</a></li>
        <li><a href="./sessionreport/activesession.php"> Session Reports</a></li>
        <li><a href="./customreport/customReport.php"> Custom Reports</a></li>
       <li><a href="./configurationservice/configuration.php">Service Configuration</a></li>-->

                        </ul>
                </div>
             </div>
              <div id="contentWrapper">
                <div id="menu">
                   <h1>Change Password</h1>
                  <ul>
                    <li><a href="./changepassword.php"> Change Password</a></li>
                  </ul>
                <div id="slidingjpg">
                    <img src="./images/system.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
                <div id="mainContent">
                <div id="fundform">
             <form id="form1" name="form1" method="post" action="./Controller.php">
              <div class="caption">Change Password</div>
              <?php  
                if (isset($_GET['wmchange']))
                {
     echo '<div id="response"><span class="statusSuccess"></span><span class="successtext">Password Successfully Changed</span></div>';
                    unset($_GET['wmchange']);
                }elseif(isset ($_GET['wmerror']))
                {
                    //$fail = $_GET['fail'];
    echo '<div id="error"><span class="statuserror"></span><span class="statustext">Error</span></div>';
                    unset($_GET['wmerror']);
                }
                
            
            ?>
              <div id="agentdiv">
                <table class="agentform" width="100%">
               <tr>
                 <td id="key">Current Password</td>
                 <td id="value"><input type="text" name="oldpassword" size="30px"  value="" data-bvalidator="required"/></td>
               </tr>
               <tr>
                 <td id="key">New Password</td>
                 <td id="value"><input type="text" name="newpassword" size="30px" id="newpassword" value="" data-bvalidator="required" data-bvalidator-msg="enter new password"/></td>
               </tr>
                 <tr>
                     <td id="key">Confirm Password</td>
                     <td id="value"><input type="text" name="confirmpassword" size="30px"  value="" data-bvalidator="equalto[newpassword],required" data-bvalidator-msg="please confirm password"/></td>
                 </tr>
                 <tr>
                     <td id="key"></td>
                     <td id="value"><input type="submit" value="Change Password" name="changepassword"/></td>
               </tr>
                </table>
               </div>
           </form>
             </div>
           </div>
              </div>
       </div>
          </div> 
        </div>
        <div id="footer"></div>
    </body>
</html>
