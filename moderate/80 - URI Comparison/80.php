<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/80/

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
                        list($a, $b) = explode(';', $line);
                        $urls = array();
                        $urls[] = parse_url($a);
                        $urls[] = parse_url($b);
                        
                        for($i=0;$i<2;$i++){
                            // 1. A port that is empty or not given is equivalent to the default port of 80 
                            $urls[$i]['port'] = isset($urls[$i]['port']) ? $urls[$i]['port'] : 80;
                            // 2. Comparisons of host names MUST be case-insensitive 
                            $urls[$i]['scheme'] = strtolower($urls[$i]['scheme']);
                            // 3. Comparisons of scheme names MUST be case-insensitive 
                            $urls[$i]['host'] = strtolower($urls[$i]['host']);
                            // 4. Characters are equivalent to their % HEX HEX encodings. (Other than typical reserved characters in urls like , / ? : @ & = + $ #)
                            $urls[$i]['path'] = isset($urls[$i]['path']) ? rawurldecode($urls[$i]['path']) : '';
                        }
                        
                        echo ( ( $urls[0] == $urls[1] ) ? 'True' : 'False' ) ."\n";
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
