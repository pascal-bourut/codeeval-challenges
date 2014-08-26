<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/39/

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
                        $n = $line;
                        $seen = array();
                        do{
                            $new_n = 0;
                            $n = ''.$n;
                            for($i=0, $cnt = strlen($n) ; $i < $cnt ; $i++){
                                $new_n += $n[$i] * $n[$i];
                            }
                            $n = $new_n;
                            if( !isset($seen[$n]) ){
                                $seen[$n] = 0;
                            }
                            else{
                                $seen[$n]++;
                            }
                        }
                        while( ($n != 1) && (!$seen[$n]) );
                        echo ( $n == 1 ? 1 : 0 )."\n";
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
