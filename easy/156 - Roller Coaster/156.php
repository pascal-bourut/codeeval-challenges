<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/156/

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
                        
                        $line = strtolower($line);                
                        $len = strlen($line);
                        $newline = '';
                        $upper = true;
                        $min = ord('a');
                        $max = ord('z');
                        for($i=0 ; $i < $len ; $i++){
                            $char = $line[$i];
                            $ord = ord($char);
                            if( $ord >= $min && $ord <= $max ){
                                if( $upper ){
                                    $char = strtoupper($char);
                                }
                                $upper = !$upper;
                            }
                            $newline .= $char;
                        }
                        echo $newline."\n";
                    
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
