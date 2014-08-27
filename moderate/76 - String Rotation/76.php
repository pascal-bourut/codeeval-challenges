<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/76/

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
                        list($a, $b) = explode(',', $line);
                        $offset = 0;
                        $ok = false;
                        while( false !== ( $pos = strpos($b, $a[0], $offset) ) ){
                            $start = substr($b, $pos);
                            $end = substr($b, 0, $pos);
                            if( $a == $start.$end ){
                                $ok = true;
                            }
                            $offset = $pos + 1;
                        }//
                        echo ($ok ? 'True' : 'False') . "\n";
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
