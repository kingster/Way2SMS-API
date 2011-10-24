Way2SMS PHP API
=============

Send SMS Via Way2SMS from PHP.  

Tested Working with Way2SMS UI Version 4. Supports upto 160 Characters


How to
-------
```php
<?php
    include('way2sms-api.php');
    sendsmsToMany ( '9000012345' , 'password' , '987654321' , 'Hello World');   
    sendsmsToMany ( '9000012345' , 'password' , '987654321;9876501234' , 'Hello World');   
?>
```


Note
-------
Please use this code on your own risk. The author is no way responsible for the outcome arising out of this.