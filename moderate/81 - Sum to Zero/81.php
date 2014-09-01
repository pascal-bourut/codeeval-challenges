<?php
header('Content-Type: text/plain; charset=utf-8');
// https://www.codeeval.com/open_challenges/81/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line !== '' ){
                        $numbers = explode(',',$line);
                        $cnt = count($numbers);
                        
                        $count = 0;
                        for($i=0; $i < $cnt ; $i++){
                            for($j=$i+1; $j < $cnt ; $j++){
                                for($k=$j+1; $k < $cnt ; $k++){
                                    for($l=$k+1; $l < $cnt ; $l++){
                                        if( ( $numbers[$i] + $numbers[$j] + $numbers[$k] + $numbers[$l] )===0 ){
                                            $count++;                
                                        }
                                    }
                                }
                            }
                        }
                        echo $count."\n";
                    }//
                    
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
