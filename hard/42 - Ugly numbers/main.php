<?php
header('Content-Type: text/plain; charset=utf-8');
// https://www.codeeval.com/open_challenges/42/

bcscale(0);
/*
$cpt = 0;
for($i=0;$i<=9999999999999;$i++){
    $cpt++;
}
echo $cpt;
die();
*/

$cpt = 0;
for($k=0;$k<=9999999;$k++){
    if( $k==0 || ($k%2)==0 || ($k%3)==0 || ($k%5)==0 || ($k%7)==0 ){
        $cpt++;
    }
}
echo $cpt;
die();


// $preteched_base = array();
function ugly_numbers( $str ){
    
    
$uglys = array();
    
    // $limit_sup = pow(2,31);
    // $limit_inf = -pow(2,31);
    
    $ugly_count = 0;
    $digits_cnt = strlen($str);
    
    $base = array('0','1','2');
    $tests = array(
        array('','0'),
        array('','1'),
        array('','2')
    );
    /*
    $maxs = array(
        0,
        0,
        base_convert('2', 3, 10)+1,
        base_convert('22', 3, 10)+1,
        base_convert('222', 3, 10)+1,
        base_convert('2222', 3, 10)+1,
        base_convert('22222', 3, 10)+1,
        base_convert('222222', 3, 10)+1,
        base_convert('2222222', 3, 10)+1,
        base_convert('22222222', 3, 10)+1,
        base_convert('222222222', 3, 10)+1,
        base_convert('2222222222', 3, 10)+1,
        base_convert('22222222222', 3, 10)+1,
        base_convert('222222222222', 3, 10)+1,
    );
    */
    $maxs = array(0,0,3,9,27,81,243,729,2187,6561,19683,59049,177147,531441);
    
    if($digits_cnt>=13){
        // HACK ... Argh!!! I give up ... PHP is dam too slow ... 
        // can't get under 6.7s for a 13-digits long string
        // I switch to nodejs for full completion
        // return mt_rand(417905,531441);
    }
    
    if( $digits_cnt == 1 ){
        if( $str==0 || ($str%2)==0 || ($str%3)==0 || ($str%5)==0 || ($str%7)==0 ){
            ++$ugly_count;
        }
    }
    else{
        $digits = array();
        for($i=0;$i<$digits_cnt;++$i){
            $digits[$i] = $str[$i];
        }
        
        $others = array();
        
        $i = $maxs[$digits_cnt];
        while($i--){
            
            // if( isset($preteched_base[$i]) ){
            //    $test = str_split($preteched_base[$i]);
            // }
            // else{
                // $test = base_convert($i, 10, 3);

                $r = $i % 3;
                // $test = $base[$r];
                $test = $tests[$r]; // array('',$base[$r]);
                // $k = 0;
                $q = ($i/3) | 0;
                while ($q) {
                    $r = $q % 3;
                    $q = ($q/3) | 0;
                    // $test = $base[$r].$test;
                    $test[] = $base[$r];
                    // ++$k;
                }

             //   $preteched_base[$i] = $test;
            //}
  
            
            $sum = 0;
            $tmp = '';
            
            $j = $digits_cnt;
            $big_number = 0;
            while( $j-- ){
                $tmp = $digits[$j] . $tmp;
                ++$big_number;
                // if( !empty($test[$k]) ){
                if( !empty($test[$j]) ){
                    // if( $test[$k] == 2 ){
                    if( $test[$j] == 2 ){
                        $tmp = -$tmp;
                    }
                    $sum = $sum+$tmp;
                    $tmp = '';
                    --$big_number;
                }
                // $k--;
            }
            if( $tmp ){
                $sum += $tmp;
            }

            $sum = ($sum<0) ? -$sum : $sum;
            if( isset($uglys[$sum]) ){
                if($uglys[$sum]){
                    ++$ugly_count;
                }
            }
            else {
                if( $big_number > 9 ){
                    if( $sum==0 || bcmod($sum,2)==0 || bcmod($sum,3)==0 || bcmod($sum,5)==0 || bcmod($sum,7)==0 ){
                        ++$ugly_count;    
                        $others[$sum] = 1;
                    } 
                }
                else{
                    if( $sum==0 || ($sum%2)==0 || ($sum%3)==0 || ($sum%5)==0 || ($sum%7)==0 ){
                        ++$ugly_count;
                        $others[$sum] = 1;
                    }
                }
            } 
        }   
        print_r($others);
        
    }
 
    return $ugly_count;
}

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) {
    $argv[1] = $_GET['f_i_l_e'];
    $t0 = microtime(true);
}




/*
$sum = '3456789013';
echo bcmod($sum, 2)."\r\n";
echo bcmod($sum, 3)."\r\n";
echo bcmod($sum, 5)."\r\n";
echo bcmod($sum, 7)."\r\n";

if( $sum==0 || ($sum%2)==0 || ($sum%3)==0 || ($sum%5)==0 || ($sum%7)==0 ){
    echo 'ugly'."\r\n";
}
else{
    echo 'ok'."\r\n";
}

die();
*/
if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                // $i=0;
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        echo ugly_numbers( $line )."\n";
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

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) {
    echo 'delta: ' . (microtime(true) - $t0)."\n";
}

exit(0);

?>
