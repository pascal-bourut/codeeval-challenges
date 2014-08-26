


// https://www.codeeval.com/public_sc/60/

// returns last consecutive number with sum of its digits > N
// e.g.: get_max(19) = 298  (2+9+8=19     next: 299 2+9+9=20)
var get_max = function(n){
    var nines = Math.floor((n+1)/9);
    var rest = (n+1) - nines * 9;
    var max = rest + new Array(nines+1).join('9') - 1;
    return max;
};

// returs sum of digits of N
// digits_sum(298) = 2+9+8 = 19
var digits_sum = function(n){
    if( n == 0 ) return 0;
    if( n < 0 ) n = -n;
    var sum = 0;
    var tab = (n+'').split('');
    var j = tab.length;
    while(j--){
        sum += parseInt(tab[j]);
    }
    return sum;
};


var sum_max = 19;
var max = get_max( sum_max );

var digits_sums = {};
for(var i=0 ; i <= max ; i++){
    digits_sums[i] = digits_sum(i);
}

var sub_total = 0;
var max_iteration = 1024;

// already visited 
var walked = {};
var grid_walk = function(x, y){
    var xy = x+'-'+y;
    if( 'undefined' === typeof(walked[xy]) ){
        walked[xy] = true;
        sub_total++;
        
        var sx = digits_sums[x];
        var sy = digits_sums[y];
        
        // I don't want to go into negative x 
        // move left only if x > 0
        if( x>0 && (digits_sums[x-1] + sy) <= sum_max ){
            if( sub_total%max_iteration == 0 ){
                setTimeout(function(){
                    grid_walk(x-1, y);        
                },0);
            }
            else{
                grid_walk(x-1, y);
            }
        }
        if( (digits_sums[x+1] + sy) <= sum_max ){
            if( sub_total%max_iteration == 0 ){
                setTimeout(function(){
                    grid_walk(x+1, y);
                },0);
            }
            else{
                grid_walk(x+1, y);
            }
        }
        // I don't want to go into negative y
        // move up only if y > 0
        if( y>0 && (sx + digits_sums[y-1]) <= sum_max ){
            if( sub_total%max_iteration == 0 ){
                setTimeout(function(){
                    grid_walk(x, y-1);
                },0);
            }
            else{
                grid_walk(x, y-1);
            }
        }
        if( (sx + digits_sums[y+1]) <= sum_max ){
            if( sub_total%max_iteration == 0 ){
                setTimeout(function(){
                    grid_walk(x, y+1);
                },0);
            }
            else{
                grid_walk(x, y+1);
            }
        }
        
    }
};

process.on('exit', function (){
    // I've just walked into positive quarter
    // I delete the first line and I quadruple the sub total
    var total = (sub_total - max) * 4;
    // 0,0 is my starting position
    // I counted it 4 times, I only need one
    // so, I have to reduce by 3
    total -= 3;
    console.log(total);
});

// GO!
grid_walk(0,0);
