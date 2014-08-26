// https://www.codeeval.com/open_challenges/103/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var numbers = line.split(' ');
        var cnt = numbers.length;
        var unique = {};
        for( var i = 0 ; i < cnt ; i++ ){
            if( 'undefined' === typeof(unique[numbers[i]]) ){
                unique[numbers[i]] = 0;
            }
            unique[numbers[i]]++;
        }
        
        for( var number in unique ){
            if( unique[number] != 1 ){
                delete unique[number];
            }
        } 

        var keys = Object.keys( unique );
        keys.sort( function(a,b){return a-b;} );
        
        var winner = line.indexOf(keys[0]);
        console.log( -1 == winner ? 0 : winner/2+1 );
    }
});
