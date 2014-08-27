// https://www.codeeval.com/open_challenges/66/

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var depth = Number(line);
        var old = [1];
        var result = '1';
        for(var i=1; i < depth ; i++){
            var current = [];
            result += ' 1';
            current.push( 1 );
            for(var j=0; j < i-1 ; j++){
                var v = (old[j] + ( 'undefined' !== typeof(old[j+1]) ? old[j+1] : 0 ) );
                result += ' ' + v;
                current.push( v );
            }
            result += ' 1';
            current.push( 1 );
                            
            old = current;
        }
        console.log( result );
    }
});