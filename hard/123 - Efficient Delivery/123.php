<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/123/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

function efficient_delivery($tankers, $idx, $oil, $allocation){
    global $solutions, $min_diff;
    if( $oil > 0 ){
        $capacity = $tankers[$idx];
        $nb = count($tankers);
        $last_tanker = false;
        if( $capacity ){
            $cnt = ($oil / $capacity)|0;
            $rest = $oil - $cnt * $capacity;
            
            if( $idx == ($nb-1) ){
                $last_tanker = true;
                
                if( $rest === 0 ){
                    $allocation[$idx] = $cnt;
                    $oil = 0;
                }
                else{
                    $oil -= $cnt * $capacity;
                }
                
            }
            else{
                for($i = 0; $i <= $cnt ; $i++ ){
                    $allocation[$idx] = $i;
                    efficient_delivery($tankers, $idx+1, $oil - $i * $capacity, $allocation);
                }
            }
        }
        
        if( $last_tanker && $oil ){
            // no more tankers available
            // amount of oil left < amount possible on a tanker
            $diff = INF;
            for($i = 0; $i < $nb ; $i++ ){
                if( $oil < $tankers[$i] ){
                    $diff = $tankers[$i] - $oil;
                }
            }
            if( $diff < $min_diff ){
                $min_diff = $diff;
            }
        }
    }
    
    if( $oil === 0 ){
        // oil = 0
        // ok
        // print_r($allocation);
        $solutions[] = array_reverse($allocation);
    }    
}



// $t0 = microtime(true);

function solution_cmp($a,$b){
    $aa = $bb = '';
    for($i=0, $cnt=count($a);$i<$cnt;$i++){
        $aa .= sprintf('%04d', $a[$i]);
        $bb .= sprintf('%04d', $b[$i]);
    }
    return $aa > $bb ? 1 : -1;
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
                        list($tankers, $oil) = explode(', ', $line);
                        $tankers = array_reverse(explode(',',substr($tankers,1,-1)));
                        $solutions = array();
                        $min_diff = $oil;
                        // print_r($tankers);
                        // echo $oil  ."\n";
                        efficient_delivery($tankers, 0, $oil, array_fill(0,count($tankers),0) );
                        if( $solutions ){
                            usort($solutions,'solution_cmp');
                            for($i=0, $cnt=count($solutions); $i < $cnt ; $i++){
                                echo '['.implode(',', $solutions[$i]).']';
                            }
                            echo "\n";
                        }
                        else{
                            echo $min_diff . "\n";
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

// echo (microtime(true) - $t0) . "\n";

exit(0);

?>
