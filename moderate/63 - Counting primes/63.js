// https://www.codeeval.com/open_challenges/63/


function sieve_of_aktin( start, limit ){
    var limitSqrt = Math.sqrt(limit);
    var sieve = [];
    var n;
    
    sieve[2] = limit >= 2;
    sieve[3] = limit >= 3;
 
    for (var x = 1; x <= limitSqrt; x++) {
        var xx = x * x;
        for (var y = 1; y <= limitSqrt; y++) {
            var yy = y * y;
            if (xx + yy >= limit) {
                break;
            }
            // first quadratic using m = 12 and r in R1 = {r : 1, 5}
            n = (4 * xx) + (yy);
            
            if (n <= limit && (n % 12 == 1 || n % 12 == 5)) {
                sieve[n] = !sieve[n];
            }
            // second quadratic using m = 12 and r in R2 = {r : 7}
            n = (3 * xx) + (yy);
            if (n <= limit && (n % 12 == 7)) {
                sieve[n] = !sieve[n];
            }
            // third quadratic using m = 12 and r in R3 = {r : 11}
            n = (3 * xx) - (yy);
            if (x > y && n <= limit && (n % 12 == 11)) {
                sieve[n] = !sieve[n];
            }
        }
    }
 
    // false each primes multiples
    for (n = 5; n <= limitSqrt; n++) {
        if (sieve[n]) {
            x = n * n;
            for (var i = x; i <= limit; i += x) {
                sieve[i] = false;
            }
        }
    }
    
    //primes values are the one which sieve[x] = true
    var max = sieve.length;
    var count = 0;
    for( n = start ; n <= max ; n++ ){
        if( sieve[n] ){
            count++;
        }   
    }
    
    return count;
}

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(',');
        var n  = Number(tmp[0]);
        var m = Number(tmp[1]);
        console.log( sieve_of_aktin(n, m) );
    }
});