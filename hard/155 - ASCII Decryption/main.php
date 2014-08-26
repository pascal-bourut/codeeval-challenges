<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/browse/155/
function decrypt( $line ){
    $decrypted = '';
    
    list($length, $last_letter, $encrypted) = explode(' | ', $line);

    $last_letter_ord = ord($last_letter);
    
    // first, I look for all identical words with length=$length
    $encrypted_letters = explode(' ', $encrypted);
    $count = count($encrypted_letters);
    $stack = array();
    $candidates = array();
    for($i = 0 ; $i < $count ; ++$i){
        array_push($stack, $encrypted_letters[$i]);
        
        if( count($stack) > $length ){
            array_shift($stack);
        }
        if( count($stack) == $length ){
            $word = implode(' ', $stack);
            $substr_count = substr_count($encrypted, $word);
            if( $substr_count == 2 ){
                $candidates[] = array(
                    'prev' => isset($encrypted_letters[$i - $length]) ? $encrypted_letters[$i - $length] : true,
                    'word' => $word,
                    'next' => isset($encrypted_letters[$i + 1])  ? $encrypted_letters[$i + 1] : true
                );
            }
        }
    }
    
    // For each word I found, I try to decrypt the letter before and after it based on its last_letter to determine a possible condition n
    // letter before and after should be a space 
    // if not, it's not an acceptable "word"
    $conditions = array();
    foreach($candidates as $candidate){
        $word = $candidate['word'];
        $letters = explode(' ',$word);
        $letters_count = count($letters);
        $candidate_last_letter_ord = $letters[$letters_count-1];
        $ord_delta = $candidate_last_letter_ord - $last_letter_ord;
        
        $prev = $candidate['prev'];
        $next = $candidate['next'];
        
        if( $prev !== true ){
            $prev = (' ' === chr( $prev - $ord_delta) );
        }
        if( $next !== true ){
            $next = (' ' === chr( $next - $ord_delta) );
        }
        
        if( $prev && $next ){
            $conditions[] = $ord_delta;
        }
    }
    
    // I found some potentials conditions values
    // a last test to be sure I only have 1 identical word and so, one condition
    if( count($conditions) == 2 && ($conditions[0] == $conditions[1]) ){
        $condition = $conditions[0];
        // ok! I can decrypt now!
        for( $i = 0 ; $i < $count ; ++$i ){
            // sub condition and chr
            $decrypted .= chr($encrypted_letters[$i] - $condition);
        }
    }//
    
    return $decrypted;
}//decrypt


if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                while ( $fp && !feof( $fp ) ) {
                    $line = fgets( $fp );
                    echo decrypt($line)."\r\n";
                }//
                fclose( $fp );
            }
            else{
                echo '!fp'."\r\n";
            }
        }
        else{
            echo '!readable'."\r\n";
        }
    }
    else{
        echo '!file_exists'."\r\n";
    }
}
else{
    echo '!argv[1]'."\r\n";
}

exit(0);

?>
