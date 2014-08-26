// https://www.codeeval.com/open_challenges/59/


var trans = [
    ['0'],
    ['1'],
    ['a','b','c'],
    ['d','e','f'],
    ['g','h','i'],
    ['j','k','l'],
    ['m','n','o'],
    ['p','q','r','s'],
    ['t','u','v'],
    ['w','x','y','z']
];

var words = [];

var phone_to_word = function(str, idx, histo ){
    
    if( 'undefined' !== typeof(str[idx]) ){
        var c = str[idx];
        var letters = trans[c];
        for(var i=0, cnt=letters.length ; i < cnt ; i++){
            phone_to_word(str, idx+1, histo + letters[i]);
        }
    }
    else{
        words.push( histo );
    }
};


var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        words = [];
        phone_to_word( line, 0, '');
        console.log( words.join(',') );
    }
});