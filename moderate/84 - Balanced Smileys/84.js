// https://www.codeeval.com/open_challenges/84/

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        
        var min_open = 0;
        var max_open = 0;
        
        for(var i=0, len = line.length ; i < len ;i++){
            var c = line[ i ];
            if( c == '(' ){
                // opening parenthesis (or maybe second char of a frowny face)
                max_open++;
                if( i===0 || line[i-1] != ':' ){
                    // first character or doesn't form a smiley with the previous character
                    min_open++;
                }
            }
            else if( c==')' ){
                // closing parenthesis (or maybe second char of a smiley face)
                if( min_open > 0 ){
                    min_open--;
                }
                
                if( i===0 || line[i-1] != ':' ){
                    // first character or doesn't form a smiley with the previous character 
                    max_open--;
                }
                
                if( max_open < 0 ){
                    // closing parenthesis with not opening one
                    break;
                }
                
            }
        }
        //
        console.log( (max_open>=0 && min_open===0) ? 'YES' : 'NO' );
    }
});
