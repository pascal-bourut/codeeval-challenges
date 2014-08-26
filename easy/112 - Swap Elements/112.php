<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/112/

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
                        // 1 2 3 4 5 6 7 8 9 : 0-8
                        // 1 2 3 4 5 6 7 8 9 10 : 0-1, 1-3
                        // echo str_replace('-',' ',str_replace(' ','',str_replace('  ','-',strtr($line, $trans))))."\n";
                        list($numbers, $swaps) = explode(' : ', $line);
                        $numbers = explode(' ',$numbers);
                        $swaps = explode(', ',$swaps);
                        for($i=0, $cnt=count($swaps) ; $i < $cnt ; $i++){
                            list($a,$b) = explode('-', $swaps[$i]);
                            $c = $numbers[$b];
                            $numbers[$b] = $numbers[$a];
                            $numbers[$a] = $c;
                        }
                        echo implode(' ',$numbers)."\n";
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
