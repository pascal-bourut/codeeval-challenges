<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/7/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        $operators = array();
                        $digits = array();
                        
                        $tokens = explode(' ',$line);
                        for($i=0, $cnt = count($tokens); $i < $cnt ; $i++){
                            $token = $tokens[$i];
                            if( $token == '+' || $token == '*' || $token == '/' ){
                                $operators[] = $token;
                            }
                            else{
                                $digits[] = $token;
                            }
                        }
                        $cnt = count($operators);
                        $i = $cnt;
                        $j = 0;
                        $result = $digits[0];
                        while($i--){
                            $j++;
                            switch($operators[$i]){
                                case '+':
                                $result += $digits[$j];
                                break;
                                case '*':
                                $result *= $digits[$j];
                                break;
                                case '/':
                                $result /= $digits[$j];
                                break;
                            }//
                        }//
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
