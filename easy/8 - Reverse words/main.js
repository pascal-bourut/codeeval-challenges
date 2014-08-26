var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var words = line.split(' ');
        console.log( words.reverse().join(' ').trim() );
    }
});
