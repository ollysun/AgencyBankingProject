/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function composeEntities(selectBoxId){
    //alert('event fired');
    
    
   var selectId = document.getElementById(selectBoxId); 
   
    var id = selectId.value;
    //alert(id);
    
    var url = "../configurationservice/custom.php?param="+escape(id); // The server-side script 
    //alert(url);
    //alert(url);die();
//    var urlval = "../configurationservice/configuration.php?param="+escape(id) + '"';
    var xmlhttp;
    
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 )
        {
            if (xmlhttp.status==200){
		//alert(xmlhttp.responseText);die();
            var $result = xmlhttp.responseText;
         document.getElementById('paramval').innerHTML=$result;
         document.getElementById('paramval').disabled=false;
            }
        }
    } 
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

function requestCustomerInfo() {      
            var sId = document.getElementById("txtCustomerId").value; 
            http.open("GET", url + escape(sId), true); 
            http.onreadystatechange = handleHttpResponse; 
            http.send(null); 
} 

