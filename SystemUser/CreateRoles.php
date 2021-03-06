<?php
include '../Controller.php';

//Model::checkvalidation();

$userdetail = populateAction();
//var_dump($userdetail); die();
$splitmethod = splitKeyword($userdetail);
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
        <script type="text/javascript" src="../jquery/js/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="../jquery/js/jquery.bvalidator.js"></script>
        
        <script type="text/javascript">            
    
    $(document).ready(function () {
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
       <div id="mainContent">
          <div id="fundform">
           <?php
                  if (isset($_GET['wmRespond'])) {
echo '<div id="response"><span class="statusSuccess"></span><span class="successtext">Role account successfully created.</span></div>';  
                     unset($_GET['wmRespond']);
                    }
                    else if (isset($_SESSION['errorlist'])) {  
            ?>
           <div id="errorDetail"> Please fix the following input errors:
             <ul>
               <?php
                    if (isset($_SESSION['errorlist']))
                    {
                        $errorlist = $_SESSION['errorlist'];
                        unset($_SESSION['errorlist']);
                    }
                    //var_dump($errorlist); die();
                    foreach ($errorlist as $val) {
                     $control = $val;
                     if ($control=='rolename') {
                     echo '<li> Role Name can not be blank. </li>'    ;
                        }
                        if ($control=='roledescription') {
                     echo '<li> RoleDescription can not be blank. </li>'    ;
                        }
                        if ($control=='roleAction') {
                     echo '<li> please click more than one actions. </li>'    ;
                        }
                    }
                    ?>
             </ul>
           </div>
                  <?php                                      
                    }
                    ?>
           <form id="form1" name="form1" method="post" action="../Controller.php">
               <div class="caption" style="width: 530px">Create Roles</div>
               <div id="agentdiv" style="width: 538px">
               <table class="agentform" width="100%">
                   <tr>
                 <td id="key">RoleName</td>
                 <td id="value"><input type="text" placeholder =" Please enter your rolename" name="rolename" size="30px" value="<?php  if (isset($_POST['rolename'])) echo $_POST['rolename']?>" data-bvalidator="alpha,required"/></td>
               </tr>
               <tr>
               <td id="key">Role Description</td>
               <td id="value"><textarea style="color:white;" name="roledescription" placeholder =" Please enter your role description" rows="6" cols="26" data-bvalidator="alpha,required"><?php  if (isset($_POST['roledescription'])) echo $_POST['roledescription']?></textarea></td>
               </tr>
               <tr>
               <td id ="key">Permissions</td>
               <td id="value">
                   <ul>
                   <?php
                   if (sizeof($splitmethod)> 0){
                     for($i=0; $i < sizeof($splitmethod['ActionId']); $i++)
                     {
                   ?>
                     <li><input type="checkbox" name="actions[]" value="<?php echo $splitmethod['ActionName'][$i]; ?>"/> <?php  echo $splitmethod['ActionName'][$i]; ?></li>
                  <?php 
                     }
                   }
                   ?>
                    </ul>
                 </td>
               </tr>
               <tr>
                   <td id="key"></td>
                   <td id="value"><input type="submit" value="AssignRole" name="AssignRole" id="AssignRole"/></td>
               </tr>
               </table>
               </div>
           </form>
          </div>
       </div>
              </div>
         </div>
          </div><
          <br><br>
        <div id="footer"></div>
    </body>
</html>
