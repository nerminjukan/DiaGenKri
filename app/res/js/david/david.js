// connection implementation between two objects
Raphael.fn.connection = function (obj1, obj2, line, id_c, color_user = "#000", bg) {
    if (obj1.line && obj1.from && obj1.to) {
        line = obj1;
        obj1 = line.from;
        obj2 = line.to;
    }
    var bb1 = obj1.getBBox(),
        bb2 = obj2.getBBox(),
        p = [{x: bb1.x + bb1.width / 2, y: bb1.y - 1},
            {x: bb1.x + bb1.width / 2, y: bb1.y + bb1.height + 1},
            {x: bb1.x - 1, y: bb1.y + bb1.height / 2},
            {x: bb1.x + bb1.width + 1, y: bb1.y + bb1.height / 2},
            {x: bb2.x + bb2.width / 2, y: bb2.y - 1},
            {x: bb2.x + bb2.width / 2, y: bb2.y + bb2.height + 1},
            {x: bb2.x - 1, y: bb2.y + bb2.height / 2},
            {x: bb2.x + bb2.width + 1, y: bb2.y + bb2.height / 2}],
        d = {}, dis = [];
    for (var i = 0; i < 4; i++) {
        for (var j = 4; j < 8; j++) {
            var dx = Math.abs(p[i].x - p[j].x),
                dy = Math.abs(p[i].y - p[j].y);
            if ((i == j - 4) || (((i != 3 && j != 6) || p[i].x < p[j].x) && ((i != 2 && j != 7) || p[i].x > p[j].x) && ((i != 0 && j != 5) || p[i].y > p[j].y) && ((i != 1 && j != 4) || p[i].y < p[j].y))) {
                dis.push(dx + dy);
                d[dis[dis.length - 1]] = [i, j];
            }
        }
    }
    if (dis.length == 0) {
        var res = [0, 4];
    } else {
        res = d[Math.min.apply(Math, dis)];
    }
    var x1 = p[res[0]].x,
        y1 = p[res[0]].y,
        x4 = p[res[1]].x,
        y4 = p[res[1]].y;
    dx = Math.max(Math.abs(x1 - x4) / 2, 10);
    dy = Math.max(Math.abs(y1 - y4) / 2, 10);
    var x2 = [x1, x1, x1 - dx, x1 + dx][res[0]].toFixed(3),
        y2 = [y1 - dy, y1 + dy, y1, y1][res[0]].toFixed(3),
        x3 = [0, 0, 0, 0, x4, x4, x4 - dx, x4 + dx][res[1]].toFixed(3),
        y3 = [0, 0, 0, 0, y1 + dy, y1 - dy, y4, y4][res[1]].toFixed(3);
    var path = ["M", x1.toFixed(3), y1.toFixed(3), "C", x2, y2, x3, y3, x4.toFixed(3), y4.toFixed(3)].join(",");
    if (line && line.line) {
        line.bg && line.bg.attr({path: path});
        line.line.attr({path: path});
    } else {
        let color = color_user;
        let line_path = this.path(path).attr({stroke: color, fill: "none", "stroke-width": 3});
        line_path.mouseover(deleteConnection);
        line_path.mouseout(noDelete);
        return {
            bg: bg && bg.split && this.path(path).attr({stroke: bg.split("|")[0], fill: "none", "stroke-width": bg.split("|")[1] || 3}),
            line: line_path,
            from: obj1,
            to: obj2,
            id: id_c
        };
    }
};

// dragging shapes
Raphael.st.draggable = function() {
    var me = this,
        lx = 0,
        ly = 0,
        ox = 0,
        oy = 0,
        moveFnc = function(dx, dy) {
            lx = dx + ox;
            ly = dy + oy;
            me.transform('t' + lx + ',' + ly);
        },
        startFnc = function() {
            console.log("[dragging shapes] works");
        },
        endFnc = function() {
            ox = lx;
            oy = ly;
        };

    this.drag(moveFnc, startFnc, endFnc);
};

class Shape{
    constructor(id_shape, array_connections){
        this.id_shape = id_shape;
        this.array_connections = array_connections;
    }

    // checks whether two shapes are connected
    checkConnection(id_neighbour){
        for (let i = array_connections.length - 1; i >= 0; i--)
            if(array_connections[i].id === id_neighbour)
                return true;
        return false;
    }
}

// raphael paper reference
let paper;
// array for shapes(circles, rectangles)
let shapes = [];
// array for connection between shapes
let connections = [];
// id of connections
let id_connection = 0;
// if adding connections is possible
let add_connection = false;
// if removing connection is possible - that's when user's mouse is on the line and user pressed some key(- minus key for now)
// following variable represents id of path(connection) to be removed
let remove_connectionn_id = null;

var dragger = function () {
        this.ox = this.type == "rect" ? this.attr("x") : this.attr("cx");
        this.oy = this.type == "rect" ? this.attr("y") : this.attr("cy");
        this.animate({"fill-opacity": .2}, 500);
    },
    move = function (dx, dy) {
        var att = this.type == "rect" ? {x: this.ox + dx, y: this.oy + dy} : {cx: this.ox + dx, cy: this.oy + dy};
        this.attr(att);
        for (var i = connections.length; i--;) {
            paper.connection(connections[i]);
        }
        //paper.safari();
    },
    up = function () {
        this.animate({"fill-opacity": 0}, 500);
    }


// ############## START OF REMOVE SHAPE ##############
// on double click remove "double clicked" shape
function doubleClick(){
    console.log("shape to be removed:", this.id);

    // get ids of all connections that a shape got
    let connections_ids = getAllConnections(this.id);

    // remove connections
    removeConnections(connections_ids);

    // remove shape
    // get index of shape in order to splice array
    index = -1;
    /*for(let i = 0; i < shapes.length; i++){
     if(shapes[i].id === this.id)
     index = i;
     }*/
    var toRemove = canvasSets[getSet(this.id)];

    canvasSets.splice(getSet(this.id), 1);
    toRemove.forEach(function (e) {
        e.remove();
    });
    if (index > -1) {
        console.log("removing", this.id);
        shapes.splice(index, 1);
        this.remove();
        // reset variables for shapes(which should be connected)
        // thats saftey because one might want to add connection to first shape, then delete second one by mistake and there would be an error connecting thoose two
        line_first_shape_id = null;
        line_second_shape_id = null;
    }
}

// returns array that contains ids of all connections that comes to that shape
function getAllConnections(shape_id){
    let to_remove = [];
    for(let i = 0; i < connections.length; i++){
        if(connections[i].from.id === shape_id || connections[i].to.id === shape_id){
            to_remove.push(connections[i].id)
        }
    }
    return to_remove;
}
function removeConnections(c_ids){
    console.log("dolžina",connections.length - 1);
    for(let i = c_ids.length - 1; i >= 0; i--){
        for(let j = connections.length - 1; j >= 0; j--){
            // if id of connection and if of connections to be removed matches
            if(connections[j].id === c_ids[i]){
                console.log("remove connection on index", j, " with id of path:", connections[j].line.id, "that is connecting:", connections[j].from.id,
                    "and", connections[j].to.id);
                connections[j].line.remove();
                connections.splice(j, 1);
                //c_ids.splice(i, 1); // optimization, also increment i to get to correct index
                console.log("successfuly removed");
            }
        }
    }
}

// ############## END OF REMOVE SHAPE ##############

// ############## START OF REMOVE CONNECTION ##############
function deleteConnection(){
    console.log("path:",this.id);
    this.attr("stroke-width", 5);
    remove_connectionn_id = this.id;
}

function noDelete(){
    this.attr("stroke-width", 3);
    remove_connectionn_id = null;
}

// returns index of connection with id as parameter
function getConnectionIndex(id){
    for(let i = 0; i < connections.length; i++)
        if(connections[i].line.id === id)
            return i;
    return null;
}
// ############## END OF REMOVE CONNECTION ##############

// ############## START OF CONNECTING TWO SHAPES ##############
let line_first_shape_id = null,
    line_second_shape_id = null; // when thoose are both something but null, connect two shapes
function connectTwoShapes(){
    console.log("id of shape:", this.id);
    if(!add_connection)
        return;
    if(!line_first_shape_id){
        line_first_shape_id = this.id;
        console.log("[connect shapes] got first shape:", this.id);
        return "first";
    }

    if(!line_second_shape_id){
        if(this.id === line_first_shape_id){
            console.log("[connect shapes] same shapes, choose different!");
            return "error";
        }
        line_second_shape_id = this.id;
        console.log("[connect shapes] got second shape:", this.id);
    }

    // check if two shapes are already connected
    // TODO;

    // get indexes of shapes to be connected
    let indexes = getIndexesOfTwoShapes(line_first_shape_id, line_second_shape_id);
    //console.log("first", indexes.f, "second", indexes.s);

    // reset variables for shapes
    line_first_shape_id = null;
    line_second_shape_id = null;

    // get reference to paper from data of element
    paper = shapes[indexes.f].data("paper");
    //console.log("[connect shapes] paper canvas:", paper.canvas);

    // connect shapes
    connections.push(paper.connection(shapes[indexes.f], shapes[indexes.s], "#000", id++));
    console.log("[connect shapes] DONE");

    // reset adding connections
    addConnection();
}

// returns indexes of shapes with ids as paramters
function getIndexesOfTwoShapes(shape1_id, shape2_id){
    let first = null,
        second = null;
    for(let i = 0; i < shapes.length; i++){
        if(shapes[i].id === shape1_id)
            first = i;

        if(shapes[i].id === shape2_id)
            second = i;

        // if both are set just stop
        if(first && second){
            //console.log("[connect shapes - get index] done finding indexes");
            break;
        }
    }
    console.log("[connect shapes - get index] indexes of shapes:", first, second);
    return {
        f: first,
        s: second
    };
}

// when add connection is true, you can actually add connection
function addConnection(){
    add_connection = !add_connection;
    if(add_connection){
        document.getElementById("add_connection_button").classList.remove("btn");
        document.getElementById("add_connection_button").classList.remove("btn-primary");
        document.getElementById("add_connection_button").classList.add("button_checked");
    }
    else{
        document.getElementById("add_connection_button").classList.remove("button_checked");
        document.getElementById("add_connection_button").classList.add("btn-primary");
        document.getElementById("add_connection_button").classList.add("btn");

    }
    // reset variables for shapes
    line_first_shape_id = null;
    line_second_shape_id = null;
    console.log("adding connection?", add_connection);
}

// ############## END OF CONNECTING TWO SHAPES ##############

// ************* some other functions
// center element(target) inside his parent(outer)
function scrollTo(name_of_div, shape){
    //let out = $("#"+name_of_div);
    // spodnji primerm bo "zaskrolal" tako, da bo element na poziciji 1000, 1000 na sredini div-a
    // elipsa (krog) ima središče v [1000, 1000], kvadrat ima središče v [1000 + rect.width() / 2, 1000 + rect.height() / 2]
    // ****** primer za rectangle ******
    // let box = rectangle.getBBox();
    // out.scrollLeft(box.x - out.width()/2 + box.width/2);
    // out.scrollTop(box.y - out.height()/2 + box.height/2);
    // ****** primer za elipso ******
    // let box = elipse.getBBox();
    // out.scrollTop(box.cy - out.height()/2);
    // out.scrollLeft(box.cx - out.width()/2);

    // name of div whoose child is raphael paper
    let out = $("#"+name_of_div);
    console.log("[scrollTo] type:", shape.type);
    if(shape.type === "rect"){
        let box = shape.getBBox();
        out.scrollLeft(box.x - out.width()/2 + box.width/2);
        out.scrollTop(box.y - out.height()/2 + box.height/2);
    } else {
        let box = shape.getBBox();
        out.scrollTop(box.cy - out.height()/2);
        out.scrollLeft(box.cx - out.width()/2);
    }
    shape.animate({"fill-opacity": .2}, 500);
    // shape.animate({"fill-opacity": 0}, 500);
}

function zoom(og_width, og_height, map_width, map_height){
    var original_width = og_width;
    var original_height = og_height;
    var zoom_width = map_width/original_width;
    var zoom_height = map_height/original_height;
    if(zoom_width<=zoom_height)
        zoom = zoom_width;
    else
        zoom = zoom_height;
    paper.setViewBox($("#canvas").offset().left, $("#canvas").offset().top, (map_width/zoom), (map_height/zoom));
}
// ************* end of some other functions
window.onload = function () {
    // set focus to div with paper
    // $('#content').focus();


    IDinput = document.getElementById('IDinput');
    IDtext = document.getElementById('IDtext');

    // drag and drop is possible "everywhere"
    document.addEventListener("dragover", function (ev) {
        ev.preventDefault();
    }, false);


    let element = document.getElementById('content'),
        positionInfo = element.getBoundingClientRect(),
        height = positionInfo.height,
        width = positionInfo.width;

    paper = Raphael(document.getElementById('content'), 2000, 2000);
    paper.rect(0, 0, 2000, 2000).attr({"stroke-width": 10});
    console.log("[main] paper canvas:", paper.canvas);

    // TESTING
    connections = [];
    /*shapes = [  paper.ellipse(paper.width/2, paper.height/2, 30, 20),
     paper.rect(290, 80, 60, 40, 10),
     paper.rect(290, 180, 60, 40, 2),
     paper.ellipse(450, 100, 20, 20),
     paper.rect(paper.width/2, paper.height/2, 60, 40, 4),
     paper.rect(400, 250, 60, 40, 2)
     ];*/

    // create set for objects
    var mySet = paper.set();

    // create shapes
    for (var i = 0, ii = shapes.length; i < ii; i++) {
        var color = Raphael.getColor();
        shapes[i].attr({fill: color, stroke: color, "fill-opacity": 0, "stroke-width": 2, cursor: "move"});
        // save reference to paper
        shapes[i].data("paper", paper);
        shapes[i].drag(move, dragger, up);
        shapes[i].dblclick(doubleClick);
        shapes[i].click(connectTwoShapes);
    }
    // add connections between shapes
    /*connections.push(paper.connection(shapes[0], shapes[1], "#000", id_connection++));
     connections.push(paper.connection(shapes[1], shapes[2], "#000", id_connection++));
     connections.push(paper.connection(shapes[1], shapes[3], "#000", id_connection++));
     connections.push(paper.connection(shapes[2], shapes[3], "#000", id_connection++, "#4286f4"));

     for(let i = 0; i < connections.length; i++)
     console.log(connections[i].from.id, ":", connections[i].to.id, connections[i].id);*/

    mySet.push(paper.circle(50, 50, 50).attr('fill', 'red'));
    mySet.push(paper.circle(50, 50, 40).attr('fill', 'white'));
    mySet.push(paper.circle(50, 50, 30).attr('fill', 'red'));
    mySet.push(paper.circle(50, 50, 20).attr('fill', 'white'));
    mySet.push(paper.circle(50, 50, 10).attr('fill', 'red'));

    // make set draggable
    mySet.draggable();

    // lets center screen to some shape
    //scrollTo("content", shapes[0]);


    // connections.push(paper.connection(shapes[1], shapes[2], "#fff", "#fff|5"));
    // connections.push(paper.connection(shapes[1], shapes[3], "#000", "#fff"));
};

$('html').keyup(function(e){
    console.log("key code:", e.keyCode);
    // keycode = 8 ==> backspace
    if(e.keyCode == 8) {
        if(remove_connectionn_id){
            console.log("minus pressed, delete path with id", remove_connectionn_id);
            let index = getConnectionIndex(remove_connectionn_id);
            // remove line and than delete whole connection from array
            connections[index].line.remove();
            connections.splice(index, 1);
            remove_connectionn_id = null;
        }
        else
            console.log("just minus pressed, delete nothing");
    }
});




function addToShapes(shape){
    //shape.attr({fill: "blue", stroke: "blue", "fill-opacity": 1, "stroke-width": 2, });
    // save reference to paper
    shape.data("paper", paper);
    //shape.drag(move, dragger, up);
    shape.dblclick(doubleClick);
    shape.click(connectTwoShapes);
    shapes.push(shape)
}

////////

// HTML input ID input field
var IDinput;

// HTML input Text field
var IDtext;

// the currently handled shape -> makes it globally accessible (idea)
var active;

// counter and ID number for sets inserted into 'canvasSets'
var id = 0;

// holds all the sets of elements indexied by 'id'
var canvasSets = [];

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

    // create local variables
    var shape;
    var set = paper.set();

    var txt;
    var fts;

    // draws a rectangle
    if(arg === "aSquare"){
        // create element and draw it on canvas
        shape =  paper.rect(ev.offsetX, ev.offsetY, 100, 50).attr({fill: "white", cursor: "move"}).data('setID', id);

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
        set.draggable();

        // saves the set ito a global array
        canvasSets.push(set);
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
        set.draggable();

        canvasSets.push(set);
        id++;
    }
    // draws a link (for testing purposes)
    else if(arg === "aLink"){
        var x = ev.offsetX + 90;
        var y = ev.offsetY + 10;
        shape = paper.path("M" + ev.offsetX+" "+ev.offsetY+"L" + x + " " + y).attr({stroke: "pink", "stroke-width":4}).data('setID', id);
        shape.rotate(45);

        txt = paper.text(ev.offsetX+40, ev.offsetY+40, "TEST").attr({'fill': 'red'});

        set.push(shape);

        canvasSets.push(set);
        id++;
    }
    // if the shape is not recognised, nothing is drawn
    else{
        return null;
    }
    set.data('id', shape.id);
    console.log("set id: ", set.data('id'));
    addToShapes(shape);

    // saves the current shape to a global scope
    active = shape;

    // sets the values in IDinput and IDtext to the currently active shape's values
    IDinput.setAttribute('value', shape.id);
    // when creating
    IDtext.removeAttribute('disabled');
    IDtext.value = "neki";

    // shape click event handler
    shape.click(function () {

        // saves the current shape to a global spoce
        active = shape;

        // change colours (testing purposes)
        //shape.attr({fill: getRandomColor()});
        //shape.attr({stroke: getRandomColor()});

        // read and set the element's values for IDtext and IDinput
        IDtext.value = "neki";

        IDtext.value = getText(shape.id);
        console.log("IDtext: ", IDtext.value);
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

function getSet(id){
    for(let i = 0; i < canvasSets.length; i++){
        console.log("getSet:",canvasSets[i][0].id);
        if(canvasSets[i][0].id === id){
            console.log("found correct set");
            return i;
        }
    }
    return null;
}

// acces the correct set from canvasSets and extract the text element 't', change the element's value
function getText(id) {
    console.log("[getText] id:",id);
    let index = getSet(id);

    var set = canvasSets[index];
    console.log("[getText] set:", set);

    var t = set.pop();
    var txt = t.attr('text');
    console.log("TEKST OUT: ", txt);
    set.push(t);
    return txt;
}

// 'onblur' event handler for IDtext input field, changes the text in the corresponding element (set of elements)
function setText() {
    var id = IDinput.value;
    var set = canvasSets[getSet(id)];
    console.log("[setText] set:", set);
    var t = set.pop();
    t.attr({text: IDtext.value});
    set.push(t);
}

// de-selects any selected element and hides handles
function looseFocus(ev){
    if(ev.target.childElementCount > 0){
        // for(var i = 0; i < canvasHandles.length; i++){
        //     // canvasHandles[i].hideHandles();
        // }
    }

}

// initial setup function, createc the canvas as 'paper' sets some global variables, adds 'dragover' event handler for canvas
// $(function(){
//     //set = paper.set();
//     IDinput = document.getElementById('IDinput');
//     IDtext = document.getElementById('IDtext');

//     document.addEventListener("dragover", function (ev) {
//         ev.preventDefault();
//     }, false);

// });















