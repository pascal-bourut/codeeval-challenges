// https://www.codeeval.com/open_challenges/11/

/*   30
    |
  ____
  |   |
  8   52
  |
____
|   |
3  20
    |
   ____
  |   |
  10 29
*/

var ancestors = {
    '29': ['29','20','8','30'],
    '10': ['10','20','8','30'],
    '20': ['20','8','30'],
    '3': ['3','8','30'],
    '8': ['8','30'],
    '52': ['52','30'],
    '30': ['30']
};

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(' ');
        var a_ancestors = ancestors[tmp[0]];
        var b_ancestors = ancestors[tmp[1]];
        for(var i = 0, cnt = a_ancestors.length ; i < cnt ; i++){
            var a_ancestor = a_ancestors[i];
            if( -1 !== b_ancestors.indexOf(a_ancestor) ){
                console.log( a_ancestor );
                break;
            }
        }
    }
});