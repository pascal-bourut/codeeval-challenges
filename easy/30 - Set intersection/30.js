// https://www.codeeval.com/open_challenges/29/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        
        var tmp = line.split(';');
        var a = tmp[0].split(',');
        var b = tmp[1].split(',');
        
        var c = [];
        for(var i=0, nb=a.length ; i<nb ; i++){
            var t = a[i];
            if( b.indexOf(t) != -1 ){
                c.push(t);
            }
        }
        console.log(c.join(','));
    }
});