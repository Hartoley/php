<?php
    $names =['keemah', 'keenah', 'john'];

    for ($i=0; $i < count($names); $i++) { 
        echo $names[$i] . "<br/>";
  };

  echo "<br/>";

  foreach ($names as $nn) {
   echo $nn . "<br/>";
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main>
        <?php include "./components/nav.html"?>
        <h1>Welcome to PHP</h1>
        <?php
            foreach ($names as $nnn) {
               echo "<h2>" . $nnn . "</h2>";
            }
        ?>

    <?php include "./components/footer.html"?>
    </main>
</body>
</html>