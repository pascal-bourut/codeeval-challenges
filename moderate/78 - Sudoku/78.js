// https://www.codeeval.com/open_challenges/78/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(';');
        var size = tmp[0];
        var data = tmp[1].split(',');
        var all = '';
        for(var i=0;i<size;i++){
            all += (i+1);
        }
        var sqrt = Math.sqrt(size);
        var zones = {};
        for(var i=0, cnt=data.length; i < cnt ; i++){
            var x = i % size;
            var y = Math.floor(i / size);
                            
            var zx = Math.floor(x / sqrt);
            var zy = Math.floor(y / sqrt);
            if( 'undefined' == typeof(zones[zx+''+zy]) ){
                zones[zx+''+zy] = [];
            }   
            zones[zx+''+zy].push(data[i]);
        }
        var valid = true;
        for(var i in zones){
            var zone = zones[i];
            zone.sort();
            var z = zone.join('');
            if( z != all ){
                valid = false;
                break;
            }
        }
        console.log(valid ? 'True' : 'False' );
    }
});