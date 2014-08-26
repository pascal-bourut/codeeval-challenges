<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/89/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                $levels = array();
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        $levels[] = explode(' ',$line);
                    }                    
                }//
                fclose( $fp );
                
                $i = count($levels) - 1;
                while($i--){
                    $level = $levels[$i];
                    // replace each numbers of this level by the sum of it and max(adjacent left, adjacent right)
                    for($j=0, $nb = count($level) ; $j < $nb ; $j++){
                        $levels[$i][$j] += max( $levels[$i+1][$j], $levels[$i+1][$j+1]);
                    }
                }
                echo $levels[0][0];
                
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
