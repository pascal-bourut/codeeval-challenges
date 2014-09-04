// https://www.codeeval.com/open_challenges/151/

// n + (n-1) + (n-2) + (n-3) + (n-4) + … + 1  >=  100
// n (n+1) / 2  >=  100
// 13.651 => 14

// http://datagenetics.com/blog/july22012/index.html

function get_maximum_floors( eggs, drop_count){
    if (eggs === 0) {
        return 0;
    }
    else{
        var result = 0;
        for (var i = 0; i < drop_count; i++){
            result += get_maximum_floors( eggs - 1, i) + 1;
        }
        return result;
    }
}

function cracking_eggs( eggs, floors){
    var drops_count = 0;
    while (get_maximum_floors(eggs, drops_count) < floors){
        drops_count++;
    }
    return drops_count;
}

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if ( line !== '' ) {
        var tmp = line.split(' ');
        var eggs = Number(tmp[0]);
        var floors = Number(tmp[1]);
        
        var result = cracking_eggs( eggs, floors );
        console.log(result);
    }
});
