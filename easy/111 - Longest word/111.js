// https://www.codeeval.com/open_challenges/92/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(' ');
        var max = 0;
        var word = '';
        for( var i=0, nb=tmp.length ; i < nb ; i++){
            var len = tmp[i].length;
            if( len > max ){
                word = tmp[i];
                max = len;
            }
        }
        console.log(word);
    }
});