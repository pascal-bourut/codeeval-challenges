var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(', ');
        var str = tmp[0];
        var chars = tmp[1];
        var i = chars.length;
        while(i--){
            str = str.split(chars[i]).join('');
        }
        console.log( str.trim() );
    }
});
