<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/131/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $signs = array('+','-');
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets( $fp ));
                    if( $line ) {
                        
                        list($digits, $pattern) = explode(' ', $line);
                        // echo $digits.' '.$pattern."\n";
                        for($s=0; $s<2; $s++){
                            $sign = $signs[$s];
                            $pos = strpos($pattern, $sign);
                            if( false !== $pos ){
                                $left_operand = substr($digits, 0, $pos);
                                $right_operand = substr($digits, $pos);
                                // echo $left_operand.' '.$sign.' '.$right_operand."\n";
                                if( $sign == '+' ){
                                    $result = bcadd($left_operand,$right_operand);
                                }
                                else{
                                    $result = bcsub($left_operand,$right_operand);
                                }
                                echo $result."\n";
                                break;
                            }
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

exit(0);

?>
