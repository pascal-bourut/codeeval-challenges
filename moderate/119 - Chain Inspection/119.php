<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/119/

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
                        // echo $line."\n";
                        $pairs = array();
                        $tmp = preg_split('/[;\-]/', $line);
                        $i = count($tmp);
                        $max = $i / 2;
                        while( ($i = $i-2)>=0 ){
                            $pairs[ $tmp[$i] ] = $tmp[$i+1];
                        }
                        
                        $i = 0;
                        $step = 'BEGIN';
                        do{
                            $step = $pairs[$step];
                            $i++;
                        }
                        while( $step != 'END' && $i <= $max );
                       
                        echo ( ( 'END' == $step ) && ( $i == $max ) ? 'GOOD' : 'BAD' ) . "\n";
                        
                        unset($pairs);
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
