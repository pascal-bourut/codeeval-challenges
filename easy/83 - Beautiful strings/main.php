<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/83/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets( $fp ));
                    if( $line ) {
                        $line = strtolower($line);
                        $chars = count_chars($line, 1);
                        $orda = ord('a');
                        $ordz = ord('z');
                        arsort($chars);
                        // print_r($chars);
                        $note = 26;
                        $total = 0;
                        foreach($chars as $k => $v){
                            if( $k >= $orda && $k <= $ordz ){
                                $total += $note * $v;
                                $note--;
                            }
                        }
                        echo $total."\n";
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
