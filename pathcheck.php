<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function pathcheck()
{
    //return realpath(dirname(__FILE__));
     $server = $_SERVER['SCRIPT_FILENAME']; 
    return $server;
}
?>
