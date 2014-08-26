<?php
header('Content-Type: text/plain; charset=utf-8');

bcscale(10);
    
// https://www.codeeval.com/open_challenges/94/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

function exponent($a, $b){
    return bcpow( $a, $b );
}
function multiply($a, $b){
    return bcmul($a, $b);
}
function divide($a, $b){
    if( $b == 0 ) return 'ERR';
    return bcdiv($a,$b);
}
function add($a, $b){
    return bcadd($a,$b);
}
function subtract($a, $b){
    return bcsub($a, $b);
}



function calc( $str ){
    $float = '(-?\d+(?:\.\d+)?(?:E\-?\d+)?)';
    
    // exponent
    // echo '-> 1: '.$str."\n";
    while( preg_match('/'.$float.'\s?([\^])\s?'.$float.'/', $str, $tokens) ){
        $result = exponent($tokens[1], $tokens[3]); 
        $str = str_replace($tokens[0], $result, $str);
    }
    // echo '<- 1: '.$str."\n";
    
    // echo '-> 2: '.$str."\n";
    // multiply/divide
    while( preg_match('/'.$float.'\s?([*\/])\s?'.$float.'/', $str, $tokens) ){
        if( $tokens[2] == '*' ){
            $result = multiply($tokens[1], $tokens[3]); 
        }
        else if( $tokens[2] == '/' ){
            $result = divide($tokens[1], $tokens[3]); 
        }
        $str = str_replace($tokens[0], $result, $str);
        // echo '<-- 2: '.$str."\n";
    }
    // echo '<- 2: '.$str."\n";
    
    // echo '-> 3: '.$str."\n";
    // add/substract
    while( preg_match('/'.$float.'\s?([+-])\s?'.$float.'/', $str, $tokens) ){
        if( $tokens[2] == '+' ){
            $result = add($tokens[1], $tokens[3]); 
        }
        else if( $tokens[2] == '-' ){
            $result = subtract($tokens[1], $tokens[3]); 
        }
        $str = str_replace($tokens[0], $result, $str);
    }
    // echo '<- 3: '.$str."\n";
    
    // double-minus
    $str = str_replace('--','',$str);
    
    return $str;
}

// 

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line !== '' ){
                        // echo '-> ' . $line . "\n";
                        // eval( "\$check = $line;" );
                        
                        while( preg_match('/\(([^\)\(]+)\)/', $line, $tokens) ){
                            $result = calc($tokens[1]);
                            $line = str_replace($tokens[0], $result, $line);
                        }
                        // echo '<- '. $line . "\n";
                        $result = calc($line);
                        
                        // scientific notation to decimal
                        // 2.0E-5 => 0.00002
                        $result = rtrim(rtrim(sprintf('%.5f', $result),'0'),'.');
                        echo $result."\n";
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