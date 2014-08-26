<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/58/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

$word_list = array();
function find_friends($word, $friends = array() ){
    global $word_list;
    
    $len = strlen($word);
    // echo '$word: ' . $word . "\n";
    
    $new_friends = array();
    
    for( $l = $len-1; $l <= $len+1; $l++){
        if( isset($word_list[$l]) ){
            $list = $word_list[$l];
            $j = count($list);
            while($j--){
                $friend = $list[$j];
                if ( !isset($friends[$friend]) ){
                    $d = levenshtein($word, $friend);
                    if( $d == 1 ){
                        $new_friends[$friend] = true;
                        $friends[$friend] = true;
                    }
                }
            }
        }
    }//
    
    foreach($new_friends as $friend => $null){
        $friends = find_friends( $friend, $friends );
    }
    
    return $friends;
}//


if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $words = array();
                $word_list = array();
                $eoi = false;
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        
                        if( $eoi ){
                            $len = strlen($line);
                            if( !isset($word_list[$len]) ){
                                $word_list[$len] = array();
                            }
                            $word_list[$len][] = $line;
                        }   
                        elseif( $line=='END OF INPUT' ){
                            $eoi = true;
                        }
                        else{
                            $words[] = $line;
                        }
                    }
                }//
                
                for($i=0, $cnt=count($words) ; $i < $cnt ; $i++){
                    $total = count(find_friends($words[$i]));
                    echo ($total ? $total : 1) . "\n";
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
