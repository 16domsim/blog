<pre>
<?php
require_once './inc/classes/class.ValidableUser.php';
$a = new ValidableUser();
echo "aktueller Benutzer:" . $a . "\n";
echo "Fehler:\n";
foreach ($a->getAllErrors() as $key => $value) {
    echo $key . ": " . $value . "\n";
}

echo "\nRating test:\n";
$a->setRating("hallo");
echo "Wert: hallo; Fehler: " . $a->getRatingError() . "\n";
$a->setRating(- 1);
echo "Wert: -1; Fehler: " . $a->getRatingError() . "\n";
$a->setRating(6);
echo "Wert: 6; Fehler: " . $a->getRatingError() . "\n";
$a->setRating(2);
echo "Wert: 2; Fehler: " . $a->getRatingError() . "\n";
$a->setRating(1.26);
echo "Wert: 1.26; Fehler: " . $a->getRatingError() . "\n";

echo "\nBirtday test:\n";
$a->setBirthDate("");
echo "Wert: -; Fehler: " . $a->getBirthdateError() . "\n";
$a->setBirthDate("hallo");
echo "Wert: hallo; Fehler: " . $a->getBirthdateError() . "\n";
$a->setBirthDate("22");
echo "Wert: 22; Fehler: " . $a->getBirthdateError() . "\n";
$a->setBirthDate("40.02.1998");
echo "Wert: 40.02.1998; Fehler: " . $a->getBirthdateError() . "\n";
$a->setBirthDate("29/02/2001");
echo "Wert: 29/02/2001; Fehler: " . $a->getBirthdateError() . "\n";
$a->setBirthDate("1.1.0");
echo "Wert: 1.1.0; Fehler: " . $a->getBirthdateError() . "\n";
$date = new DateTime();
$date->modify("+1 year");
$a->setBirthDate(date('d.m.Y', $date->getTimestamp()));
echo "Wert: " . date('d.m.Y', $date->getTimestamp()) . "; Fehler: " . $a->getBirthdateError() . "\n";
$a->setBirthDate("1.1.2001");
echo "Wert: 1.1.01; Fehler: " . $a->getBirthdateError() . "\n";


echo "\nPassword test:\n";
$a->setPassword("hallo");
$a->setPasswordRepeat("Hal");
echo "Wert 1: hallo; Wert 2: Hal; Fehler: " . $a->getPasswordRepeatError() . "\n";
$a->setPassword("hallo");
$a->setPasswordRepeat("HallO");
echo "Wert 1: hallo; Wert 2: HallO; Fehler: " . $a->getPasswordRepeatError() . "\n";
$a->setPassword("hallo");
$a->setPasswordRepeat("hallo");
echo "Wert 1: hallo; Wert 2: hallo; Fehler: " . $a->getPasswordRepeatError() . "\n";

?>
</pre>