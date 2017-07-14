<?php
include '../Controller.php';
Model::checkvalidation();
$roles = populateAllRoles();
//var_dump($roles); die();
sessiontimeout();
logmeout();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banking Agency</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
        <link href="../jquery/css/bvalidator/bvalidator.css" rel="stylesheet" type="text/css" />
        <script src="../jquery/development/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="../jquery/js/jquery.bvalidator.js"></script>
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
           <div id="menu" >
                <h1>Corporate Menu</h1>
                  <ul>
                     <?php echo UserManagementRole(); ?>
                  </ul>
            </div>
         <div id="mainContent">
             <div id="fundform">
             <form id="form1" name="form1" method="post" action="../Controller.php">
              <div class="caption" style="width: 530px">Top Level Link</div>
              <?php 
                if (isset($_GET['wmerror']))
                {
                    echo '<div id ="error"><span class="statuserror"></span><span class="statustext">Please complete empty field below </span></div>';
                }elseif(isset($_GET['wmlink']))
                {
                    echo '<div id ="response"><span class="statusSuccess"></span><span class="successtext">Link has been created </span></div>';
                }
                unset($_GET['wmlink']);
            ?>
              <div id="agentdiv" style="width: 538px">
                <table class="agentform" width="100%">
               <tr>
                 <td id="key">Link Name</td>
                 <td id="value"><input typ="text" name="linkname" value="" data-bvalidator="required"/></td>
               </tr>
               <tr>
                 <td id="key">Role Name</td>
                 <td id="value">
                     <select name="rolename" data-bvalidator="required">
                         <option value="">--select rolename---</option>
                         <? foreach ($roles as $value) {?>
                      <option value="<?php echo $value->rolename;?>"><?php echo $value->rolename;?></option>
                        <?}?>
                     </select>
                 </td>
               </tr>
                 <tr>
                     <td id="key"></td>
                     <td id="value"><input type="submit" value="Create Top Link" name="rolelink"/></td>
               </tr>
                </table>
               </div>
           </form>
             </div>
         </div>
       </div>
          </div> 
        </div>
        <div id="footer"></div>
    </body>
</html>
