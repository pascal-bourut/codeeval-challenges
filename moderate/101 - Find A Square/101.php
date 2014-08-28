<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/101/

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
                        $coords = preg_split('/[\(\), ]+/', $line);
                        // bounding box of the 4 points
                        $bbox_min_x = 11;
                        $bbox_max_x = -1;
                        $bbox_min_y = 11;
                        $bbox_max_y = -1;
                        $points = array();
                        for( $i=1 ; $i <= 8 ; $i+=2 ){
                            $x = $coords[$i];
                            $y = $coords[$i+1];
                            if( $x < $bbox_min_x ) $bbox_min_x = $x;
                            if( $x > $bbox_max_x ) $bbox_max_x = $x;
                            if( $y < $bbox_min_y ) $bbox_min_y = $y;
                            if( $y > $bbox_max_y ) $bbox_max_y = $y;
                            $points[$x.$y] = array($x, $y);
                        }
                        $count = count($points);
                        if( $count == 4 ){
                            $points = array_values($points);
                            // first condition: bbox width = bbox height
                            $w = $bbox_max_x - $bbox_min_x;
                            $h = $bbox_max_y - $bbox_min_y;
                            
                            if( $w && $h && $w == $h ){
                                // then, all 4 points must be on the bbox border
                                $all_one = true;
                                $all_two = true;
                                for($i=0 ; $i < 4 ; $i++){
                                    $x = $points[$i][0];
                                    $y = $points[$i][1];
                                    $on_bbox = ( ( $x == $bbox_min_x || $x == $bbox_max_x ) ? 1 : 0 + ( ( $y == $bbox_min_y || $y == $bbox_max_y ) ? 1 : 0 ) );
                                    if( $on_bbox == 0 ){
                                        $all_two = false;
                                        $all_one = false;
                                        break;
                                    }
                                    else if( $on_bbox == 1 ){
                                        $all_two = false;
                                    }
                                    else if( $on_bbox == 2 ){
                                        $all_one = false;
                                    }
                                }
                                // all 4 points must have 1 or 2 coordinates on the border
                                // but not a mix
                                $ok = $all_one || $all_two;
                            }
                            else{
                                $ok = false;
                            }
                        }
                        else if( $count == 1 ){
                            // 1 point != 1 square
                            $ok = false;
                        }
                        else{
                            // 2 or 3 distinct points
                            $ok = false;
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
