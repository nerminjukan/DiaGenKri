
var paper;

start = function () {
// storing original coordinates
this.ox = this.attr("x");
this.oy = this.attr("y");
this.attr({opacity: 1, text: "test"});
if (this.attr("y") < 60 &&  this.attr("x") < 60)
    this.attr({fill: "#3fb118"});
};

move = function (dx, dy) {
    // move will be called with dx and dy
    //var ale =
    //console.log(this.node);
    //paper.freeTransform(this);
    if(this.ox + this.node.width.baseVal.value + dx < document.getElementById('content').clientWidth &&
        this.oy + dy >= 0 && this.oy + this.node.height.baseVal.value + dy < document.getElementById('content').clientHeight &&
        this.ox + dx >= 0){
        //var r = this.oy - Math.abs(dy);
        //console.log("res: " + r + ", dy: " + dy);
        this.attr({x: this.ox + dx, y: this.oy + dy});
        if (this.attr("fill") !== "#7fb501") this.attr({fill: "#7fb501", text: "test"});
    }
    else{
        console.log(dy);
    }


};

up = function () {
    // restoring state
    this.attr({opacity: .5});
    console.log("X: " + this.attr("x") + " Y: " + this.attr("y"));
    if (this.attr("x") < 211){
        this.remove();
    }


};


var clone_handler = function() {
    var x = this.clone();
    //console.log(Object.getOwnPropertyNames(x));
    //console.log(x.node);
    x.drag(move, start, up);
    //var ft = paper.freeTransform(x, {rotate: "false"});
    //ft.hideHandles();

    //x.hover(hv_on, hv_off);
};


$(function(){
    paper = Raphael(document.getElementById('content'), "100%", "100%", 0, 0);

    var toolBorder = paper.rect(10, 10, 200,
        document.getElementById('content').clientHeight - 20);

    var field = paper.rect(50, 50, 100, 50).attr({fill: "black"});
    var eltext = paper.set();
    el = paper.ellipse(0, 0, 30, 20);
    text = paper.text(0, 0, "ellipse").attr({fill: '#ff0000'})
    eltext.push(el);
    eltext.push(text);
    eltext.translate(100,100)


    //alert( 'Size: ' + paper.width + 'x' + paper.height );

    field.mousemove(clone_handler);
});


