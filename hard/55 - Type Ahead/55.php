<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/55/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

$text = 'Mary had a little lamb its fleece was white as snow;
And everywhere that Mary went, the lamb was sure to go.
It followed her to school one day, which was against the rule;
It made the children laugh and play, to see a lamb at school.
And so the teacher turned it out, but still it lingered near,
And waited patiently about till Mary did appear.
"Why does the lamb love Mary so?" the eager children cry; "Why, Mary loves the lamb, you know" the teacher did reply."';

$words = preg_split("/\s+/",trim(preg_replace('/[^A-Za-z ]/',' ', $text)));
$cnt = count($words);

function cmp($a,$b){
    if( $a['v'] == $b['v'] ){
        return $a['k'] < $b['k'] ? -1 : 1;
    }
    else{
        return $b['v'] - $a['v'];
    }
}

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        list($n, $user_words) = explode(',', $line); 
                        // echo $user_words."\n";
                        $next = array();
                        $user_words = explode(' ',$user_words);
                        $keys = array_keys($words, $user_words[0]);
                        for($i=0, $cnt=count($keys);$i < $cnt ; $i++){
                            $ok = true;
                            for($j=1 ; $j < $n-1 ; $j++){
                                $ok &= ( $user_words[$j] == $words[$keys[$i]+$j] );
                            }
                            if( $ok ){
                                if( !isset($next[ $words[$keys[$i]+$n-1] ]) ){
                                    $next[ $words[$keys[$i]+$n-1] ] = 0;
                                }
                                $next[ $words[$keys[$i]+$n-1] ]++;
                            }
                        }
                        
                        $total = array_sum($next);
                        $tmp = array();
                        foreach($next as $k => $v){
                            $tmp[] = array('k'=>$k,'v'=>$v);
                        }
                        usort($tmp, 'cmp');
                        
                        $result = array();
                        for($i=0, $cnt=count($tmp); $i < $cnt ; $i++){
                            $result[] = $tmp[$i]['k'].','.number_format($tmp[$i]['v'] / $total,3,'.','');
                        }
                        echo implode(';',$result)."\n";
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
