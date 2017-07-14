<?php
include('Model.php'); 
session_start();
 //$data=array();
 //$loginuser = "";
 
 getRoles();
 createUser();
 createAgent();
 //populateAgent();
 sendAgentDetail();
// populateManageRequest();
corporatesetup();
resetpassword();
corporateAcct();

 function populateAction()    
{
     $modobj =  new Model();
    $url = $modobj->urlval;
    $url = $url. "ActionUrl?getAction";
    //echo $url;die();
    $result= Model::callABWM($url);
    //return $result;
    //$split = explode(" ", trim($result));
    
    return $result;
}

function populateUserType()
{
    $modobj =  new Model();
    $urlval = $modobj->urlval;
    $urlval = $urlval."PopulateUserType?userType";
    $result = Model::callABWM($urlval);
    
    return $result;
}

function populateRoleType()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    $url = $url . "PopulateUserRole?getRoles";
    //echo $url;
    $result = Model::callABWM($url);
    
    return $result;
}

function populateServiceName()
{
   $modobj =  new Model();
    $url = $modobj->urlval;
    $url = $url . "LoadServiceName?serviceName";
    //echo $url; die();
    $result = Model::callABWM($url);
    
    return $result;
}

function populateParameterValue($serviceval)
{
    $modobj =  new Model();
    $urlval = $modobj->urlval;
    $urlval = $urlval."LoadParamValue?serviceName=" . $serviceval;
    //echo $urlval; die();
    $result = Model::callABWM($urlval);
    
    return $result;
}

function splitKeyword($str)
{   
        $xml_object = simplexml_load_string($str); 
        $xml_array=object2array($xml_object); 
        return $xml_array;
}

function object2array($object) { return @json_decode(@json_encode($object),1); }

function populateUser()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    $url = $url . "userdetail?getalluser";
    $result = Model::callABWM($url);
    return $result;
}

function validateroledata($ag)
{
       $errorList=array();
    if (empty($ag->rolename)) {
         $errorList[]='rolename';
     }
     if (empty($ag->roledescription)) {
         $errorList[]='roledescription';
     }
     if (empty($ag->roleaction)) {
         $errorList[]='roleAction';
     }
      return $errorList;
}

function getRoles()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    $error = array();
    $obj = new Role();
    if (isset($_POST['AssignRole']))
    {
        $obj->rolename = mysql_real_escape_string(stripcslashes($_POST['rolename']));
        $obj->roledescription = mysql_real_escape_string(stripcslashes($_POST['roledescription']));
        if (is_array($_POST['actions']))
        {
            foreach($_POST['actions'] as $val)
            {
                $obj->roleaction[] = mysql_real_escape_string($val); 
            }
        }
        //echo $obj->rolename; die();
        $pipeaction = join("|", $obj->roleaction);
        $error = validateroledata($obj);
        //return $error;
        if (count($error)>0) {
           $_SESSION['errorlist'] = $error;  
           header('Location:SystemUser/CreateRoles.php');
           //return $error;
        }else{
            
            $url =  $url."CreateRole_Permission?rolename=" . urlencode($obj->rolename) . "&roledesc=" . urlencode($obj->roledescription) . "&action=" . urlencode($pipeaction);             
           //echo $url; die();
           $result = Model::callABWM($url);
            if ($result == 00){
                header("Location:SystemUser/CreateRoles.php?wmRespond");
            }else{
                $_SESSION['connecterror'] = "connection error";
                header("Location:coporate/corporateSetup.php");
                die();
            }
             
        }
        
    }  
}

function corporatesetup()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    global $loginuser;
    //$filetype = array('image/jpg', 'image/png', 'image/jpeg');
    //$error = array();
    //$target_path = "./uploadfolder/";
    $obj = new corporate();
    if (isset($_SESSION['username'])){
        $loginuser = $_SESSION['username'];
    }
    if (isset($_POST['createsetup']))
    {
        $obj->corporatename = mysql_real_escape_string($_POST['corporatename']);
        $obj->address = mysql_real_escape_string($_POST['address']);
        $obj->email = mysql_real_escape_string($_POST['email']);
        $obj->phone = mysql_real_escape_string($_POST['phone']);
        $obj->header = mysql_real_escape_string($_POST['corpheader']);
        //var_dump($obj);
         $error = validatecorporateuser($obj);
         if (count($error)>0) {
           $_SESSION['errorlist'] = $error;  
           header('Location:coporate/corporateSetup.php');
         }  else {
             $url =  $url."CorporateSetup?corpname=" . urlencode($obj->corporatename) . "&address=" . urlencode($obj->address) 
. "&email=" . urlencode($obj->email) . "&corpHeader=" . urlencode($obj->header). "&phoneNumber=" . urlencode($obj->phone) ."&loginUser=" . urlencode($loginuser);             
           //echo $url; die();
           $result = Model::callABWM($url);
          
            if ($result == 00){
                header("Location:coporate/corporateSetup.php?wmRespond=success");
                die();
            }else{
                $_SESSION['connecterror'] = "connection error";
                header("Location:coporate/corporateSetup.php");
                die();
            }
         }
    }
}

function getcorporatelist()
{
     $modobj =  new Model();
    $url = $modobj->urlval;
    $url = $url . "ListCorporateName?corpName";
    //echo $url;die();
    $result = Model::callABWM($url);
    
    return $result;
}

function corporateAcct()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    global $loginuser;
    $error = array();$userarray = array();
    $obj = new corpacct();
    if (isset($_SESSION['username'])){
        $loginuser = $_SESSION['username'];
    }
    
    if (isset($_POST['create']))
    {
        $obj->corpname = mysql_real_escape_string($_POST['corporatename']);
        $obj->acctType = mysql_real_escape_string($_POST['acctType']);
        $obj->acctno = mysql_real_escape_string($_POST['acctno']);
        $obj->acctname = mysql_real_escape_string($_POST['acctname']);
        $error = validatecorpacct($obj);
        //var_dump($error);die();
        if (count($error)>0) {
           $_SESSION['errorlist'] = $error;  
           header('Location:coporate/corporateacct.php');
           //return $error;
        }else{
            $url =  $url."CorporateAccountSetup?accountName=" 
. urlencode($obj->acctname) . "&accountNo=" . urlencode($obj->acctno) 
. "&acctType=" . urlencode($obj->acctType) . "&corpName=" . urlencode($obj->corpname)
      . "&loginUser=" . urlencode($loginuser);             
           //echo $url; die();
           $result = Model::callABWM($url);
           //echo $result; die();
            if ($result == 00){
                header("Location:coporate/corporateacct.php?wmRespond");
                die();
            }else{
                $_SESSION['connecterror'] = "connection error";
                header("Location:coporate/corporateacct.php");
                die();
            }
             
        }
         }
}
function validatecorpacct($obj)
{
    $errorList=array();
    if (empty($obj->corpname)) {
         $errorList[]='Invalid corporate name';
     }
     if (empty($obj->acctType)) {
         $errorList[]='Invalid Account Type';
     }
     if (empty($obj->acctno) && !is_numeric($obj->acctno)) {
         $errorList[]='Invalid account no';
     }
     if (empty($obj->acctname)) {
         $errorList[]='Invalid Account Name';
     }
      return $errorList;
}

function createAgent()
{
   $modobj =  new Model();
    $url = $modobj->urlval;
    global $loginuser;
    $error = array();$userarray = array();
    $obj = new Agent();
    if (isset($_SESSION['username'])){
        $loginuser = $_SESSION['username'];
    }
    
    if (isset($_POST['CreateAgent']))
    {
        $obj->agentfName = mysql_real_escape_string($_POST['fname']);
        $obj->agentlName = mysql_real_escape_string($_POST['lname']);
        $obj->agentPhone = mysql_real_escape_string($_POST['phoneno']);
        $obj->email = mysql_real_escape_string($_POST['email']);
        $obj->address = mysql_real_escape_string($_POST['address']);
        $obj->DOB = mysql_real_escape_string($_POST['dob']);
        $obj->agentType = mysql_real_escape_string($_POST['agentType']);
        $obj->NOK = mysql_real_escape_string($_POST['nok']);
        $obj->NOKaddress = mysql_real_escape_string($_POST['nokaddress']);
        $agentrole = mysql_real_escape_string($_POST['Agentrole']);
        $error = validateCreateAgent($obj);
        //return $error;
        if (count($error)>0) {
           $_SESSION['errorlist'] = $error;  
           header('Location:coporate/CreateAgent.php');
           //return $error;
        }else{
            $url =  $url."createAgent?fname=" 
. urlencode($obj->agentfName) . "&lname=" . urlencode($obj->agentlName) 
. "&phone=" . urlencode($obj->agentPhone) . "&email=" . urlencode($obj->email)
. "&address=" . urlencode($obj->address) . "&DOB=" . urlencode($obj->DOB)
. "&agntType=" . urlencode($obj->agentType)
. "&NOK=" . urlencode($obj->NOK) . "&NOKaddress=" . urlencode($obj->NOKaddress)
. "&loginUser=" . urlencode($loginuser) . "&roleId=" . urlencode($agentrole);             
           //echo $url; die();
           $result = Model::callABWM($url);
           //echo $result; die();
            if ($result == 00){
                header("Location:coporate/CreateAgent.php?wmRespond");
                die();
            }else if(empty ($result) || is_null($result) || $result == " "){
                $_SESSION['connecterror'] = "connection error";
                header("Location:coporate/CreateAgent.php");
                die();
            }else if($result == 01){
                $_SESSION['exist'] = "Already Exists";
                header("Location:coporate/CreateAgent.php");
                die();
            }else
            {
               $_SESSION['connecterror'] = "connection error";
                header("Location:coporate/CreateAgent.php");
                die(); 
            }
             
        }
         }
}

function getAgentbalance()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    $id = $_SESSION['id'];
    $url = $url . "CurrentAgentBalance?Id=" . $id;
    //echo $url; die();
    $result = Model::callABWM($url);
    //echo $result;  die();
    return $result;
}

function createUser()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    $error = array();$userarray = array();
    $obj = new users();
    if (isset($_SESSION['username'])){
        $loginuser = $_SESSION['username'];
    }
    if (isset($_POST['CreateUser']))
    {
        $obj->fname = mysql_real_escape_string($_POST['fname']);
        $obj->lname = mysql_real_escape_string($_POST['lname']);
        $obj->phonenumber = mysql_real_escape_string($_POST['phoneno']);
        $obj->email = mysql_real_escape_string($_POST['email']);
        $obj->address = mysql_real_escape_string($_POST['address']);
        $obj->dob = mysql_real_escape_string($_POST['dob']);
        $obj->roletype = mysql_real_escape_string($_POST['roletype']);
        $obj->usertype = mysql_real_escape_string($_POST['usertype']);
        $obj->nokname = mysql_real_escape_string($_POST['nok']);
        $obj->nokaddress = mysql_real_escape_string($_POST['nokaddress']);
        $error = validateuserdata($obj);
        //return $error;
        if (count($error)>0) {
           $_SESSION['errorlist'] = $error;  
           header('Location:SystemUser/CreateUser.php');
           //return $error;
        }else{
            $url =  $url."UserSetup?fname=" 
. urlencode($obj->fname) . "&lname=" . urlencode($obj->lname) 
. "&phone=" . urlencode($obj->phonenumber) . "&email=" . urlencode($obj->email)
. "&address=" . urlencode($obj->address) . "&dob=" . urlencode($obj->dob)
. "&roleId=" . urlencode($obj->roletype) ."&userType=" . urlencode($obj->usertype)
. "&nok=" . urlencode($obj->nokname) . "&nokAddr=" . urlencode($obj->nokaddress)
. "&loginUser=" . urlencode($loginuser);             
           //echo $url; die();
           $result = Model::callABWM($url);
           //echo $result; die();
                if ($result == 01)
                {
                    header("Location:SystemUser/CreateUser.php?wmRespondExists");
                }  else if($result == 00){
                    header("Location:SystemUser/CreateUser.php?wmRespond");
                }else{
                    $_SESSION['connecterror'] = "connection error";
                    header("Location:SystemUser/CreateUser.php");
                    die();
                }
            
             
        }
         }
}

function resetpassword()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    if (isset($_SESSION['username'])){
        $loginuser = $_SESSION['username'];
    }
     if (isset($_POST['unableuser']))
    {
         $hiddenid = $_POST['hiddenid'];
         $ob = populateRequestUser($hiddenid);
        $action = $_POST['unableuser'];
        $comment = mysql_real_escape_string(stripcslashes($_POST['comment']));
        foreach($ob as $userid){
            $username = $userid->fullname;
            $phone = $userid->phonenumber;
        }
        $url = $url . "ManageUser?&action=" . urlencode($action) . "&name=" . urlencode($username)
               . "&phoneNumber=" . urlencode($phone) . "&comment=" . urlencode($comment)
                . "&loginUser=" . $loginuser;
        //echo $url; die();
        $result = Model::callABWM($url);
        //echo $result; die();
            if ($result == 00){
                header("Location:SystemUser/displayUsers.php?wmdisable=$action&userId=$hiddenid");
                die();
            }
    }else if(isset($_POST['resendpin']))
    {
         $hiddenid = $_POST['hiddenid'];
         $ob = populateRequestUser($hiddenid);
        $actiontxt = $_POST['resendpin'];
        $comment = mysql_real_escape_string(stripcslashes($_POST['comment']));
        foreach($ob as $userid){
            $username = $userid->fullname;
            $phone = $userid->phonenumber;
        }
        
        $url = $url . "ManageUser?&action=" . urlencode($actiontxt) . "&name=" . urlencode($username)
               . "&phoneNumber=" . urlencode($phone) . "&comment=" . urlencode($comment)
               . "&loginUser=" . $loginuser;
        //echo $url; die();
         $result = Model::callABWM($url);
         //echo $result; die();
            if ($result == 00){
                header("Location:SystemUser/displayUsers.php?wmreset=$actiontxt&userId=$hiddenid");
                die();
            }
    }
}

function disableAgent()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    if (isset($_SESSION['username'])){
        $loginuser = $_SESSION['username'];
    }
    if(isset($_POST['DisableAgent']))
    {
        $hiddenid = $_POST['hiddenid'];
         $ob = populateAgentdetail($hiddenid);
        $actiontxt = $_POST['DisableAgent'];
        $comment = mysql_real_escape_string(stripcslashes($_POST['comment']));
        foreach($ob as $userid){
            $username = $userid->agentfullname;
            $phone = $userid->agentPhone;
        }
        if (empty($comment))
        {
            header("Location:coporate/disableagent.php?wmerrorcomment=$actiontxt&agentid=$hiddenid");
            die();
        }else{
            $url = $url . "ManageUser?&action=" . urlencode($actiontxt) . "&name=" . urlencode($username)
               . "&phoneNumber=" . urlencode($phone) . "&comment=" . urlencode($comment)
               . "&loginUser=" . $loginuser;
            //echo $url; die();
            $result = Model::callABWM($url);
            //echo $result; die();
            if ($result == 00){
                header("Location:coporate/disableagent.php?wmdisableAgent=$actiontxt&agentid=$hiddenid");
                die();
            }elseif($result == 01)
            {
                header("Location:coporate/disableagent.php?wmerrordisable=$actiontxt&agentid=$hiddenid");
                die();
            }
        }
    }
}
disableAgent();

function disableuser()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    if (isset($_SESSION['username'])){
        $loginuser = $_SESSION['username'];
    }
     if (isset($_POST['disableuser']))
    {
         $hiddenid = $_POST['hiddenid'];
         $ob = populateCustomerDetail($hiddenid);
        $action = $_POST['disableuser'];
        $comment = mysql_real_escape_string(stripcslashes($_POST['comment']));
        foreach($ob as $userid){
            $username = $userid->firstName;
            $phone = $userid->custPhone;
        }
        $url = $url . "ManageUser?&action=" . urlencode($action) . "&name=" . urlencode($username)
               . "&phoneNumber=" . urlencode($phone) . "&comment=" . urlencode($comment)
                . "&loginUser=" . $loginuser;
        //echo $url; die();
        $result = Model::callABWM($url);
        //echo $result; die();
            if ($result == 00){
                header("Location:coporate/displaycustomer.php?wmdisable=$action&customerID=$hiddenid");
                die();
            }elseif($result == 01)
            {
                header("Location:coporate/displaycustomer.php?wmerror=$action&customerID=$hiddenid");
                die();
            }
    }
}

disableuser();

function sendAgentDetail()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    if (isset($_POST['fund']))
    {
        $amount = mysql_real_escape_string(stripslashes($_POST['amount']));
        $comment = mysql_real_escape_string(stripslashes($_POST['comment']));
        //echo $amount; die();
        $id = $_SESSION['id'];
        $loginUser = $_SESSION['username'];
        if (empty($amount)  && empty($comment))
        {
            $_SESSION['agenterror'] = "Invalid data";
            header('Location:coporate/fundagent.php');
        }  else {
             $url = $url . "fundAgentAccount?amount=" . urlencode($amount) ."&InitiatorComment=".  urlencode($comment). "&Id=" . urlencode($id) . "&loginUser=" . urlencode($loginUser);
             //echo $url; die();
             $result = Model::callABWM($url);
           //echo $result; die();
            if ($result == 00){
                header("Location:coporate/fundagent.php?wmRespond");
                die();
            }
        }
    }
}
sendAgentDetail();
function createCustomer()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    if (isset($_POST['CreateCustomer']))
    {
        $firstname = mysql_real_escape_string(stripslashes($_POST['fname']));
        $lastname = mysql_real_escape_string(stripslashes($_POST['lname']));
        $acctType = mysql_real_escape_string(stripslashes($_POST['acctType']));
        $phoneno = mysql_real_escape_string(stripslashes($_POST['phoneno']));
        $email = mysql_real_escape_string(stripslashes($_POST['email']));
        $Idtype = mysql_real_escape_string(stripslashes($_POST['Idtype']));
        $Idno = mysql_real_escape_string(stripslashes($_POST['idno']));
        $address = mysql_real_escape_string(stripslashes($_POST['address']));
        $loginUser = $_SESSION['username'];
        if (empty($firstname) || empty($lastname) || empty($acctType) || empty($phoneno) ||
            empty($email) || empty($Idtype) || empty($Idno) || empty($address))
        {
            $_SESSION['customererror'] = "please fill empty field" . "<br>";
            header('Location:coporate/Customercreation.php');
        }elseif(!validateEmail($email)){
            $_SESSION['customererror'] =   $_SESSION['customererror'] . "Invalid Email";
            header('Location:coporate/Customercreation.php');
        }  else {
             $url = $url . "CustomerRegistration?firstname=" . urlencode($firstname) .
   "&lastname=".  urlencode($lastname). "&accountType=" . urlencode($acctType) . 
 "&phone=" . urlencode($phoneno). "&email=" . urlencode($email) . 
      "&idenType=" . urlencode($Idtype) . "&phone=" . urlencode($phoneno)
    . "&address=" . urlencode($address) . "&ldno=" . urlencode($Idno) . "&loginUser=" . urlencode($loginUser);
             //echo $url; die();
             $result = Model::callABWM($url);
           //echo $result; die();
            if ($result == 00){
                header("Location:coporate/Customercreation.php?wmRespond=success" );
                die();
            }elseif(empty ($result) || is_null($result) || $result == " "){
                $_SESSION['connecterror'] = "connection error";
                header("Location:coporate/Customercreation.php");
                die();
            }elseif($result == 02)
            {
                $_SESSION['exist'] = 'Already exists';
                header("Location:coporate/Customercreation.php");
                die();      
            }else if($result == 01){
                $_SESSION['outputerror'] = "Entry Error";
                header("Location:coporate/Customercreation.php");
                die();
            }
        }
    }
}

createCustomer();

function validateEmail($email)
{
    $pattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
    return preg_match($pattern, $email);
}

function validateCreateAgent($obj)
{
     $errorList=array();
    if (empty($obj->agentfName)) {
         $errorList[]='Invalid firstname';
     }
     if (empty($obj->agentlName)) {
         $errorList[]='Invalid lastname';
     }
     if (empty($obj->agentPhone) || !is_numeric($obj->agentPhone)) {
         $errorList[]='Invalid phonenumber';
     }
     if (empty($obj->email) || !validateEmail($obj->email) ) {
         $errorList[]='Invalid email';
     }
     if (empty($obj->address)) {
         $errorList[]='Invalid address';
     }
     if (empty($obj->DOB) || !valid_date($obj->DOB)) {
         $errorList[]='Invalid Date of Birth';
     }
     if (!isset($obj->agentType)) {
         $errorList[]='Invalid Agent Type';
     }
     if (empty($obj->NOK)) {
         $errorList[]='Invalid Next of Kin';
     }
     if (empty($obj->NOKaddress)) {
         $errorList[]='Invalid Next of Kin address';
     }
      return $errorList;
}

function validatecorporateuser($ag)
{
    $errorList=array();
    if (empty($ag->corporatename)) {
         $errorList[]='Invalid corporatename';
     }
     if (empty($ag->email) || !validateEmail($ag->email) ) {
         $errorList[]='Invalid email';
     }
     if (empty($ag->address)) {
         $errorList[]='Invalid address';
     }
     if (empty($ag->header) || strlen($ag->header) > 11) {
         $errorList[]='please enter the header with maximum of 11 character';
     }
     if (empty($ag->phone) && !is_numeric($ag->phone))
     {
         $errorList[]='Invalid phone number';
     }
      return $errorList;
}

function validateuserdata($ag)
{
    $errorList=array();
    if (empty($ag->fname)) {
         $errorList[]='Invalid firstname';
     }
     if (empty($ag->lname)) {
         $errorList[]='Invalid lastname';
     }
     if (empty($ag->phonenumber) || !is_numeric($ag->phonenumber)) {
         $errorList[]='Invalid phonenumber';
     }
     if (empty($ag->email) || !validateEmail($ag->email) ) {
         $errorList[]='Invalid email';
     }
     if (empty($ag->address)) {
         $errorList[]='Invalid address';
     }
     if (empty($ag->dob) || !valid_date($ag->dob)) {
         $errorList[]='Invalid Date of Birth';
     }
     if (!isset($ag->roletype)) {
         $errorList[]='Invalid Role Type';
     }
     if (!isset($ag->usertype)) {
         $errorList[]='Invalid UserType';
     }
     if (empty($ag->nokname)) {
         $errorList[]='Invalid Next of Kin';
     }
     if (empty($ag->nokaddress)) {
         $errorList[]='Invalid Next of Kin address';
     }
      return $errorList;
}

function valid_date($date) {
    return (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date));
}


function sortUserArray($userdetail)
{
    if (isset($userdetail) && is_array($userdetail))
    {
        switch ($userdetail) {
            case $userdetail[0]:
                return $userdetail;
                break;
            case $userdetail[1]:
                return $userdetail;
                break;
            case $userdetail[2]:
                return $userdetail;
                break;
            default:
                break;
        }
    }
}

if(isset($_POST['Login']))
{   
    $modobj =  new Model();
    $url = $modobj->urlval;
    if (!empty($_POST['username']) || !empty($_POST['password']))
    {
          $_SESSION['username'] = $_POST['username'];
          $username = $_POST['username'];
          $password = $_POST['password'];
                    $url =  $url.'CorporateView?UserId='.  urlencode(trim($username)) .
                            "&password=".  urlencode(trim($password)) ;
                    //echo $url;die();
                    $result = Model::callABWM($url);
                   //echo $result; die();
                    if (intval($result) == 01)
                    {
                        $_SESSION['error']= "Invalid Password Entered";
                        header('Location:index.php');
                        die();
                    }elseif (intval ($result) == 02) {
                        $_SESSION['error']= "Invalid UserId";
                        header('Location:index.php');
                        die();
                    }elseif ($result == 03) {
                        $_SESSION['error']= "Your Account has been locked";
                        header('Location:index.php');
                        die();
                    }elseif($result == 04)   {
                          $_SESSION['error']= "Sorry Your Account has been Disables";
                        header('Location:index.php');
                        die();
                    }elseif($result == 06)   {
                       $_SESSION['error']= "This User has already login";
                       header('Location:index.php');
                       die();
                    }else{
                        //echo "yeah l got here";die();
                        validateuserdetail($result, $username, $password);
                    }
        
    }  else {
        $_SESSION['error'] = "Please enter username and password";
        header('Location:index.php');die();
    }
}
 function validateLogin($username,$password)
{
     $errorList=array();
     if (empty($username)) {
         $errorList[]='username';
     }
     if (empty($password)) {
         $errorList[]='password';
     }
     return $errorList;
}
function validateAgent($obj)
{
	$errorList=array();
     if (empty($obj->agentName)) {
         $errorList[]='AgentName';
     }
     if (empty($obj->agentPhone)) {
         $errorList[]='PhoneNo';
     }
     return $errorList;
}
function validateFundTrasfer($obj)
{
        
	$errorList=array();
     if (empty($obj->tillBalance)) {
         $errorList[]='emptyAmt';
                
     }
 if (!empty($obj->tillBalance)){
         
      if (is_int($obj->tillBalance)) {
             $errorList[]='invalidnum';
             
         }
   }
         return $errorList;
}


function validateuserdetail($apiresponse, $user, $password)
{
    //var_dump($apiresponse); die();
          if (isset($apiresponse))
          {
                  $_SESSION["authorized"] = true;
                //  session_regenerate_id();
                  $outputarray = explode("|",$apiresponse);
                  $response = $outputarray[0]; 
                  $status = $outputarray[1];
                  $_SESSION['status'] = $outputarray[1];
			//echo $_SESSION['status']; die();
                   $_SESSION['roleid'] = $outputarray[2];
                   $rolename = Model::getRolename($outputarray[2]);
                   //echo " this is role: " . $rolename; die();
                   $scope = $outputarray[3];
                   $_SESSION['scope'] = $outputarray[3];
                   if (count($outputarray) > 3)
                   {
                       $_SESSION['corpid'] = $outputarray[4];
                   }
                   $_SESSION['roles'] = Model::getRolename($outputarray[2]);
                   $_SESSION['perm'] = explode("|", Model::listAllpermission($outputarray[2]));
                   $arrayvalue = explode("|", Model::listAllpermission($outputarray[2]));
                   
                  //var_dump($arrayvalue);die();
                  
                  $statustolower = strtolower($status);
                  //echo $response . "<br>"; echo "roles :". $_SESSION['roles'] ; echo $statustolower; echo intval($response); die();
                  //if(intval($response) == 00) echo "yes";else echo "no";die();
                  if ($response == 00)
                  {
                      if ($outputarray[1] == 'admin')
                      {
                          $_SESSION['adminusername'] = $user;
                          $_SESSION['adminpassword'] = $password;
                        header("Location:superadmin/index.php");
                        die();
                      }  else {
                          $outputresponse = array();
                          foreach($arrayvalue as $val)
                          {
                               $outputresponse[] =  Model::listToplevel($val);
                          }
                          //var_dump($outputresponse);die();
                          $_SESSION['toplevel'] = TopLevelmodule(array_unique($outputresponse));
                          $_SESSION['tpasslevel'] = passwordmodule(array_unique($outputresponse));
                          //var_dump($_SESSION['toplevel']);die();
                         if (isset($_SESSION['toplevel']) && sizeof($_SESSION['toplevel']) > 0)
                         {
                            header("Location:superadmin/index.php");
                            die();
                         }
                      }
                    
                  }else {
                      $_SESSION['error']="Invalid Response";
                      header('Location:index.php');
                  }
              
          }else{
              
              $_SESSION['loginErr']="No response from API";
              header('Location:index.php');
              exit();
          }
}

function sublevelmodule()
{
    $permarray = $_SESSION['perm'];
    
    $sublevel = array(
        'Quick Menu' => array('CreateAgent',
                              'ViewAgent',
                              'CreateCustomer', 
                              'CorporateSetUp',
                              'CreateCorporateAcct',
                              'ManageRequest',
                              'ViewTransaction',
                              'ManageAgent',
                              'ManageCustomer',
                              'ViewAgentTill'),
        'Service Configuration' => array('CreateConfiguration',
                                         'ViewConfiguration'),
        'User Management' => array('CreateRoles',
                                   'CreateUser',
                                   'CreateToplevel',
                                   'ViewRole',
                                   'ViewUser'),
        'System Activities' => array('ActivityLog'),
        'Session Report' => array('Active UserSession'),
        'Custom Report' => array('CustomReport')
    );
    
    foreach ($permarray as $val) {
        
    }
}

function topmenumodule()
{
    if (isset($_SESSION['toplevel']))
    {
        //var_dump($_SESSION['toplevel']);die();
        foreach ($_SESSION['toplevel'] as $value) 
        {
           $pathparts = pathinfo($value);
           $base = basenamevalue($pathparts['filename']);
           echo '<li>' . '<a href=' . $value .'>' . $base .'</a></li>';
        }
    }else{
        echo '<li><a href="../coporate/index.php"> Quick Menu</a></li>';
        echo '<li><a href="../SystemUser/welcome.php"> User Management</a></li>';
        echo '<li><a href="../Systemactivity/activitylog.php"> System Activities</a></li>';
        echo '<li><a href="../sessionreport/activesession.php"> Session Reports</a></li>';
        echo '<li><a href="../customreport/customReport.php"> Custom Reports</a></li>';
        echo '<li><a href="../configurationservice/configuration.php">Service Configuration</a></li>';
    }  
}

function passmodule()
{
    if (isset($_SESSION['tpasslevel']))
    {
        //var_dump($_SESSION['toplevel']);die();
        foreach ($_SESSION['tpasslevel'] as $value) 
        {
           $pathparts = pathinfo($value);
           $base = basenamevalue($pathparts['filename']);
           echo '<li>' . '<a href=' . $value .'>' . $base .'</a></li>';
        }
    }else{
        echo '<li><a href="./coporate/index.php"> Quick Menu</a></li>';
        echo '<li><a href="./SystemUser/welcome.php"> User Management</a></li>';
        echo '<li><a href="./Systemactivity/activitylog.php"> System Activities</a></li>';
        echo '<li><a href="./sessionreport/activesession.php"> Session Reports</a></li>';
        echo '<li><a href="./customreport/customReport.php"> Custom Reports</a></li>';
        echo '<li><a href="./configurationservice/configuration.php">Service Configuration</a></li>';
    }  
}

function quickuserRole()
{   
    $quickrole = '';
    if (isset($_SESSION['adminusername']) && isset($_SESSION['adminpassword'])){
                    echo '<li><a href="CreateAgent.php"> Create Agent</a></li>';
                    echo '<li><a href="ViewAgents.php"> View Agent</a></li>';
                    echo '<li><a href="Request.php">Manage Requests</a></li>';
                    echo '<li><a href="corporateSetup.php">Corporate SetUp</a></li>';
                    echo '<li><a href="corporatepage.php">View Corporate Account</a></li>';
                    echo '<li><a href="viewtransaction.php">View All Transactions</a></li>';
                    echo '<li><a href="viewAgentTill.php">View All Agent Till Balance</a></li>';
                    echo '<li><a href="Customercreation.php">Create Customer</a></li>';
                    return;
     }else{
                      if(isset($_SESSION['perm'])){
                        foreach($_SESSION['perm'] as $valsession){
                        if (strcmp($valsession, 'CreateAgent') == 0){
                            $quickrole = '<li><a href="CreateAgent.php"> Create Agent</a></li>';
                        }elseif (strcmp($valsession, 'ViewAgent') == 0) {
                            $quickrole .= '<li><a href="ViewAgents.php"> View Agent</a></li>';
                        }elseif(strcmp($valsession, 'ManageRequest')==0) {
                            $quickrole .= '<li><a href="Request.php">Manage Requests</a></li>';
                        }elseif(strcmp($valsession, 'CorporateSetUp') == 0){
                            $quickrole .= '<li><a href="corporateSetup.php">Corporate Setup</a></li>';
                        }elseif (strcmp($valsession, 'ViewCorporateAccount') == 0) {
                            $quickrole .= '<li><a href="corporatepage.php">View Corporate Account</a></li>';
                        }elseif(strcmp($valsession, 'ViewTransaction') == 0){
                            $quickrole .= '<li><a href="viewtransaction.php">View All Transactions</a></li>';
                        }elseif (strcmp($valsession, 'ViewAgentTill') == 0) {
                            $quickrole .= '<li><a href="viewAgentTill.php">View All Agent Till Balance</a></li>'; 
                        }elseif (strcmp($valsession, 'CreateCustomer') == 0) {
                            $quickrole .= '<li><a href="Customercreation.php">Create Customer</a></li>'; 
                        }
                       }
                     }
                      }
                      return $quickrole;
}

function UserManagementRole()
{
    $userRole = '';
          if (isset($_SESSION['adminusername']) && isset($_SESSION['adminpassword'])){
                    echo '<li><a href="CreateRoles.php"> Create Role</a></li>';
                    echo '<li><a href="ViewRole.php">View Roles</a></li>';
                    echo '<li><a href="CreateUser.php">Create User</a></li>';
                    echo '<li><a href="ViewUser.php">View Users</a></li>';
                    return;
           }else{
                      if(isset($_SESSION['perm'])){
                        foreach($_SESSION['perm'] as $valsession){
                         if (strcmp($valsession, 'CreateRoles') == 0){
                            $userRole = '<li><a href="CreateRoles.php"> Create Role</a></li>';
                         }elseif (strcmp($valsession, 'ViewRoles') == 0) {
                            $userRole .= '<li><a href="ViewRole.php"> View Roles</a></li>';
                        }elseif(strcmp($valsession, 'UserSetup')==0) {
                            $userRole .= '<li><a href="CreateUser.php">Create User</a></li>';
                        }elseif(strcmp($valsession, 'ViewUser') == 0){
                            $userRole .= '<li><a href="ViewUser.php">View User</a></li>';
                        }
                       }
                     }
             }
             return $userRole;
}

function SystemActivityRole()
{ $activity = '';
     if (isset($_SESSION['adminusername']) && isset($_SESSION['adminpassword'])){
                    echo '<li><a href="activitylog.php">System Activities</a></li>';
                    return;
           }else{
                      if(isset($_SESSION['perm'])){
                        foreach($_SESSION['perm'] as $valsession){
                         if (strcmp($valsession, 'ActivityLog') == 0){
                            $activity = '<li><a href="activitylog.php">System Activities</a></li>';
                         }
                       }
                     }
             }
             return $activity;
}

function SystemSession()
{ $session = '';
    if (isset($_SESSION['adminusername']) && isset($_SESSION['adminpassword'])){
                    echo '<li><a href="activesession.php">Active Session</a></li>';
           }else{
                      if(isset($_SESSION['perm'])){
                        foreach($_SESSION['perm'] as $valsession){
                         if (strcmp($valsession, 'ActiveSession') == 0){
                            $session =  '<li><a href="activesession.php">Active Session</a></li>';
                         }
                       }
                     }
             }
             return $session;         
}

function ServiceConfiguration()
{ $service = '';
    if (isset($_SESSION['adminusername']) && isset($_SESSION['adminpassword'])){
                    echo '<li><a href="configuration.php">Create Configuration</a></li>';
                    echo '<li><a href="#"> View Configuration</a></li>';
                    echo '<li><a href="CreateProvider.php">Create Provider</a></li>';
                    return;
           }else{
                      if(isset($_SESSION['perm'])){
                        foreach($_SESSION['perm'] as $valsession){
                         if (strcmp($valsession, 'CreateConfiguration') == 0){
                            $service =  '<li><a href="configuration.php">Create Configuration</a></li>';
                         }elseif (strcmp($valsession, 'ViewConfiguration') == 0) {
                            $service .= '<li><a href="#"> View Configuration</a></li>';
                        }elseif (strcmp($valsession, 'CreateProvider') == 0) {
                            $service .= '<li><a href="CreateProvider.php"> Create Provider</a></li>';
                        }
                       }
                     }
             }
             return $service;
}

function CustomReport()
{ $rpt = '';
    if (isset($_SESSION['adminusername']) && isset($_SESSION['adminpassword'])){
                    echo '<li><a href="customReport.php">Custom Report</a></li>';
           }else{
                      if(isset($_SESSION['perm'])){
                        foreach($_SESSION['perm'] as $valsession){
                         if (strcmp($valsession, 'CustomReport') == 0){
                            $rpt = '<li><a href="customReport.php">Custom Report</a></li>';
                         }
                       }
                     }
             }
             return $rpt;
}

function TopLevelmodule($tlevel)
{
    //var_dump($tlevel);die();
    $list = array();
    $toplevel = array(
        'QuickMenu' => "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/coporate/index.php",
        'ServiceConfiguration' => "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/configurationservice/configuration.php",
        'UserManagement' => "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/SystemUser/welcome.php",
        'SystemActivities' => "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/Systemactivity/activitylog.php",
        'SessionReport' => "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/sessionreport/activesession.php",
        'CustomReports' => "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/customreport/customReport.php"
    );
    
    foreach ($toplevel as $key => $value) {
        foreach ($tlevel as $val) {
            if(strcasecmp($key, $val) == 0)
            {
                $_SESSION['topname'] = $key;
                $list[] = $value;
            }
        }
    }
    //var_dump($_SESSION['topname']);die();
    //var_dump($list);die();
    return $list;
    
}

function passwordmodule($tlevel)
{
    //var_dump($tlevel);die();
    $list = array();
    $toplevel = array(
        'QuickMenu' => "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/coporate/index.php",
        'ServiceConfiguration' => "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/configurationservice/configuration.php",
        'UserManagement' => "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/SystemUser/welcome.php",
        'SystemActivities' => "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/Systemactivity/activitylog.php",
        'SessionReport' => "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/sessionreport/activesession.php",
        'CustomReports' => "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/customreport/customReport.php"
    );
    
    foreach ($toplevel as $key => $value) {
        foreach ($tlevel as $val) {
            if(strcasecmp($key, $val) == 0)
            {
                $_SESSION['topname'] = $key;
                $list[] = $value;
            }
        }
    }
    //var_dump($_SESSION['topname']);die();
    //var_dump($list);die();
    return $list;
}

function basenamevalue($baseval)
{
    $returnval = '';
    if (strcasecmp($baseval,"configuration") == 0){
        $returnval =  "Configuration Service";
    }elseif (strcasecmp($baseval, "activitylog") == 0) {
        $returnval =  "System Activities";
    }elseif (strcasecmp($baseval, "activesession") == 0) {
        $returnval =  "Session Report";
    }elseif(strcasecmp($baseval, "welcome") == 0)
    {
        $returnval = "User Management";
    }elseif(strcasecmp($baseval, "index") == 0)
    {
        $returnval = "Quick Menu";
    }elseif (strcasecmp($baseval, "activesession") == 0) {
        $returnval = "Session Report";
    }elseif(strcasecmp($baseval, "customReport") == 0){
        $returnval = "Custom Reports";
    }
    
    return $returnval;
}


  //header("location:coporate/CreateAgent.php");     
function populateAgent($start, $limit) 
{
    $result = Model::getAllAgent($start, $limit);
    return $result;
}

function search($start,$limit)
{    
    $phone = '';$name='';$type ='';
    
        if (isset($_POST['agentphone']) || isset($_POST['agentname']) || isset($_POST['agentType']))
        {
            $phone = mysql_real_escape_string(stripcslashes($_POST['agentphone']));
            $name =  mysql_real_escape_string(stripcslashes($_POST['agentname']));
            $type = mysql_real_escape_string(stripcslashes($_POST['agentType']));
        } 
    
        $result = Model::searchagentByAllAgent($start,$limit,$phone,$name,$type); 
    return $result;
}

function searchCustomer($start, $limit)
{
     $phone = '';$name='';$type ='';
    
        if (isset($_POST['phone']) || isset($_POST['customername']) || isset($_POST['accountType']))
        {
            $phone = mysql_real_escape_string(stripcslashes($_POST['phone']));
            $name =  mysql_real_escape_string(stripcslashes($_POST['customername']));
            $type = mysql_real_escape_string(stripcslashes($_POST['accountType']));
        } 
    
        $result = Model::searchCustomer($start,$limit,$phone,$name,$type); 
    return $result;
}


function populateAgentdetail($agentval)
{
    $result = Model::listagentdetail($agentval);
    return $result;
}

function populateManageRequest($start,$limit)
{
    $result = Model::listAllRequest($start,$limit);
    return $result;
}

function populateAllUser($start,$limit)
{
     $result = Model::listAllUser($start, $limit);
    return $result;
}

function populateRequestUser($id)
{
    $result = Model::listUserID($id);
    return $result;
}

function populateAllRoles()
{
    $result = Model::listAllRoles();
    return$result;
}

function populateRequestDetail($idval)
{
    $result = Model::listRequestID($idval);
    return $result;
}

function populateCustomerDetail($idval)
{
    $result = Model::listCustomerID($idval);
    return $result;
}


function getAgentFund($Id)
{
    $agentbalance = Model::getUserbalance($Id);
    return $agentbalance;
}

function getAgentCashFlow($start,$limit,$Idval)
{
    $recon='';$from='';$to='';
         if (isset($_POST['reconType']) || 
                  isset($_POST['flowtype']) ||
               isset($_POST['fromdate']) || isset($_POST['todate']))
          {
            $recon = $_POST['reconType'];
            $from = $_POST['fromdate'];
            $to = $_POST['todate'];
          }
    $agentcashflow = Model::getAgentCashFlow($start,$limit,$Idval,$recon, $from,$to);
    return $agentcashflow;
}

function approveRequest()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    if (isset($_SESSION['username'])){
        $loginuser = $_SESSION['username'];
    }
    if (isset($_POST['Approve']))
    {
	//echo $_POST['Approve']; die();
         $hiddenagent = $_POST['hiddenagent'];
         $ob = populateRequestDetail($hiddenagent);
        $action = $_POST['Approve'];
        $comment = mysql_real_escape_string(stripcslashes($_POST['comment']));
        foreach($ob as $userid){
            $amount = $userid->amount;
            $phone = $userid->phone;
            $requestType = $userid->requestType;
        }
        $url = $url . "ManageApproval?status=" . urlencode($action) . "&amount=" . urlencode($amount)
               . "&phone=" . urlencode($phone) . "&reason=" . urlencode($comment)
                . "&approver=" . $loginuser . "&Id=" . $hiddenagent . "&requestType=" . urlencode($requestType);
        //echo $url; die();
        $result = Model::callABWM($url);
        //echo $result; die();
        if ($result == 03){
           header("Location:coporate/manageRequestResponse.php?wmerr=$action&requestId=$hiddenagent");
           die();
       }elseif($result == 00) {
           header("Location:coporate/manageRequestResponse.php?wmapprove=$action&requestId=$hiddenagent");
           die();
       }  else {
           header("Location:coporate/masuccesstextsuccesstextnageRequestResponse.php?wmapprove=$action&requestId=$hiddenagent");
           die();
       }
    }else if(isset($_POST['Decline']))
    {
         $hiddenagent = $_POST['hiddenagent'];
         $ob = populateRequestDetail($hiddenagent);
        $action = $_POST['Decline'];
        $comment = mysql_real_escape_string(stripcslashes($_POST['comment']));
        foreach($ob as $userid){
            $amount = $userid->amount;
            $phone = $userid->phone;
            $requestType = $userid->requestType;
        }
        $url = $url . "ManageApproval?status=" . urlencode($action) . "&amount=" . urlencode($amount)
               . "&phone=" . urlencode($phone) . "&reason=" . urlencode($comment)
                . "&approver=" . $loginuser . "&Id=" .$hiddenagent . "&requestType=" . urlencode($requestType);
        //echo $url;die();
        $result = Model::callABWM($url);
        //echo $result; die();
            if ($result == 00){
                header("Location:coporate/manageRequestResponse.php?wmdecline=$action&requestId=$hiddenagent");
                die();
            }else{
                $_SESSION['errorResponse'] = "error Response";
                header("Location:coporate/manageRequestResponse.php?requestId=$hiddenagent");
                die();   
            }
                
    }
}
approveRequest();

function acceptlink()
{
   $modobj =  new Model();
    $url = $modobj->urlval;
    if (isset($_SESSION['username'])){
        $loginuser = $_SESSION['username'];
    }
    if (isset($_POST['rolelink']))
    {
        $linkname = mysql_real_escape_string(stripcslashes($_POST['linkname']));
        $rolename = mysql_real_escape_string(stripcslashes($_POST['rolename']));
        if (empty($linkname) && empty($rolename))
        {
            header("Location:SystemUser/CreateToplevel.php?wmerror");
            die();
        }
        $url = $url . "TopLinkLevel?linkName=" . urlencode($linkname) . "&roleName="
                . urlencode($rolename) . "&loginUser=" . urlencode($loginuser);
        //echo $url;die();
        $result = Model::callABWM($url);
         //echo $result;die();
            if ($result == 00){
                header("Location:SystemUser/CreateToplevel.php?wmlink=$linkname");
                die();
            }
    }
}

acceptlink();

function populateTransactions()
{
    $result = Model::getAllTransaction();
    return $result;
}

function searchTransaction($startpoint,$limit)
{
   $cust = '';$trans = '';$type ='';$agent ='';
   $start ='';$end = '';
          if (isset($_POST['customer']) || 
                  isset($_POST['transactionID']) ||
               isset($_POST['transactionType']) || isset($_POST['agentID']))
          {
            $cust = $_POST['customer'];
            $trans = $_POST['transactionID'];
            $type = $_POST['transactionType'];
            $agent = $_POST['agentID'];
            $start = $_POST['startDate'];
            $end = $_POST['endDate'];
          }

          $result = Model::searchTransactionbyCustomer($startpoint,$limit,$cust,$trans,$type,$agent,$start, $end); 
    return $result;
}

function getTransType()
{
    $result = Model::gettransactionType();
    //var_dump($result); die();
    return $result;
    
}

function getAgentRecordBalance($agentid)
{
    $result = Model::getAgentRecordBalance($agentid);
    return $result;
}

function populateAgentTransaction($start,$limit,$phonenumber)
{
    $cust = '';$transtype ='';$from='';$to='';$status = '';
    
    if (isset($_POST['customer']) || 
                  isset($_POST['transactiontype']) ||
               isset($_POST['fromdate']) || isset($_POST['todate']) || isset($_POST['status']))
          {
            $cust = $_POST['customer'];
            $transtype = $_POST['transactiontype'];
            $status = $_POST['status'];
            $from = $_POST['fromdate'];
            $to = $_POST['todate'];
          }
    $result = Model::getAgentTransaction($start,$limit,$phonenumber,$cust,$transtype,$status,$from,$to);
    return $result;
}

function populateAllAgentTill()
{
    $result = Model::getAllAgentTill();
    return $result;
}

function searchActivesession($start, $limit)
{
    $username='';$role = '';$logindate='';
        if (isset($_POST['username']) || isset($_POST['rolename']) ||
            isset($_POST['logindate']))
        {
            $username = mysql_real_escape_string(stripcslashes($_POST['username']));
            $role = mysql_real_escape_string(stripslashes($_POST['rolename']));
            $logindate = mysql_real_escape_string(stripslashes($_POST['logindate']));
        } 
    
        $result = Model::getAllActiveSession($start,$limit,$username, $role, $logindate); 
    return $result;
}
function TerminateSession($id)
{
    $result = Model::TerminateSession($id);
    return $result;
}
function populateAllActivity()
{
    $result = Model::getAllActivity();
    return $result;
}

function searchActivity($start, $limit)
{
        $username = '';$status='';$phone='';
        if (isset($_POST['username']) || isset($_POST['status']) || isset($_POST['phone']))
        {
            $username = $_POST['username'];
            $status = $_POST['status'];
            $phone = $_POST['phone'];
        } 
    
        $result = Model::SearchActivity($start,$limit,$username,$status,$phone);
    return $result;
}
function populateCorporate()
{
    $result = Model::getAllCorporateAcct();
    return $result;
}

function populateparameter($servicevalue)
{
    $result = Model::listparambyservicename($servicevalue);
    return $result;
}



function changePassword()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    if (isset($_SESSION['username'])){
        $loginuser = $_SESSION['username'];
    }
    
    if (isset($_POST['changepassword']))
    {
        $oldpassword = $_POST['oldpassword'];
        //echo $oldpassword; die();
        $currentpassword = $_POST['newpassword'];
        $confirmpassword = $_POST['confirmpassword'];
        $url = $url . "changePassword?currentPassword=" . urlencode($oldpassword) .
            "&newPassword=" . urlencode($currentpassword) . "&loginUser=" . urlencode($loginuser);
        //echo $url; die();
        $result = Model::callABWM($url);
        //echo $result; die();
        if ($result == 00){
            header("Location:changepassword.php?wmchange&success=".$result);
            die();
       }
        else {
             header("Location:changepassword.php?wmerror&fail=" . "Invalid Response");
            die();
       }
    }
}

changePassword();

//$query, $per_page = 10,$page = 1, $url='index.php?'
function pagination($query, $per_page = 100,$page = 1, $url = '')
{
        $conn = mysql_connect("localhost","THandler", "cellulant123");
        //$conn = mysql_connect('192.168.0.111:3306', "moses", "password");
        mysql_select_db("agencybanking", $conn);
    	$result = mysql_query($query, $conn);
        //echo $query; die();
        //echo mysql_num_rows($result); die();
        if (mysql_num_rows($result) >= 0)
        {
            $total = mysql_num_rows($result);
        }
    	//echo $total; die();
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
        //echo $lastpage; die();
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage >= 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                    $pagination .= "<li class='details'>Page $page of $lastpage</li>";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='current'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}?page=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}?page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a href='{$url}?page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}?page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}?page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}?page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}?page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a href='{$url}?page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}?page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}?page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}?page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}?page=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}?page=$next'>Next</a></li>";
                $pagination.= "<li><a href='{$url}?page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
    
      //echo $pagination; die();
        return $pagination;
}

function reconcilenow()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    $agent ='';$amount ='';
    if (isset($_POST['reconcile']))
    {
        if (isset($_POST['agentid']) && isset($_POST['sumamount']) && isset($_POST['balance']))
        {
            $agent = $_POST['agentid'];
            $amount = $_POST['sumamount'];
            $balance = $_POST['balance'];
            if ((intval($amount) == 0) && (intval($balance) == 0))
            {
                header("Location:reconcileagent.php?wmnorecord&agent=".$agent);
               die(); 
            }else{
                $url = $url . "ReconcileAccount?agentId=" . urlencode($agent) .
                    "&cash=" . urlencode($amount);
                //echo $url; die();
                $result = Model::callABWM($url);
                //echo $result; die();
            }
        }
        if (intval($result) == 00){
            header("Location:reconcileagent.php?wmreconcile&success=".$agent);
            die();
        }else if(intval($result) == 01){
            header("Location:reconcileagent.php?wmerror&Incomplete=".$agent);
            die();
        }else if(empty ($result) || is_null($result) || $result == " "){
            header("Location:reconcileagent.php?wmresponderror");
            die();
        }
    }
}

reconcilenow();

function systemconfiguration()
{
    $modobj =  new Model();
    $url = $modobj->urlval;
    $thirdpartyname  ='';$urlname ='';
    $servicename = '';$parametername = '';
    $parameterval = '';
    if (isset($_POST['createconfiguration']))
    {
        if (isset($_POST['thirdpartyname']) && isset($_POST['url'])
            || isset($_POST['servicename']) || isset($_POST['parameterval'])
            || isset($_POST['parametername']))
        {
            $thirdpartyname = $_POST['thirdpartyname'];
            $urlname = $_POST['url'];
            $servicename = $_POST['servicename'];
            $parametername = $_POST['parametername'];
            $parameterval = $_POST['parameterval'];
        }
        $url = $url . "ConfigureService?thirdPartyName=" . urlencode($thirdpartyname) .
            "&url=" . urlencode($urlname) . "&Name=" . urlencode($parametername) . "&Value=" . urlencode($parameterval) .
             "&loginUser=" . urlencode($_SESSION['username']) . "&serviceName=" . urlencode($servicename);
        //echo $url; die();
        $result = Model::callABWM($url);
        //echo $result; die();
        if ($result == 00){
            header("Location:./configurationservice/configuration.php?wmconfigure&success=");
            die();
        }else if($result == 01){
            header("Location:./configurationservice/configuration.php?wmerror&Incomplete=");
            die();
        }else if(empty ($result) || is_null($result) || $result == " "){
            header("Location:./configurationservice/configuration.php?wmresponderror");
            die();
        }  else {
            $_SESSION['connecterror'] = "connection error";
            header("Location:./configurationservice/configuration.php");
            die();
        }
    }
}

systemconfiguration();

function updateCustomer()
{
   $firstname = '' ;$lastname = '';$acctType = '';
   $phone = '';$email =''; $IdType =''; $IdNumber =''; $address = '';
    if (isset($_POST['update']))
    {
        if (isset($_POST['firstname']) && !empty($_POST['firstname']))
        {
            $firstname = mysql_real_escape_string(stripcslashes($_POST['firstname']));
        }
        
        if (isset($_POST['lastname']) && !empty($_POST['lastname']))
        {
            $lastname = mysql_real_escape_string(stripcslashes($_POST['lastname']));
        }
        
        if (isset($_POST['acctType']) && !empty($_POST['acctType']))
        {
            $acctType = mysql_real_escape_string(stripcslashes($_POST['acctType']));
        }
        
        if (isset($_POST['phone']) && !empty($_POST['phone']))
        {
            $phone = mysql_real_escape_string(stripcslashes($_POST['phone']));
        }  
        
        if (isset($_POST['email']) && !empty($_POST['email']))
        {
            $email = mysql_real_escape_string(stripcslashes($_POST['email']));
        }
        
        if (isset($_POST['IdType']) && !empty($_POST['IdType']))
        {
            $IdType = mysql_real_escape_string(stripcslashes($_POST['IdType']));
        }
        
        if (isset($_POST['IdNumber']) && !empty($_POST['IdNumber']))
        {
            $IdNumber = mysql_real_escape_string(stripcslashes($_POST['IdNumber']));
        }
        
        if (isset($_POST['address']) && !empty($_POST['address']))
        {
            $address = mysql_real_escape_string(stripcslashes($_POST['address']));
        }
        
        $id = $_POST['hiddenid'];
        $ag = new Customer();
        $ag->IdNumber = $IdNumber;
        $ag->IdType = $IdType;
        $ag->address = $address;
        $ag->custEmail = $email;
        $ag->custPhone = $phone;
        $ag->firstName = $firstname;
        $ag->lastName = $lastname;
        $ag->dateCreated = date('Y-m-d');
        $ag->acctType = $acctType;
        $ag->Id = $id;
        $output = Model::updateCustomer($ag);
        
        if (isset($output))
        {
            header("Location:coporate/updateCustomer.php?wmupdate&customerID=$id");
            die();
        }  else {
            header("Location:coporate/updateCustomer.php?wmdecline&customerID=$id");
            die();
        }
        
    }
}
updateCustomer();

function updateAllCustomer()
{
   $firstname = '' ;$lastname = '';$acctType = '';
   $phone = '';$email =''; $IdType =''; $IdNumber =''; $address = '';
    if (isset($_POST['updateme']))
    {
        if (isset($_POST['firstname']) && !empty($_POST['firstname']))
        {
            $firstname = mysql_real_escape_string(stripcslashes($_POST['firstname']));
        }
        
        if (isset($_POST['lastname']) && !empty($_POST['lastname']))
        {
            $lastname = mysql_real_escape_string(stripcslashes($_POST['lastname']));
        }
        
        if (isset($_POST['acctType']) && !empty($_POST['acctType']))
        {
            $acctType = mysql_real_escape_string(stripcslashes($_POST['acctType']));
        }
        
        if (isset($_POST['phone']) && !empty($_POST['phone']))
        {
            $phone = mysql_real_escape_string(stripcslashes($_POST['phone']));
        }  
        
        if (isset($_POST['email']) && !empty($_POST['email']))
        {
            $email = mysql_real_escape_string(stripcslashes($_POST['email']));
        }
        
        if (isset($_POST['IdType']) && !empty($_POST['IdType']))
        {
            $IdType = mysql_real_escape_string(stripcslashes($_POST['IdType']));
        }
        
        if (isset($_POST['IdNumber']) && !empty($_POST['IdNumber']))
        {
            $IdNumber = mysql_real_escape_string(stripcslashes($_POST['IdNumber']));
        }
        
        if (isset($_POST['address']) && !empty($_POST['address']))
        {
            $address = mysql_real_escape_string(stripcslashes($_POST['address']));
        }
        
        $id = $_POST['hiddenid'];
        $ag = new Customer();
        $ag->IdNumber = $IdNumber;
        $ag->IdType = $IdType;
        $ag->address = $address;
        $ag->custEmail = $email;
        $ag->custPhone = $phone;
        $ag->firstName = $firstname;
        $ag->lastName = $lastname;
        $ag->dateCreated = date('Y-m-d');
        $ag->acctType = $acctType;
        $ag->Id = $id;
        $output = Model::updateAllCustomer($ag);
        
        if (isset($output))
        {
            header("Location:coporate/generalUpdating.php?wmupdate&customerID=$id");
            die();
        }  else {
            header("Location:coporate/generalUpdating.php?wmdecline&customerID=$id");
            die();
        }
        
    }
}
updateAllCustomer();
function logout()
{
    if (isset($_SESSION['logout']))
    {
        $rs = Model::callABWM(trim($_SESSION['logout']));
        if (isset($rs))
        {
            unset($_SESSION['logout']);
        }
    }
}

function logmeout()
{
    if (isset($_SESSION['username']))
    {
        $sessionuser = $_SESSION['username'];
    }
    $mod = new Model();
    //$logoutpath = "http://192.168.0.107:8080/AgencyBankingMWare/";
    $logoutpath = $mod->urlval;
    $logoutpath = $logoutpath . "LogoutSession?loginuser=" . $sessionuser;
    $_SESSION['logout'] = $logoutpath;
}

function sessiontimeout()
{
    session_cache_expire(10);//session time out in ten minutes
    // set time-out period (in seconds)
    $inactive = 600;//ten minutes
    $_SESSION["timeout"] = time();
    // check to see if $_SESSION["timeout"] is set
    if (isset($_SESSION["timeout"])) {
    // calculate the session's "time to live"
    $sessionTTL = time() - $_SESSION["timeout"];
    if ($sessionTTL > $inactive) {
	header("Location:index.php");
        logmeout();
	//session_destroy();
    }
  }
}


function userinfo()
{
	echo '<ul>';
        echo '<li>username:';
        if (isset($_SESSION['status'])){
           echo $_SESSION['status'] . '</li> |';
        }else{
           echo 'Admin' . '</li> |' ;
        }
        echo '<li>'; 
        if (isset($_SESSION['roles'])){
             echo $_SESSION['roles'] . '</li> |';
        }else{
             echo "Administrator" . '</li> |';
         }
         echo '<li class="logout"><a href=../index.php> Log out</a></li>';
        echo '</ul>';
}

function openlogin()
{
    echo '
        <form>    
                  <fieldset>
                      <legend>Please select the form Type</legend>
                   <table class="agentform" style="width: 100%;">
                       <tr><td><input type="radio" name="cellulantlogin" value="1"/>Cellulant Admin</td>
                       <td><input type="radio" name="cellulantlogin" value="0"/>Corporate</td></tr>              
                   </table>
                  </fieldset>
              </form>';
}

function corporate()
{
    echo '<div id="corporate">
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
               <td id="value"><textarea style="color:white;" name="address" placeholder =" Please enter your your address" rows="6" cols="26"></textarea></td>
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
                   <option value="default">Default</option> ';
                for($i = 0 ;  $i < sizeof($splitmethod['rolename']); $i++)
                {
                  echo '<option value=$splitmethod[rolename][$i]>$splitmethod[rolename][$i]</option>';
                }

           echo '</select>
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
         </div> ';
}

function cellulant()
{
        echo '<div id="cellulant">
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
               <td id="value"><textarea style="color:white;" name="address" placeholder =" Please enter your your address" rows="6" cols="26"></textarea></td>
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
                   <option value="default">Default</option> ';
                for($i = 0 ;  $i < sizeof($splitmethod['rolename']); $i++)
                {
                 echo '<option value="$splitmethod[rolename][$i]>$splitmethod[rolename][$i]</option>';
                }
               echo '</select>
               </td>
               </tr>
               <tr>
               <td id="key">UserType</td>
               <td id="value">
               <select name="usertype" data-bvalidator="required" data-bvalidator-msg="Select usertype from drop-down menu.">
                   <option value="">--select the Usertype--</option>';
                    for($i = 0;$i < sizeof($splituser['usertype']); $i++)
                    {
                     echo ' <option value="$splituser[usertype][$i]"> $splituser[usertype][$i]</option>';   
                    }
                    
              echo '</select>
               </td>
               </tr>
               <tr>
               <td id="key">CorporateList</td>
               <td id="value">
               <select name="corptype" data-bvalidator="required" data-bvalidator-msg="Select usertype from drop-down menu.">
                   <option value="">--select the CorporateList--</option>';
                    foreach($allcorp as $value)
                    {
                        echo "<option>$value</option>";
                    }
               echo '</select>
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
         </div>';
}

function getAllCorporate()
{
    $result = Model::viewallcorporatelist();
    return $result;
}

function getCorporate($id)
{
    $result = Model::viewcorporatebyID($id);
    return $result;
}

function createprovider()
{
    
}

?>
