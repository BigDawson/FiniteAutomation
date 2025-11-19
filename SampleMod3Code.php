<?php
require_once __DIR__ . "/Mod3.php";

echo "1101 mod3 is " . mod3("1101") . "\n";
echo "1101 mod3 is " . mod3("1110") . "\n";
echo "1101 mod3 is " . mod3("1111") . "\n";

function mod3($binary)
{
    $mod3 = new Mod3();
    $mod3->Execute($binary);
    return $mod3->GetOutput();

}