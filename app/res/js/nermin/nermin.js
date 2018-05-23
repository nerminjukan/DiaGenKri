// canvas element
var paper;

// HTML input ID input field
var IDinput;

// HTML input Text field
var IDtext;

// the currently handled shape -> makes it globally accessible (idea)
var active;
var activeFTS;

// counter and ID number for sets inserted into 'canvasSets'
var id = 0;

// holds all the sets of elements indexied by 'id'
var canvasSets = [];

// holds all the freeTransform variables of elements (idea)
var canvasHandles = [];

// helper function for 'element.click' event handler
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// inserts element information from Toolbar into dataTransfer, enables identification of dropped element onto canvas
function startDrag(ev) {
    ev.dataTransfer.setData('Text/html', ev.target.id);
}

// the actual drawing function, determines which shape to draw
function shapeDraw(arg, ev) {

    if(activeFTS){
        activeFTS.hideHandles();
    }

    // create local variables
    var shape;
    var set = paper.set();
    var txt;
    var fts;

    // draws a rectangle
    if(arg === "aSquare"){
        // create element and draw it on canvas
        shape =  paper.rect(ev.offsetX, ev.offsetY, 100, 50).attr({fill: "black"}).data('setID', id);
        // creates a 'details' rectangle
        var resizable = paper.rect(ev.offsetX+10, ev.offsetY+10, 20, 20).attr({fill: "white"});
        // adds a text field
        txt = paper.text(ev.offsetX+60, ev.offsetY+30, "TEST").attr({'fill': 'red'});

        // adds a dblclick handler to the 'details' rectangle
        resizable.click(function () {
            console.log("I am going to hide links soon.")
        });

        // adds a dblclick handler to the text field
        txt.dblclick(function () {
           IDtext.focus();
        });

        // adds the elements to a set
        set.push(shape);
        set.push(resizable);
        set.push(txt);

        // adds a freeTransform extension to the set
        fts = paper.freeTransform(set);

        // saves the set ito a global array
        canvasSets.push(set);
        // saves the freeTransform extension to a  global array
        canvasHandles.push(fts);
        // increments the global id
        id++;
    }
    // draws a decision node, similar process as for rectangle element, doesn't include the 'details' element
    else if(arg === "aDecision"){
        shape = paper.rect(ev.offsetX, ev.offsetY, 75, 75).attr({fill: "white"}).data('setID', id);
        shape.rotate(45);
        txt = paper.text(ev.offsetX+40, ev.offsetY+40, "TEST").attr({'fill': 'red'});

        txt.dblclick(function () {
            IDtext.focus();
        });

        set.push(shape);
        set.push(txt);

        fts = paper.freeTransform(set);

        canvasSets.push(set);
        canvasHandles.push(fts);
        id++;
    }
    // draws a link (for testing purposes)
    else if(arg === "aLink"){
        var x = ev.offsetX + 90;
        var y = ev.offsetY + 10;
        shape = paper.path("M" + ev.offsetX+" "+ev.offsetY+"L" + x + " " + y).attr({stroke: "pink", "stroke-width":4}).data('setID', id);
        shape.rotate(45);

        txt = paper.text(ev.offsetX+40, ev.offsetY+40, "TEST").attr({'fill': 'red'});
        fts = paper.freeTransform(txt);

        fts.hideHandles();

        txt.dblclick(function () {
            fts.showHandles();
        });
        set.push(shape);

        canvasSets.push(set);
        canvasHandles.push(fts);
        id++;
    }
    // if the shape is not recognised, nothing is drawn
    else{
        return null;
    }

    // saves the current shape to a global spoce
    active = shape;
    activeFTS = fts;

    // sets the values in IDinput and IDtext to the currently active shape's values
    IDinput.setAttribute('value', shape.id);
    // when creating
    IDtext.removeAttribute('disabled');
    IDtext.value = "";

    // shape click event handler
    shape.click(function () {

        // hide the currently active element's handles
        activeFTS.hideHandles();

        // saves the current shape to a global spoce
        active = shape;
        activeFTS = fts;

        // change colours (testing purposes)
        var el = paper.getById(shape.id);
        el.attr({fill: getRandomColor()});
        el.attr({stroke: getRandomColor()});

        // show handles for this element (now active)
        activeFTS.showHandles();

        // read and set the element's values for IDtext and IDinput
        IDtext.value = getText(shape.id);
        IDinput.setAttribute('value', shape.id);
    });



    // return shape (no actual use)
    return shape;
}

// event handler for 'ondrop' event of canvas
// reads the received data and forwards the info to 'shapeDraw'
function mainDraw(ev) {
    var data = ev.dataTransfer.getData("text/html");
    shapeDraw(data, ev);

}

// acces the correct set from canvasSets and extract the text element 't', change the element's value
function getText(id) {
    var set = canvasSets[paper.getById(id).data('setID')];
    var t = set.pop();
    var txt = t.attr('text');
    set.push(t);
    return txt;
}

// 'onblur' event handler for IDtext input field, changes the text in the corresponding element (set of elements)
function setText() {
    var id = IDinput.value;
    var set = canvasSets[paper.getById(id).data('setID')];
    var t = set.pop();
    t.attr({text: IDtext.value});
    set.push(t);
}

// de-selects any selected element and hides handles
function looseFocus(ev){
    if(ev.target.childElementCount > 0){
        for(var i = 0; i < canvasHandles.length; i++){
            canvasHandles[i].hideHandles();
        }
    }

}

// initial setup function, createc the canvas as 'paper' sets some global variables, adds 'dragover' event handler for canvas
$(function(){
    paper = Raphael(document.getElementById('content'), 1000, 1000, 0, 0);
    //set = paper.set();
    IDinput = document.getElementById('IDinput');
    IDtext = document.getElementById('IDtext');

    document.addEventListener("dragover", function (ev) {
        ev.preventDefault();
    }, false);
    
});




