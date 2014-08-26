// https://www.codeeval.com/open_challenges/50/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        
        var tmp = line.split(';');
        var str = tmp[0];
        var sub = tmp[1].split(',');
        var replaced = {};
        var first = 'a'.charCodeAt(0);
        for(var i=0,cnt=sub.length;i<cnt;i+=2){
            var replacement = String.fromCharCode(first + Object.keys(replaced).length);
            replaced[ replacement ] = sub[i + 1];
            str = str.split( sub[i] ).join(replacement);
        }//
        for(var k in replaced){
            str = str.split(k).join(replaced[k]);
        }
        console.log(str);
        
    }
});