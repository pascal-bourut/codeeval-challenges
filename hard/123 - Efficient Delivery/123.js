// https://www.codeeval.com/open_challenges/123/
var solutions = null;
var min_diff = 0;

function efficient_delivery( tankers, idx, oil, allocation){
    
    if( oil > 0 ){
        var capacity = tankers[idx];
        var nb = tankers.length;
        var last_tanker = false;
        if( capacity ){
            var cnt = Math.floor(oil / capacity);
            var rest = oil%capacity;
            
            if( idx == (nb-1) ){
                last_tanker = true;
                
                if( rest === 0 ){
                    allocation[idx] = cnt;
                    oil = 0;
                }
                else{
                    oil -= cnt * capacity;
                }
            }
            else{
                for(var i = 0; i <= cnt ; i++ ){
                    
                    var new_allocation = [];
                    for( var a in allocation){
                        new_allocation[a] = allocation[a];
                    }
                    new_allocation[idx] = i;
                    efficient_delivery(tankers, idx + 1, oil - i * capacity, new_allocation);
                }
            }
        }
        
        if( last_tanker && oil>0 ){
            
            // no more tankers available
            // amount of oil left < amount possible on a tanker
            var diff = Number.POSITIVE_INFINITY;
            for( var t in tankers ){
                if( oil < tankers[t] ){
                    diff = tankers[t] - oil;
                }
            }
            if( diff < min_diff ){
                min_diff = diff;
            }
            // console.log(min_diff);
        }
    }
    
    if( oil === 0 ){
        // oil = 0
        // ok
        allocation.reverse();
        solutions.push( allocation.join(',') );
    }    
}



function solution_cmp(a,b){
    a = a.split(',');
    b = b.split(',');
    var aa = '';
    var bb = '';
    for(var i=0, cnt=a.length ; i < cnt ; i++){
        aa += new Array(5 - a[i].length).join('0') + a[i];
        bb += new Array(5 - b[i].length).join('0') + b[i];
    }
    return aa > bb ? 1 : -1;
}


var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        // console.log(line);
        var tmp = line.split(', ');
        var tankers = tmp[0];
        var oil = Number(tmp[1]);
        tankers = tankers.substr(1,tankers.length-2).split(',').reverse();
        
        min_diff = oil - 1;
        solutions = [];
        
        for(var i=0, cnt=tankers.length; i < cnt ; i++){
            tankers[i] = Number(tankers[i]);
        }
        
        efficient_delivery( tankers, 0, oil, new Array( tankers.length + 1 ).join('0').split('') );
        var result = '';
        if( solutions.length ){
            solutions.sort(solution_cmp);
            for(var s=0, max=solutions.length; s < max ; s++){
                result += '[' + solutions[s] + ']';
            }
        }
        else{
            result = min_diff;
        }
        console.log(result);
    }
});