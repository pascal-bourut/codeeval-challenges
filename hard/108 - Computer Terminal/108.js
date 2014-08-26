// https://www.codeeval.com/open_challenges/108/


var inputs = '';
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        inputs += line;
    }
});

var rows = 10;
var cols = 10;
// init terminal, cursor 0x0, insert mode false (overwrite mode when first turn on)
var terminal = {};
for( var y = 0 ; y < rows ; y++ ){
    terminal[ y ] = {};
    for( var x = 0 ; x < cols ; x++ ){
        terminal[ y ][ x ] = ' ';
    }
}
var cursor_x = 0;
var cursor_y = 0;
var insert_mode = false;

for( var i = 0 , len = inputs.length ; i < len ; i++ ){
    var input = inputs.charAt(i);
    var character = '';
    if( input == '^' ){
        i++;
        var special = inputs.charAt(i);
        switch( special ){
            case 'c' : 
            // ^c - clear the entire screen; the cursor row and column do not change 
           for( var y = 0 ; y < rows ; y++ ){
                terminal[ y ] = {};
                for( var x = 0 ; x < cols ; x++ ){
                    terminal[ y ][ x ] = ' ';
                }
            }
            break;
            case 'h' : 
            // ^h - move the cursor to row 0, column 0; the image on the screen is not changed
            cursor_x = 0;
            cursor_y = 0;
            break;                            
            case 'b' : 
            // ^b - move the cursor to the beginning of the current line; the cursor row does not change 
            cursor_x = 0;
            break;
            case 'd' : 
            // ^d - move the cursor down one row if possible; the cursor column does not change 
            if( cursor_y < (rows-1) ) cursor_y++;
            break;
            case 'u' : 
            // ^u - move the cursor up one row, if possible; the cursor column does not change 
            if( cursor_y>0 ) cursor_y--;
            break;
            case 'l' : 
            // ^l - move the cursor left one column, if possible; the cursor row does not change 
            if( cursor_x>0 ) cursor_x--;
            break;
            case 'r' : 
            // ^r - move the cursor right one column, if possible; the cursor row does not change 
            if( cursor_x < (cols-1) ) cursor_x++;
            break;
            case 'e' : 
            // ^e - erase characters to the right of, and including, the cursor column on the cursor's row; the cursor row and column do not change
            for(var x = cursor_x; x < cols ; x++){
                terminal[cursor_y][x] = '';
            }
            break;
            case 'i' : 
            // ^i - enter insert mode 
            insert_mode = true;
            break;
            case 'o' : 
            // ^o - enter overwrite mode 
            insert_mode = false;
            break;
            case '^' : 
            // ^^ - write a circumflex (^) at the current cursor location, exactly as if it was not a special character; this is subject to the actions of the current mode (insert or overwrite) 
            character = '^';
            break;
            default : 
            // ^DD - move the cursor to the row and column specified; each D represents a decimal digit; the first D represents the new row number, and the second D represents the new column number_format 
            cursor_y = Number(special);
            i++;
            cursor_x = Number(inputs.charAt(i));
            break;
        }//


    }//
    else{
        character = input;
    }

    if( character ){
        // When a normal character (not part of a control sequence) arrives at the terminal, it is displayed on the terminal screen in a manner that depends on the terminal mode. 
        if( !insert_mode ){
            // When the terminal is in overwrite mode (as it is when it is first turned on), the received character replaces the character at the cursor's location. 
            terminal[cursor_y][cursor_x] = character;
        }
        else{
            // But when the terminal is in insert mode, the characters to the right of and including the cursor's location are shifted right one column,
            for(var x = cols - 1 ; x > cursor_x ; x--){
                terminal[cursor_y][x] = terminal[cursor_y][x-1];
            }
            terminal[cursor_y][cursor_x] = character;
            // and the new character is placed at the cursor's location; the character previously in the rightmost column of the cursor's row is lost. 
        }

        // Regardless of the mode, the cursor is moved right one column, if possible.
        if( cursor_x < (cols-1) ) cursor_x++;
    }

}

// console.log(terminal);

var output = '';
for( var y = 0 ; y < rows ; y++ ){
     for( var x = 0 ; x < cols ; x++ ){
         output += terminal[ y ][ x ];
     }
    output += "\n";
}
console.log(output);