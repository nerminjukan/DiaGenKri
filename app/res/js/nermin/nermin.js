
var paper;

var IDinput;

var IDtext;

var active;

var id = 0;

var canvasSets = [];

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
    var set = paper.set();
    var txt;

    if(arg === "aSquare"){
       shape =  paper.rect(ev.offsetX, ev.offsetY, 100, 50).attr({fill: "black"}).data('setID', id);
       var resizable = paper.rect(ev.offsetX+10, ev.offsetY+10, 20, 20).attr({fill: "white"});
       txt = paper.text(ev.offsetX+60, ev.offsetY+30, "TEST").attr({'fill': 'red'});

       set.push(shape);
       set.push(resizable);
       set.push(txt);
       canvasSets.push(set);
       id++;
    }
    else if(arg === "aDecision"){
        shape = paper.rect(ev.offsetX, ev.offsetY, 75, 75).attr({fill: "white"}).data('setID', id);
        shape.rotate(45);

        txt = paper.text(ev.offsetX+40, ev.offsetY+40, "TEST").attr({'fill': 'red'});
        set.push(shape);
        set.push(resizable);
        set.push(txt);
        canvasSets.push(set);
        id++;
    }
    else if(arg === "aLink"){
        shape = paper.path("M" + ev.offsetX+","+ev.offsetY+"H10").attr({stroke: "pink", "stroke-width":4});
        shape.rotate(45);
    }
    else{
        return null;
    }

    active = shape;

    IDinput.setAttribute('value', shape.id);
    IDtext.removeAttribute('disabled');
    IDtext.value = "";

    shape.click(function () {
        var el = paper.getById(shape.id);
        el.attr({fill: getRandomColor()});
        el.attr({stroke: getRandomColor()});


        IDtext.value = getText(shape.id);
        IDinput.setAttribute('value', shape.id);
    });



    return shape;
}


function mainDraw(ev) {
    var data = ev.dataTransfer.getData("text/html");
    var shape = shapeDraw(data, ev);
    //canvasElements.push(shape);

}

function getText(id) {
    var set = canvasSets[paper.getById(id).data('setID')];
    var t = set.pop();
    var txt = t.attr('text');
    set.push(t);
    return txt;
}


function setText(ev) {
    var id = IDinput.value;

    var set = canvasSets[paper.getById(id).data('setID')];
    var t = set.pop();
    t.attr({text: IDtext.value});
    set.push(t);
}

$(function(){
    paper = Raphael(document.getElementById('content'), 1000, 1000, 0, 0);
    set = paper.set();
    IDinput = document.getElementById('IDinput');
    IDtext = document.getElementById('IDtext');

    document.addEventListener("dragover", function (ev) {
        ev.preventDefault();
    }, false);


});




