// https://www.codeeval.com/open_challenges/45/

String.prototype.reverse = function() {
    var s = this;
    var o = '';
    for (var i = s.length - 1; i >= 0; i--)
        o += s[i];
    return o;
}
/*
function reverse(s) {
  var o = '';
  for (var i = s.length - 1; i >= 0; i--)
    o += s[i];
  return o;
}
*/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var cpt = 0;
        var number = Number(line);
        do{
            number += Number((number+'').reverse());
            cpt++;
        }while( number != (number+'').reverse() );
        console.log(cpt + ' ' + number);
    }
});