// https://www.codeeval.com/open_challenges/85/
var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(',');
        var n = Number(tmp[0]);
        var k = Number(tmp[1]);
        var a = Number(tmp[2]);
        var b = Number(tmp[3]);
        var c = Number(tmp[4]);
        var r = Number(tmp[5]);
        
        var i = 0;
        var m = [];
        m[0] = a;
        for( i = 1; i < k ; i++){
            m.push( ( b * m[i-1] + c ) % r );
        }

        for( i = k; i < n ; i++){
            var sub = m.slice( i-k , i );
            var min = 0;
            while( -1 != sub.indexOf(min) ){
                min++;
            }
            m.push( min );
        }//

        console.log(m[n-1]);
    }
});