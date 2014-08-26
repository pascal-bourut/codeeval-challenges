<?php
header('Content-Type: text/plain; charset=utf-8');
// https://www.codeeval.com/open_challenges/46/

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

    return implode(',',$primes); 
}


if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        echo sieve_of_atkin( $line )."\n";
                    }
                }//
                fclose( $fp );
            }
            else{
                echo '!fp'."\n";
            }
        }
        else{
            echo '!readable'."\n";
        }
    }
    else{
        echo '!file_exists'."\n";
    }
}
else{
    echo '!argv[1]'."\n";
}

exit(0);
?>
