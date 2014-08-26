// https://www.codeeval.com/open_challenges/39/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        
        var n = line;
        var seen = {};
        do{
            var new_n = 0;
            n = '' + n;
            for( var i=0, cnt=n.length ; i < cnt; i++){
                var c = Number(n.charAt(i));
                new_n += c*c;
            }
            n = new_n;
            if( 'undefined' === typeof(seen[n]) ){
                seen[n] = false;
            }
            else{
                seen[n] = true;
            }
        }
        while( n != 1 && !seen[n] );
        console.log( n == 1 ? 1 : 0 );
    }
});