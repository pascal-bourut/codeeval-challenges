<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/103/

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
                        $numbers = explode(' ', $line);
                        $cnt = count($numbers);
                        $unique = array();
                        for( $i = 0 ; $i < $cnt ; $i++ ){
                            if( !isset($unique[$numbers[$i]]) ){
                                $unique[$numbers[$i]] = 0;
                            }
                            $unique[$numbers[$i]]++;
                        }
                        foreach( $unique as $number => $cnt){
                            if( $cnt != 1 ){
                                unset($unique[$number]);
                            }
                        } 
                        ksort($unique);
                        $lowest = key($unique);
                        $winner = array_search($lowest, $numbers);
                        echo (false !== $winner ? $winner+1 : 0) . "\n";
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
