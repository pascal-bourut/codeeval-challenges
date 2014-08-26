<?php
// https://www.codeeval.com/open_challenges/109/
header('Content-Type: text/plain; charset=utf-8');

// http://wiki.openstreetmap.org/wiki/Mercator
function lon2x($lon) { return deg2rad($lon) * 6378137.0; }
function lat2y($lat) { return log(tan(M_PI_4 + deg2rad($lat) / 2.0)) * 6378137.0; }

// transcripted to PHP from http://www.java-gaming.org/index.php?topic=22590.0
function lines_intersect($x1,$y1,$x2,$y2,$x3,$y3,$x4,$y4){
    // Return false if either of the lines have zero length
    if ($x1 == $x2 && $y1 == $y2 || $x3 == $x4 && $y3 == $y4){
        return false;
    }
    // Fastest method, based on Franklin Antonio's "Faster Line Segment Intersection" topic "in Graphics Gems III" book (http://www.graphicsgems.org/)
    $ax = $x2-$x1;
    $ay = $y2-$y1;
    $bx = $x3-$x4;
    $by = $y3-$y4;
    $cx = $x1-$x3;
    $cy = $y1-$y3;

    $alphaNumerator = $by*$cx - $bx*$cy;
    $commonDenominator = $ay*$bx - $ax*$by;
    if ($commonDenominator > 0){
        if ($alphaNumerator < 0 || $alphaNumerator > $commonDenominator){
            return false;
        }
    }else if ($commonDenominator < 0){
        if ($alphaNumerator > 0 || $alphaNumerator < $commonDenominator){
            return false;
        }
    }
    $betaNumerator = $ax*$cy - $ay*$cx;
    if ($commonDenominator > 0){
        if ($betaNumerator < 0 || $betaNumerator > $commonDenominator){
            return false;
        }
    }else if ($commonDenominator < 0){
        if ($betaNumerator > 0 || $betaNumerator < $commonDenominator){
            return false;
        }
    }
    if ($commonDenominator == 0){
        // This code wasn't in Franklin Antonio's method. It was added by Keith Woodward.
        // The lines are parallel.
        // Check if they're collinear.
        $y3LessY1 = $y3-$y1;
        $collinearityTestForP3 = $x1*($y2-$y3) + $x2*($y3LessY1) + $x3*($y1-$y2);   // see http://mathworld.wolfram.com/Collinear.html
        // If p3 is collinear with p1 and p2 then p4 will also be collinear, since p1-p2 is parallel with p3-p4
        if ($collinearityTestForP3 == 0){
            // The lines are collinear. Now check if they overlap.
            if ($x1 >= $x3 && $x1 <= $x4 || $x1 <= $x3 && $x1 >= $x4 ||
                  $x2 >= $x3 && $x2 <= $x4 || $x2 <= $x3 && $x2 >= $x4 ||
                  $x3 >= $x1 && $x3 <= $x2 || $x3 <= $x1 && $x3 >= $x2){
                if ($y1 >= $y3 && $y1 <= $y4 || $y1 <= $y3 && $y1 >= $y4 ||
                     $y2 >= $y3 && $y2 <= $y4 || $y2 <= $y3 && $y2 >= $y4 ||
                     $y3 >= $y1 && $y3 <= $y2 || $y3 <= $y1 && $y3 >= $y2){
                    return true;
                }
            }
        }
        return false;
    }
    return true;
}

function order_id($a, $b) {
    if ($a['id'] == $b['id']) {
        return 0;
    }
    return ($a['id'] < $b['id']) ? -1 : 1;
}

function process($points){
    $bridges = array();
    foreach($points as $ps){
        $ps = trim(preg_replace('/[^0-9\.\-]/',' ',$ps));
        $tmp = preg_split('/\s+/',$ps);
        $bridges[] = array(
            'id' => $tmp[0],
            'lat_a' => $tmp[1],
            'lng_a' => $tmp[2],
            'lat_b' => $tmp[3],
            'lng_b' => $tmp[4], 
        );
    }
    
    usort($bridges, 'order_id');
    // print_r($bridges);

    // check xing between each bridges
    $bridges_cnt = count($bridges);
    $xings = array();
    for($i=0 ; $i < $bridges_cnt ; $i++){
        for($j = $i+1 ; $j < $bridges_cnt ; $j++){
            // echo $bridges[$i]['id'].' vs '.$bridges[$j]['id']."\r\n";
            // mercator projection
            $xai = lon2x($bridges[$i]['lng_a']);
            $yai = lat2y($bridges[$i]['lat_a']);
            $xbi = lon2x($bridges[$i]['lng_b']);
            $ybi = lat2y($bridges[$i]['lat_b']);
            
            $xaj = lon2x($bridges[$j]['lng_a']);
            $yaj = lat2y($bridges[$j]['lat_a']);
            $xbj = lon2x($bridges[$j]['lng_b']);
            $ybj = lat2y($bridges[$j]['lat_b']);
            
            if( lines_intersect($xai,$yai,$xbi,$ybi,$xaj,$yaj,$xbj,$ybj) ){
                $xings[$i][$j] = true;
                $xings[$j][$i] = true;
            }
        }
    }
    
    // print_r($xings);
    
    // now, I know who blocks who
    // I will decide not to build some bridges and see if I can increase the total built
    $max = bindec(str_repeat('1', $bridges_cnt));
    $i = $max + 1 ;
    
    $best = false;
    $current_max = 0;
    while($i--){
        $test = decbin($i);
        $count_one = count(explode('1',$test)) - 1 ;
        if( $count_one <= $current_max ){
            // number of 1 < current_max, no need to go further
            continue;
        }
        $combo = str_pad( $test , $bridges_cnt, '0', STR_PAD_LEFT );
        // echo $combo."\n";
        $build = 0;
        $j = $bridges_cnt;
        $xs = $xings;
        while($j--){
            if( $combo[$j] == 0 ){
                // I won't build this bridge
                // Is the total of built bridges better now?
                if( isset($xs[$j]) ){
                    foreach( $xs[$j] as $k => $null ){
                        unset($xs[$k][$j]);
                        if( !$xs[$k] ) unset($xs[$k]);
                    }
                    unset($xs[$j]);
                }
            }
            else{
                $build++;
            }
        }
        
        if( $build < $current_max ){
            // I'm done, I won't find a better combo
            continue;
        }
        
        $max_to_build = $build - count($xs);
        if( $max_to_build > $current_max ){
            $best = $combo;
            $current_max = $max_to_build;
            if( $current_max == $bridges_cnt ) break;
        }
        /*
        print_r($xs);
        echo $max_to_build."\n";
        */
    }
    
    
    if( $best ){
        for($i=0 ; $i < $bridges_cnt ; $i++){
            if( $best[$i] == 1 ){
                echo $bridges[$i]['id']."\n";
            }
        }
    }
    
}//process


if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) {
    $argv[1] = $_GET['f_i_l_e'];
    $t0 = microtime(true);
}


if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                $points = array();
                while ( $fp && !feof( $fp ) ) {
                    $line = fgets( $fp );
                    if( trim($line) ){
                        $points[] = $line;
                    }
                }//
                echo process($points);
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

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) {
    echo 'delta: ' . (microtime(true) - $t0)."\n";
}

exit(0);

?>
