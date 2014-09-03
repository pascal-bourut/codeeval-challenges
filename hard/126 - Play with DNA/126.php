<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/126/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

function segment_cmp($a,$b){
    if( $a[1] == $b[1] ){
        return $a[0] > $b[0];
    }
    else{
        return $a[1] > $b[1];
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
                    if( $line !== '' ){
                        // echo $line."\n";
                        list($segment, $mismatches, $dna) = explode(' ',$line);
                        $dna_len = strlen($dna);
                        $segment_len = strlen($segment);
                        $unsorted = array();
                        for( $i=0, $max = $dna_len - $segment_len ; $i <= $max ; $i++ ){
                            $sub = substr($dna, $i, $segment_len);
                            $dist = levenshtein($segment, $sub);
                            if( $dist <= $mismatches ){
                                $unsorted[] = array($sub, $dist); 
                            }
                        }
                        if( $unsorted ){
                            usort($unsorted, 'segment_cmp');
                            $result = array();
                            for($i=0, $cnt=count($unsorted); $i < $cnt ; $i++){
                                $result[] = $unsorted[$i][0];
                            }
                            echo implode(' ',$result)."\n";
                        }
                        else{
                            echo 'No match'."\n";
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
