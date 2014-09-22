<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/114/
if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

function package_problem($size, $curr, $max, $things, $total_value, $total_weight, $selected, $current_selection ){
    $result = array();
    if ( $curr == $max ){
        // last item
        $value = 0;
        $weight = 0;
        for($i=0;$i<$curr;$i++){
            if( $current_selection[$i] == 1 ){
                $value += $things[$i][3];
                $weight += $things[$i][2];
            }
        }
        
        // var_export($current_selection)."\n";
        // echo $value.' '.$weight."\n";
        if ( ($weight < $size) && ($value > $total_value || ($value == $total_value && $weight < $total_weight)) ){
            // better solution now (greater value, or same value but less weight)
            $result = array('value' => $value, 'weight' => $weight, 'selection' => $current_selection);
        }
        else{
            // keeping old selection
            $result = array('value' => $total_value, 'weight' => $total_weight, 'selection' => $selected);
        }
    }
    else{
        // first option: without this item
        $current_selection[$curr] = 0;
        $result = package_problem($size, $curr+1, $max, $things, $total_value, $total_weight, $selected, $current_selection );
        // then: with this item
        $current_selection[$curr] = 1;
        $result = package_problem($size, $curr+1, $max, $things, $result['value'], $result['weight'], $result['selection'], $current_selection );
    }
    return $result;
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
                        // 81 : (1,53.38,$45) (2,88.62,$98) (3,78.48,$3) (4,72.30,$76) (5,30.18,$9) (6,46.34,$48)
                        list($size, $tmp) = explode(' : ', $line);
                        
                        $things = array();
                        if( preg_match_all('/\(([0-9]+),([0-9.]+),\$([0-9]+)\)/',$tmp, $matches, PREG_SET_ORDER ) ){
                            foreach($matches as $thing){
                                $things[] = $thing;
                            }
                        }
                        $cnt = count($things);
                        
                        $result = package_problem( $size, 0, $cnt, $things, 0, INF, array_fill(0,$cnt,0), array_fill(0,$cnt,0) );
                        if( $result['weight'] && $result['weight'] <= $size ){
                            $ids = array();
                            for($i=0 ; $i < $cnt ; $i++){
                                if( $result['selection'][$i] ){
                                    $ids[] = $things[$i][1];
                                }
                            }
                            sort($ids);
                            echo implode(',',$ids);
                        }
                        else{
                            echo '-' ; 
                        }
                        echo "\n";
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
