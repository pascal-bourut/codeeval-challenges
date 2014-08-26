<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/57/

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
                        $result = '';
                        list($rows, $cols, $data) = explode(';',$line);
                        $data = explode(' ', $data);
                        
                        $xmin = 0;
                        $ymin = 0;
                        $xmax = $cols-1;
                        $ymax = $rows-1;
                        $direction = 0;
                        $steps = $xmax - $xmin;
                        $x = -1;
                        $y = 0;
                        for($i=0, $len = $rows*$cols; $i < $len ; $i++){
                            
                            switch($direction){
                                case 0 : // left-to-right
                                    $x++;
                                    if( $steps == 0 ){
                                        $direction = 1;
                                        $ymin++;
                                        $steps = $ymax - $ymin + 1;
                                    }
                                    break;
                                case 1 : // top-to-bottom
                                    $y++;
                                    if( $steps == 0 ){
                                        $direction = 2;
                                        $xmax--;
                                        $steps = $xmax - $xmin + 1;
                                    }
                                    break;
                                case 2 : // right-to-left
                                    $x--;
                                    if( $steps == 0 ){
                                        $direction = 3;
                                        $ymax--;
                                        $steps = $ymax - $ymin + 1;
                                    }
                                    break;
                                case 3 : // bottom-to-top
                                    $y--;
                                    if( $steps == 0 ){
                                        $direction = 0;
                                        $xmin++;
                                        $steps = $xmax - $xmin + 1;
                                    }
                                    break;
                            }//
                            
                            $result .= ' '.$data[$y * $cols + $x];
                            $steps--;
                            
                            
                        }//
                        echo trim($result)."\n";
                    }//
                    
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
