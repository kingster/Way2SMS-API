<?php 

/**
 * sendSMStoMany
 * Function to send to sms to multiple people via way2sms
 * @author Kingster
 * @category SMS
 * @example sendsmsToMany ( '9000012345' , 'password' , '987654321' , 'Hello World')
 * Please use this code on your own risk. The author is no way responsible for the outcome arising out of this
 * Good Luck!
 **/

function sendSMSToMany($uid, $pwd, $phone, $msg)
{
  $curl = curl_init();
  $timeout = 30;
  $ret = "";

  $uid = urlencode($uid);
  $pwd = urlencode($pwd);

  curl_setopt($curl, CURLOPT_URL, "http://site6.way2sms.com/Login1.action");
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, "username=".$uid."&password=".$pwd."&button=Login");
  //curl_setopt($curl , CURLOPT_PROXY , '10.3.100.211:8080' );
  curl_setopt($curl, CURLOPT_COOKIESESSION, 1);
  curl_setopt($curl, CURLOPT_COOKIEFILE, "cookie_way2sms");
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($curl, CURLOPT_MAXREDIRS, 20);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5");
  curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
  curl_setopt($curl, CURLOPT_REFERER, "http://site6.way2sms.com/");
  $text = curl_exec($curl);


  // Check for proper login
  $pos = stripos(curl_getinfo($curl, CURLINFO_EFFECTIVE_URL), "Main.action");
  if ($pos === "FALSE" || $pos == 0 || $pos == "")
    return "invalid login";

  if (trim($msg) == "" || strlen($msg) == 0)
    return "invalid message";
  $msg = urlencode(substr($msg,0,160));
  $pharr = explode(";", $phone);
  $refurl = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
  curl_setopt($curl, CURLOPT_REFERER, $refurl);
  curl_setopt($curl, CURLOPT_URL, "http://site6.way2sms.com/jsp/InstantSMS.jsp");
  $text = curl_exec($curl);


  preg_match_all('/<input[\s]*type="hidden"[\s]*name="Action"[\s]*id="Action"[\s]*value="?([^>]*)?"/si', $text, $match);
  $action = $match[1][0]; // get custid from the form fro the Action field in the post form


  foreach ($pharr as $p)
  {
    if (strlen($p) != 10 || !is_numeric($p) || strpos($p, ".") != false)
    {
      $ret .= "invalid number;".$p."\n";
      continue;
    }

    $p = urlencode($p);

    // Send SMS
    curl_setopt($curl, CURLOPT_URL, 'http://site6.way2sms.com/quicksms.action');
    curl_setopt($curl, CURLOPT_REFERER, curl_getinfo($curl, CURLINFO_EFFECTIVE_URL));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS,
      "HiddenAction=instantsms&bulidgpwd=*******&bulidguid=username&catnamedis=Birthday&chkall=on&gpwd1=*******&guid1=username&ypwd1=*******&yuid1=username&Action=".
      $action."&MobNo=".$p."&textArea=".$msg);
    $contents = curl_exec($curl);

  }
  //echo $text;
  
  // Logout :P
  curl_setopt($curl, CURLOPT_URL, "http://site6.way2sms.com/LogOut");
  curl_setopt($curl, CURLOPT_REFERER, $refurl);
  curl_exec($curl);

  curl_close($curl);
  

  //preg_match_all('/<span class="style1">?([^>]*)?<\/span>/si', $contents, $match);
  //$out=str_replace("&nbsp;","",$match[1][0]);
  if ($text == 'ok')
    return true;
  else
    return false;

}
?>
 
