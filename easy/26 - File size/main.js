// https://www.codeeval.com/open_challenges/26/

var fs  = require("fs");
/*
var stats = fs.statSync(process.argv[2]);
var fileSizeInBytes = stats["size"];
console.log(fileSizeInBytes);
*/
fs.stat(process.argv[2], function(err, stat) {
    console.log(stat.size);    
});
