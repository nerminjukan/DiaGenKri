
var paper;

start = function () {
// storing original coordinates
this.ox = this.attr("x");
this.oy = this.attr("y");
this.attr({opacity: 1});
if (this.attr("y") < 60 &&  this.attr("x") < 60)
    this.attr({fill: "#000"});
};

move = function (dx, dy) {
    // move will be called with dx and dy
    //var ale =
    //console.log(this.node);
    if(this.ox + this.node.width.baseVal.value + dx < document.getElementById('content').clientWidth &&
        this.oy + dy >= 0 && this.oy + this.node.height.baseVal.value + dy < document.getElementById('content').clientHeight &&
        this.ox + dx >= 0){
        //var r = this.oy - Math.abs(dy);
        //console.log("res: " + r + ", dy: " + dy);
        this.attr({x: this.ox + dx, y: this.oy + dy});
        if (this.attr("fill") !== "#000") this.attr({fill: "#000"});
    }
    else{
        console.log(dy);
    }


};

up = function () {
    // restoring state
    this.attr({opacity: .5});
    if (this.attr("y") < 60 && this.attr("x") < 60)
        this.attr({fill: "#AEAEAE"});
};


var clone_handler = function() {
    var x = this.clone();
    //console.log(Object.getOwnPropertyNames(x));
    //console.log(x.node);
    x.drag(move, start, up);
    //x.hover(hv_on, hv_off);
};


$(function(){
    paper = Raphael(document.getElementById('content'), "100%", "100%", 0, 0);

    var toolBorder = paper.rect(10, 10, 200,
        document.getElementById('content').clientHeight - 20);

    var field = paper.rect(50, 50, 100, 50).attr({fill: "black"});


    //alert( 'Size: ' + paper.width + 'x' + paper.height );

    field.mousemove(clone_handler);
});


