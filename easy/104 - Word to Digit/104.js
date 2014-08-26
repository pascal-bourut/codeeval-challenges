// https://www.codeeval.com/open_challenges/104/

var trans = {
    'zero': '0',
    'one': '1',
    'two': '2',
    'three': '3',
    'four': '4',
    'five': '5',
    'six': '6',
    'seven': '7',
    'eight': '8',
    'nine': '9',
};
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var words = line.split(';');
        var numbers = '';
        for(var i=0, nb=words.length ; i < nb ; i++){
            numbers += trans[words[i]];
        }
        console.log(numbers);
    }
});