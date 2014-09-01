// https://www.codeeval.com/open_challenges/81/
var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var numbers = line.split(',');
        
        var count = 0;
        var cnt = numbers.length;
        var i = cnt;
        while(i--){
            numbers[i] = Number(numbers[i]);
        }
        for(var i=0; i < cnt ; i++){
            for(var j=i+1; j < cnt ; j++){
                for(var k=j+1; k < cnt ; k++){
                    for(var l=k+1; l < cnt ; l++){
                        // console.log(numbers[i],numbers[j],numbers[k],numbers[l]);
                        if( ( numbers[i] + numbers[j] + numbers[k] + numbers[l] )===0 ){
                            // console.log('++');
                            count++;                
                        }
                    }
                }
            }
        }
        console.log(count);
    }
});