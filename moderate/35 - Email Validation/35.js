// https://www.codeeval.com/open_challenges/35/

var regexp = new RegExp(/^(("[^"]+")|([A-Za-z0-9._%+-]+))@[A-Za-z0-9.-]+\.[A-Za-z]+$/);

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        console.log( regexp.test(line)?'true':'false' );
    }
});