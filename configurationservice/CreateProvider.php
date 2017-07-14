<?php
include '../Controller.php';
Model::checkvalidation();

$param = ''; $splitparamvalue = array();

$servicedetail = populateServiceName();
//var_dump($roledetail); die();
$splitmethod = splitKeyword($servicedetail);
//var_dump($splitmethod);die();
include '../pathcheck.php';
//$base = basename(pathcheck());
sessiontimeout();
 logmeout();                  
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Create Provider</title>
        <link type="text/css" rel="stylesheet" href="../style.css"/> 
        <link href="../jquery/css/bvalidator/bvalidator.css" rel="stylesheet" type="text/css" />
        <script src="../jquery/development/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="../jquery/js/jquery.bvalidator.js"></script>
        <script src="../jquery/customjs.js"></script>
        <script type="text/javascript">
                $(document).ready(function() {
                    
                     $('#form1').bValidator();
                     
                     $("#dob").datepicker({
                        defaultDate: "+1w",
                        dateFormat: "yy-mm-dd"
                    });
//                                $('#servicename').change(function(){
//                                    
//                                        if ($(this).val() != '')   
//                                        {
////                                                var dataval = $('this').val();
//                                               $.get(
//                                                    'configuration.php',
//                                                    { serviceid: $(this).val() },
//                                                    function(data)
//                                                    {
////                                                        $('#result').html(data);
//                                                    });
//
//                                         }
//                                    })
                     
                    
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
                <h1>Service Configuration</h1>
                  <ul>
                    <?php echo ServiceConfiguration();?>
                  </ul>
                <div id="slidingjpg">
                    <img src="../images/system.jpg"  alt="" title="branchless banking"/>
                </div>
            </div>
         <div id="mainContent">
             <div id="fundform">
           <?php
                  if (isset($_GET['wmconfigure'])) {
          echo '<div id="response"><span class="statusSuccess"></span><span class="successtext">System Configuration Successfully Created. </span></div>';  
                     unset($_GET['wmconfigure']);
                    }else if(isset($_GET['wmerror'])){
           echo '<div id="error"><span class="statuserror"></span><span class="statustext">This Service has already been done</span></div>';
                    unset($_GET['wmerror']);
                    }
                    elseif (isset($_SESSION['errorlist'])) {  
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
                    }  elseif (isset($_GET['wmresponderror'])) {
                        echo '<div id="error"><span class="statuserror"></span><span class="statustext">Sorry No response from the connection </span></div>';
                            unset($_SESSION['connecterror']);
                    }elseif (isset($_SESSION['connecterror'])) {
           echo '<div id="error"><span class="statuserror"></span><span class="statustext">Sorry Connection Error. </span></div>';
                            unset($_SESSION['connecterror']);
               }
                    ?>
           <div id="formcontainer">
           <form id="form1" name="form1" method="post" action="../Controller.php">
               <div class="caption" style="width: 530px">Create Provider</div>
               <div id="agentdiv">
                <table class="agentform" width="100%">
               <tr>
               <td id="key">Name</td>
               <td id="value"><input type="text" placeholder="please enter the name" name="name" size="30px" value ="" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter the thirdpartyname" /></td>
               </tr>
                <tr>
               <td id="key">Platform Name</td>
               <td id="value">
               <input type="text" placeholder="please enter the platform name" name="platformname" size="30px" value ="" data-bvalidator="required" data-bvalidator-msg="enter valid parameter name"/>
               </td>
               </tr>
               <tr>
               <td id="key">Address</label>
               <td id="value"><textarea style="color:white;" name="address" placeholder =" Please enter the platform address" rows="6" cols="26" data-bvalidator="alpha,required" data-bvalidator-msg="Please enter the next of kin address"></textarea></td>
               </tr>
               <tr>
                    <td id="key">Email</td>
                    <td id="value">
                        <input type="text" placeholder="please enter the email" name="email" size="30px" value ="" data-bvalidator="required, email" data-bvalidator-msg="enter valid email"/>
                    </td>
               </tr>
               <tr>
                   <td id="key">Phone Number</td>
                   <td id="value">
                        <input type="text" placeholder="please enter the phone Number" name="phonenumber" size="30px" value ="" data-bvalidator="required, Number" data-bvalidator-msg="enter valid phone Number"/>
                    </td>
               </tr>
               <tr>
                   <td id="key"></td>
                   <td id="value"><input type="submit" value="CreateProvider" name="createconfiguration"/></td>
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
