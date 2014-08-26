// https://www.codeeval.com/open_challenges/89/

var levels = [];
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var numbers = line.split(' ');
        var i = numbers.length;
        while(i--){
            numbers[i] = Number(numbers[i]);
        }
        levels.push( numbers );
    }
});

var i = levels.length - 1;
while( i-- ){
    var level = levels[i];
    var bottom_level = levels[i+1];
    // replace each numbers of this level by the sum of it and max(adjacent left, adjacent right)
    for(var j=0, nb = level.length ; j < nb ; j++){
        var l = bottom_level[j];
        var r = bottom_level[j+1];
        levels[i][j] += l>r?l:r;
    }
}
console.log(levels[0][0]);