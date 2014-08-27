<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/68/

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
                        $i = strlen($line);
                        $opening_chars = array('(' => 0, '{' => 1, '[' => 2 );
                        $closing_chars = array(')' => 0, '}' => 1, ']' => 2 );
                        $stack = array();
                        $valid = true;
                        while($i--){
                            $c = $line[$i];
                            if( isset($closing_chars[$c]) ){
                                array_push($stack, $closing_chars[$c]);
                            }
                            else{ 
                                $type = $opening_chars[$c];
                                $last = array_pop($stack);
                                
                                if( $type != $last ){
                                    $valid = false;
                                    break;
                                }
                            }
                        }
                        echo ( ( (count($stack) == 0) && $valid ) ? 'True' : 'False' ) . "\n"; 
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
