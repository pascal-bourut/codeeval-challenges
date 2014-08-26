<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/4/

// http://en.wikipedia.org/wiki/List_of_prime_numbers
function is_prime( $n ){
	$i = 2;
    if ($n == 2) {
		return true;	
	}
 
	$sqrt_n = sqrt($n);
	while ($i <= $sqrt_n) {
		if ($n % $i == 0) {
			return false;
		}
		$i++;
	}
	return true;
}//

$nb = 1000;
$max = PHP_INT_MAX;
$sum = 0;
$cpt = 0;
for($i = 2 ; $i < $max ; $i++ ){
    if( is_prime($i) ){
        $sum += $i;
        if( ++$cpt >= $nb ) break;
    }//
}
echo $sum."\n"; 

exit(0);
?>