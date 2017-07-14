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
        <title>Corporate SetUP</title>
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
                <div id="fundform" style="width: 530px;">
             <form id="form1" name="form1" method="post" action="../Controller.php">
              <div class="caption">Corporate SetUp</div>
              <?php 
                if (isset($_GET['wmRespond'])) {
                    echo '<div id ="error"><span class="statusSuccess"></span><span class="statustext">Corporate Successfully created </span></div>';            
                    unset($_GET['wmRespond']);
               }  else if (isset($_SESSION['errorlist'])){
                      $errorlist = $_SESSION['errorlist'];
                       unset($_SESSION['errorlist']);
                      //print_r($errorlist);die();
                    foreach ($errorlist as $val) {
                        $control = $val;
                        echo '<li> ' . $control . '</li>';
                    }
                   
               }elseif(isset($_SESSION['connecterror'])){
                   echo '<div id="error"><span class="statuserror"></span><span class="statustext">Sorry Connection Error. </span></div>';
                   unset($_SESSION['connecterror']);
               }
            ?>
              <div id="agentdiv">
                <table class="agentform" style="width: 530px;">
               <tr>
                 <td id="key">Corporate Name</td>
                 <td id="value"><input type="text" placeholder =" Please enter the corporate name" name="corporatename" size="30px"  value="" data-bvalidator="alpha,required"/></td>
               </tr>
               <tr>
                 <td id="key">Corporate Header</td>
                 <td id="value"><input type="text" placeholder =" Please enter your corporate header" name="corpheader" size="30px"  value="" data-bvalidator="alpha,maxlength[11],required"/></td>
               </tr>
               <tr>
               <td id="key">Provider Name</td>
               <td id="value">
                   <select id="providername" name="providername" data-bvalidator="required" data-bvalidator-msg="Select providername from drop-down menu.">
                   <option value="">--select your Provider Name--</option>
                <?php 
                for($i = 0 ;  $i < sizeof($splitmethod['service']); $i++)
                {
                ?>
                   <option value="<?php echo $splitmethod['service'][$i];?>"><?php echo $splitmethod['service'][$i];?></option>
                <?php
                }
                ?>
               </select>
               </td>
               </tr>
               <tr>
                 <td id="key">Address</td>
                 <td id="value"><textarea rows="5" cols="30" placeholder =" Please enter corporate Address" name="address"></textarea></td>
               </tr>
               <tr>
                 <td id="key">E-mail Address</td>
                 <td id="value"><input type="text" name="email" size="30px" placeholder =" Please your email address"  value="" data-bvalidator="email,required" data-bvalidator-msg="enter valid email"/></td>
               </tr>
                 <tr>
                     <td id="key">PhoneNumber</td>
                     <td id="value"><input type="text" name="phone" size="30px" placeholder =" Please phone Number"  value="" data-bvalidator="number,required"/></td>
                 </tr>
                 <tr>
                     <td id="key"></td>
                     <td id="value"><input type="submit" value="Create" name="createsetup"/></td>
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
