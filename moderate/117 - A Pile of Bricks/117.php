<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/117/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $faces = array(
                     array('w' => array(1,4), 'h' => array(2,5) ), /*front*/
                     array('w' => array(1,4), 'h' => array(3,6) ), /*top*/
                     array('w' => array(3,6), 'h' => array(2,5) ), /*side*/
                );
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        // [-1,-5] [5,-2]|(1 [4,7,8] [2,9,0]);(2 [0,7,1] [5,9,8])   
                        // echo $line."\n";
                        list($hole, $bricks) = explode('|', $line);
                        list($x0, $y0, $x1, $y1) = explode(',',strtr($hole,array('['=>'',']'=>'',' '=>',')));
                        // echo $x0,' ', $y0,' ', $x1,' ', $y1."\n";
                        $hole_w = abs($x0 - $x1);
                        $hole_h = abs($y0 - $y1);
                        
                        // echo 'hole: '.$hole_w.'x'.$hole_h."\n";
                        
                        $pass_through = array();
                        $bricks = explode(';', $bricks);
                        $i = count($bricks);
                        while($i--){
                            // list($idx, $x0, $y0, $z0, $x1,  $y1, $z1)
                            $tmp = explode(',', strtr($bricks[$i],array('('=>'', ')'=>'','['=>'',']'=>'',' '=>',')));
                            $j=3;
                            while($j--){
                                $face_w = abs($tmp[$faces[$j]['w'][0]] - $tmp[$faces[$j]['w'][1]]);
                                $face_h = abs($tmp[$faces[$j]['h'][0]] - $tmp[$faces[$j]['h'][1]]);
                                // echo 'brick face #' . $j . ': ' . $face_w . 'x' . $face_h . "\n";
                                if( ($face_w <= $hole_w && $face_h <= $hole_h)||($face_w <= $hole_h && $face_h <= $hole_w) ){
                                    $pass_through[] = $tmp[0];
                                    break;
                                }
                            }
                        }
                        sort($pass_through);
                        echo ( $pass_through ? implode(',',$pass_through) : '-' ) ."\n";
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
