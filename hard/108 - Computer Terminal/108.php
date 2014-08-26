<?php
header('Content-Type: text/plain; charset=utf-8');

// https://www.codeeval.com/open_challenges/108/

if( isset($_GET['f_i_l_e']) && $_GET['f_i_l_e'] ) $argv[1] = $_GET['f_i_l_e'];

if( isset($argv[1]) && $argv[1] ){
    $filename = $argv[1];
    if( file_exists($filename) ){
        if( is_readable($filename) ){
            $fp = fopen($filename, 'r');
            if( $fp ){
                $inputs = '';
                while ( $fp && !feof( $fp ) ) {
                    $line = trim(fgets($fp));
                    if( $line ){
                        $inputs .= $line;    
                    }
                }//
                
                $rows = 10;
                $cols = 10;
                // init terminal, cursor 0x0, insert mode false (overwrite mode when first turn on)
                $terminal = array();
                for( $y = 0 ; $y < $rows ; $y++ ){
                    $terminal[$y] = array_fill(0, $cols ,' ');
                }
                $cursor_x = 0;
                $cursor_y = 0;
                $insert_mode = false;
                
                for( $i = 0 , $len = strlen($inputs) ; $i < $len ; $i++ ){
                    $input = $inputs[$i];
                    // echo $i.':'.$input.':'."\n";
                    $character = '';
                    if( $input == '^' ){
                        $i++;
                        $special = $inputs[$i];
                        switch($special){
                            case 'c' : 
                            // ^c - clear the entire screen; the cursor row and column do not change 
                            for( $y = 0 ; $y < $rows ; $y++ ){
                                $terminal[$y] = array_fill(0, $cols , ' ');
                            }//
                            break;
                            case 'h' : 
                            // ^h - move the cursor to row 0, column 0; the image on the screen is not changed
                            $cursor_x = 0;
                            $cursor_y = 0;
                            break;                            
                            case 'b' : 
                            // ^b - move the cursor to the beginning of the current line; the cursor row does not change 
                            $cursor_x = 0;
                            break;
                            case 'd' : 
                            // ^d - move the cursor down one row if possible; the cursor column does not change 
                            if( $cursor_y < ($rows-1) ) $cursor_y++;
                            break;
                            case 'u' : 
                            // ^u - move the cursor up one row, if possible; the cursor column does not change 
                            if( $cursor_y>0 ) $cursor_y--;
                            break;
                            case 'l' : 
                            // ^l - move the cursor left one column, if possible; the cursor row does not change 
                            if( $cursor_x>0 ) $cursor_x--;
                            break;
                            case 'r' : 
                            // ^r - move the cursor right one column, if possible; the cursor row does not change 
                            if( $cursor_x < ($cols-1) ) $cursor_x++;
                            break;
                            case 'e' : 
                            // ^e - erase characters to the right of, and including, the cursor column on the cursor's row; the cursor row and column do not change
                            // echo '->'.$cursor_x.','.$cursor_y."\n";
                            for($x = $cursor_x; $x < $cols ; $x++){
                                // echo 'erase('.$x.','.$y.')'."\n";
                                $terminal[$cursor_y][$x] = '';
                            }
                            // echo '<-'.$cursor_x.','.$cursor_y."\n";
                            break;
                            case 'i' : 
                            // ^i - enter insert mode 
                            $insert_mode = true;
                            break;
                            case 'o' : 
                            // ^o - enter overwrite mode 
                            $insert_mode = false;
                            break;
                            case '^' : 
                            // ^^ - write a circumflex (^) at the current cursor location, exactly as if it was not a special character; this is subject to the actions of the current mode (insert or overwrite) 
                            $character = '^';
                            break;
                            default : 
                            // ^DD - move the cursor to the row and column specified; each D represents a decimal digit; the first D represents the new row number, and the second D represents the new column number_format 
                            $cursor_y = $special;
                            $i++;
                            $cursor_x = $inputs[$i];
                            break;
                        }//
                        
                        
                    }//
                    else{
                        $character = $input;
                    }
                    
                    if( $character ){
                        // echo $i.':character: ' .$character."\n";
                        // When a normal character (not part of a control sequence) arrives at the terminal, it is displayed on the terminal screen in a manner that depends on the terminal mode. 
                        if( !$insert_mode ){
                            // When the terminal is in overwrite mode (as it is when it is first turned on), the received character replaces the character at the cursor's location. 
                            $terminal[$cursor_y][$cursor_x] = $character;
                        }
                        else{
                            // But when the terminal is in insert mode, the characters to the right of and including the cursor's location are shifted right one column,
                            for($x = $cols - 1 ; $x > $cursor_x ; $x--){
                                $terminal[$cursor_y][$x] = $terminal[$cursor_y][$x-1];
                            }
                            $terminal[$cursor_y][$cursor_x] = $character;
                            // and the new character is placed at the cursor's location; the character previously in the rightmost column of the cursor's row is lost. 
                        }
                        
                        // Regardless of the mode, the cursor is moved right one column, if possible.
                        if( $cursor_x < ($cols-1) ) $cursor_x++;
                    }
                    
                }
                
                for( $y = 0 ; $y < $rows ; $y++ ){
                    echo implode('', $terminal[$y])."\n";
                }
                
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