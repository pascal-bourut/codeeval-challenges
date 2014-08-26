// https://www.codeeval.com/open_challenges/102/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var json = JSON.parse(line);
        var items = json.menu.items;
        var sum = 0;
        var i = items.length;
        while(i--){
            if( items[i] && items[i].label ){
                sum += items[i].id;
            }
        }
        console.log(sum);
    }
});