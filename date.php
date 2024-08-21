<?php
date_default_timezone_set('Africa/lagos');
echo date('l') . "<br/>"; //returns the day of the week
echo date('j'); // returns the day of the month (1-31)
echo date('S'). "<br/>"; // returns the prefix behind the date (1st 2nd 3rd)
echo date('jS \of'). "<br/>"; // returns the day of the month (1-31)
echo date('F'). "<br/>"; // returns the month of the year (1-31)
echo date('Y'). "<br/>"; // returns the year (2024)
echo date('A'). "<br/>"; // returns AM or PM
echo date('h:i:s'). "<br/>"; // returns the hour, minutes and seconds (hr:min:sec)
print_r(getdate()). "<br/>";
echo date("h:i A") . "<br/>";



$str = 'This is just a random text';
$hashed = bin2hex($str);
echo(bin2hex($hashed)). "<br/>";
echo rand(1, 100). "<br/>";
$reversed = hex2bin($hashed);
echo($reversed). "<br/>";
echo random_bytes(8);
?>