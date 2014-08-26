
// https://www.codeeval.com/open_challenges/152/

var categories = {
    "The Golden Years": 100,
    "Working for the man": 65,
    "College": 22,
    "High school": 18,
    "Middle school": 14,
    "Elementary school": 11,
    "Preschool Maniac": 4,
    "Still in Mama's arms": 2
}


var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(',');
        var n = Number(tmp[0]);
        var m = Number(tmp[1]);
        var people = [];
        for(var i=0; i<n ; i++){
            people[i] = true;
        }
        var next = (m - 1);
        var killings = '';
        for( var i = 0 ; i < n ; i++){
            if( next == i ){
                if( killings != '' ){
                    killings += ' ';
                }
                killings += i;
                people[i] = false;
                                
                k = m;
                for( var j=0; j < n*m ; j++ ){
                    var idx = (i + j) % n;
                    if( people[idx] ){
                        if( --k == 0 ){
                            next = idx;
                            i = -1;
                            break;
                        }
                    }
                }   
            }
        }
        console.log( killings );
    }
});