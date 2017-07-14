<?php
include '../Controller.php';
Model::checkvalidation();
$corpdetail = getcorporatelist();
//var_dump($corpdetail); die();
$splitmethod = splitKeyword($corpdetail);
//var_dump($splitmethod); die();
corporateAcct();
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Corporate Account SetUp</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
        <link rel="stylesheet" href="../jquery/development/themes/base/jquery.ui.all.css" />
        <link rel="stylesheet" href="../jquery/development/demos/demos.css"/>
        <script src="../jquery/development/jquery-1.8.2.js"></script>
        <script src="../jquery/development/ui/jquery.ui.core.js"></script>
        <script src="../jquery/development/ui/jquery.ui.widget.js"></script>
        <script src="../jquery/development/ui/jquery.ui.datepicker.js"></script>
        <link href="../jquery/css/bvalidator/bvalidator.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../jquery/js/jquery.bvalidator.js"></script>
        <script>
                $(function() {
                    $("#dob").datepicker({
                        defaultDate: "+1w",
                        dateFormat: "yy-mm-dd"
                    });
                    
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
                   <div id="slidingjpg">
                    <img src="../images/corporate.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
         <div id="mainContent">
                <div id="fundform">
             <form  id="form1" name="form1" method="post" action="../Controller.php">
              <div class="caption" style="width: 530px;">Corporate Account</div>
              <?php 
                if (isset($_SESSION['errorlist']))
                {
                    $errorlist=$_SESSION['errorlist'];
                    unset($_SESSION['errorlist']);
                    foreach ($errorlist as $value) {
                        $control=$value;
                     echo '<li> ' . $control . '</li>';
                    }
                }elseif(isset($_GET['wmRespond']))
                {
                    echo '<div id ="response"><span class="statusSuccess"></span><span class="successtext">Your Request has been sent for Approval </span></div>';
                    unset($_GET['wmRespond']);
                }elseif(isset($_SESSION['connecterror'])){
                    echo '<div id="error"><span class="statuserror"></span><span class="statustext">Sorry Connection Error. </span></div>';
                    unset($_SESSION['connecterror']);
                }
                
            ?>
              <div id="agentdiv" style="width: 538px;">
                <table class="agentform" width="100%">
               <tr>
                 <td id="key">Corporate Name</td>
                 <td id="value">
                     <select name="corporatename" data-bvalidator="required" data-bvalidator-msg="please select corporate name">
                         <option value="">---Select Corporate Name ---</option>
                <?php 
                for($i = 0 ;  $i < sizeof($splitmethod['corporateName']); $i++)
                {
                ?>
                   <option value="<?php echo $splitmethod['corporateName'][$i];?>"><?php echo $splitmethod['corporateName'][$i];?></option>
                <?php
                }
                ?>
                     </select></td>
               </tr>
               <tr>
                 <td id="key">Account Name</td>
                 <td id="value"><input type="text" name="acctname" size="30px"  value="" placeholder="Please enter account name" data-bvalidator="alpha,required" data-bvalidator-msg="please enter account name"/></td>
               </tr>
               <tr>
                 <td id="key">Account No</td>
                 <td id="value"><input type="text" name="acctno" size="30px"  value="" placeholder="Please enter account number" data-bvalidator="number,required" data-bvalidator-msg="please enter account number"/></td>
               </tr>
                 <tr>
                     <td id="key">Acct Type</td>
                     <td id="value"><select name="acctType" data-bvalidator="required" data-bvalidator-msg="please select account Type">
                         <option value="">---select acctType---</option>
                         <option value="savings">Saving</option>
                         <option value="current">Current</option>
                     </select></td>
                 </tr>
                 <tr>
                     <td id="key"></td>
                     <td id="value"><input type="submit" value="Create" name="create"/></td>
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
