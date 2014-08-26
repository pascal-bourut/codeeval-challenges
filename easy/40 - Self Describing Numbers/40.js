// https://www.codeeval.com/open_challenges/40/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var len = line.length;
        var counts = new Array( 10 ).join('0').split('');
        for(var i=0; i < len ; i++){
            counts[ Number(line.charAt(i)) ]++;
        }
        var is_sd = true;
        for(var i=0; (i < len) && is_sd; i++){
            is_sd = is_sd && (counts[i] == Number(line.charAt(i)));
        }
        console.log(is_sd ? 1 : 0);
        
    }
});