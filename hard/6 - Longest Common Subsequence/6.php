<?php
header('Content-Type: text/plain; charset=utf-8');

// http://en.wikipedia.org/wiki/Longest_common_subsequence_problem

// https://www.codeeval.com/open_challenges/6/
if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

function longest_common_subsequence($a,$b){
    $lengths = array();
    $a_len = strlen($a);
    $b_len = strlen($b);
    
    for( $i=0 ; $i <= $a_len ; $i++ ){
        $lengths[$i] = array();
        for( $j=0 ; $j <= $b_len ; $j++ ){
            $lengths[$i][$j] = 0;
        }
    }
 
    for($i = 0; $i < $a_len ; $i++){
        for($j = 0; $j < $b_len ; $j++){
            if( $a[$i] == $b[$j] ){
                $lengths[$i+1][$j+1] = $lengths[$i][$j] + 1;
            }
            else{
                $lengths[$i+1][$j+1] = $lengths[$i+1][$j] > $lengths[$i][$j+1] ? $lengths[$i+1][$j] : $lengths[$i][$j+1];
            }
        }
    }
    
    $result = '';
    for( $x = $a_len, $y = $b_len; $x != 0 && $y != 0; ) {
        if ($lengths[$x][$y] == $lengths[$x-1][$y]){
            $x--;
        }
        else if ($lengths[$x][$y] == $lengths[$x][$y-1]){
            $y--;
        }
        else {
            $result = $a[$x-1] . $result;
            $x--;
            $y--;
        }
    }
 
    return $result;
}//longest_common_subsequence

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        // echo $line."\n";
                        list($a,$b) = explode(';', $line);
                        
                        // I remove characters which are not in both strings
                        $aa = str_split($a);
                        $bb = str_split($b);
                        
                        $aa_len = count($aa);
                        for($i=0 ; $i < $aa_len ; $i++){
                            if( false === in_array($aa[$i], $bb) ){
                                $aa[$i] = '';
                            }
                        }
                        $bb_len = count($bb);
                        for($j=0 ; $j < $bb_len ; $j++){
                            if( false === in_array($bb[$j], $aa) ){
                                $bb[$j] = '';
                            }
                        }
                        
                        $a = implode('',$aa);
                        $b = implode('',$bb);
                        
                        // echo $a.' '.$b."\n";
                        echo longest_common_subsequence($a,$b)."\n";
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
