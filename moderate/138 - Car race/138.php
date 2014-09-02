<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/138/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];


function lap_time_cmp($a,$b){
    return $a['lap_time'] - $b['lap_time'];
}


if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $track = false;
                $cars = array();
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        if( !$track ){
                            $track = explode(' ', $line);
                            // var_export($track);
                        }
                        else{
                            $tmp = explode(' ', $line);
                            $cars[] = array(
                                'id' => $tmp[0],
                                'top_speed' => $tmp[1] / 3600,  // seconds
                                'time_to_accelerate_top' => $tmp[2],
                                'time_to_brake_zero' => $tmp[3],
                                'lap_time' => 0
                            );
                            $cars[count($cars)-1]['accelerate_rate'] = $cars[count($cars)-1]['top_speed'] / $cars[count($cars)-1]['time_to_accelerate_top'];
                            $cars[count($cars)-1]['brake_rate'] = $cars[count($cars)-1]['top_speed'] / $cars[count($cars)-1]['time_to_brake_zero'];
                        }
                    }
                }//
                fclose( $fp );
                
                $nb = count($cars);
                for( $j = 0 ; $j < $nb ; $j++ ){
                    
                    $car = $cars[$j];
                    $time = 0;
                    $speed_start_of_section = 0;
                    
                    for( $i = 0, $cnt = count($track) ; $i < $cnt ; $i+=2 ){
                        $section_length = $track[$i];
                        $angle_factor = 1 - $track[$i+1] / 180;
                        $ts = $car['top_speed'];
                        $a = $car['accelerate_rate'];
                        $b = $car['brake_rate'];
                        
                        $speed_end_of_section = $angle_factor * $ts;
                    
                        // echo $speed_start_of_section.'>'.$speed_end_of_section."\n";
                        
                        // accelerate phase from $speed_start_of_section to $top_speed => time and distance
                        $t = ( $ts - $speed_start_of_section ) / $a;
                        // Linear distance can be expressed as (if acceleration is constant):
                        // s = v0 t + 1/2 a t2
                        $d = $speed_start_of_section * $t + ( $a * $t * $t ) * 0.5;
                        
                        $section_length -= $d;
                        $time += $t;
                        
                        // brake phase from $top_speed to $speed_end_of_section => time and distance
                        $t = ( $ts - $speed_end_of_section) / $b;
                        $d = $ts * $t - ($b * $t * $t ) * 0.5; // caution: minus here
                        
                        $section_length -= $d;
                        $time += $t;
                        
                        // top speed during (section_length - accelerate_phase.distance - brake_phase.distance) => time
                        $time += $section_length / $ts;
                        
                        $speed_start_of_section = $speed_end_of_section;
                    }//
                
                    $cars[$j]['lap_time'] = $time;
                }
            
                usort($cars, 'lap_time_cmp');
                
                // print_r($cars);
                
                for( $j = 0; $j < $nb ; $j++ ){
                    echo $cars[$j]['id'] . ' '. sprintf('%0.2f', round($cars[$j]['lap_time'],2)) . "\n";
                }
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
