<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/54/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $bills_coins = array(
                    'ONE HUNDRED' => 10000,
                    'FIFTY' => 5000,
                    'TWENTY' => 2000,
                    'TEN' => 1000,
                    'FIVE' => 500,
                    'TWO' => 200,
                    'ONE' => 100,
                    'HALF DOLLAR' => 50,
                    'QUARTER' => 25,
                    'DIME' => 10,
                    'NICKEL' => 5,
                    'PENNY' => 1
                );
                
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        list($pp, $ch) = explode(';', $line);
                        $pp = $pp * 100;
                        $ch = $ch * 100;
                        if( $ch < $pp ){
                            $result = 'ERROR';
                        }
                        else if( $ch == $pp ){
                            $result = 'ZERO';
                        }
                        else{
                            $diff = $ch - $pp;
                            $result = array();
                            
                            foreach( $bills_coins as $k => $v ){
                                if( $diff >= $v ){
                                    $cnt = floor($diff / $v);
                                    $result = array_merge( $result, array_fill(0,$cnt,$k) );
                                    $diff -= $cnt * $v;
                                    $diff = round($diff);
                                    if($diff==0) break;
                                }
                            }            
                            $result = implode(',',$result);
                        }
                        echo $result."\n";
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
