<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/153/

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
                        list($n, $m) = explode(' ', $line);
                        // echo $line."\n";
                        $unlocked = $n;
                        if( $m == 1 ){
                            $unlocked -= 1;
                        }
                        else{
                            // There are "n" unlocked rooms located in a row along a long corridor.
                            $locks = 0; 
                            // m-1 passes
                            for( $j = 1 ; $j <= $n ; $j++ ){
                                $div2 = $j%2 == 0;
                                $div3 = $j%3 == 0;
                                $lock = false;
                                if( $div2 && $div3 ){
                                    // 0
                                }
                                else if( $div2 ){
                                    $lock = true;
                                }
                                else if( $div3 ){
                                    if( ($m-1)%2!=0 ){
                                        $lock = true;
                                    }
                                }
                                
                                if( $j == $n ){
                                    // last pass (switch lock)
                                    $lock = !$lock;
                                }
                                
                                if( $lock ){
                                    $locks++;
                                }
                            }
                            $unlocked -= $locks;
                        }
                        
                        echo $unlocked."\n";
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
