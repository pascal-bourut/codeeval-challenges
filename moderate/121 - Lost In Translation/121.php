<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/121/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                
                $from = 'rbc vjnmkf kd yxyqci na rbc zjkfoscdd ew rbc ujllmcp tc rbkso rbyr ejp mysljylc kd kxveddknmc re jsicpdrysi de kr kd eoya kw aej icfkici re zjkr';
                $to = 'the public is amazed by the quickness of the juggler we think that our language is impossible to understand so it is okay if you decided to quit';
                $trans = array();
                $i = strlen($from);
                while($i--){
                    $trans[ $from[$i] ] = $to[$i];
                }
                $trans['g'] = 'v';
                $trans['h'] = 'x';
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                       echo strtr($line, $trans)."\n";
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
