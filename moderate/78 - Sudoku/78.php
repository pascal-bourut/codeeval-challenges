<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/78/

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
                        list($size,$data) = explode(';',$line);
                        $data = explode(',',$data);
                        // print_r($data);
                        $all = '';
                        for($i=0;$i<$size;$i++){
                            $all .= ($i+1);
                        }
                        $sqrt = sqrt($size);
                        $zones = array();
                        for($i=0, $cnt=count($data); $i < $cnt ; $i++){
                            $x = $i % $size;
                            $y = floor($i / $size);
                            
                            $zx = floor($x / $sqrt);
                            $zy = floor($y / $sqrt);
                            $zones[$zx.$zy][] = $data[$i];
                        }
                        $valid = true;
                        foreach($zones as $zone){
                            sort($zone);
                            $z = implode('',$zone);
                            if( $z != $all ){
                                $valid = false;
                                break;
                            }
                        }
                        echo ( $valid ? 'True' : 'False' ) ."\n";
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
