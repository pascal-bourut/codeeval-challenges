// https://www.codeeval.com/open_challenges/61/

var message = '012222 1114142503 0313012513 03141418192102 0113 2419182119021713 06131715070119';
var keyed_alphabet = 'BHISOECRTMGWYVALUZDNFJKPQX';

var a = 'A'.charCodeAt(0);
var decoded = '';
// echo $message."\n";
for(var i=0, len = message.length ; i < len ; i+=2 ){
    var c = message[i];
    if( c == ' ' ){
        decoded += ' ';
        i--;
    }
    else{
        var ord = Number(c) * 10 + Number(message[i+1]);
        var chr = String.fromCharCode(a + ord);
        var key = keyed_alphabet.indexOf(chr);
        decoded += String.fromCharCode(a + key);
    }
}

console.log(decoded);
