<?php 

/**
 * sendWay2SMS
 * Function to send to sms to single/multiple people via way2sms
 * @author Kingster
 * @author SuyashBansal
 * @category SMS
 * @example sendWay2SMS ( '9000012345' , 'password' , '987654321,9876501234' , 'Hello World')
 * @return String/Array
 * Please use this code on your own risk. The author is no way responsible for the outcome arising out of this
 * Good Luck!
 **/

function sendWay2SMS($uid, $pwd, $phone, $msg)
{
  $curl = curl_init();
  $timeout = 30;
  $result = array();

  $uid = urlencode($uid);
  $pwd = urlencode($pwd);

  // Go where the server takes you :P
  curl_setopt($curl, CURLOPT_URL, "http://way2sms.com");
  curl_setopt($curl, CURLOPT_HEADER, true);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  $a = curl_exec($curl);
  if(preg_match('#Location: (.*)#', $a, $r))
    $way2sms = trim($r[1]);

  // Setup for login
  curl_setopt($curl, CURLOPT_URL, $way2sms."Login1.action");
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, "username=".$uid."&password=".$pwd."&button=Login");
  curl_setopt($curl, CURLOPT_COOKIESESSION, 1);
  curl_setopt($curl, CURLOPT_COOKIEFILE, "cookie_way2sms");
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($curl, CURLOPT_MAXREDIRS, 20);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5");
  curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
  curl_setopt($curl, CURLOPT_REFERER, $way2sms);
  $text = curl_exec($curl);

  // Check if any error occured
  if (curl_errno($curl))
    return "access error : ". curl_error($curl);

  // Check for proper login
  $pos = stripos(curl_getinfo($curl, CURLINFO_EFFECTIVE_URL), "ebrdg.action");
  if ($pos === "FALSE" || $pos == 0 || $pos == "")
    return "invalid login";

  // Check the message
  if (trim($msg) == "" || strlen($msg) == 0)
    return "invalid message";

  // Take only the first 140 characters of the message
  $msg = urlencode(substr($msg, 0, 140));
  // Store the numbers from the string to an array
  $pharr = explode(",", $phone);

  // Set the home page from where we can send message
  $refurl = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
  $newurl = str_replace("ebrdg.action?id=", "main.action?section=s&Token=", $refurl);
  curl_setopt($curl, CURLOPT_URL, $newurl);

  // Extract the token from the URL
  $jstoken = substr($newurl, 50, -41);
  //Go to the homepage
  $text = curl_exec($curl);

  // Send SMS to each number
  foreach ($pharr as $p)
  {
    // Check the mobile number
    if (strlen($p) != 10 || !is_numeric($p) || strpos($p, ".") != false)
    {
      $result[] = array('phone' => $p, 'msg' => urldecode($msg), 'result' => "invalid number");
      continue;
    }
    $p = urlencode($p);

    // Setup to send SMS
    curl_setopt($curl, CURLOPT_URL, $way2sms.'smstoss.action');
    curl_setopt($curl, CURLOPT_REFERER, curl_getinfo($curl, CURLINFO_EFFECTIVE_URL));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "ssaction=ss&Token=".$jstoken."&mobile=".$p."&message=".$msg."&button=Login");
    $contents = curl_exec($curl);

    //Check Message Status
    $pos = strpos($contents, 'Message has been submitted successfully');
    $res = ($pos !== false) ? true : false;
    $result[] = array('phone' => $p, 'msg' => urldecode($msg), 'result' => $res);
  }

  // Logout
  curl_setopt($curl, CURLOPT_URL, $way2sms."LogOut");
  curl_setopt($curl, CURLOPT_REFERER, $refurl);
  $text = curl_exec($curl);

  curl_close($curl);
  return $result;
}

