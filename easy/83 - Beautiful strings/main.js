// https://www.codeeval.com/open_challenges/83/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        line = line.toLowerCase();
        var az = 'az';
        var orda = az.charCodeAt(0);
        var ordz = az.charCodeAt(1);
        var total = 0;
        
        var len = line.length;
        var i = len;
        var chars = {};
        while(i--){
            var c = line.charCodeAt(i);
            if( c >= orda && c <= ordz ){
                if( 'undefined' === typeof(chars[c]) ){
                    chars[c] = 0;
                }
                chars[c]++;
            }
        }
        
        var arr = [];
        for (var c in chars) {
            arr.push( chars[c] );
        }
        arr.sort(function(a,b){
            return a-b;
        });
        var note = 26;
        len = arr.length;
        i = len;
        while(i--){
            total += note * arr[i];
            note--;
        }
        
        console.log( total );
    }
});