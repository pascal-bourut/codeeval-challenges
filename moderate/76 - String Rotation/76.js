// https://www.codeeval.com/open_challenges/76/
var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(',');
        var a = tmp[0];
        var b = tmp[1];
        
        var offset = 0;
        var ok = false;
        while( -1 !== ( pos = b.indexOf(a[0], offset) ) ){
            var start = b.substr( pos );
            var end = b.substr(0, pos);
            if( a == start+end ){
                ok = true;
            }
            offset = pos + 1;
        }//
        console.log( ok ? 'True' : 'False');
    }
});