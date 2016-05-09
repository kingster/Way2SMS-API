Way2SMS PHP API
=============

Send SMS Via Way2SMS from PHP.  

<del>Tested Working with Way2SMS UI Version 4. Supports upto 140 Characters</del><br />
<del>Way2SMS has added a Captcha Verification. Will update when I can find a workaround</del><br />
UPDATE: Fully functional again :)  



How to Use
-------

##### Simple Usage

```php
<?php
    include('way2sms-api.php');
    sendWay2SMS ( '9000012345' , 'password' , '987654321' , 'Hello World');   
    sendWay2SMS ( '9000012345' , 'password' , '987654321,9876501234' , 'Hello World');   
?>
```

##### Multiple Messages with different content
```php
<?php 
    include('way2sms-api.php');
    $client = new WAY2SMSClient();
    $client->login('username', 'password');
    $client->send('987654321', 'msg1');
    //Add sleep between requests to make this requests more human like! 
    //A blast of request's may mark the ip as spammer and blocking further requests.
    sleep(1);
    $client->send('987654321,9876501234', 'msg2');
    sleep(1);
    $client->logout();
?>
```




HTTP API
------------

Send SMS just making GET or POST Requests.

Incase u want to use the service from your application then the parameters for ur application would be

```
http://www.yourdomain.com/sendsms.php?uid=LOGIN_ID&pwd=PASSWORD&phone=XXXXXXXXX,YYYYYYYYY&msg=Hello+World

Parameters
uid = LOGIN_ID ( Your Login ID [either nickname or 10 Digit mobile no] )
pwd = PASSWORD ( Your Login Password )
phone = 10 Digit Mobile number. Incase of multiple numbers then numbers separated by comma (,)
msg = Your Message.
```


Note
-------
Please use this code on your own risk. The author is no way responsible for the outcome arising out of this.
