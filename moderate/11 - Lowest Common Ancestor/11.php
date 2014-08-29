<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/11/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $ancestors = array(
                    '29' => array('29','20','8','30'),
                    '10' => array('10','20','8','30'),
                    '20' => array('20','8','30'),
                    '3' => array('3','8','30'),
                    '8' => array('8','30'),
                    '52' => array('52','30'),
                    '30' => array('30')
                );
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        list($a,$b) = explode(' ',$line);
                        $a_ancestors = $ancestors[$a];
                        $b_ancestors = $ancestors[$b];
                        
                        for($i = 0, $cnt = count($a_ancestors) ; $i < $cnt ; $i++){
                            $a_ancestor = $a_ancestors[$i];
                            if( false !== array_search($a_ancestor,$b_ancestors) ){
                                echo $a_ancestor."\n";
                                break;
                            }
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
