// https://www.codeeval.com/open_challenges/71/
var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        
        var tmp = line.split(';');
        var data = tmp[0].split(',');
        var k = Number(tmp[1]);
        
        for( var i=0, cnt = data.length ; i <= cnt-k ; i += k ){
            var inverted = data.slice(i, i+k).reverse();
            for( var j=i; j < i+k ; j++){
                data[j] = inverted[j-i];
            }
        }
        console.log(data.join(','));
    }
});