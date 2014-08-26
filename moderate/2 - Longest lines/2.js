// https://www.codeeval.com/open_challenges/2/

var lines = [];
var count = false;

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        if( count === false ){
            count = Number(line);
        }
        else{
            lines.push(line);
        }
    }
});


lines.sort(function(a,b){return b.length-a.length;});
for(var i=0;i<count;i++){
    console.log(lines[i]);
};
