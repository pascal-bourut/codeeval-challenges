var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var sep = line.indexOf(' ');
        var n = line.substr(0, sep);
        var sequence = line.substr(sep+1).split(' ');
        var prev = false;
        var jolly = true;
        if( n != '1' ){
            var i = parseInt(n);
        
            var all = new Array( i + 1 ).join('0').split('');
            while(i--){
                var d = sequence[i];
                if( prev !== false ){
                    var diff = Math.abs(Math.floor(prev - d));
                    if( (diff < 1) || (diff > (n-1)) || all[diff]===true ){
                        jolly = false;
                        break;
                    }
                    all[diff] = true;
                }
                prev = d;
            }
        }
        console.log( jolly ? 'Jolly' : 'Not jolly' );
    }
});
