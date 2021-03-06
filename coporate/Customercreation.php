<?php
include '../Controller.php';
Model::checkvalidation();
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Create Customer</title>
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
                   <?php echo quickuserRole();?>
                  </ul>
                   <div id="slidingjpg">
                    <img src="../images/corporate.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
              <div id="mainContent">
           <?php
                   if (isset($_GET['wmRespond']) ){
               echo '<div id="response"><span class="statusSuccess"></span><span class="successtext">Customer Successfully Created. </span></div>';  
                    }
                    else if (isset($_SESSION['customererror'])) {
            ?>
           <div id="errorDetail"> Please fix the following input errors:
             <ul>
               <?php
                    $errorlist=$_SESSION['customererror'];
                    foreach ($errorlist as $value) {
                     $control=$value;
                     echo '<li> ' . $control . '</li>';
                    }
                    ?>
             </ul>
           </div>
           <?php                                      
                    }elseif (isset($_SESSION['exist'])) {
            echo '<div id="error"><span class="statuserror"></span><span class="statustext">Customer Already Exists </span></div>';
                      unset($_SESSION['exist']);
                     }elseif (isset($_SESSION['connecterror'])) {
           echo '<div id="error"><span class="statuserror"></span><span class="statustext">Sorry Connection Error. </span></div>';
                            unset($_SESSION['connecterror']);
                     }elseif(isset($_SESSION['outputerror'])){
            echo '<div id="error"><span class="statuserror"></span><span class="statustext">Please check Entry Error or Connection Error. </span></div>';
                            unset($_SESSION['outputerror']);             
                     }
                    ?>
          
           <div id="formcontainer">
           <form id="form1" name="form1" method="post" action="../Controller.php">
               <div class="caption" style="width: 530px;">Create Customer</div>
               <div id="agentdiv">
                  <table class="agentform" width="100%">
                    <tr>
                        <td id="key">FirstName</td>
                        <td id="value"><input type="text" placeholder="please enter your firstname" name="fname" size="30px" value ="" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your first name"/></td>
                    </tr>
                    <tr>
                        <td id="key">LastName</td>
                        <td id="value"><input type="text" name="lname" placeholder="please enter your lastname" size="30px" value ="" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your first name"/></td>
                    </tr>
                    <tr>
                        <td id="key"> AccountType</td>
                        <td id="value">
                <select name="acctType" data-bvalidator="required" data-bvalidator-msg="Select agenttype from drop-down menu.">
                   <option value="">---Select the account type---</option>
                   <option value="saving">Saving Account</option>
                   <option value="current">Current Account</option>
                </select>
                            </td>
                    </tr>
                    <tr>
                        <td id="key">Phone Number</label>
                        <td id="value"><input type="text" placeholder="please enter your Phone Number" name="phoneno" size="30px" value ="" data-bvalidator="number,required"/></td>
                    </tr>
                    <tr>
                        <td id="key">Email</td>
                       <td id="value"><input type="text" placeholder="please enter your Email Address" name="email" size="30px" value ="" data-bvalidator="email,required" data-bvalidator-msg="enter valid email"/></td>
                    </tr>
                    <tr>
                        <td id="key"> Identification Type</td>
                        <td id="value">
                <select name="Idtype" data-bvalidator="required" data-bvalidator-msg="Select Identification type from drop-down menu.">
                   <option value="">---Select the Identification type---</option>
                   <option value="nationalcard">National ID Card</option>
                   <option value="passport">International Passport</option>
                   <option value="driverlicense">Driver License</option>
                </select>
                            </td>
                    </tr>
                    <tr>
                        <td id="key">Identification Number</td>
                       <td id="value"><input type="text" name="idno" size="30px" value ="" placeholder="please enter your Identification Number" data-bvalidator="alphanum,required" data-bvalidator-msg="please enter valid Identification number"/></td>
                    </tr>
                    <tr>
                        <td id="key">Address</td>
                        <td id="value"><textarea name="address" rows="5" cols="30" placeholder="please enter your Address please"></textarea></td>
                    </tr>
                    <tr>
                        <td id="key"></td>
                        <td id="value"><input type="submit" value="Create" name="CreateCustomer"/></td>
                    </tr>
                   </table>
               </div>
               
           </form>
               
           </div>
            <?php 
             if (isset($_SESSION['adminusername']) && isset($_SESSION['adminpassword']))
             {
           ?>
                 <div id="footnav">
                   <ul>
                       <li><a href="viewCustomer.php">View All Customers</a></li>
                   </ul>
               </div> 
           <?php }elseif (isset($_SESSION['perm'])) {
               foreach($_SESSION['perm'] as $valsession){
                            if (strcmp($valsession, 'ManageCustomer') == 0){
            ?>
                <div id="footnav">
                   <ul>
                       <li><a href="viewCustomer.php">View All Customers</a></li>
                   </ul>
               </div>   
            <?php
                            }
               }
               
           }?>
           </div>
           </div>
       </div>
          </div> 
        </div>
        <div id="footer"></div>
    </body>
</html>
