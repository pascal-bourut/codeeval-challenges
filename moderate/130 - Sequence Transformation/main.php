<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/130/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $trans = array(
                    '0' => 'A+',
                    '1' => '(A+|B+)',
                );
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets( $fp ));
                    if( $line ) {
                        // echo $line."\n";
                        list($binary_seq, $string_seq) = explode(' ', $line);
                        
                        // 1 => (A|B)+
                        // 0 => A+
                        
                        $pattern = strtr($binary_seq, $trans);
                        // ereg ... greedy
                        $result = @ereg('^'.$pattern.'$', $string_seq, $tokens);
                        echo ($result ? 'Yes' : 'No')."\n";
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
