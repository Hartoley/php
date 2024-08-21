<?php
$users = [
    ["firstName"=> "keenah", "age"=> 5, "gender" => "Male"],
    ["firstName"=> "keemah", "age"=> 6, "gender" => "Female"],
    ["firstName"=> "keena", "age"=> 7, "gender" => "Male"]
];

echo $users[0]["firstName"] . "<br/> ";
echo $users[0]["gender"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <main>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Serial no.</th>
      <th scope="col">First Name</th>
      <th scope="col">Age</th>
      <th scope="col">Gender</th>
    </tr>
  </thead>
  <tbody>
             <?php
                foreach ($users as $key => $values) {
                    echo "
                    <tr>
                        <td>$key</td>
                        <td>$values[firstName]</td>
                        <td>$values[age]</td>
                        <td>$values[gender]</td>
                    </tr>";
                }
             ?>
  </tbody>
</table>
    </main>
</body>
</html>