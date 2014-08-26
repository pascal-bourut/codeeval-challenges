// https://www.codeeval.com/open_challenges/156/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var len = line.length;
        for(var i=1 ; i <= len ; i++){
            if( ( len%i) == 0 ){
                var sub = line.substr(0, i);
                var nb = len/i;
                var j = nb;
                var control = '';
                while(j--){
                    control += sub;
                }
                if( control == line ){
                    console.log(i);
                    break;
                }
            }
        }
    }
});