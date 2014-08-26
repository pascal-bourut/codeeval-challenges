<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/14/

function process($chars, $used = array()){
    $all = array();
    $chars_len = count($chars);
    $used_len = count($used);
    // for each chars
    for( $i=0; $i < $chars_len ; ++$i){
        $char = $chars[$i];
        // if char is not already used
        if( !in_array($char, $used) ){
            if( $used_len == ($chars_len-1) ){
                // if last char, return word
                return implode('', $used).$char;
            }
            else{
                // if I don't have reach the last level => process
                $words = process( $chars, array_merge($used, (array)$char) );
                $all = array_merge($all, (array)$words);
            }
        }
    }//for
    return $all;
}//process

function permut($str){
    $result = '';
    if( $str ){
        $chars = str_split($str);
        // first, I sort the array
        sort($chars);
        // recursive process
        $all = process($chars);
        // join result
        $result = implode(',',$all);
    }
    return $result;
}//permut

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = fgets( $fp );
                    echo permut( trim($line) )."\r\n";
                }//
                fclose( $fp );
            }
            else{
                echo '!fp'."\r\n";
            }
        }
        else{
            echo '!readable'."\r\n";
        }
    }
    else{
        echo '!file_exists'."\r\n";
    }
}
else{
    echo '!argv[1]'."\r\n";
}

exit(0);

?>
