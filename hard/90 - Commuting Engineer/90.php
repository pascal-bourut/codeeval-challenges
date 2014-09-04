<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/90/

// less than 20 cities => brute force approach?


function distance($lat1, $lng1, $lat2, $lng2){
    $pi80 = M_PI / 180;
    $lat1 *= $pi80;
    $lng1 *= $pi80;
    $lat2 *= $pi80;
    $lng2 *= $pi80;

    $r = 6372.797; // mean radius of Earth in km
    $dlat = $lat2 - $lat1;
    $dlng = $lng2 - $lng1;
    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $km = $r * $c;

	return $km;
}//

function commuting_engineer($prev, $indexes, $visited, $curr_length, $best, $step ){
    global $distances;
    
    // echo 'commuting_engineer('.$prev.','.var_export($visited, true).')'."\n";
    
    // echo var_export($to_visit,true).' '.var_export($path,true)."\n";
    // echo $prev.' '.implode(',',array_keys($visited)).': '.$step."\n";
    $visited[$prev] = true;
        
    if( $step === 0 ){
        // path length
        // print_r($visited);
        // echo $curr_length.'<'. $best[0]."\n";
        if( $curr_length < $best[0] ){
            // echo 'OUI'."\n";
            $best[0] = $curr_length;
            $best[1] = $visited;
        }
    }
    else{
        foreach( $indexes as $k => $next ){
            if( !isset($visited[$next]) ){
                if( $prev < $next ){
                    $a = $prev;
                    $b = $next;
                }
                else{
                    $b = $prev;
                    $a = $next;
                }
                $d = $distances[$a][$b];
                $next_length = $curr_length + $d;
                
                if( $next_length < $best[0] ){
                    $best = commuting_engineer($next, $indexes, $visited, $next_length, $best, $step - 1);
                }
            }
        }
    }
    return $best;
}

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                $places = array();
                $ids = array();
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        // echo $line."\n";
                        if( preg_match('/^([0-9]+) \|.*\(([0-9\-\.]+), ([0-9\-\.]+)\)$/',$line,$matches) ){
                            $places[] = array(
                                'lat' => $matches[2],
                                'lng' => $matches[3],
                            );
                            $ids[] = $matches[1];
                        }
                    }
                }//
                fclose( $fp );
                
                $distances = array();
                $cnt = count($places);
                for($i=0; $i < $cnt-1 ; $i++){
                    for($j=$i+1; $j < $cnt ; $j++){
                        $d = distance($places[$i]['lat'], $places[$i]['lng'], $places[$j]['lat'], $places[$j]['lng']);
                        // echo $i.'vs'.$j.': '. $d . "\n";
                        if( $ids[$i] < $ids[$j] ){
                            $a = $ids[$i];
                            $b = $ids[$j];   
                        }
                        else{
                            $a = $ids[$j];
                            $b = $ids[$i];   
                        }
                        
                        $distances[$a][$b] = $d;
                    }
                }
                
                // print_r($distances);
                
                // $ids = array(1,2,3,4);
                
                list($best_length,$best_path) = commuting_engineer( 1, $ids, array(), 0, array(INF, false), count($ids)-1 );
                echo implode("\n", array_keys($best_path))."\n";
                
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
