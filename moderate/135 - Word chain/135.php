<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/135/

function word_chain($nodes, $key, $used = array(), $max = 0 ){
    // echo $key.' '.var_export($used, true) . "\n";
    if( isset($nodes[$key]) ){
        $new_max = $max;
        for($i=0, $cnt = count($nodes[$key]) ; $i < $cnt ; $i++){
            $word = $nodes[$key][$i];
            if( !isset($used[$word]) ){
                $next_used = $used;
                $next_used[$word] = true;
                $m = word_chain( $nodes, substr($word,-1,1), $next_used, $max + 1);
                if( $m > $new_max ){
                    $new_max = $m;
                }
            }
        }
        $max = $new_max;
    }
    return $max;
}

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
                        $max = 0;
                        
                        $nodes = array();
                        
                        $words = explode(',', $line);
                        $len = count($words);
                        $i = $len;
                        while($i--){
                            $word = $words[$i];
                            if( !isset($nodes[$word[0]]) ){
                                $nodes[$word[0]] = array();
                            }
                            $nodes[ $word[0] ][] = $word;
                        }
                        
                        // print_r($nodes);
                        
                        $keys = array_keys($nodes);
                        $i = count($keys);
                        while($i--){
                            $result = word_chain( $nodes, $keys[$i] );
                            if( $result > $max ){
                                $max = $result;
                            }
                        }
                        // echo $max."\n";
                        echo /*$line.': '.*/( ( $max > 1 ) ? $max : 'None' ). "\n";
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
