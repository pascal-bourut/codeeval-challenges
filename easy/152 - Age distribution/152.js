
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
        var age = Number( line );
        var out = '';
        if( age < 0 || age > 100 ){
            out = 'This program is for humans';
        }
        else{
            for(var category in categories ){
                var age_max = categories[category];
                if( age <= age_max ) {
                    out = category;
                }
                else{
                    break;
                }
            }
        }
        console.log(out);
    }
});