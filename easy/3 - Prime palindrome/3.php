<?php
header('Content-Type: text/plain; charset=utf-8');
// https://www.codeeval.com/open_challenges/3/

// http://en.wikipedia.org/wiki/List_of_prime_numbers
// log(n) => http://en.wikipedia.org/wiki/Sieve_of_Atkin

function sieve_of_atkin( $limit ){
    $sqrt = sqrt($limit); 
    $is_prime = array_fill(0, $limit + 1, false); 
    $is_prime[2] = ($limit >= 2);
    $is_prime[3] = ($limit >= 3);
    
    for ($i = 1; $i <= $sqrt; $i++) { 
        $powi = $i*$i;
        for ($j = 1 ; $j <= $sqrt; $j++) { 
            $powj = $j*$j;
            
            if ( ($powi + $powj) >= $limit) {
                break;
            }
            
            $n = 4 * $powi + $powj;
            if ($n <= $limit && ($n % 12 == 1 || $n % 12 == 5)) { 
                $is_prime[$n] ^= true; 
            } 

            $n = 3 * $powi + $powj;
            if ($n <= $limit && $n % 12 == 7) { 
                $is_prime[$n] ^= true; 
            } 
                 
            $n = 3 * $powi - $powj; 
            if ($i > $j && $n <= $limit && $n % 12 == 11) { 
                $is_prime[$n] ^= true; 
            } 
        } 
    } 

    for ($n = 5 ; $n <= $sqrt ; $n++) { 
        if ($is_prime[$n]) { 
            $s = $n * $n; 
                 
            for ($k = $s; $k <= $limit; $k += $s) { 
                $is_prime[$k] = false; 
            } 
        } 
    } 

    $primes = array();
    for ( $i = 0 ; $i < $limit ; $i++) { 
        if ($is_prime[$i]) { 
            $primes[] = $i; 
        } 
    } 

    return $primes; 
}

$sieve = sieve_of_atkin(1000);
$i = count($sieve);
while($i--){
    $prime = $sieve[$i];
    if( $prime == strrev($prime) ){
        echo $prime."\n";
        break;
    }
}
exit(0);
?>
