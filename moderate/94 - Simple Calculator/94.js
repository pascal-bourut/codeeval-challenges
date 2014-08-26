// https://www.codeeval.com/open_challenges/94/

/*
function exponent(a, b){
    return Math.pow(a,b);
}
function multiply(a, b){
    return a * b;
}
function divide(a, b){
    if( b === 0 ) return 'ERR';
    return a / b;
}
function add(a, b){
    a = parseFloat(a);
    b = parseFloat(b);
    return a + b;
}
function subtract(a, b){
    return a - b;
}
*/

function calc(str){
    // var float = '(-?\d+(?:\.\d+)?(?:E\-?\d+)?)';
    
    var tokens = null;
    
    // special case: HACK ?
    // before: X^Y / X^Z    
    // after: X^(Y-Z)
    // eg: 
    // before: 6^5/6^2
    // adfter: 6^3
    
    if( null !== (tokens = str.match(/(-?\d+(?:\.\d+)?(?:e\-?\d+)?)\s?([\^])\s?(-?\d+(?:\.\d+)?(?:e\-?\d+)?)\s?([\/])\s?(-?\d+(?:\.\d+)?(?:e\-?\d+)?)\s?([\^])\s?(-?\d+(?:\.\d+)?(?:e\-?\d+)?)/) ) ){
        if( tokens[1] == tokens[5] ){
            var a = tokens[1];
            var b = tokens[3] - tokens[7];
            str = str.replace(tokens[0], a+'^'+b );
        }
    }
    
    
    // exponent
    while( null !== (tokens = str.match(/(-?\d+(?:\.\d+)?(?:e\-?\d+)?)\s?([\^])\s?(-?\d+(?:\.\d+)?(?:e\-?\d+)?)/)) ){
        // console.log(str);
        // var result = Mexponent( tokens[1], tokens[3] );
        var result = Math.pow( tokens[1], tokens[3] );
        str = str.replace(tokens[0], result);
        // console.log(str);
    }
    
    // multiply/divide
    
    while( null !== (tokens = str.match(/(-?\d+(?:\.\d+)?(?:e\-?\d+)?)\s?([*\/])\s?(-?\d+(?:\.\d+)?(?:e\-?\d+)?)/)) ){
        var result = 0;
        if( tokens[2] == '*' ){
            // result = multiply(tokens[1], tokens[3]); 
            result = tokens[1] * tokens[3];
        }
        else if( tokens[2] == '/' ){
            // result = divide(tokens[1], tokens[3]); 
            result = tokens[1] / tokens[3];
        }
        str = str.replace(tokens[0], result);
    }
    
    // add/substract
    while( null !== (tokens = str.match(/(-?\d+(?:\.\d+)?(?:e\-?\d+)?)\s?([+-])\s?(-?\d+(?:\.\d+)?(?:e\-?\d+)?)/)) ){
        var result = 0;
        if( tokens[2] == '+' ){
            // result = add(tokens[1], tokens[3]); 
            result = parseFloat(tokens[1]) + parseFloat(tokens[3]);
        }
        else if( tokens[2] == '-' ){
            // result = subtract(tokens[1], tokens[3]); 
            result = tokens[1] - tokens[3];
        }
        str = str.replace(tokens[0], result);
    }
    
    // double-minus
    str = str.replace('--', '');
    if( str == '-0' ){
        str = '0';
    }
    
    return str;
}

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var result = 0;
        // console.log(line);
        var tokens = null;
        while( null !== (tokens = line.match(/\(([^\)\(]+)\)/) ) ){
            result = calc(tokens[1]);
            line = line.replace(tokens[0], result); 
        } 
        
        result = calc( line );
        
        // scientific notation to decimal
        // 2.0E-5 => 0.00002
        // $result = rtrim(rtrim(sprintf('%.5f', $result),'0'),'.');
        result = parseFloat(result).toFixed(5) - 0;
        // result = Math.round( result * 10000 ) / 100000;
        console.log(result);
    }
});