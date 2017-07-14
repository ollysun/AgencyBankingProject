<?php
include '../Controller.php';
Model::checkvalidation();

$roledetail = populateRoleType();
//var_dump($roledetail); die();
$splitmethod = splitKeyword($roledetail);
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Create Agent</title>
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
                   <h1>Corporate Menu</h1>
                  <ul>
                   <?php echo quickuserRole();?>
                  </ul>
                   <div id="slidingjpg">
                    <img src="../images/corporate.jpg"  alt="" title="branchless banking"/>
                </div>
              </div>
              <div id="mainContent">
           <?php
                   if (isset($_GET['wmRespond'])) {
                       ?>
           <div id ="response"><span class="statusSuccess"></span><span class="successtext">Agent Successfully Created </span></div>
           <?php
                    unset($_GET['wmRespond']);
                    }
                    else if (isset($_SESSION['errorlist'])) {
                        ?>
           <div id="errorDetail"> Please fix the following input errors:
             <ul>
               <?php
                    $errorlist=$_SESSION['errorlist'];
                    unset($_SESSION['errorlist']);
                    foreach ($errorlist as $value) {
                     $control=$value;
                     echo '<li> ' . $control . '</li>';
                    }
                ?>
             </ul>
           </div>
           <?php                                      
                }elseif (isset($_SESSION['connecterror'])) {
                   echo '<div id="error"><span class="statuserror"></span><span class="statustext">Sorry Connection Error. </span></div>';
                   unset($_SESSION['connecterror']);
                }elseif (isset($_SESSION['exist'])) {
                   echo '<div id="error"><span class="statuserror"></span><span class="statustext">Agent Already Exists. </span></div>';
                   unset($_SESSION['exist']);
                }
                    ?>
          
           <div id="formcontainer">
           <form id="form1" name="form1" method="post" action="../Controller.php">
               <div class="caption" style="width: 530px;">Create Agent</div>
               <div id="agentdiv">
                  <table class="agentform" width="100%">
                    <tr>
                        <td id="key">CorporateName</td>
                        <td id="value"><input type="text" placeholder="plese enter first name" name="fname" size="30px" value ="" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your first name"/></td>
                    </tr>
                    <tr>
                        <td id="key">FirstName</td>
                        <td id="value"><input type="text" placeholder="plese enter first name" name="fname" size="30px" value ="" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your first name"/></td>
                    </tr>
                    <tr>
                        <td id="key">LastName</td>
                        <td id="value"><input type="text" placeholder="enter last name" name="lname" size="30px" value ="" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your last name"/></td>
                    </tr>
                    <tr>
                        <td id="key">AgentType</td>
                        <td id="value">
               <select name="agentType" data-bvalidator="required" data-bvalidator-msg="Select agenttype from drop-down menu.">
                   <option value="">---Select the agent type---</option>
                   <option value="corporateAgent">Corporate Agent</option>
                   <option value="retailAgent">Retail Agent</option>
               </select>
                            </td>
                    </tr>
                    <tr>
                        <td id="key">Agent RoleType</td>
               <td id="value">
               <select name="Agentrole" data-bvalidator="required" data-bvalidator-msg="Select roletype from drop-down menu.">
                   <option value="">--select the Roletype--</option>
                   <option value="AgentRole">AgentRole</option>
               </select>
                    </tr>
                    <tr>
                        <td id="key">Phone Number</label>
                        <td id="value"><input type="text" placeholder="Type the phone Number" name="phoneno" size="30px" value ="" data-bvalidator="number,required"/></td>
                    </tr>
                    <tr>
                        <td id="key">Email</td>
                        <td id="value"><input type="text" placeholder="please enter your email" name="email" size="30px" value ="" data-bvalidator="email,required" data-bvalidator-msg="Please enter valid email"/></td>
                    </tr>
                    <tr>
                        <td id ="key">Address</td>
                        <td id="value"><textarea name="address" placeholder="please enter your home address" rows="6" cols="26"></textarea></td>
                    </tr>
                    <tr>
                        <td id="key">Date Of Birth</td>
                        <td id="value"><input type="text" name="dob" placeholder="please enter your date of birth" size="30px" value ="" id="dob" data-bvalidator="date[yyyy-mm-dd],required"/></td>
                    </tr>
                    <tr>
                        <td id="key">Next Of Kin</td>
                        <td id="value"><input type="text" name="nok" size="30px" placeholder="please enter your next of kin" value ="" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your next of Kin"/></td>
                    </tr>
                    <tr>
                        <td id="key">Next Of Kin Address</td>
                        <td id="value"><textarea name="nokaddress" placeholder="please enter your next of kin address" rows="6" cols="26" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your next of Kin address"></textarea></td>
                    </tr>
                    <tr>
                        <td id="key"></td>
                        <td id="value"><input type="submit" value="CreateAgent" name="CreateAgent"/></td>
                    </tr>
                   </table>
               </div>
           </form>
               <?//die();?>
           </div>
         
           </div>
           </div>
       </div>
          </div>
        <div id="footer"></div>
    </body>
</html>
