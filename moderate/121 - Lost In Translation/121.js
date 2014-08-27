// https://www.codeeval.com/open_challenges/121/

var from = 'rbc vjnmkf kd yxyqci na rbc zjkfoscdd ew rbc ujllmcp tc rbkso rbyr ejp mysljylc kd kxveddknmc re jsicpdrysi de kr kd eoya kw aej icfkici re zjkr';
var to = 'the public is amazed by the quickness of the juggler we think that our language is impossible to understand so it is okay if you decided to quit';
var trans = {};
var i = from.length;
while(i--){
    trans[ from[ i ] ] = to[ i ];
}
trans.g = 'v';
trans.h = 'x';

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        line = line.split('');
        var i = line.length;
        while(i--){
            line[i] = trans[line[i]];
        }
        console.log( line.join('') );
    }
});