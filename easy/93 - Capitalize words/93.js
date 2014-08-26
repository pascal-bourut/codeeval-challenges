// https://www.codeeval.com/open_challenges/93/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var words = line.split(' ');
        var i = words.length;
        while(i--){
            words[i] = words[i].charAt(0).toUpperCase() + words[i].substring(1);
        }
        console.log( words.join(' ') );
    }
});