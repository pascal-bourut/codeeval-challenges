<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/115/

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
                        $all = explode(',', $line);
                        $words = array();
                        $digits = array();
                        
                        for( $i=0, $cnt=count($all) ; $i < $cnt ; $i++ ){
                            if( is_numeric($all[$i]) ){
                                $digits[] = $all[$i];
                            }
                            else{
                                $words[] = $all[$i];
                            }
                        }
                        $words = implode(',',$words);
                        $digits = implode(',',$digits);
                        echo $words.($words&&$digits ? '|' : '').$digits."\n";
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
