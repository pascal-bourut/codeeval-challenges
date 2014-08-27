// https://www.codeeval.com/open_challenges/68/
var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var i = line.length;
        var opening_chars = {'(': 0, '{': 1, '[': 2 };
        var closing_chars = {')': 0, '}': 1, ']': 2 };
        var stack = [];
        var valid = true;
        while( i-- ){   
            var c = line[i];
            if( 'undefined' !== typeof(closing_chars[c]) ){
                stack.push( closing_chars[c] );
            }
            else{ 
                type = opening_chars[c];
                var last = stack.pop();
                                
                if( type != last ){
                    valid = false;
                    break;
                }
            }
        }
        console.log( ((stack.length === 0) && valid) ? 'True' : 'False' );
    }
});