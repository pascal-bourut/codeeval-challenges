<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/51/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                $distance_squared_max = 10000 * 10000 + 1;
                $points = array();
                
                function point_cmp($a,$b){
                    // sort x
                    return $a[0] - $b[0];
                }
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line !== '' ){
                        if( strpos($line,' ') === false ) {
                            if( $points ){
                                $distance_squared = $distance_squared_max;
                                $cnt = count($points);
                                usort($points, 'point_cmp');
                                // print_r($points);
                                for($i=0, $max=$cnt-1 ; $i < $max ; $i++){
                                    for($j = $i+1; $j < $cnt ; $j++){
                                        $p0 = $points[$i];
                                        $x0 = $p0[0];
                                        $p1 = $points[$j];
                                        $x1 = $p1[0];
                                        $xd = $x1 - $x0; 
                                        if( $xd * $xd > $distance_squared ){
                                            // echo '.';
                                            break;
                                        }
                                        
                                        $y0 = $p0[1];
                                        $y1 = $p1[1];
                                        $yd = $y1 - $y0; 
                                        $ds = $xd * $xd + $yd * $yd;
                                        
                                        if( $ds < $distance_squared ){
                                            $distance_squared = $ds;
                                        }
                                    }
                                }
                                echo ( ( $distance_squared >= $distance_squared_max ) ? 'INFINITY' : sprintf('%.04f', round(sqrt($distance_squared),4) ) ) . "\n";
                            }
                            $points = array();
                        }
                        else{
                            $points[] = explode(' ',$line);
                        }
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
