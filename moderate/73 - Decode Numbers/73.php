<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/73/

function decode_numbers($n){
    $len = strlen($n);
    if( $len <= 1 ){
        return 1;
    }
    else{
        $count = 0;
        for( $i=1 ; $i <= 2 ; $i++){
            $sub = substr($n, 0, $i);
            
            if( intval($sub) > 26 ){
                break; 
            }
            $count += decode_numbers( substr($n, $i) );
        }
        return $count;
    }
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
                        echo decode_numbers( $line )."\n";
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
