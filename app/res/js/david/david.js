// connection implementation between two objects
Raphael.fn.connection = function (obj1, obj2, line, id_c, color_user = "#000", bg) {
    if (obj1.line && obj1.from && obj1.to) {
        line = obj1;
        obj1 = line.from;
        obj2 = line.to;

        line.line.attr({"arrow-end":"classic-wide-long"});
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
        line.line.attr({"arrow-end":"classic-wide-long"});
        line.bg && line.bg.attr({path: path});
        line.line.attr({path: path});
    } else {
        let color = color_user;
        let line_path = this.path(path).attr({"arrow-end":"classic-wide-long", stroke: color, fill: "none", "stroke-width": 3});
        line_path.setName = 'name' + id_c;

        //line_path.setID = id_c;
        line_path.data('fromTo', obj1.id+' '+obj2.id);
        line_path.mouseover(deleteConnection);
        line_path.mouseout(noDelete);
        line_path.click(deleteConnectionOnClick);
        return {
            bg: bg && bg.split && this.path(path).attr({stroke: bg.split("|")[0], fill: "none", "stroke-width": bg.split("|")[1] || 3}),
            line: line_path,
            from: obj1,
            to: obj2,
            id: id_c,
            // TODO fix text to follow line (update text position)
            text: paper.text(line_path.getPointAtLength(line_path.getTotalLength() / 2).x, line_path.getPointAtLength(line_path.getTotalLength() / 2).y-20, "no-text").attr({'fill': 'red'}).dblclick(function () {
                IDinput.value = line_path.id;
                IDtext.focus();
            })
        };
    }
};

// variable that is set to true when some shape is dragged
// it is useful because it prevents modal to be shown when user drags some shape(actually set)
let dragging_set = false

// dragging shapes
Raphael.st.draggable = function() {
        let me = this,
        lx = 0,
        ly = 0,
        ox = 0,
        oy = 0,
        moveFnc = function(dx, dy) {
            dragging_set = true
            // console.log('[draggable] start of drag', "scale:", panZoom.getCurrentScale());

            lx = dx * panZoom.getCurrentScale().x + ox;
            ly = dy * panZoom.getCurrentScale().y + oy;
            if(me[0].data('rotate') === true){
                me[0].transform('t' + lx + ',' + ly + 'r45');
                me[1].transform('t' + lx + ',' + ly);
                //console.log('MATRIX: ',me[0].matrix);
            }
            else{
                me.transform('t' + lx + ',' + ly);
            }
            for (let i = connections.length; i--;) {
                paper.connection(connections[i]);
            }
            //console.log('DX AND DY: ', dx, dy);

        },
        startFnc = function() {},
        endFnc = function() {
            ox = lx;
            oy = ly;
            /*me.forEach(function (e) {
                console.log('X AND Y PRE: ' , e.attr('x'), e.attr('y'));
                let bbox = e.getBBox();
                if(e.type === 'rect'){
                    //e.attr('x', bbox.x);
                    //e.attr('y', bbox.y);
                    console.log('X AND Y POST: ', e.attr('x'), e.attr('y'));

                }
                else{
                    //e.attr('cx', bbox.x);
                    //e.attr('cy', bbox.y);
                    console.log('CX AND CY POST: ', e.attr('cx'), e.attr('cy'));

                }

                console.log('E MATRIX: ', e.matrix);

            });*/
            dragging_set = false
            // console.log('[draggable] end of drag');
        };

    this.drag(moveFnc, startFnc, endFnc);
};
    // start1 = function() {

    //     ox =  this.attr("x");
    //     oy = this.attr("y");
    //     this.attr({
    //         opacity: 1
    //     });
    //         console.log("[starting new drag] ");

    // },

    // move1 = function(dx, dy) {
    //     var att ={
    //         x: ox + dx,
    //         y:oy + dy
    //     };
    //     this.attr(att);
    // },
    // up1 = function() {
    //     this.attr({
    //         opacity: .5
    //     });
    //     ox = 0, oy = 0;
    // };

    // this.forEach(function (el) {
    //this.drag(moveFnc, startFnc, endFnc);

    // });
    // this.drag(move1, start1, up1);

//};



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

let json;

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
// if deleting connections is possible
let delete_connection = false
// if deleting shapes(actually sets of shapes) is possible
let delete_shape = false
// if removing connection is possible - that's when user's mouse is on the line and user pressed some key(- minus key for now)
// following variable represents id of path(connection) to be removed
let remove_connectionn_id = null;
// variable for zoom
let panZoom = null;

// HTML input ID input field
var IDinput;

// HTML input Text field
var IDtext;

let IDdesc;

// the currently handled shape -> makes it globally accessible (idea)
var active;

// counter and ID number for sets inserted into 'canvasSets'
var id = 0;

// holds all the sets of elements indexied by 'id'
var canvasSets = [];

var scale = {
    x:1,
    y:1
};

// custom defined colors as rgb channels
let Colors = {
    green: "rgb(0, 200, 0)",
    red: "rgb(200, 0, 0)"
};
// $(window).resize(function(){
//     scale = getScale(paper);
//     console.log("[window] resized")
// })

// function getScale(paper, new_width, new_height){
//     var x = new_width/$(paper.canvas).width();
//     var y = new_height/$(paper.canvas).height();
//     scale =  {
//         x:x,
//         y:y
//     }
// }

var dragger = function () {
        this.ox = this.type == "rect" ? this.attr("x") : this.attr("cx");
        this.oy = this.type == "rect" ? this.attr("y") : this.attr("cy");
        this.animate({"fill-opacity": .2}, 500);
    },
    move = function (dx, dy) {
        // getScale(paper, 200, 200);
        var att = this.type == "rect" ? {x: this.ox + dx * scale.x, y: this.oy + dy * scale.y} : {cx: this.ox + dx * scale.x, cy: this.oy + dy * scale.y};
        this.attr(att);
        for (var i = connections.length; i--;) {
            paper.connection(connections[i]);
        }
        //paper.safari();
    },
    up = function () {
        this.animate({"fill-opacity": 0}, 500);
    }


    // TODO change handler for removing shapes

// ############## START OF REMOVE SHAPE ##############
// on double click remove "double clicked" shape
function removeShape(shape_id){
    //console.log("shape to be removed:", this.id);
    // shape should not be deleted
    if(!delete_shape)
        return

    // get ids of all connections that a shape got
    let connections_ids = getAllConnections(shape_id);

    // remove connections
    removeConnections(connections_ids);

    // remove shape
    // get index of shape in order to splice array
    index = -1;
    /*for(let i = 0; i < shapes.length; i++){
     if(shapes[i].id === this.id)
     index = i;
     }*/
    // console.log("[removeShape] id of shape to be removed:", shape_id, shape_id)
    // console.log("[removeShape] canvasSets:", canvasSets);
    let toRemove = canvasSets[getSet(shape_id)];
    console.log("[removeShape] set with this shape to be removed:", toRemove);

    canvasSets.splice(getSet(shape_id), 1);
    console.log("REMOVING:");
    toRemove.forEach(function (e) {
        console.log(e.id)
        e.remove();
    });
    if (index > -1) {
        //console.log("removing", this.id);
        shapes.splice(index, 1);
        shape_id.remove();
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
    //("dolžina",connections.length - 1);
    for(let i = c_ids.length - 1; i >= 0; i--){
        for(let j = connections.length - 1; j >= 0; j--){
            // if id of connection and if of connections to be removed matches
            if(connections[j].id === c_ids[i]){
                //console.log("remove connection on index", j, " with id of path:", connections[j].line.id, "that is connecting:", connections[j].from.id,
                    //"and", connections[j].to.id);
                connections[j].line.remove();
                connections.splice(j, 1);
                //c_ids.splice(i, 1); // optimization, also increment i to get to correct index
                //console.log("successfuly removed");
            }
        }
    }
}

// to set delete_shape with click on button
function setDeleteShape(){
    if(add_connection)
        addConnection();

    if(delete_connection)
        setDeleteConnection();

    delete_shape = !delete_shape;

    if(delete_shape){
        document.getElementById("delete_shape_button").classList.remove("btn");
        document.getElementById("delete_shape_button").classList.remove("btn-primary");
        document.getElementById("delete_shape_button").classList.add("button_checked");

        console.log("[setDeleteShape button] deleting shapes")
    }
    else{
        document.getElementById("delete_shape_button").classList.remove("button_checked");
        document.getElementById("delete_shape_button").classList.add("btn-primary");
        document.getElementById("delete_shape_button").classList.add("btn");

        console.log("[setDeleteShape button] not deleting shapes")
    }
}

// ############## END OF REMOVE SHAPE ##############

// ############## START OF REMOVE CONNECTION ##############
function deleteConnection(){
    //console.log("path:",this.id);
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
function onShapeClicked(){
    //console.log("id of shape:", this.id);
    if(!add_connection && !delete_shape)
        return;
    else if(delete_shape){
        // delete shape
        removeShape(this.id);
        // reset deleting shapes
        setDeleteShape();
        // and return
        return;
    }

    if(!line_first_shape_id){
        // modal with vertex info should be shown only if user is not adding connections
        // dragging_set = true
        line_first_shape_id = this.id;
        //console.log("[connect shapes] got first shape:", this.id);
        return "first";
    }

    if(!line_second_shape_id){
        if(this.id === line_first_shape_id){
            // modal with vertex info should be shown only if user is not adding connections
            // dragging_set = true

            //console.log("[connect shapes] same shapes, choose different!");
            return "error";
        }
        line_second_shape_id = this.id;
        //console.log("[connect shapes] got second shape:", this.id);
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
    //console.log("[connect shapes] DONE");

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
    //console.log("[connect shapes - get index] indexes of shapes:", first, second);
    return {
        f: first,
        s: second
    };
}

// when add connection is true, you can actually add connection
function addConnection(){
    // if user decides to add connection he can not delete it at same time
    if(delete_connection)
        setDeleteConnection();

    if(delete_shape)
        setDeleteShape();

    add_connection = !add_connection;
    

    if(add_connection){
        document.getElementById("add_connection_button").classList.remove("btn");
        document.getElementById("add_connection_button").classList.remove("btn-primary");
        document.getElementById("add_connection_button").classList.add("button_checked");
        // modal info about vertex should not be displayed when user is adding connections
        dragging_set = true
        console.log("[addConnection button] adding connections")
    }
    else{
        document.getElementById("add_connection_button").classList.remove("button_checked");
        document.getElementById("add_connection_button").classList.add("btn-primary");
        document.getElementById("add_connection_button").classList.add("btn");
        // modal info about vertex should not be displayed when user is adding connections
        console.log("[addConnection button] not adding connections")
    }
    // reset variables for shapes
    line_first_shape_id = null;
    line_second_shape_id = null;

    //console.log("adding connection?", add_connection);
}

// when add connection is true, you can actually add connection
function setDeleteConnection(){
    if(add_connection)
        addConnection();

    if(delete_shape)
        setDeleteShape();

    delete_connection = !delete_connection;

    if(delete_connection){
        document.getElementById("delete_connection_button").classList.remove("btn");
        document.getElementById("delete_connection_button").classList.remove("btn-primary");
        document.getElementById("delete_connection_button").classList.add("button_checked");

        console.log("[deleteConnection button] deleting connections")
    }
    else{
        document.getElementById("delete_connection_button").classList.remove("button_checked");
        document.getElementById("delete_connection_button").classList.add("btn-primary");
        document.getElementById("delete_connection_button").classList.add("btn");

        console.log("[deleteConnection button] not deleting connections")
    }
}


// delete connection on click on connection if everything was set
function deleteConnectionOnClick(){
    if(remove_connectionn_id && delete_connection){
        console.log("deleting connection", this.id)
        console.log("minus pressed, delete path with id", remove_connectionn_id);
        let index = getConnectionIndex(remove_connectionn_id);
        // remove line and than delete whole connection from array
        connections[index].line.remove();
        connections.splice(index, 1);
        remove_connectionn_id = null;
        // reset delete_connection to false
        setDeleteConnection();
    }
    else {
        console.log("you didnt click button to delete connection hehehehehehe");
    }
}


// delete connection on back arrow key press
// $('html').keyup(function(e){
//     //console.log("key code:", e.keyCode);
//     // keycode = 8 ==> backspace
//     if(e.keyCode === 8) {
//         if(remove_connectionn_id){
//             //console.log("minus pressed, delete path with id", remove_connectionn_id);
//             let index = getConnectionIndex(remove_connectionn_id);
//             // remove line and than delete whole connection from array
//             connections[index].line.remove();
//             connections.splice(index, 1);
//             remove_connectionn_id = null;
//         }
//         else {
//             //console.log("just minus pressed, delete nothing");
//         }
//     }
// });

// ############## END OF CONNECTING TWO SHAPES ##############

// ************* some other functions
// center element(target) inside his parent(outer)
function scrollTo(name_of_div, shape, coorindates = null){
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

    // scroll to specific coordinates
    if(coorindates){
        out.scrollTop(coorindates.y- out.height()/2);
        out.scrollLeft(coorindates.x - out.width()/2);
        return;
    }

    //console.log("[scrollTo] type:", shape.type);
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


// returns center point of shapes in array, centroid
function calculateCenter(shapes){
    let box = null;
    let x = 0, y = 0;
    for(let i = 0; i < shapes.length; i++){
        box = shapes[i].getBBox();
        x += box.cx;
        y += box.cy;
    }
    return {
        x: x/shapes.length || 0,
        y: y/shapes.length || 0
    }
}

function hoverIn(){
    // this.transform("s1.5");
    let currentColor = this.attr('stroke');
    // console.log("[hoverIn]",this.attr('stroke'));
    // let hehe = Raphael.getColor();
    console.log("[hoverIn]",currentColor, Raphael.getRGB(currentColor).r, Raphael.getRGB(currentColor).g, Raphael.getRGB(currentColor).b);
    let newColor = "rgb(" + Raphael.getRGB(currentColor).r * 0.5 + ", " +
                            Raphael.getRGB(currentColor).g * 0.5 + ", " +
                            Raphael.getRGB(currentColor).b * 0.5 + ")";
    console.log("[hoverIn] NEW COLOR:", newColor);
    if(Raphael.getRGB(currentColor).r == 0)
        this.attr({stroke: "rgb(0, 100, 0)"});
        // console.log("red is zero")
    else
        this.attr({stroke: "rgb(100, 0, 0)"});
        // console.log("green is zero")

    // this.attr({stroke: newColor});

    // this.attr({stroke: "rgb(150, 100, 70)"});
}
function hoverOut(){
    // this.transform("s1");
    // this.transform("s1.5");
    let currentColor = this.attr('stroke');
    // console.log("[hoverOut]",this.attr('stroke'));
    // let hehe = Raphael.getColor();
    console.log("[hoverOut]",currentColor, Raphael.getRGB(currentColor).r, Raphael.getRGB(currentColor).g, Raphael.getRGB(currentColor).b);
    let newColor = "rgb(" + Raphael.getRGB(currentColor).r * 2 + ", " +
                            Raphael.getRGB(currentColor).g * 2 + ", " +
                            Raphael.getRGB(currentColor).b * 2 + ")";
    console.log("[hoverOut] NEW COLOR:", newColor);

    if(Raphael.getRGB(currentColor).r == 0)
        this.attr({stroke: "rgb(0, 200, 0)"});
        // console.log("red is zero")
    else
        this.attr({stroke: "rgb(200, 0, 0)"});

    // this.attr({stroke: newColor});

    // this.attr({stroke: "rgb(70, 100, 150)"});

    // console.log(this.attr('stroke'));
}
// ************* end of some other functions
// window.onload = function () {
// set focus to div with paper
// $('#content').focus();


// IDinput = document.getElementById('IDinput');
// IDtext = document.getElementById('IDtext');

// // drag and drop is possible "everywhere"
// document.addEventListener("dragover", function (ev) {
//     ev.preventDefault();
// }, false);


// let element = document.getElementById('content'),
//     positionInfo = element.getBoundingClientRect(),
//     height = positionInfo.height,
//     width = positionInfo.width;

// paper = Raphael(document.getElementById('content'), 2000, 2000);
// paper.rect(0, 0, 2000, 2000).attr({"stroke-width": 10});
// console.log("[main] paper canvas:", paper.canvas);

// TESTING
// connections = [];
/*shapes = [  paper.ellipse(paper.width/2, paper.height/2, 30, 20),
 paper.rect(290, 80, 60, 40, 10),
 paper.rect(290, 180, 60, 40, 2),
 paper.ellipse(450, 100, 20, 20),
 paper.rect(paper.width/2, paper.height/2, 60, 40, 4),
 paper.rect(400, 250, 60, 40, 2)
 ];*/

// create set for objects
// var mySet = paper.set();

// create shapes
// for (var i = 0, ii = shapes.length; i < ii; i++) {
//     var color = Raphael.getColor();
//     shapes[i].attr({fill: color, stroke: color, "fill-opacity": 0, "stroke-width": 2, cursor: "move"});
//     // save reference to paper
//     shapes[i].data("paper", paper);
//     shapes[i].drag(move, dragger, up);
//     shapes[i].dblclick(removeShape);
//     shapes[i].click(onShapeClicked);
// }
// add connections between shapes
/*connections.push(paper.connection(shapes[0], shapes[1], "#000", id_connection++));
 connections.push(paper.connection(shapes[1], shapes[2], "#000", id_connection++));
 connections.push(paper.connection(shapes[1], shapes[3], "#000", id_connection++));
 connections.push(paper.connection(shapes[2], shapes[3], "#000", id_connection++, "#4286f4"));

 for(let i = 0; i < connections.length; i++)
 console.log(connections[i].from.id, ":", connections[i].to.id, connections[i].id);*/

// let c1 = paper.circle(50, 50, 50).attr('fill', 'red');
// let c2 = paper.circle(50, 50, 40).attr('fill', 'white');
// let c3 = paper.circle(50, 50, 30).attr('fill', 'red');
// let c4 = paper.circle(50, 50, 20).attr('fill', 'white');
// let c5 = paper.circle(50, 50, 10).attr('fill', 'red');

// addToShapes(c1);
// addToShapes(c2);
// addToShapes(c3);
// addToShapes(c4);
// addToShapes(c5);

// mySet.push(c1);
// mySet.push(c2);
// mySet.push(c3);
// mySet.push(c4);
// mySet.push(c5);

// make set draggable
// mySet.draggable();

// lets center screen to some shape
//scrollTo("content", shapes[0]);


// connections.push(paper.connection(shapes[1], shapes[2], "#fff", "#fff|5"));
// connections.push(paper.connection(shapes[1], shapes[3], "#000", "#fff"));
// };




// ************************************** start of zoom
jQuery(function ($) {
    IDinput = document.getElementById('IDinput');
    IDtext = document.getElementById('IDtext');
    IDdesc = document.getElementById('IDdesc');

    // drag and drop is possible "everywhere"
    document.addEventListener("dragover", function (ev) {
        ev.preventDefault();
    }, false);


    let element = document.getElementById('content'),
        positionInfo = element.getBoundingClientRect(),
        height = positionInfo.height,
        width = positionInfo.width;

    paper = Raphael(document.getElementById('content'), 3000, 3000);
    // paper.rect(0, 0, 2000, 2000).attr({"stroke-width": 10});
    //console.log("[main] paper canvas:", paper.canvas);

    // TESTING
    connections = [];
    // shapes = [  paper.ellipse(paper.width/2, paper.height/2, 30, 20),
    //  paper.rect(290, 80, 60, 40, 10),
    //  paper.rect(290, 180, 60, 40, 2),
    //  paper.ellipse(450, 100, 20, 20),
    //  paper.rect(paper.width/2, paper.height/2, 60, 40, 4),
    //  paper.rect(400, 250, 60, 40, 2)
    //  ];

    // create set for objects
    var mySet = paper.set();
    // var d = ["M", 100, 100, "l", 10, 0, "M", 105, 95, "l", 0, 10].join(",");

    // var c1 = paper.path(d).attr({"stroke-width": 3});
    // var c2 = paper.path("M200 200l10 0M205 195l0 10").attr({"stroke-width": 3});

    // var c2 = paper.path("M105 95l0 10").attr({"stroke-width": 3});
    // var c3 = paper.path("M2 100 h100 v100 h100 v100 h-100 v100 h-100 v-100 h-100 v-100 h100 z").attr({"stroke-width": 5, fill: Raphael.getColor()});

    // create shapes
    for (var i = 0, ii = shapes.length; i < ii; i++) {
        var color = Raphael.getColor();
        shapes[i].attr({fill: color, stroke: color, "fill-opacity": 0, "stroke-width": 2, cursor: "move"});
        // save reference to paper
        shapes[i].data("paper", paper);
        // shapes[i].drag(move, dragger, up);
        //shapes[i].dblclick(removeShape);
        shapes[i].click(onShapeClicked);
    }


    panZoom = paper.panzoom();
    panZoom.enable();
    // paper.safari();

    $("#up").click(function (e) {
        //console.log("[mapContainer up]");

        panZoom.zoomIn(0.9, calculateCenter(shapes));
        e.preventDefault();
    });

    $("#down").click(function (e) {
        //console.log("[mapContainer down]");

        panZoom.zoomOut(0.9, calculateCenter(shapes));
        e.preventDefault();
    });

});
// ************************************** end of zoom





function addToShapes(shape){
    //shape.attr({fill: "blue", stroke: "blue", "fill-opacity": 1, "stroke-width": 2, });
    // save reference to paper
    shape.data("paper", paper);
    // shape.drag(move, dragger, up);
    //shape.dblclick(removeShape);
    shape.click(onShapeClicked);
    shapes.push(shape)
}

////////

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

function changeIncomingConnections(node_id, change){
    for(let i = 0; i < connections.length; i++){
        if(connections[i].to.id === node_id){
            if(change){
                connections[i].line.hide();
            }
            else{
                connections[i].line.show();
            }
            //console.log(change);
        }
    }
}

function changeConnectionVisibility(shape_id, first_id){
    var shape = paper.getById(shape_id);

    //console.log('shape id: ' + shape.id);

    var hide = paper.getById(first_id).data('connections');
    //console.log('before   HIDE of ID: ' +hide + ' : ' + shape.id);
    var setID;
    //hide = !hide;
    //console.log('after    HIDE of ID: ' +hide + ' : ' + shape.id);
    //console.log(connections.length);
    for(let i = 0; i < connections.length; i++){
        if(connections[i].from.id === shape.id){
            //console.log('FOUND ONE');
            if(hide){
                if(shape.data('type') !== 'decision'){
                    paper.getById(shape.data('resizableID')).attr({stroke: Colors.red});
                }

                setID = getSet(connections[i].to.id);

                if(setID && connections[i].to.id !== first_id){
                    changeIncomingConnections(connections[i].to.id, true);
                    connections[i].line.hide();
                    //console.log(connections[i].line.id +' is hidden');
                    canvasSets[setID].forEach( function (e) {
                        //console.log('element ID: ' +e.id);
                            paper.getById(e.id).hide();
                        }

                    );

                    //shape.data('connections', hide);
                }
                else{
                    connections[i].line.hide();
                    //shape.data('connections', hide);
                    continue;
                    //console.log('set ID to hide: ' + paper.getById(connections[i].to.id).data('setID'));
                }

            }
            else{
                if(shape.data('type') !== 'decision'){
                    paper.getById(shape.data('resizableID')).attr({stroke: Colors.green});
                }

                setID = getSet(connections[i].to.id);
                if(setID && connections[i].to.id !== first_id){
                    changeIncomingConnections(connections[i].to.id, false);
                    connections[i].line.show();
                    canvasSets[setID].forEach( function (e) {
                            paper.getById(e.id).show();
                        }
                    );

                    //shape.data('connections', hide);
                }
                else{
                    connections[i].line.show();
                    //shape.data('connections', hide);
                    continue;
                }

            }
            changeConnectionVisibility(connections[i].to.id, first_id);

        }
        else{
            //console.log('NO CONNECTIONS');
        }
    }

}

function hideNodes(parentID) {
    //console.log('parent: ' +parentID);
    var shape = paper.getById(parentID);
    changeConnectionVisibility(shape.id, shape.id);
    var status = shape.data('connections');
    shape.data('connections', !status);
}

// the actual drawing function, determines which shape to draw
function shapeDraw(arg, ev) {

    // create local variables
    var shape;
    var set = paper.set();


    var txt;

    // draws a rectangle
    if(arg === "aSquare"){
        // create element and draw it on canvas
        shape =  paper.rect(ev.offsetX, ev.offsetY, 100, 40).attr({fill: "white", cursor: "move"}).data('setID', id);

        shape.data('connections', true);

        shape.data('desc', '');


        // CREATE + sign
        console.log("[shapeDraw] ev.offset:", ev.offsetX, ev.offsetY)
        let d = ["M", ev.offsetX+5, ev.offsetY+10, "l", 10, 0, "M", ev.offsetX+10, ev.offsetY+5, "l", 0, 10].join(",");
        let resizable = paper.path(d).attr({"stroke-width": 3, stroke: Colors.green});
        resizable.mouseover(hoverIn);
        resizable.mouseout(hoverOut);
        // DONE + sign

        // creates a 'hide' rectangle
        // var resizable = paper.rect(ev.offsetX+5, ev.offsetY+5, 10, 10).attr({fill: "green"});
        resizable.data('type', 'hide');
        resizable.data('parentID', shape.id);
        
        shape.mouseup(function () {
            // display onlt if shape was not dragged
            if(!dragging_set && !line_first_shape_id && !line_second_shape_id && !delete_shape){
                document.getElementById('descText').innerHTML = shape.data('desc');
                document.getElementById('h4ID').innerHTML = 'Opis vozlišča: ' +  shape.id;
                $("#longText").modal();
                console.log("[longText modal] showing");
            }
        });

        shape.data('resizableID', resizable.id);
        // adds a text field
        txt = paper.text(ev.offsetX+50, ev.offsetY+20, "no-text").attr({'font-size': 7, 'fill': 'red', 'text-anchor': 'middle'});

        // adds a dblclick handler to the 'hide' rectangle
        resizable.click(function(){hideNodes(resizable.data('parentID'))});


        // adds a dblclick handler to the text field
        txt.dblclick(function () {
            IDtext.focus();
        });

        shape.data('rotate', false);

        // adds the elements to a set
        set.push(shape);
        set.push(resizable);
        set.push(txt);
        set.draggable();

        for(var i in set){
            set[i].setName = 'name' + set[0].id;
        }

        // saves the set ito a global array
        canvasSets.push(set);
        // increments the global id
        id++;
    }
    // draws a decision node, similar process as for rectangle element, doesn't include the 'details' element
    else if(arg === "aDecision"){
        shape = paper.rect(ev.offsetX, ev.offsetY, 50, 50).attr({fill: "white", cursor: "move"}).data('setID', id);
        shape.rotate(45);
        shape.data('rotate', true);
        shape.data('type', 'decision');
        txt = paper.text(ev.offsetX+25, ev.offsetY+25, "no-text").attr({'font-size': 7, 'fill': 'red'});

        shape.data('connections', true);
        shape.data('desc', '');

        txt.dblclick(function () {
            IDtext.focus();
        });

        set.push(shape);
        set.push(txt);
        set.draggable();

        for(var i in set){
            set[i].setName = 'name' + set[0].id;
        }

        canvasSets.push(set);
        console.log('ADDED SHAPE - DRAW');
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
    //console.log("set id: ", set.data('id'));
    addToShapes(shape);

    // saves the current shape to a global scope
    active = shape;

    // sets the values in IDinput and IDtext to the currently active shape's values
    IDinput.setAttribute('value', shape.id);
    // when creating
    IDtext.removeAttribute('disabled');

    IDdesc.removeAttribute('disabled');

    // shape click event handler
    shape.click(function () {

        // saves the current shape to a global spoce
        active = shape;

        // change colours (testing purposes)
        //shape.attr({fill: getRandomColor()});
        //shape.attr({stroke: getRandomColor()});

        // read and set the element's values for IDtext and IDinput
        IDtext.value = "neki";

        IDtext.value = getText(shape.id).short;
        IDdesc.value = getText(shape.id).long;
        //console.log("IDtext: ", IDtext.value);
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
        //console.log("getSet:",canvasSets[i][0].id);
        if(canvasSets[i][0].id === id){
            console.log("found correct set", id);
            return i;
        }
    }
    return null;
}

// acces the correct set from canvasSets and extract the text element 't', change the element's value
function getText(id) {
    // console.log("[getText] id:",id);
    let index = getSet(id);

    var set = canvasSets[index];
    // console.log("[getText] set:", set);

    var t = set.pop();
    var txt1 = t.attr('text');
    //console.log("TEKST OUT: ", txt);
    set.push(t);

    var text2 = set[0].data('desc');
    return {short: txt1, long: text2};
}

// 'onblur' event handler for IDtext input field, changes the text in the corresponding element (set of elements)
function setText() {
    var id = IDinput.value;
    if(paper.getById(id).type !== 'path'){
        var set = canvasSets[getSet(id)];
        //console.log("[setText] set:", set);
        var t = set.pop();
        t.attr({text: IDtext.value});

        set[0].data('desc', IDdesc.value);
        set.push(t);
    }
    // TODO change text on line
    else{
        return;
    }

}

// de-selects any selected element and hides handles
function looseFocus(ev){
    if(ev.target.childElementCount > 0){
        // for(var i = 0; i < canvasHandles.length; i++){
        //     // canvasHandles[i].hideHandles();
        // }
    }

}

// TODO fix dragging of decision node, check all event-handlers after re-load
// TODO fix dragging of decision node, check all event-handlers after re-load

function saveGraph() {

    connections = [];
    shapes = [];
    canvasSets = [];
    json = null;



    json = paper.toJSON(function(el, data) {

        if(window[data.setName]){
            window[data.setName].remove();
        }

        let dx, dy;

        data.id = el.node.id;
        console.log('NODE ID: ',el.id);
        data.setName = el.setName;
        //console.log('data setName PRE: ' + data.setName);
        //console.log('element x and y PRE: ', el.attr('x'), el.attr('y'));
        if(el.data('type') === 'decision'){
            el.rotate(-45);
            let cx = el.getBBox().x;
            let cy = el.getBBox().y;

            dx = cx - el.attr('x');
            dy = cy - el.attr('y');
        }
        else{
            dx = el.matrix.e;
            dy = el.matrix.f;
        }

        console.log(dx, dy);


        el.attr('x', el.attr('x') + dx);
        el.attr('y', el.attr('y') + dy);

        el.matrix.a = 1;
        el.matrix.b = 0;
        el.matrix.c = 0;
        el.matrix.d = 1;
        el.matrix.e = 0;
        el.matrix.f = 0;


        return data;
    });
    console.log(json);

    $.post("../../../DiaGenKri/public/visualisation/save",
        {
            data: json
        },
        function(data, status){
            console.log(data);
            console.log('\n')
            json = data;
        });

    console.log(json);

    paper.clear();

}

function loadGraph() {
    console.log('LOADING');
    paper = Raphael('content');

    paper.fromJSON(json, function(el, data) {
        el.node.id = data.id;
        console.log('el node id: ',el.id);
        // Recreate the set using the identifier
        if( !window[data.setName] ){
            window[data.setName] = paper.set();

            canvasSets.push(window[data.setName]);

            console.log(data.setName);
        }

        // Place each element back into the set
        //console.log('setName POST:' +data.setName);
        window[data.setName].push(el);

        window[data.setName].draggable();

        console.log('SAVING: ', window[data.setName]);

        console.log('window :' +window[data.setName]);

        el.click(function () {
            console.log(el.matrix);
        })



        if(el.type === 'path'){
            var idSplit = el.data('fromTo').split(" ");
            connections.push(paper.connection(paper.getById(idSplit[0]), paper.getById(idSplit[1]), "#000", id++));
            el.remove();
            console.log("PATH");
        }
        else if(el.type === 'rect' && el.data('type') === 'hide'){
            el.click(function () {
                hideNodes(el.data('parentID'));
            })
            console.log("HIDE");
        }
        else if(el.type === "rect" && el.data('type') === 'decision'){
            el.rotate(45);
            addToShapes(el);
            console.log("DECISION");
        }
        else if(el.type === 'rect' && el.data('type') === undefined){
            console.log("ELSE");
            addToShapes(el);
        }
        console.log('setName');
        el.setName = data.setName;

        //return el;
    });
}














