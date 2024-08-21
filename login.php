<?php
include("./database/connectdb.php");


echo "Login to your PHP account <br/>";
echo "My name is Keena <br/>";
print("Using the print method <br/>");
print_r("Print r is used to output complex data like arrays and multi-dimensional arrays <br/>");

echo "<h1>It can also output an html tag</h1>";

$name = "Tolani <br/>";
$num1 =20;
$num2 =17;


echo $num1 + $num2. "<br/>";
echo "My name is ". $name. "<br/>";

$hasPaid = false;
$hasEaten = true;
$matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];
$user = [
    "name" => "John Doe",
    "age" => 30,
    "email" => "john.doe@example.com"
];

$cars = ["Toyota", "Benz", "Tesla", "Lamboghini", "Audi"];
$str_method = "Testing string method". "<br/>";

echo strlen($str_method . "This is it");
echo "<br/>";
echo strtoupper($str_method);
echo strtolower($str_method);



echo $cars[2];
print_r($cars);





?>