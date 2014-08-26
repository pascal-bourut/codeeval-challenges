// https://www.codeeval.com/open_challenges/131/

var signs = ['+','-'];

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(' ');
        var digits = tmp[0];
        var pattern = tmp[1] 
        
        for( var s=0; s<2; s++){
            var sign = signs[s];
            var pos = pattern.indexOf(sign);
            if( -1 != pos ){
                var left_operand = Number(digits.substr(0, pos));
                var right_operand = Number(digits.substr(pos));
                /// console.log(left_operand, right_operand);
                if( sign == '+' ){
                    result = left_operand + right_operand;
                }
                else{
                    result = left_operand - right_operand;
                }
                console.log(result);
                break;
            }
        }
    }
});