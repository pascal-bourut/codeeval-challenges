<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/101/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

function cmp_v($a,$b){
    return $a['v'] - $b['v'];
}

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        $coords = preg_split('/[\(\), ]+/', $line);
                        $points = array();
                        $distances = array();
                        $ok = true;
                        for( $i=1 ; $i <= 8 ; $i+=2 ){
                            $x = $coords[$i];
                            $y = $coords[$i+1];
                            $points[] = array($x, $y);
                            
                            if( $i > 2 ){
                                $distance = ($points[0][0] - $x) * ($points[0][0] - $x) + ($points[0][1] - $y) * ($points[0][1] - $y);
                                if( $distance === 0 ){
                                    $ok = false;
                                    break;
                                }
                                $distances[] = array('k' => '0-' . (($i-1)/2), 'v' => $distance);
                            }
                            if( $i > 6 ){
                                $distance = ($points[2][0] - $points[1][0]) * ($points[2][0] - $points[1][0]) + ($points[2][1] - $points[1][1]) * ($points[2][1] - $points[1][1]);
                                if( $distance === 0 ){
                                    $ok = false;
                                    break;
                                }
                                $distances[] = array('k' => '1-2', 'v' => $distance);
                            }
                            
                        }
                        
                        if( $ok ){
                            usort($distances, 'cmp_v' );
                            $ok = ($distances[0]['v'] !== 0) && ($distances[0]['v'] == $distances[1]['v']) && ( round($distances[0]['v'] * 2,5) == round($distances[3]['v'],5) );
                        }
                        echo ( $ok ? 'true' : 'false' ) . "\n";
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
