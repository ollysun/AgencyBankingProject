<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include '../Model.php';
function splitKeyword($str) {
    $xml_object = simplexml_load_string($str);
    $xml_array = object2array($xml_object);
    return $xml_array;
}

function object2array($object) {
    return @json_decode(@json_encode($object), 1);
}

if (isset($_REQUEST['param'])) {
    $serviceval = $_REQUEST['param'];
}
$mod = new Model();
//$urlval = "http://192.168.0.111:8080/AgencyBankingMWare/";
$urlval = $mod->urlval;
$urlval = $urlval . "LoadParamValue?serviceName=" . $serviceval;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $urlval);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
//echo $result; die();
curl_close($ch);
$valarray = splitKeyword($result);
//var_dump($valarray);die();
for ($i = 0; $i < sizeof($valarray['paramValue']); $i++) {

//   echo '<option value=$valarray["paramValue"][$i]>$valarray["paramValue"]</option>';
    echo "<option value='". $valarray['paramValue'][$i]."'>".$valarray['paramValue'][$i]."</option>";

}





?>
