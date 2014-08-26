<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/64/


function fibo($n){
    if( $n <= 1 ){
        return 1;
    }
    else{
        return fibo($n-1) + fibo($n-2);
    }
}

function linear_fibo($n){
    $a = 1;
    $b = 2;
    for($i=1 ; $i < ($n-1) ; $i++){
        $tmp = bcadd($a,$b);
        $a = $b;
        $b = $tmp;
    }
    return $b;
}

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $stairs = trim(fgets($fp));
                    if( $stairs ){
                        
                        // $total = fibo( $stairs );
                        
                        // http://fr.wikipedia.org/wiki/Suite_de_Fibonacci
                        echo (( $stairs <= 1 ) ? $stairs : linear_fibo( $stairs ))."\n";
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
(