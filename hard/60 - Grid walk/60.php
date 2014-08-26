<?php
die();
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/public_sc/60/

// returns last consecutive number with sum of its digits > N
// e.g.: get_max(19) = 298  (2+9+8=19     next: 299 2+9+9=20)

function get_max($n){
    $nines = floor(($n+1)/9);
    $rest = ($n+1) - $nines * 9;
    $max = $rest . str_repeat('9',$nines);
    $max -= 1;
    return $max;
}//

// returs sum of digits of N
// digits_sum(298) = 2+9+8 = 19
function digits_sum ($n){
    if( $n == 0 ) return 0;
    if( $n < 0 ) $n = -$n;
    $sum = 0;
    $n = ''.$n;
    $j = strlen($n);
    while($j--){
        $sum += $n[$j];
        
    }
    return $sum;
}//


$sum_max = 19;
$max = get_max( $sum_max );

$digits_sums = array();
for($i=0 ; $i <= $max*$max ; $i++){
    $digits_sums[$i] = digits_sum($i);
}

$sub_total = 0;

// already visited 
$walked = array();

$retest = array();

$old = 0;
for( $x=0 ; $x <= $max ; $x++){
    $y = $sum_max - $digits_sums[$x]; 
    $ymax = get_max( $y );
    echo $x.': '.$ymax."\n";
    for($y=0 ; $y <= $ymax ; $y++){
        $xy = $x.'-'.$y; 
        $walked[$xy] = true;
        $sub_total++;
    }
    
    if( $old && $ymax > $old ){
        
        for($y = $old+1 ; $y < $ymax ; $y++){
            if( ($digits_sums[$x-1] + $digits_sums[$y]) <= $sum_max ){
                $retest[] = ($x-1).','.$y;
            }
        }
    }
    
    $old = $ymax;
}

function grid_walk ($x, $y){
    global $sub_total, $walked,$digits_sums,$sum_max;
    $xy = $x+'-'+$y;
    if( !isset($walked[$xy]) ){
        $walked[$xy] = true;
        $sub_total++;
        echo '++';
        
        $sx = $digits_sums[$x];
        $sy = $digits_sums[$y];
        
        // I don't want to go into negative x 
        // move left only if x > 0
        if( $x>0 && ($digits_sums[$x-1] + $sy) <= $sum_max ){
            grid_walk($x-1, $y);
        }
        if( ($digits_sums[$x+1] + $sy) <= $sum_max ){
            grid_walk($x+1, $y);
        }
        // I don't want to go into negative y
        // move up only if y > 0
        if( $y>0 && ($sx + $digits_sums[$y-1]) <= $sum_max ){
            grid_walk($x, $y-1);
        }
        if( ($sx + $digits_sums[$y+1]) <= $sum_max ){
            grid_walk($x, $y+1);
        }
    }
};


print_r($retest);
foreach($retest as $xy){
    list($x,$y) = explode(',',$xy);
    grid_walk($x,$y);
}

echo $sub_total."\n";

// 102485

/*
process.on('exit', function (){
    // I've just walked into positive quarter
    // I delete the first line and I quadruple the sub total
    var total = (sub_total - max) * 4;
    // 0,0 is my starting position
    // I counted it 4 times, I only need one
    // so, I have to reduce by 3
    total -= 3;
    console.log(total);
});

// GO!
grid_walk(0,0);
*/
?>