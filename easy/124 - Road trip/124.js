// https://www.codeeval.com/open_challenges/124/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var cities = line.split(';');
        var i = cities.length - 1;
        var distances = [];
        while(i--){
            var tmp = cities[i].split(',');
            distances.push( Number(tmp[1]) );
        }
        distances.sort(function(a,b){return a-b;});
        
        var current = 0;
        var result = [];
        for(var i=0, nb=distances.length ; i < nb ; i++){
            result.push( distances[i] - current );
            current = distances[i];
        }
        console.log( result.join(',') );
    }
});