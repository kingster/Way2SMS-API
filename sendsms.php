<?php 

/**
 * @author Kingster
 * @category SMS
 * @copyright 2011
 * @description Request this page with get or post params
 * @param uid = Way2SMS Username
 * @param pwd = Way2SMS Password
 * @param phone = Number to send to. Multiple Numbers separated by comma (,). 
 * @param msg = Your Message ( Upto 160 Chars)
 */

include ('way2sms-api.php');

if (isset($_GET['uid']) && isset($_GET['pwd']) && isset($_GET['phone']) && isset($_GET['msg']))
{
  $res =   sendWay2SMS($_GET['uid'], $_GET['pwd'], $_GET['phone'], $_GET['msg']);
  if(is_array($res)) echo $res[0]['result'] ? 'true' : 'false';
  else echo $res;
  exit;
}
else
  if (isset($_POST['uid']) && isset($_POST['pwd']) && isset($_POST['phone']) && isset($_POST['msg']))
  {
    $smsg = stripslashes($_POST['msg']);
    $res =  sendWay2SMS($_POST['uid'], $_POST['pwd'], $_POST['phone'], $smsg);
    if(is_array($res)) echo $res[0]['result'] ? 'true' : 'false';
    else echo $res;
    exit;
  }

?>