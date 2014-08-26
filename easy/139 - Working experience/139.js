// https://www.codeeval.com/open_challenges/139/


var months = {
    'Jan': 1,
    'Feb': 2,
    'Mar': 3,
    'Apr': 4,
    'May': 5,
    'Jun': 6,
    'Jul': 7,
    'Aug': 8,
    'Sep': 9,
    'Oct': 10,
    'Nov': 11,
    'Dec': 12
};


var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var experiences = line.split('; ');
        var xp = {};
        var total = 0;
        for(var i=0, cnt=experiences.length; i < cnt ; i++){
            var tmp = experiences[i].split('-');
            var from_mY = tmp[0].split(' ');
            var to_mY = tmp[1].split(' ');
            var begin = (from_mY[1] - 1990) * 12 + months[from_mY[0]];
            var end = (to_mY[1] - 1990) * 12 + months[to_mY[0]];
            for( var j = begin ; j <= end ; j++ ){
                if( 'undefined' === typeof(xp[j]) ){
                    total++;
                    xp[j] = true;
                }
            }
        }
        console.log( Math.floor(total / 12) );
    }
});
