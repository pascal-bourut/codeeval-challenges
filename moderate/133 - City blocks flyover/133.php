<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/133/

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
                        // echo $line."\n";
                        list($streets, $avenues) = explode(' ',$line);
                        $streets = explode(',',trim($streets,'()'));
                        $avenues = explode(',',trim($avenues,'()'));
                        
                        $smax = count($streets) - 1;
                        $amax = count($avenues) - 1;
                        
                        $tan = $avenues[$amax] / $streets[$smax];
                        
                        $crossed = 0;
                        
                        // echo count($avenues)."\n";
                        // echo $tan . "\n";
                        for( $s=0 ; $s < $smax ; $s++ ){
                            for( $a=0 ; $a < $amax ; $a++ ){
                                $curr_x = $streets[$s];
                                $curr_y = $avenues[$a];
                                
                                $next_x = $streets[$s+1];
                                $next_y = $avenues[$a+1];
                                
                                // echo 'from ('.$curr_x.','.$curr_y.') to ('.$next_x.','.$next_y.')'."\n";
                                if ( ($next_x > ($curr_y / $tan)) && ($next_y > ($tan * $curr_x)) ){
                                    $crossed++;
                                    // echo '++'."\n";
                                }
                                
                            }
                        }
                        echo $crossed."\n";
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
