<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/87/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                $cols = 256;
                $rows = 256;
                $board = array();
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        $query = explode(' ',$line);
                        switch($query[0]){
                            case 'SetCol': 
                            for($i=0; $i<$rows; $i++){
                                $board[$query[1] + $i * $cols] = $query[2];
                            }
                            break;
                            case 'SetRow': 
                            for($i=0; $i<$cols; $i++){
                                $board[$query[1] * $rows + $i] = $query[2];
                            }
                            break;
                            case 'QueryCol': 
                            $sum = 0;
                            for($i=0; $i<$rows; $i++){
                                $sum +=  isset($board[$query[1] + $i * $cols]) ? $board[$query[1] + $i * $cols] : 0;
                            }
                            echo $sum."\n";
                            break;
                            case 'QueryRow': 
                            $sum = 0;
                            for($i=0; $i<$cols; $i++){
                                $sum +=  isset($board[$query[1] * $rows + $i]) ? $board[$query[1] * $rows + $i] : 0;
                            }
                            echo $sum."\n";
                            break;
                        }
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
