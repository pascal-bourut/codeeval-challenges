<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/128/

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
                        $numbers = explode(' ',$line);
                        $result = array();
                        $prev = false;
                        $count = 0;
                        for($i=0, $cnt=count($numbers);$i<$cnt;$i++){
                            $current = $numbers[$i];
                            if( $current === $prev ){
                                $count++;
                            }
                            else{
                                if( $prev !== false ){
                                    $result[] = $count;
                                    $result[] = $prev;
                                    $count = 0;
                                }
                                $count++;
                            }
                            $prev = $current;
                        }
                        if( $count ){
                            $result[] = $count;
                            $result[] = $prev;
                        }
                            
                        echo implode(' ',$result)."\n";
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
