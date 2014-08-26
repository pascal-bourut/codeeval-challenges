// https://www.codeeval.com/open_challenges/23/

var max = 12;

/*
Print out the table in a matrix like fashion, each number formatted to a width of 4 
(The numbers are right-aligned and strip out leading/trailing spaces on each line). The first 3 line will look like:
*/

for(var i=1 ; i <= max ; ++i){
    var line = '';
    for(var j=1 ; j <= max ; ++j){
        var nb = i * j; 
        if( j > 1){
            var k = 4 - (nb+'').length;
            while(k--){
                line += ' ';
            }
        }
        line += nb;
    }
    console.log(line);
}
