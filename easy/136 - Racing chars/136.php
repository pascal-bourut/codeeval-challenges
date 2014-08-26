<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/136/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                $old_pos = false;
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        $pos = strpos($line, 'C');
                        if( $pos === false ){
                            $pos = strpos($line, '_');
                        }
                        if( $old_pos === false || $pos == $old_pos ){
                            $way = '|';
                            
                        }
                        else if( $pos < $old_pos ){
                            $way = '/';
                        }
                        else if( $pos > $old_pos ){
                            $way = '\\';
                        }
                        $line[$pos] = $way;
                        $old_pos = $pos;
                        echo $line."\n";
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
