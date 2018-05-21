
var paper;

var set;

var canvasElements = [];

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function alertMe(ev, tar) {
    console.log(ev.target.id + ", " + tar.id);
    console.log(ev.screenY);
    var pos = $("#content").position();
    console.log("x: " +pos.top);
    console.log("y: " +pos.left);
}

function startDrag(ev) {
    ev.dataTransfer.setData('Text/html', ev.target.id);
}

function shapeDraw(arg, ev) {

    var shape;

    if(arg === "aSquare"){
       shape =  paper.rect(ev.offsetX, ev.offsetY, 100, 50).attr({fill: "black"});
       var resizable = paper.rect(ev.offsetX+10, ev.offsetY+10, 20, 20).attr({fill: "white"});

       set.push(shape);
       set.push(resizable);
    }
    else if(arg === "aDecision"){
        shape = paper.rect(ev.offsetX, ev.offsetY, 75, 75).attr({fill: "white"});
        shape.rotate(45);
    }
    else if(arg === "aLink"){
        shape = paper.path("M" + ev.offsetX+","+ev.offsetY+"H10").attr({stroke: "pink", "stroke-width":4});
        shape.rotate(45);
    }
    else{
        return null;
    }

    shape.click(function () {
        var el = paper.getById(shape.id);
        el.attr({fill: getRandomColor()});
        el.attr({stroke: getRandomColor()});
    });



    return shape;
}


function mainDraw(ev) {
    var data = ev.dataTransfer.getData("text/html");
    var shape = shapeDraw(data, ev);
    canvasElements.push(shape);

}

$(function(){
    paper = Raphael(document.getElementById('content'), 1000, 1000, 0, 0);
    set = paper.set();

    document.addEventListener("dragover", function (ev) {
        ev.preventDefault();
    }, false);


});




