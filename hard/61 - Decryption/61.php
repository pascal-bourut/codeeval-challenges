<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/61/

$message = "012222 1114142503 0313012513 03141418192102 0113 2419182119021713 06131715070119";
$keyed_alphabet = "BHISOECRTMGWYVALUZDNFJKPQX";

/*
// B=>0, H=>1, I=>2, ..., X=>25
$keys = array_flip(str_split($keyed_alphabet));
// print_r($keys);
*/

$a = ord('A');
$decoded = '';
// echo $message."\n";
for($i=0, $len = strlen($message) ; $i < $len ; $i+=2 ){
    $c = $message[$i];
    if( $c == ' ' ){
        $decoded .= ' ';
        $i--;
    }
    else{
        $ord = $c . $message[$i+1];
        $chr = chr($a + $ord);
        $key = strpos($keyed_alphabet,$chr); // $keys[$chr];
        $char = chr($a + $key);
        // echo $ord.' => '.$chr.' => '. $key. ' => ' . $char . "\n";
        $decoded .= $char;
    }
}

echo $decoded."\n";

exit(0);

?>
