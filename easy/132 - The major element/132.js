// https://www.codeeval.com/open_challenges/132/


var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var numbers = line.split(',');
        var count = {};
        var nb = numbers.length;
        var i = nb;
        while(i--){
            if( 'undefined' == typeof(count[numbers[i]]) ){
                count[numbers[i]] = 0;
            }
            count[numbers[i]]++;
        }
        
        var count_arr = [];
        for( var n in count ){
            count_arr.push({'n':n,'count': count[n]}); 
        }
        delete count;
        count_arr.sort(function(a,b){
            return b.count - a.count;
        });
        
        var times = count_arr[0].count;
        var number = count_arr[0].n;
        if( times > nb/2 ){
            console.log(number);
        }
        else{
            console.log('None');
        }
    }
});