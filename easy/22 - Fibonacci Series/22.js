// // https://www.codeeval.com/open_challenges/22/

function linear_fibo(n){
    var a = 1;
    var b = 2;
    for(var i=1 ; i < (n-1) ; i++){
        var tmp = a + b;
        a = b;
        b = tmp;
    }
    return b;
}

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        if( line == 0 ){
            console.log(0);
        }
        else if( line == 1 ){
            console.log(1);
        }
        else if( line == 2 ){
            console.log(1);
        }
        else{
            console.log( linear_fibo(Number(line)-1) );
        }
    }
});