// https://www.codeeval.com/open_challenges/12/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        for(var i=0, len=line.length; i < len; i++){
            var c = line.charAt(i);
            if( -1 == line.indexOf( c,i+1 ) && -1 == line.substr(0,i).indexOf(c)){
                console.log(c);
                break;
            }
        }
    }
});