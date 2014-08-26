// https://www.codeeval.com/open_challenges/112/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        
        var tmp = line.split(' : ');
        var numbers = tmp[0].split(' ');
        var swaps = tmp[1].split(', ');
        for( var i=0, nb=swaps.length ; i < nb ; i++){
            var ab = swaps[i].split('-');
            var c = numbers[ab[1]];
            numbers[ab[1]] = numbers[ab[0]];
            numbers[ab[0]] = c;
        }
        console.log(numbers.join(' '));
    }
});