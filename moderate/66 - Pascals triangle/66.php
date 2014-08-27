<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/66/
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
                        $depth = $line;
                        
                        $old = array(1);
                        $result = '1';
                        for($i=1; $i < $depth ; $i++){
                            $current = array();
                            $result .= ' 1';
                            $current[] = 1;
                            for($j=0; $j < $i-1 ; $j++){
                                $v = ($old[$j] + ( isset($old[$j+1]) ? $old[$j+1] : 0 ) );
                                $result .= ' '.$v;
                                $current[] = $v;
                            }
                            $result .= ' 1';
                            $current[] = 1;
                            
                            $old = $current;
                        }
                        echo $result."\n";
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
