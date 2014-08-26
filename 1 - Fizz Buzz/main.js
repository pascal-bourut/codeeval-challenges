var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(' ');
        var a = parseInt(tmp[0]);
        var b = parseInt(tmp[1]);
        var c = parseInt(tmp[2]);
        var n = '';
        for(var i = 1; i <= c ; i++){
            var fb = ((i%a == 0)?'F':'')+((i%b == 0)?'B':'');
            if( fb != '' ){
                n += ' '+fb;
            }
            else{
                n += ' '+i;
            }
        }
        console.log(n.trim());
        
    }
});
