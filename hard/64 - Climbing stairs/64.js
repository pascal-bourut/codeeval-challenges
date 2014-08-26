// https://www.codeeval.com/open_challenges/156/

function add_large_positive_number(a, b){
    var a = String(a);
    var b = String(b);
    var answer = '';
    var carry = 0;
    var zeros = 0;
    var i = 0;
    var max = 0;
       
    if (a.length> b.length){
        max = a.length;
        zeros = max - b.length;
        for (i = 0 ; i < zeros ; i++) {
            b = "0" + b;
        }
    }
    else if (b.length>  a.length){
        max = b.length;
        zeros = max - a.length;
        for (i = 0 ; i<zeros ; i++) {
            a = "0" + a  ;
        }
    }
    else{
        // a and b have same number of digets
        max = a.length;  
    }
       
    // add each character starting with the last (max - 1),
    // carry the 1 if the sum has a length of 2
    for (i = max - 1 ;  i> -1 ; i--){
        var sum = String( Number(a.charAt(i)) + Number(b.charAt(i)) + carry);
        if (sum.length == 2){
            answer = sum.charAt(1) + answer;
            carry = 1;
        }
        else{
            carry = 0;
            answer = sum + answer;
        }
    }
    if (carry == 1){
        answer = 1 + answer;
    }
    return answer;
}

function linear_fibo(n){
    var a = 1;
    var b = 2;
    var tmp = 0;
    for(var i=1 ; i < (n-1) ; i++){
        tmp = add_large_positive_number(a, b);
        a = b;
        b = tmp;
    }
    return tmp;
}

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var stairs = Number(line);
        var total = ( stairs <= 1 ) ? stairs : linear_fibo( stairs );
        console.log(total);
    }
});