<?php
include '../Controller.php';
Model::checkvalidation();
if (isset($_GET['fullname']))
{
    $_SESSION['fullname'] = $_GET['fullname'];
}
if (isset($_GET['phone']))
{
    $_SESSION['phone'] = $_GET['phone'];
}

if (isset($_GET['id']))
{
    $id = trim($_GET['id']);
    $_SESSION['idval'] = trim($_GET['id']);
    $_SESSION['balance'] = getAgentbalance(trim($_SESSION['idval']));
}
//$phone = $_GET['phone'];
//$id = $_SESSION['id'];
sendAgentDetail();

//$balance = getAgentbalance();
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
           <div id="menu" >
                <h1>Corporate Menu</h1>
                   <ul>
                   <?php echo quickuserRole(); ?>
                  </ul>
            </div>
         <div id="mainContent">
             <div id="fundform">
             <form id="form1" name="form1" method="post" action="../Controller.php">
              <div class="caption" style="width: 530px;">Fund Agent Account</div>
              <?php 
                if (isset($_SESSION['agenterror']))
                {
                    echo '<div id ="error"><span class="statuserror"></span><span class="statustext">Please enter your amount and comment </span></div>';
                    unset($_SESSION['agenterror']);
                }elseif(isset($_GET['wmRespond']))
                {
                    echo '<div id ="response"><span class="statusSuccess"></span><span class="successtext">Your Request has been sent for Approval </span></div>';
                    unset($_GET['wmRespond']);
                }
                
            ?>
             <input type="hidden" value="<?php echo $id; ?>" name ="hiddenid"/>
              <div id="agentdiv" style="width: 537px;">
                <table class="agentform" width="100%">
               <tr>
                 <td id="key">Agent FullName</td>
                 <td id="value"><?php echo  $_SESSION['fullname'];?></td>
               </tr>
               <tr>
                 <td id="key">Agent PhoneNumber</td>
                 <td id="value"><?php echo $_SESSION['phone']; ?></td>
               </tr>
               <tr>
                 <td id="key">Current Balance</td>
                 <td id="value"><?php echo $_SESSION['balance']; ?></td>
               </tr>
                 <tr>
                     <td id="key">Amount</td>
                     <td id="value"><input type="text" name="amount" size="30px"  value=""/></td>
                 </tr>
                 <tr>
                     <td id="key">Comment</td>
                     <td id="value"><textarea rows="5" cols="30" name="comment"></textarea></td>
                 </tr>
                 <tr>
                     <td id="key"></td>
                     <td id="value"><input type="submit" value="Fund Till" name="fund"/></td>
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
