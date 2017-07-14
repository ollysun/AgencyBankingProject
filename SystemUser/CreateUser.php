<?php
include '../Controller.php';
//Model::checkvalidation();
$roledetail = populateRoleType();
//var_dump($roledetail); die();
$splitmethod = splitKeyword($roledetail);
//var_dump($splitmethod); die();
$allcorp = getAllCorporate();
$userdetail = populateUserType();
//var_dump($userdetail); die();
$splituser = splitKeyword($userdetail);
//var_dump($splituser);die();
sessiontimeout();
logmeout();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banking Agency</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
        <link rel="stylesheet" href="../jquery/development/themes/base/jquery.ui.all.css" />
        <link rel="stylesheet" href="../jquery/development/demos/demos.css"/>
        <script src="../script/jquery1.9.1.js"></script>
        <script src="../jquery/development/ui/jquery.ui.core.js"></script>
        <script src="../jquery/development/ui/jquery.ui.widget.js"></script>
        <script src="../jquery/development/ui/jquery.ui.datepicker.js"></script>
        <link href="../jquery/css/bvalidator/bvalidator.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../jquery/js/jquery.bvalidator.js"></script>
        <script type="text/javascript">
                $(function() {
                    $("input:radio").click(function(){
	var vi = $(this).val();
	if(vi == 1){
               $('#cellulant').slideDown('slow');
               $('#corporate').slideUp('slow');
        }else if(vi == 0){
            $("#corporate").slideDown();
            $("#cellulant").slideUp();
        }
    });
                    $("#dob").datepicker({
                        defaultDate: "+1w",
                        dateFormat: "yy-mm-dd"
                    });
                    
                     $('#form1').bValidator();
                     $('#form2').bValidator();
                     
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
           echo '<div id="response"><span class="statusSuccess"></span><span class="successtext">User Account Successfully Created. </span></div>';  
                     unset($_GET['wmRespond']);
                    }else if(isset($_GET['wmRespondExists'])){
           echo '<div id="error"><span class="statuserror"></span><span class="statustext">User Already Exists </span></div>';
                    unset($_GET['wmRespondExists']);
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
             }
             openlogin();
               ?>
                 
                 
              
<!--          <div id="openlogin">
              <form>    
                  <fieldset>
                      <legend>Please select the form Type</legend>
                   <table class="agentform" style="width: 100%;">
                       <tr><td><input type="radio" name="cellulantlogin" value="1"/>Cellulant Admin</td>
                       <td><input type="radio" name="cellulantlogin" value="0"/>Corporate</td></tr>              
                   </table>
                  </fieldset>
              </form>
              <style type="text/css">
                  p{
		display:block;
		height: 20px;
		width: 100px;
	}
              </style>
              <p id="val1" style="display: none; background: green">jajajajajaja</p>
              <p id="val2" style="display: none; background: blue">kakakakakak</p>
           </div>-->
         <div id="formcontainer">
        <!--<form id="form1" name="form1" method="post" action="../Controller.php">-->
        <div id="corporate" <?php if (isset($_SESSION['scope']) && $_SESSION['scope'] !== 1){
                           echo 'style="display: none;"';
              }  else { echo 'style="display: block;"'; }?> >
       <form id="form1" name="form1" method="post" action="../Controller.php">
            <div class="caption" style="width: 530px;">Create User</div>
            <div id="agentdiv">
                <table class="agentform" style="width: 100%;">
                <tr>
               <td id="key">CorporateName</td>
               <td id="value"><input type="text" name="corpname" size="30px" value ="" disabled="disabled"/></td>
               </tr>
               <tr>
               <td id="key">FirstName</td>
               <td id="value"><input type="text" placeholder =" Please enter your first name" name="fname" size="30px" value ="" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your first name" /></td>
               </tr>
               <tr>
               <td id="key">LastName</td>
               <td id="value"><input type="text" placeholder =" Please enter your last name" name="lname" size="30px" value ="" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your last name" /></td>
               </tr>
               <tr>
               <td id="key">Phone Number</td>
               <td id="value"><input type="text" name="phoneno" placeholder =" Please enter your phone number" size="30px" value =""  data-bvalidator="number,required"/></td>
               </tr>
               <tr>
               <td id="key">Email</td>
               <td id="value"><input type="text" placeholder =" Please enter  your email ID" name="email" size="30px" value ="" data-bvalidator="email,required" data-bvalidator-msg="enter valid email"/></td>
               </tr>
               <tr>
               <td id="key">Address</td>
               <td id="value"><textarea style="color:white;" name="address" placeholder =" Please enter your your address" rows="6" cols="26"><?php  if (isset($_POST['address'])) echo $_POST['address']?></textarea></td>
               </tr>
               <tr>
                   <td id="key">Date Of Birth</td>
                   <td id="value"><input type="text" placeholder =" Please enter your date of birth" name="dob" size="30px" value ="" id="dob" data-bvalidator="date[yyyy-mm-dd],required"/></td>
               </tr>
               <tr>
               <td id="key">RoleType</td>
               <td id="value">
               <select name="roletype" data-bvalidator="required" data-bvalidator-msg="Select roletype from drop-down menu.">
                   <option value="">--select the Roletype--</option>
                   <option value="default">Default</option>
                <?php 
                for($i = 0 ;  $i < sizeof($splitmethod['rolename']); $i++)
                {
                  echo '<option value=$splitmethod[rolename][$i]>$splitmethod[rolename][$i]</option>';
                ?>
                   <option value="<?php echo $splitmethod['rolename'][$i];?>"><?php echo $splitmethod['rolename'][$i];?></option>              
                <?php
               }
                ?>
               </select>
               </td>
               </tr>
               <tr>
               <td id="key">Next Of Kin</td>
               <td id="value"><input type="text" placeholder =" Please enter your next of kin" name="nok" size="30px" value ="" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter the next kin name"/></td>
               </tr>
               <tr>
               <td id="key">Next Of Kin Address</label>
               <td id="value"><textarea style="color:white;" name="nokaddress" placeholder =" Please enter your next of kin address" rows="6" cols="26" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter the next of kin address"></textarea></td>
               </tr>
               <tr>
                   <td id="key"></td>
                   <td id="value"><input type="submit" value="CreateUser" name="CreateUser"/></td>
               </tr>
                </table>
           </div>
       </form>
         </div> 
               
           
         <div id="cellulant" style="display: none;">
        <form id="form2" name="form2" method="post" action="../Controller.php">
              <div class="caption" style="width: 530px;">Create Cellulant Admin</div>
            <div id="agentdiv">
                <table class="agentform" style="width: 100%;">
               <tr>
               <td id="key">FirstName</td>
               <td id="value"><input type="text" placeholder =" Please enter your first name" name="fname" size="30px" value ="" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your first name" /></td>
               </tr>
               <tr>
               <td id="key">LastName</td>
               <td id="value"><input type="text" placeholder =" Please enter your last name" name="lname" size="30px" value ="" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter your last name" /></td>
               </tr>
               <tr>
               <td id="key">Phone Number</td>
               <td id="value"><input type="text" name="phoneno" placeholder =" Please enter your phone number" size="30px" value =""  data-bvalidator="number,required"/></td>
               </tr>
               <tr>
               <td id="key">Email</td>
               <td id="value"><input type="text" placeholder =" Please enter  your email ID" name="email" size="30px" value ="" data-bvalidator="email,required" data-bvalidator-msg="enter valid email"/></td>
               </tr>
               <tr>
               <td id="key">Address</td>
               <td id="value"><textarea style="color:white;" name="address" placeholder =" Please enter your your address" rows="6" cols="26"><?php  if (isset($_POST['address'])) echo $_POST['address']?></textarea></td>
               </tr>
               <tr>
                   <td id="key">Date Of Birth</td>
                   <td id="value"><input type="text" placeholder =" Please enter your date of birth" name="dob" size="30px" value ="" id="dob" data-bvalidator="date[yyyy-mm-dd],required"/></td>
               </tr>
               <tr>
               <td id="key">RoleType</td>
               <td id="value">
               <select name="roletype" data-bvalidator="required" data-bvalidator-msg="Select roletype from drop-down menu.">
                   <option value="">--select the Roletype--</option>
                   <option value="default">Default</option>
                <?php 
                for($i = 0 ;  $i < sizeof($splitmethod['rolename']); $i++)
                {
                ?>
                   <option value="<?php echo $splitmethod['rolename'][$i];?>"><?php echo $splitmethod['rolename'][$i];?></option>
                <?php
                }
                ?>
               </select>
               </td>
               </tr>
               <tr>
               <td id="key">UserType</td>
               <td id="value">
               <select name="usertype" data-bvalidator="required" data-bvalidator-msg="Select usertype from drop-down menu.">
                   <option value="">--select the Usertype--</option>
                   <?php 
                    for($i = 0;$i < sizeof($splituser['usertype']); $i++)
                    {
                    ?>
                    <option value="<?php echo $splituser['usertype'][$i];?>"><?php echo $splituser['usertype'][$i];?></option>
                     <?php
                    }
                    ?>
               </select>
               </td>
               </tr>
               <tr>
               <td id="key">CorporateList</td>
               <td id="value">
               <select name="corporatelist" data-bvalidator="required" data-bvalidator-msg="Select usertype from drop-down menu.">
                   <option value="">--select the CorporateList--</option>
                   <?php 
                    foreach($allcorp as $value)
                    {
                        echo "<option>$value</option>";
                    }
                    ?>
               </select>
               </td>
               </tr>
               <tr>
               <td id="key">Next Of Kin</td>
               <td id="value"><input type="text" placeholder =" Please enter your next of kin" name="nok" size="30px" value ="" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter the next kin name"/></td>
               </tr>
               <tr>
               <td id="key">Next Of Kin Address</label>
               <td id="value"><textarea style="color:white;" name="nokaddress" placeholder =" Please enter your next of kin address" rows="6" cols="26" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter the next of kin address"></textarea></td>
               </tr>
               <tr>
                   <td id="key"></td>
                   <td id="value"><input type="submit" value="CreateAdmin" name="CreateAdmin"/></td>
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
        </div>
        <br><br>
        <div id="footer"></div>
    </body>
</html>
