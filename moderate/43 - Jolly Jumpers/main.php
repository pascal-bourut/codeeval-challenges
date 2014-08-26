<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/browse/13/

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
                        
                        list($n, $sequence) = explode(' ', $line, 2);
                        $prev = false;
                        $jolly = true;
                        $sequence = explode(' ',$sequence);
                        if( $n != '1' ){
                            $i = $n;
                            $all = array();
                            while($i--){
                                $d = $sequence[$i];
                                if( $prev !== false ){
                                    $diff = $prev - $d;
                                    if( $diff < 0) $diff = -$diff;
                                    
                                    if( ($diff < 1) || ($diff > ($n-1)) || isset($all[$diff]) ){
                                        $jolly = false;
                                        break;
                                    }
                                    
                                    $all[$diff] = true;
                                }
                                $prev = $d;
                            }
                        }
                        echo ($jolly ? 'Jolly' : 'Not jolly')."\n";

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