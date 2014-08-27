// https://www.codeeval.com/open_challenges/41/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        
        var tmp = line.split(';');
        var size = Number(tmp[0]);
        var data = tmp[1].split(',');
        var duplicates = new Array(size+1).join('0').split('');
        var i = size;
        while(i--){
            var d = data[i];
            if( duplicates[d] !== '0' ){
                console.log(d);
                break;
            }
            else{
                duplicates[d] = 1;
            }
        }
    }
});