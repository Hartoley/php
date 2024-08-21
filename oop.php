<?php
class Human{
  public $gender = 'Male';
  public $skinColor = 'Fair';
  public $humanName = 'Victor';

  public function eat(){
    return 'daniel needs to eat';
  }

  public function sleep(){
    return "$this->humanName loves sleep than money";
  }

  public function _construct($gen, $skinColor, $humanName){
    $this->gender = $gen;
    $this->skinColor=$skinColor;
    $this->humanName=$humanName;
  }
};

$daniel = new Human('male', 'fair', 'Dude');
$human2 = new Human('Female', 'dark', 'victoria');
$samuel = new Human();
echo $human2->sleep();
echo'<br/>';

echo $daniel->skinColor;
echo'<br/>';

echo $daniel->eat();
echo'<br/>';

$samuel->gender='others';
echo $samuel->gender;
echo'<br/>';

$samuel->humanName ="Samuel";
echo $samuel->sleep();
?>