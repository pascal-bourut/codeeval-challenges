// https://www.codeeval.com/open_challenges/97/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        
        var tmp = line.split('| ');
        var letters = tmp[0].split('');
        var keys = tmp[1].split(' ');
        var result = '';
        for( var i=0, nb=keys.length ; i < nb ; i++){
            result += letters[keys[i]-1];
        }
        console.log(result);
    }
});