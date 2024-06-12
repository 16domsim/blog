<?php
$combOne[]=["Avard","BigEngine","Cobra","Diesel","Engine","Fire","Gasoline","Hyper","Ionium","Jeeep","Kreta","Limos","Motor","Nitro","Oper","Power","Quantas","Racer","Suprem","Turbo","Ultra","Virtual","Winnor","Xray","Yankee","Zora"];

$combOne[]=["Pro","One","Max","Boss","Monkey"];

$combOne[]=["Ultra","Mega","Giga"];

$possibleUserNames=array();

$possibleUserNames=insertCombinations(0,$combOne);

shuffle($possibleUserNames);

$searchText = $_REQUEST["q"];

$hint = "";


if ($searchText !== "") {
    $searchText = strtolower($searchText);
    $length=strlen($searchText);
    foreach($possibleUserNames as $name) {
        if (stristr($searchText, substr($name, 0, $length))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;
?>

<?php 

function insertCombinations($i, $combOne){
    $ret=array();
    if($i<count($combOne)&&count($combOne[$i])>0){
     
        foreach ($combOne[$i] as $comb) {
            $ret[]=$comb;
            if($i<count($combOne)-1){
            $help = insertCombinations($i+1, $combOne);
            foreach ($help as $combTwo) 
                $ret[]=$comb.''.$combTwo;
            
            }
        }
    }
        return $ret;
}
?>