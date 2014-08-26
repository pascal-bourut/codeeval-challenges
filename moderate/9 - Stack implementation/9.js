// https://www.codeeval.com/open_challenges/9/

var Stack = function(){
    var data = [];
    var size = 0;
    
    this.push = function(el){
        data.push(el);
        size++;
    };
    
    this.pop = function(){
        if( size === 0 ) return null;
        var el = data[size-1];
        size--;
        return el;
    };
    
    this.is_empty = function(){
        return size === 0 ? true : false;
    };
};


var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var stack = new Stack();
        var numbers = line.split(' ');
        for( var i=0, nb=numbers.length ; i < nb ; i++){
            stack.push( numbers[i] );
        }
        
        var even = true;
        var out = [];
        while( !stack.is_empty() ){
            var el = stack.pop();
            if( even ){
                out.push(el);
            }
            even = !even;
        }
        console.log( out.join(' ') );
    }
});