// https://www.codeeval.com/open_challenges/120/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var buildings = line.split('(').join('').split(')').join(',').split(';');
        var len = buildings.length;
        var height_at_x = {};
        var i = len;
        var min = 10001;
        var max = 0;
        while(i--){
            var building = buildings[i];
            var tmp = building.trim().split(',');
            var xmin = Number(tmp[0]);
            var xmax = Number(tmp[2]);
            var h = Number(tmp[1]);
            for( var x = xmin ; x < xmax ; x++ ){
                if( 'undefined' === typeof(height_at_x[x]) || (h > height_at_x[x]) ){
                    height_at_x[x] = h;
                }
            }
            if( xmin < min ) min = xmin;
            if( xmax > max ) max = xmax;
        }
        
        var result = '';
        var old_h = 0;
        max = max + 1;
        for( var i = min ; i <= max ; i++){
            var h = ('undefined' !== typeof(height_at_x[i])) ? height_at_x[i] : 0;
            if( h != old_h ){
                result += i + ' ' + h + ' ';
                old_h = h;
            }
        }

        console.log(result);
    }
});