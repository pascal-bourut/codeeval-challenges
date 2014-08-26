<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/149/

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
                        
                        // 1. Convert a zero based number into a binary form using the following rules: 
                        
                        $sequence = explode(' ',$line);
                        $len = count($sequence);
                        $binary_str = '';
                        for($i=0;$i<$len;$i+=2){
                            $k = $sequence[$i];
                            $v = $sequence[$i+1];
                            if( $k === '0' ){
                                // a) flag "0" means that the following sequence of zeros should be appended to a binary string. 
                                $binary_str .= $v;
                            }
                            else if( $k === '00' ){
                                // b) flag "00" means that the following sequence of zeroes should be transformed into a sequence of ones and appended to a binary string.
                                $binary_str .= str_replace('0','1',$v);
                            }
                        }
                        $integer_str = bindec($binary_str);
                        echo $integer_str."\n";
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
