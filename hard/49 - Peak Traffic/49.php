<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/49/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $one_way = array();
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        list($ts, $a, $b) = explode("\t", $line);
                        $one_way[$a][$b] = true;
                    }
                }//
                fclose( $fp );
                
                // print_r($one_way);
                
                $potential_clusters = array();
                foreach($one_way as $k => $v){
                    $cluster = array($k);
                    foreach($v as $kk => $null){
                        $cluster[] = $kk;
                    }
                    if( count($cluster) >= 3 ){
                        sort($cluster);
                        $cluster = implode(', ',$cluster);
                        $potential_clusters[$cluster] = true;
                    }
                }
                // print_r($potential_clusters);
                
                $clusters = array();
                foreach($potential_clusters as $users => $null){
                    $u = explode(', ',$users);
                    $nb = count($u);
                    $score = 0;
                    $max = $nb * ($nb-1);
                    for($i=0;$i<$nb;$i++){
                        for($j=0;$j<$nb;$j++){
                            if( $i != $j ){
                                // echo $u[$i] . ' vs ' . $u[$j] . "\n";
                                if( isset($one_way[ $u[$i] ][ $u[$j] ]) ){
                                    $score++;
                                }
                            }
                        }
                    }
                    if( $score == $max ){
                        $found = false;
                        for($i=0, $nb = count($clusters) ; $i < $nb ; $i++){
                            // no subset
                            $pos = strpos($clusters[$i], $users);
                            if( $pos !== false ){
                                // I found a super-cluster
                                $found = true;
                                break;
                            }
                            
                            $pos = strpos($users, $clusters[$i]);
                            if( $pos !== false ){
                                // I'm a super-cluster !
                                $clusters[$i] = $users;
                                $found = true;
                                break;
                            }
                            
                        }
                        if( !$found ){
                            $clusters[] = $users;
                        }
                    }
                }
                // print_r($clusters);
                sort($clusters);
                // print_r($clusters);
                echo implode("\n", $clusters)."\n";
                
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
