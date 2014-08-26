// https://www.codeeval.com/open_challenges/149//
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        
        // 1. Convert a zero based number into a binary form using the following rules: 
        var sequence = line.split(' ');
        var len = sequence.length;
        var binary_str = '';
        for(var i=0;i<len;i+=2){
            var k = sequence[i];
            var v = sequence[i+1];
            
            if( k === '0' ){
                // a) flag "0" means that the following sequence of zeros should be appended to a binary string. 
                binary_str += v;
            }
            else if( k === '00' ){
                // b) flag "00" means that the following sequence of zeroes should be transformed into a sequence of ones and appended to a binary string.
                binary_str += new Array( v.length + 1).join('1');
            }
        }
        
        console.log( parseInt((binary_str + ''),2) );
        
    }
});