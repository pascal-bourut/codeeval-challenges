<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/34/

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
                        list($numbers, $sum) = explode(';', $line);
                        
                        $numbers = explode(',',$numbers);
                        $half_sum = $sum / 2;
                        $cnt = count($numbers);
                        $lower_value = $numbers[0];
                        $pairs = array();
                        $i = $cnt;
                        while( $i-- > 1 ){
                            $ni = $numbers[$i];
                            
                            if( $half_sum > $ni ){
                                break;
                            }
                            
                            $target = $sum - $ni;
                            if( $ni >= $sum && $lower_value > $target ){
                                continue;
                            }
                            
                            $j = $i;
                            while( $j-- ){
                                $nj = $numbers[$j];
                                if( $nj == $target ){
                                    $pairs[] = $nj.','.$ni;
                                }
                                else if( $nj < $target ){
                                    break;
                                }
                            }
                        }
                        echo ( $pairs ? implode(';', $pairs) : 'NULL' ) . "\n";
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
