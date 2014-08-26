var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(',');
        var str = tmp[0];
        var substr = tmp[1];
        var pattern = substr.replace('\\*','#').replace('*','.*').replace('#','\\*');
        console.log( ( str.match(new RegExp(pattern,'g')) === null ) ? 'false' : 'true' );
    }
});
