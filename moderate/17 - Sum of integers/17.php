<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/17/

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
                        $tmp = explode(',', $line);
                        $current_sum = $best_sum = $tmp[0];
                        
                        for( $i=1, $cnt = count($tmp); $i < $cnt ; $i++){
                            $x = $tmp[$i];
                            if( $current_sum + $x > $x ){
                                // if x increases sum, add x
                                $current_sum += $x;
                            }
                            else{
                                // if not, take x as sum
                                $current_sum = $x;
                            }
                            if( $current_sum > $best_sum ){
                                $best_sum = $current_sum;
                            }
                        }
                        echo $best_sum."\n";
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
