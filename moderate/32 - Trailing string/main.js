var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(',');
        var str = tmp[0];
        var trim = tmp[1];
        console.log ( (str.substr(-trim.length,trim.length) == trim) ? '1': '0' );
    }
});
