// https://www.codeeval.com/open_challenges/70/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(',');
        
        var upper_left_x_a = Number(tmp[0]), 
            upper_left_y_a = Number(tmp[1]), 
            lower_right_x_a = Number(tmp[2]), 
            lower_right_y_a = Number(tmp[3]), 
            upper_left_x_b = Number(tmp[4]), 
            upper_left_y_b = Number(tmp[5]), 
            lower_right_x_b = Number(tmp[6]),  
            lower_right_y_b = Number(tmp[7]);
        
        var intersect = false;
        if( upper_left_x_a > lower_right_x_b || upper_left_x_b > lower_right_x_a ){
            intersect = false;
        }
        else if( upper_left_y_a < lower_right_y_b || upper_left_y_b < lower_right_y_a ){
            intersect = false;
        }
        else{
            intersect = true;
        }
        console.log( intersect ? 'True' : 'False' );
    }
});