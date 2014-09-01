// https://www.codeeval.com/open_challenges/54/

var bills_coins = {
    'ONE HUNDRED': 10000,
    'FIFTY': 5000,
    'TWENTY': 2000,
    'TEN': 1000,
    'FIVE': 500,
    'TWO': 200,
    'ONE': 100,
    'HALF DOLLAR': 50,
    'QUARTER': 25,
    'DIME': 10,
    'NICKEL': 5,
    'PENNY': 1
};

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(';');
        
        var pp = Number(tmp[0]) * 100;
        var ch = Number(tmp[1]) * 100;
        var result = null;
        if( ch < pp ){
            result = 'ERROR';
        }
        else if( ch == pp ){
            result = 'ZERO';
        }
        else{
            var diff = ch - pp;
            result = [];

            for( var k in bills_coins ){
                var v = bills_coins[k];
                if( diff >= v ){
                    var cnt = Math.floor(diff / v);
                    // console.log(cnt);
                    for(var i=0 ; i < cnt ; i++){
                        result.push( k );
                    }
                    diff -= cnt * v;
                    diff = Math.round(diff);
                    if( diff===0 ) break;
                }
            }      
            result = result.join(',');
        }
        console.log(result);
    }
});