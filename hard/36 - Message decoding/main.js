function decbin(number) {
    if (number < 0) {
        number = 0xFFFFFFFF + number + 1;
    }
    return parseInt(number, 10).toString(2);
}

function bindec(binary_string) {
    binary_string = (binary_string + '').replace(/[^01]/gi, '');
    return parseInt(binary_string, 2);
}


// message = header+pattern
// 0,00,01,10,000,001,010,011,100,101,110,0000,0001,. . .,1011,1110,00000, . . . 
// 1 => len 1 (first = 0, next + 1) 2-1
// 3 => len 2                       4-4
// 7 => len 3                       8-1
// 15 => len 4                      16-1
// 
var keys = {};
var j = 0;
for( var len = 1 ; len <= 7 ; len++ ){
    var cnt = Math.pow(2, len) - 1;
    for( var i = 0 ; i < cnt ; i++ ){
        if( 'undefined' === typeof(keys[len]) ){
            keys[len] = {};
        }

        // str_pad( decbin( i ), len,'0', 'STR_PAD_LEFT')
        var b = decbin(i);
        var blen = b.length;
        if( blen < len ){
            b = new Array( len-blen+1 ).join('0') + b;
        }
        keys[ len ][ b ] = (j++);
    }
} 


var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        
        // encoded message = 0 1 \r
        // message = x segments
        // segment = BBB  => segment key length
        // 010 => LN => 2 => keys of length 2 (00,01,10)
        // segment ends with  LN 1
        // whole message ends with 000
        line = line.replace('\r','');
        
        var tokens
        if( tokens = line.match(/^([^0-1]+)([0-1]+)000$/) ){
            var header_str = tokens[1];
            var content_str = tokens[2];
            // console.log(header_str, content_str);
            var content = [],
                header = [];
            var i = content_str.length;
            while(i--){
                content[i] = content_str.charAt(i);
            }
            i = header_str.length;
            while(i--){
                header[i] = header_str.charAt(i);
            }
            var max = content.length;
            
            var eos = ''; // end of segment
            var segment_header = '';
            var key_len = 0;
            var in_segment = false;
            var decoded = '';
            for( i = 0 ; i < max ; ){
                if( in_segment ){
                    var buf = '';
                    for( var j = 0 ; j < key_len ; j++ ){
                        buf += content[ i + j ];
                    }
                    if( buf == eos ){
                        // end of segment
                        in_segment = false;
                    }
                    else{
                        decoded += header[ keys[ key_len ][ buf ] ];
                    }
                                    
                    i += key_len;
                }
                else{
                    segment_header = content[ i ] + content[ i + 1 ] + content[ i + 2 ];
                    key_len = bindec(segment_header);
                    in_segment = true;
                    eos = new Array( key_len + 1).join('1'); // str_repeat
                    i += 3;
                }
            }
            console.log(decoded);
            
        }
    }
});
