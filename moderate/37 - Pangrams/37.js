// https://www.codeeval.com/open_challenges/37/

var a = 'a'.charCodeAt(0);
var z = 'z'.charCodeAt(0);

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        line = line.toLowerCase();
        var letters = {};
        for(var i=a; i<=z; i++){
            letters[String.fromCharCode(i)] = true;
        }
        var j = line.length;
        while(j--){
            letters[ line[j] ] = false;
        }
        var result = '';
        for( var k in letters ){
            if( letters[k] ){
                result += k;
            }
        }
        console.log( result ? result : 'NULL' );
    }
});