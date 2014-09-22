// https://www.codeeval.com/open_challenges/114/

function package_problem(size, curr, max, things, total_value, total_weight, selected, current_selection ){
    var result = [];
    if ( curr == max ){
        // last item
        var value = 0;
        var weight = 0;
        for(var i=0 ; i < curr ; i++){
            if( current_selection[i] == 1 ){
                value += things[i][2];
                weight += things[i][1];
            }
        }
        
        if ( (weight < size) && (value > total_value || (value == total_value && weight < total_weight)) ){
            // better solution now (greater value, or same value but less weight)
            result = [value,weight,current_selection];
        }
        else{
            // keeping old selection
            result = [total_value,total_weight,selected];
        }
    }
    else{
        // first option: without this item
        var n = null;
        var new_selection = [];
        for(n in current_selection){
            new_selection[n] = current_selection[n];
        }
        new_selection[curr] = 0;
        result = package_problem(size, curr+1, max, things, total_value, total_weight, selected, new_selection );
        
        
        // then: with this item
        new_selection = [];
        for(n in current_selection){
            new_selection[n] = current_selection[n];
        }
        new_selection[curr] = 1;
        result = package_problem(size, curr+1, max, things, result[0], result[1], result[2], new_selection );
    }
    return result;
}

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(' : ');
        var size = Number(tmp[0]);
        var str = tmp[1];
        
        var things = [];
        var matches = str.split(/[\(\)\,\$]+/);
        
        for(var i=1, len=matches.length; i < len ; i+=4 ){
            things.push([
                matches[i],
                Number(matches[i+1]),
                Number(matches[i+2])
            ]);
        }
        /*
        things.sort(function(a,b){
            if( a[1] == b[1] ){
                return b[2] - a[2];
            }
            return a[1] - b[1];
        });
        */
        var cnt = things.length;
        
        var result = package_problem( size, 0, cnt, things, 0, Number.POSITIVE_INFINITY, new Array(cnt+1).join('0').split(''), new Array(cnt+1).join('0').split('') );
        if( result[1]>0 && result[1] <= size ){
            var ids = [];
            for(var s=0 ; s < cnt ; s++){
                if( result[2][s] == 1 ){
                    ids.push( things[s][0] );
                }
            }
            // ids.sort(function(a,b){return a-b;});
            console.log( ids.join(',') );
        }
        else{
            console.log( '-' );
        }
    }
});