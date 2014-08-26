// https://www.codeeval.com/open_challenges/116/

var trans = {
    '.-': 'A',
  '-...': 'B',
  '-.-.': 'C',
  '-..': 'D',
  '.': 'E',
  '..-.': 'F',
  '--.': 'G',
  '....': 'H',
  '..': 'I',
  '.---': 'J',
  '-.-': 'K',
  '.-..': 'L',
  '--': 'M',
  '-.': 'N',
  '---': 'O',
  '.--.': 'P',
  '--.-': 'Q',
  '.-.': 'R',
  '...': 'S',
  '-': 'T',
  '..-': 'U',
  '...-': 'V',
  '.--': 'W',
  '-..-': 'X',
  '-.--': 'Y',
  '--..': 'Z',
  '-----': 0,
  '.----': 1,
  '..---': 2,
  '...--': 3,
  '....-': 4,
  '.....': 5,
  '-....': 6,
  '--...': 7,
  '---..': 8,
  '----.': 9,
  '': ' ',
};
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var coded = line.split(' ');
        var decoded = '';
        for(var i=0, nb=coded.length ; i < nb ; i++){
            decoded += trans[coded[i]];
        }
        console.log(decoded);
    }
});