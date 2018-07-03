// connection implementation between two objects
Raphael.fn.connection = function (obj1, obj2, line, id_c, color_user = "#000") {
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
    let conn_text = null;

    let sub_path = null;

    if (line && line.line) {
        line.line.attr({"arrow-end":"classic-wide-long"});
        line.line.attr({path: path});

        let line_path = line.line;
        // console.log(line_path);

        // console.log("[creating connections] IF IF IF IF");
        let line_center_x = line_path.getPointAtLength(line_path.getTotalLength() / 2).x;
        let line_center_y = line_path.getPointAtLength(line_path.getTotalLength() / 2).y;


        // console.log("NEW FOR LINE:", line_center_x, line_center_y)

        line.text.attr({"x": line_center_x, "y": line_center_y});

        let len = calculate(line);

        if(len !== 0){
            // console.log('len: ', len);
            // console.log('line_len: ', line_path.getTotalLength());
            if(len > line_path.getTotalLength()){
                line_path.attr({'stroke': 'white'});
            }
            else{
                line_path.attr({'stroke': 'black'});
            }
            line.subpath.show();
            line.subpath.data('visible', true);

            let sub_p = line_path.getSubpath(
                (line_path.getTotalLength() / 2)-len,
                (line_path.getTotalLength() / 2)+len);

            line.subpath.attr({path: sub_p});

            //console.log("ALPHA: ", line_path.getPointAtLength(line_path.getTotalLength() / 2).alpha);
            //console.log("LENGTH: ", length);
        }
        else{
            line.subpath.hide();
            line.subpath.data('visible', false);
        }


    } else {
        // console.log("[creating connections] ELSE ELSE ELSE ELSE");

        let color = color_user;
        let line_path = this.path(path).attr({"arrow-end":"classic-wide-long", stroke: color, fill: "none", "stroke-width": 3});
        line_path.setName = 'name' + id_c;

        // console.log("[creating connections] line_path:", line_path);

        //line_path.setID = id_c;
        line_path.data('fromTo', obj1.id + " " + obj2.id);
        if(!viewonly_graph){
            line_path.mouseover(deleteConnection);
            line_path.mouseout(noDelete);
            line_path.click(deleteConnectionOnClick);
        }
        line_path.data("id_connection", id_c);


        console.log("[connection] path from:", obj1.id, "to:", obj2.id);
        console.log("[connection] fromTo", line_path.data("fromTo"));

        sub_path = paper.path(
            line_path.getSubpath(
                (line_path.getTotalLength() / 2)-25,
                (line_path.getTotalLength() / 2)+25))
            .attr({'stroke-width' : '6', 'stroke' : '#f1f1f1'});
        sub_path.data("type", "sub_path");
        sub_path.data("id_connection", id_c);

        // sub_path.mouseover(function (){
        //     this.attr("stroke-width", 5);
        // });
        // sub_path.mouseout(function (){
        //     this.attr("stroke-width", 5);
        // });

        conn_text = paper.text(line_path.getPointAtLength(line_path.getTotalLength() / 2).x,
            line_path.getPointAtLength(line_path.getTotalLength() / 2).y, "default-text");

        conn_text.attr({'fill': 'black', 'font-size': 12});
        conn_text.data("type", "connection_text");
        conn_text.click(textClicked);
        conn_text.mouseover(function (){
            this.attr({'font-size': 13});
        });
        conn_text.mouseout(function (){
            this.attr({'font-size': 12});
        });
        conn_text.data("id_connection", id_c);
        conn_text.toFront();

        if(!viewonly_graph){
            line_path.dblclick(addDblclickHandlers);
            // line_path.dblclick(function(){
            //     completeResetInputs();
            //     console.log("POVEZAVE POVEZAVE");
            //     disableInputs(true, "#IDdesc");
            //     disableInputs(false, "#IDtext");
            //     changingText = conn_text;
            //     let inputText = document.getElementById("IDtext");
            //     inputText.value = conn_text.attr("text");
            //     inputText.focus();
            //     return;
            // });
            sub_path.dblclick(addDblclickHandlers);
        }
        sub_path.data('visible', true);

        return {
            line: line_path,
            subpath: sub_path,
            from: obj1,
            to: obj2,
            id: id_c,
            text: conn_text
        };
    }
};

function addDblclickHandlers(){
    completeResetInputs();
    disableInputs(true, "#IDdesc");
    disableInputs(false, "#IDtext");

    // find connection with that id
    let index = getConnectionById(this.data("id_connection"));
    let txt = connections[index].text;

    changingText = txt;
    let inputText = document.getElementById("IDtext");
    inputText.value = txt.attr("text");
    inputText.focus();
    console.log("dbl click handler on path fired");
    // return;
}

// calculate connection text background line
// direct atribute specifies whether to use line or line.line,
// line.line is used when connection is passed as paramtere,
// line is used when one is accessing connection directly
function calculate (line, direct = false, text = null) {

    let line_path = direct ? line : line.line;

    let alpha = line_path.getPointAtLength(line_path.getTotalLength() / 2).alpha;

    let length = alpha / 4;

    let the_text = text !== null ? text : line.text
    // console.log("[calculate] the_text:", the_text);

    if(the_text.attr("text").length === 0){
        return 0;
    }

    if(90 <= alpha && alpha <= 165){
        // console.log('90 <= x <= 165');
        length = (alpha / 11.8) + 2;
    }
    else if(165 < alpha && alpha <= 180){
        // console.log('165 < x <= 180');
        length = alpha / 20;
        length = length * (the_text.attr("text").length * 0.36);
    }
    else if(195 < alpha && alpha <= 270){
        // console.log('195 < x <= 270');
        length = alpha / 11.8;
    }
    else if(180 < alpha && alpha <= 195){
        // console.log('180 < x <= 195');
        length = (alpha / 30) + 3;
        length = length * (the_text.attr("text").length * 0.38);
    }
    else if(378 <= alpha && alpha < 390){
        // console.log('375 <= x < 390');
        length = (alpha / 38)  + 5;
    }
    else if(360 <= alpha && alpha < 378){
        // console.log('360 <= x < 375');
        length = alpha / 55;
        length = length * (the_text.attr("text").length * 0.46);
    }
    else if(390 <= alpha && alpha < 450){
        // console.log('390 <= x < 450');
        length = (alpha / 52) + 5;
    }
    else if(420 <= alpha && alpha < 450){
        // console.log('420 <= x < 450');
        length = alpha / 26;
    }
    return length;
}

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
            // disableInputs(true);
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

// to trigger raphael events
Raphael.el.trigger = function(eventName){
    for(var i = 0, len = this.events.length; i < len; i++) {
        if (this.events[i].name == eventName) {
            this.events[i].f.call(this);
        }
    }
}


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

// variable to know for which "text" shape the text is being edited
let changingText = null;

// if the same graph is being edited and id of that graph
let editingGraph = false;
let graphId = null;

// if app should be in view only state
let viewonly_graph = false;

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

// create custom event
// its purpose will be to reset inputs
let event_reset = new Event("reset_inputs");

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
    for(let i = 0; i < shapes.length; i++){
        if(shapes[i].id === shape_id)
            index = i;
    }
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

    // resets input elements
    completeResetInputs();

    if (index > -1) {
        //console.log("removing", this.id);
        shapes.splice(index, 1);
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
                connections[j].text.remove();
                connections[j].subpath.remove();
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
        //document.getElementById("delete_shape_button").classList.remove("btn");
        document.getElementById("delete_shape_button").classList.remove("btn-warning");
        document.getElementById("delete_shape_button").classList.add("btn-danger");

        console.log("[setDeleteShape button] deleting shapes")
    }
    else{
        document.getElementById("delete_shape_button").classList.remove("btn-danger");
        document.getElementById("delete_shape_button").classList.add("btn-warning");
        //document.getElementById("delete_shape_button").classList.add("btn");

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

// returns index of connection's line with id as parameter
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
    // enable inputs, because maybe user missclicked and wants to edit text
    disableInputs(true);

    // saves the current shape to a global spoce
    active = this;
    changingText = this.data('type') === 'decision' ? canvasSets[getSet(this.id)][1] : canvasSets[getSet(this.id)][2]
    resetText(changingText, this);
    IDinput.setAttribute('value', this.id);

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
    // refresh
    paper.connection(connections[connections.length - 1]);
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
        //document.getElementById("delete_connection_button").classList.remove("btn");
        document.getElementById("delete_connection_button").classList.remove("btn-warning");
        document.getElementById("delete_connection_button").classList.add("btn-danger");

        console.log("[deleteConnection button] deleting connections")
    }
    else{
        document.getElementById("delete_connection_button").classList.remove("btn-danger");
        document.getElementById("delete_connection_button").classList.add("btn-warning");
        //document.getElementById("delete_connection_button").classList.add("btn");

        console.log("[deleteConnection button] not deleting connections")
    }
}


// delete connection on click on connection if everything was set
function deleteConnectionOnClick(){
    if(remove_connectionn_id && delete_connection){
        completeResetInputs();
        console.log("deleting connection", this.id)
        console.log("minus pressed, delete path with id", remove_connectionn_id);
        let index = getConnectionIndex(remove_connectionn_id);
        // remove line and text, then delete whole connection from array
        connections[index].line.remove();
        connections[index].text.remove();
        connections[index].subpath.remove();
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

// happens when you hover over a "plus" which servers for zooming
function hoverIn(){
    // this.transform("s1.5");
    let currentColor = this.attr('stroke');
    // console.log("[hoverIn]",this.attr('stroke'));
    // let hehe = Raphael.getColor();
    // console.log("[hoverIn]",currentColor, Raphael.getRGB(currentColor).r, Raphael.getRGB(currentColor).g, Raphael.getRGB(currentColor).b);
    let newColor = "rgb(" + Raphael.getRGB(currentColor).r * 0.5 + ", " +
        Raphael.getRGB(currentColor).g * 0.5 + ", " +
        Raphael.getRGB(currentColor).b * 0.5 + ")";
    // console.log("[hoverIn] NEW COLOR:", newColor);
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
    // console.log("[hoverOut]",currentColor, Raphael.getRGB(currentColor).r, Raphael.getRGB(currentColor).g, Raphael.getRGB(currentColor).b);
    let newColor = "rgb(" + Raphael.getRGB(currentColor).r * 2 + ", " +
        Raphael.getRGB(currentColor).g * 2 + ", " +
        Raphael.getRGB(currentColor).b * 2 + ")";
    // console.log("[hoverOut] NEW COLOR:", newColor);

    if(Raphael.getRGB(currentColor).r == 0)
        this.attr({stroke: "rgb(0, 200, 0)"});
    // console.log("red is zero")
    else
        this.attr({stroke: "rgb(200, 0, 0)"});

    // this.attr({stroke: newColor});

    // this.attr({stroke: "rgb(70, 100, 150)"});

    // console.log(this.attr('stroke'));
}

// fires when "text" shape is clicked
function textClicked(){

    // first check if the text is connections text
    if(this.data("type") === "connection_text") {
        completeResetInputs();
        console.log("POVEZAVE POVEZAVE");
        disableInputs(true, "#IDdesc");
        disableInputs(false, "#IDtext");
        changingText = this;
        let inputText = document.getElementById("IDtext");
        inputText.value = this.attr("text");
        inputText.focus();
        return;
    }

    // get correct set, so set which this text belongs to

    // first determine on which position in set is the actual "text" shape,
    // if its decision node it is on position 1 because it has only 2 elements,
    // otherwise it is on position 2 because rectangle got 3 elements

    // let whichAttr =  this.data('type') === 'decision' ? 1 : 2; not working because set does not know if it is decision or not
    // console.log("PLACE:", whichAttr);
    console.log("ID OF TEXT:", this.id);
    let indexCorrectSet = null;

    indexCorrectSet = getSet(this.id, 2);
    // if you didnt find correct set with item on index 2, try with index 1
    if(indexCorrectSet === null)
        indexCorrectSet = getSet(this.id, 1);

    // if you still didn't find anything there is a problem
    if (indexCorrectSet === null){
        console.log("[textClicked] was not able to find correct set, something is wrong");
        return;
    }
    console.log("CORRECT INDEX:", indexCorrectSet);
    active = canvasSets[indexCorrectSet][0];
    IDinput.setAttribute('value', active.id);


    // remember which text you are changin
    console.log("[textClicked] changingText changed");
    changingText = this;
    console.log("[textClicked] element:", this.id, changingText.id);

    // set the value of input field to the current value of text
    // let inputText = document.getElementById("IDtext");
    // let descriptionText = document.getElementById("IDdesc");
    // inputText.value = this.attr("text");
    // descriptionText.value = active.data("desc"); // active is currently active shape

    // enable inputs
    if(active.data('type') === 'decision'){
        disableInputs(true, "#IDdesc");
        disableInputs(false, "#IDtext");
    } else
        disableInputs(false);

    resetText(this, active, true);
    // inputText.focus();
}

// reset input fields for short and long text
// parameters:
//  textShape   - shape that represents text(1(decision) or 2(square) index in a Set)
//  vertexShape - actual rectangle shape
//  focus       - whether to focus text field("#IDtext") or not
function resetText(textShape, vertexShape, focus=false){
    let inputText = document.getElementById("IDtext");
    let descriptionText = document.getElementById("IDdesc");
    inputText.value = textShape.attr("text");
    descriptionText.value = vertexShape.data("desc"); // active is currently active shape
    if(focus)
        inputText.focus(); 
}

// completly resets anything related to inputs
function completeResetInputs(){
    active = null;
    changingText = null;
    IDinput.setAttribute('value', "");
    document.getElementById("IDtext").value = "";
    document.getElementById("IDdesc").value = "";
}

// disables inputs
function disableInputs(decision, input_id = null){
    if(!input_id){
        $( "#IDtext" ).prop( "disabled", decision );
        $( "#IDdesc" ).prop( "disabled", decision );
        return;
    }

    $(input_id).prop( "disabled", decision);
}

// add event handlers back to elements
// +++++++++++++++++++++++++++++++++++
function rainingEvents(item, type){
    if(type === "rect"){
        rectEvents(item, type);
    } else if (type === "decision") {
        rectEvents(item, type);
    } else if (type === "connection") {
        pathEvents(item, type);
    } else if (type === "hide") {
        pathEvents(item, type);
    } else if (type === "subpath") {
        pathEvents(item, type);
    } else if (type === "connection_text") {
        textEvents(item, type);
    } else if (type === "shape_text") {
        textEvents(item, type);
    }
}

function rectEvents(item, type){
    if(type === "decision"){
        item.rotate(45);
        item.data('rotate', true);
        item.data('type', 'decision');

        item.data('connections', true);
        item.data('desc', '');
        id++;
    } else {
        item.data('connections', true);
        // item.data('desc', 'default-text');

        item.mouseup(function () {
            // display only if shape was not dragged
            if(!dragging_set && !line_first_shape_id && !line_second_shape_id && !delete_shape){
                document.getElementById('descText').innerHTML = item.data('desc');
                document.getElementById('h4ID').innerHTML = 'Node description: ' +  item.id;
                $("#longText").modal();
                console.log("[longText modal] showing");
            }
        });
        item.data('rotate', false);
        item.data('type', 'rect');
        // increments the global id
        id++;
    }
}

function pathEvents(item, type){
    if(type === "connection"){
        item.data('type', 'connection');
    } else if (type === "hide"){
        // console.log("[pathEvents] type", type);
        item.mouseover(hoverIn);
        item.mouseout(hoverOut);
        item.data('type', 'hide');

        let parent_shape = canvasSets[getSet(item.id, 1)][0];
        parent_shape.data('resizableID', item.id);

        item.data('parentID', parent_shape.id);


        // adds a dblclick handler to the 'hide' rectangle
        item.click(function(){hideNodes(item.data('parentID'))});
    } else if (type === "subpath"){
        item.data('type', 'subpath');
    }
    return true;
}

function textEvents(item, type){
    if(type === "shape_text"){
        // console.log("[textEvents] type", type);
        item.data("type", "shape_text");
        // adds a dblclick handler to the text field
        if(!viewonly_graph){
            item.click(textClicked);
            item.mouseover(function (){
                this.attr({'font-size': 11});
            });
            item.mouseout(function (){
                this.attr({'font-size': 10});
            });
        }
    } else if(type === "connection_text"){
        // console.log("[textEvents] type", type);

        item.attr({'fill': 'black', 'font-size': 12});
        item.data("type", "connection_text");
        if(!viewonly_graph){
            item.click(textClicked);
            item.mouseover(function (){
                this.attr({'font-size': 13});
            });
            item.mouseout(function (){
                this.attr({'font-size': 12});
            });
        }
        item.toFront();
    }
    return true;
}

// returns index of connectino with id as parameter
function getConnectionById(id_c){
    for (let i = connections.length - 1; i >= 0; i--) {
        if (connections[i].id === id_c)
            return i;
    }
    return null;
}


// extracts parameter from given string(url), www.google.com?abc=3, it will extract abc and output 3
function extractParameters( name, url ) {
    if (!url) url = location.href;
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    let regexS = "[\\?&]"+name+"=([^&#]*)";
    let regex = new RegExp( regexS );
    let results = regex.exec( url );
    return results == null ? null : results[1];
}

// get data about graph with certain id
function getGraphData(id_graph_load) {
    let info = null
    $.post("../../../DiaGenKri/public/visualisation/load",
    {
        id: id_graph_load
    },
    function(data, status){
        const myArray = $.parseJSON(data);
        // const podatki = $.parseJSON(myArray["data"]);
        // window["f_json"] = myArray["data"]
        console.log("[david.js] myArray", myArray);
        // console.log(podatki);

        info = {
            id: myArray["id"],
            email: myArray["e-mail"],
            name: myArray["name"],
            description: myArray["description"],
            intended: myArray["visual"], // 1 are doctors
            algorithm_type: myArray["algorithm_type"]
        };
        // console.log("info about graph, without data:", info);
        populateForm("name", info);
    }
    );
    
}

// populates form with name with data(object)
function populateForm(name, data){
    try{
        document.getElementById("graphName").value = data.name;
        document.getElementById("graphDescritption").value = data.description;
        console.log("data intended", data.intended);

        if(data.intended == 0){
            console.log("in 0 if");
            document.getElementById("typeDiagnostic").checked = true;
            $("#test_patients").removeClass("hide-me");
        } else if(data.intended == 1){
            document.getElementById("typeVisual").checked = true;
            $("#test_patients").addClass("hide-me");

        }

        let diagnostic = document.getElementById("opt1");
        let treatment = document.getElementById("opt2");
        let other = document.getElementById("opt3");


        if(data.algorithm_type == 7){
            diagnostic.selected = true;
            treatment.selected = true;
            other.selected = true;
        } else if (data.algorithm_type == 6){
            treatment.selected = true;
            other.selected = true;
        } else if (data.algorithm_type == 5){
            diagnostic.selected = true;
            other.selected = true;
        } else if (data.algorithm_type == 4){
            other.selected = true;
        } else if (data.algorithm_type == 3){
            diagnostic.selected = true;
            treatment.selected = true;
        } else if (data.algorithm_type == 2){
            treatment.selected = true;
        } else if (data.algorithm_type == 1){
            diagnostic.selected = true;
        } else {
            console.log("should say nothing, yup, silly me, oh silly mo moo")
        }

        console.log("[populateForm] will fill data with ", data);
    } catch(err){
        console.log("No save modal", err);
    }
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

    // // paper.print(100, 100, "Test string", paper.getFont("Times", 800), 30);
    // let txxt = paper.print(10, 50, "print", paper.getFont("Museo"), 30).attr({fill: "#fff"});
    // // following line will paint first letter in red
    // txxt.attr({fill: "#f00"}).toFront();;

    // paper.rect(200, 200, 200, 200).attr({"stroke-width": 10});
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

    // set default class for notifications
    // $.notify.defaults({ className: "success" });.

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

    // loose focus if enter is pressed
    $("#IDtext").keyup(function(e){
        //console.log("key code:", e.keyCode);
        // keycode = 8 ==> backspace
        if(e.keyCode === 13) {
            // console.log("ENTER CLICKED, loosing focus");
            // this.blur();
            // currentText = this.value;
            // changingText.attr({text: currentText});
            // this.value = "";
            $("#IDtext").trigger( "blur" );
        }

    });

    $("#IDdesc").keyup(function(e){
        if(e.keyCode === 13) {
            $("#IDdesc").trigger( "blur" );
        }
    });

    // change text on input
    $('#IDtext').on('input', function() {
        let currentText = $.trim($(this).val());
        console.log("[IDtext onInput] changingText:", changingText.id);
        // check if input changed and its not empty, only then change the value of current text,
        // because we do not want data loss
        if(currentText !== changingText.attr("text")){
            changingText.attr({text: currentText});
            if (changingText.data("type") === "shape_text")
                changeWidth(changingText);
            if(changingText.data("id_connection") !== undefined && changingText.data("type") === "connection_text"){
                // console.log(changingText.data("id_connection"));
                calculateSubPath(changingText.data("id_connection"));
            }
        }
    });

    $('#IDdesc').on('input', function() {
        let currentText = $.trim($(this).val());
        console.log("[IDdesc onInput] changingText:", changingText.id);
        // check if input changed and its not empty, only then change the value of current text,
        // because we do not want data loss
        if(currentText !== active.data("desc"))
            active.data("desc", currentText);
    });

    // change text on blur
    $("#IDtext").on("blur", function (){
        console.log("[IDtext blur]", this.value);
        let currentText = this.value;
        // check if input changed and its not empty, only then change the value of current text,
        // because we do not want data loss
        if(currentText !== changingText.attr("text"))
            changingText.attr({text: currentText});
        //this.value = "";

        // also blur long text if its not focused
        // console.log($(":focus") );
        // if ($(":focus") !== document.getElementById("IDdesc")){
        // console.log("WELL I WILL ALSO BLUR LONG TEXT HEHEHEHE");
        // $("#IDdesc").trigger( "blur" );
        // }

        disableInputs(true, "#IDtext");
    });

    $("#IDdesc").on("blur", function (){
        console.log("[IDdesc blur]", this.value);
        let currentText = this.value;
        // check if input changed and its not empty, only then change the value of current text,
        // because we do not want data loss
        if(currentText !== active.data("desc"))
            active.data("desc", currentText);
        //this.value = "";

        disableInputs(true, "#IDdesc");
    });

    $("#modal-save-graph").click(function(){
        console.log("[modal-save-graph] save, clicked");
        if(saveGraph()){
            $("#metaData").modal('hide');
            resetModal();
        }
    });

    $("#modal-cancel-graph").click(function(){
        console.log("[modal-save-graph] cancel, clicked");
        resetModal();
    });

    // listen for change in events so you can show TEST button when needed
    $("#typeDiagnostic").click(function(){
        $("#test_patients").removeClass("hide-me");
    });

    $("#typeVisual").click(function(){
        $("#test_patients").addClass("hide-me");

    });

    // **** not needed anymore, because editingGraph can be set to true in loadGraph() method,
    // **** that works because loadGraph is caled from getData.js which executes it only when graph 
    // **** is being loaded
    // check wheter user is editing graph or its completly new graph
    graphId = extractParameters('id', window.location.href);
    editingGraph = graphId === null ? false : true
    // get data about graph and populate form
    if(editingGraph)
        getGraphData(graphId);
    


});

function showModalSave(){
    $("#metaData").modal('show');
}
// ************************************** end of zoom

function changeWidth(textShape) {
    console.log('changeWidth of', textShape);
    let parent = paper.getById(textShape.data('parent'));
    if(textShape.getBBox().width > parent.attr('width') - 15){
        console.log('Too big!');
        parent.attr('width', textShape.getBBox().width + 20);
    }
    else{
        console.log('Shorter');
        if(parent.attr('width')- 4  > textShape.getBBox().width && parent.attr('width') - 4 > 100){
            console.log('Parent width: ', parent.attr('width'));
            parent.attr('width', parent.attr('width') - 6);
        }
    }

    // update connections
    for (let i = connections.length; i--;) {
        paper.connection(connections[i]);
    }
}

function calculateSubPath(id_c){
    let index = getConnectionById(id_c);
    let line = connections[index].line;
    let subpath = connections[index].subpath;
    let text = connections[index].text;
    // console.log(line, subpath);
    // if(1+1)
    //     return;

    let len = calculate(line, true, text);

    if(len !== 0){
        // console.log('len: ', len);
        // console.log('line_len: ', line_path.getTotalLength());
        if(len > line.getTotalLength()){
            line.attr({'stroke': 'white'});
        }
        else{
            line.attr({'stroke': 'black'});
        }
        subpath.show();
        subpath.data('visible', true);

        let sub_p = line.getSubpath(
            (line.getTotalLength() / 2)-len,
            (line.getTotalLength() / 2)+len);

        subpath.attr({path: sub_p});
    }
    else{
        subpath.hide();
        subpath.data('visible', false);
    }
}



function addToShapes(shape){
    //shape.attr({fill: "blue", stroke: "blue", "fill-opacity": 1, "stroke-width": 2, });
    // save reference to paper
    shape.data("paper", paper);
    // shape.drag(move, dragger, up);
    //shape.dblclick(removeShape);
    if(!viewonly_graph)
        shape.click(onShapeClicked);
    if(shapes.length === 0){
        shape.data("root", true);
    }
    else{
        shape.data("root", false);
    }
    shapes.push(shape)
    // console.log("[addToShapes] element added", shape);
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
                connections[i].text.hide();
                connections[i].subpath.hide();
                // console.log("[changeIncomingConnections] hiding connection with id", connections[i].id)
            }
            else{
                connections[i].line.show();
                connections[i].text.show();
                if(connections[i].subpath.data('visible') === true){
                    connections[i].subpath.show();
                }
                // console.log("[changeIncomingConnections] showing connection with id", connections[i].id)

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
                    connections[i].text.hide();

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
                    connections[i].text.hide();

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
                    connections[i].text.show();

                    canvasSets[setID].forEach( function (e) {
                            paper.getById(e.id).show();
                        }
                    );

                    //shape.data('connections', hide);
                }
                else{
                    connections[i].line.show();
                    connections[i].text.show();

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

    // disable inputs
    disableInputs(true);

    // create local variables
    var shape;
    var set = paper.set();


    var txt;

    // draws a rectangle
    if(arg === "aSquare"){
        // create element and draw it on canvas
        shape =  paper.rect(ev.offsetX, ev.offsetY, 100, 40).attr({fill: "white", cursor: "move"}).data('setID', id);

        shape.data('connections', true);

        shape.data('desc', 'default-text');


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
            // display only if shape was not dragged
            if(!dragging_set && !line_first_shape_id && !line_second_shape_id && !delete_shape){
                document.getElementById('descText').innerHTML = shape.data('desc');
                document.getElementById('h4ID').innerHTML = 'Node description: ' +  shape.id;
                $("#longText").modal();
                console.log("[longText modal] showing");
            }
        });

        shape.data('resizableID', resizable.id);
        // adds a text field
        // adds a text field
        txt = paper.text(ev.offsetX+15, ev.offsetY+20, "default-text").attr({'font-size': 10, 'fill': 'black', 'text-anchor': 'start'});
        txt.data("type", "shape_text");
        txt.data("parent", shape.id);

        // adds a dblclick handler to the 'hide' rectangle
        resizable.click(function(){hideNodes(resizable.data('parentID'))});


        // adds a dblclick handler to the text field
        txt.click(textClicked);
        txt.mouseover(function (){
            this.attr({'font-size': 11});
        });
        txt.mouseout(function (){
            this.attr({'font-size': 10});
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
        txt = paper.text(ev.offsetX+25, ev.offsetY+25, "default-text").attr({'font-size': 10, 'fill': 'black'});
        txt.data("type", "shape_text");
        txt.data("parent", shape.id);



        shape.data('connections', true);
        shape.data('desc', '');

        txt.click(textClicked);
        txt.mouseover(function (){
            this.attr({'font-size': 11});
        });
        txt.mouseout(function (){
            this.attr({'font-size': 10});
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

        txt = paper.text(ev.offsetX+40, ev.offsetY+40, "TEST").attr({'fill': 'black'});

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

    // RELEVANT PARTS WERE MOVED TO onShapeClicked() because there were two click handlers
    // shape click event handler
    // shape.click(function () {

    // saves the current shape to a global spoce
    // active = shape;

    // change colours (testing purposes)
    //shape.attr({fill: getRandomColor()});
    //shape.attr({stroke: getRandomColor()});

    // read and set the element's values for IDtext and IDinput
    // IDtext.value = "default";

    // IDtext.value = getText(shape.id).short;
    // IDdesc.value = getText(shape.id).long;
    // //console.log("IDtext: ", IDtext.value);
    // changingText = shape.data('type') === 'decision' ? canvasSets[getSet(shape.id)][1] : canvasSets[getSet(shape.id)][2]
    // let inputText = document.getElementById("IDtext");
    // let descriptionText = document.getElementById("IDdesc");
    // inputText.value = changingText.attr("text");
    // descriptionText.value = shape.data("desc"); // active is currently active shape
    // inputText.focus();

    // resetText(changingText, shape);
    // IDinput.setAttribute('value', shape.id);
    // });

    // trigger click so everthing resets :D
    shape.trigger("click");

    // return shape (no actual use)
    return shape;
}

// event handler for 'ondrop' event of canvas
// reads the received data and forwards the info to 'shapeDraw'
function mainDraw(ev) {
    var data = ev.dataTransfer.getData("text/html");
    shapeDraw(data, ev);
    // document.getElementById("IDtext").value = "";
    // document.getElementById("IDdesc").value = "";

}

function getSet(id, which = 0){
    for(let i = 0; i < canvasSets.length; i++){
        // decision set, because it has only 2 elements(indexes: 0, 1)
        // if i am looking for set that has text on index 2 i can just skip that
        if(canvasSets[i].length === 2 && which === 2)
            continue;

        // console.log("[getSet]:",canvasSets[i][which].id);
        if(canvasSets[i][which].id === id){
            // console.log("found correct set", id);
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
    console.log("TEKST OUT: ", txt);
    set.push(t);

    var text2 = set[0].data('desc');
    return {short: txt1, long: text2};
}

// 'onblur' event handler for IDtext input field, changes the text in the corresponding element (set of elements)
function setText() {
    var id = IDinput.value;
    if(paper.getById(id).type !== 'path'){
        var set = canvasSets[getSet(id)];
        console.log("[setText] set:", set);
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

function validation() {
    let success = true;

    if (document.forms["gForm"]["gName"].value === "") {
        document.getElementById("nameLab").innerHTML = "Please provide a graph name.";
        console.log('No graph name provided.');
        success = false;
    }
    else{
        document.getElementById("nameLab").innerHTML = "";
    }
    if((document.forms["gForm"]["gType"][0].checked === false) && (document.forms["gForm"]["gType"][1].checked === false)){
        document.getElementById("typeLab").innerHTML = "Please select a graph type.";
        console.log('No graph type selected');
        success =  false;
    }
    else{
        document.getElementById("typeLab").innerHTML = "";
    }

    if(!success){
        $("#metaData").modal('show');
    }
    return success;
}

function getGraphDescriptionData(){
    let data = [];

    data['name'] = document.forms["gForm"]["gName"].value;

    data['description'] = document.getElementById('graphDescritption').value;

    if(document.forms["gForm"]["gType"][0].checked === true){
        data['gtype'] = 1;
    }
    else{
        data['gtype'] = 0;
    }

    let select = document.getElementById('sel1'),
        options = select.getElementsByTagName('option'),
        values  = [];

    for (let i=options.length; i--;) {
        if (options[i].selected) values.push(options[i].value)
    }

    //console.log(values)

    let atype = 0;

    if(values.includes("other")){
        atype += 4;
    }
    if(values.includes("treatment")){
        atype += 2;
    }
    if(values.includes("diagnostic")){
        atype += 1;
    }

    if(atype === 0){
        atype = 4;
    }

    data['atype'] = atype;

    return data;
}

function resetModal() {
    document.forms["gForm"]["gName"].value = "";
    document.getElementById('graphDescritption').value = "";
    document.getElementById('typeDiagnostic').checked = false;
    document.getElementById('typeVisual').checked = false;

    var elements = document.getElementById("sel1").options;

    for(var i = 0; i < elements.length; i++){
        elements[i].selected = false;
    }
}

function cancelGraph() {
    if(confirm("You are about to leave the page, all your work will be lost. Do you want to proceed?")){
        window.location.replace("../../../DiaGenKri/public/home");
    }
}

function saveGraph() {
    if(canvasSets.length === 0){
        $.notify("Create algorithm first",
                    { position: 'bottom center',
                    className: 'info',
                    gap: 5 }
                    );
        return false;
    }
    if(!validation()){
        return false;
    }

    let graphDescription = getGraphDescriptionData();

    //console.log (graphDescription);

    console.log("[saveGraph] TYPE:", !editingGraph ? "save new graph" : "edit existing graph")

    disableInputs(true);

    connections = [];
    shapes = [];
    canvasSets = [];
    json = null;
    id = 0; // id for shapes, connections, probably obsolete right now



    json = paper.toJSON(function(el, data) {

        let dx, dy;

        data.id = el.id;
        console.log('[saveGraph] NODE ID: ',el.id);
        data.setName = el.setName;
        //console.log('data setName PRE: ' + data.setName);
        //console.log('element x and y PRE: ', el.attr('x'), el.attr('y'));

        // console.log("data,", window[data.setName]);
        // // remove elements
        // if(window[data.setName]){
        //     if(window[data.setName].length !== 0)
        //         window[data.setName].remove();
        //     else
        // reset this variable, it will appear as if the set does not exists
        window[data.setName] = null;

        //     // remove whole set
        //     // window.splice(window.indexOf(data.setName), 1);

        // }


        console.log("[saveGraph] type is", el.type);

        // if element is text
        if(el.type === 'text') {
            data.type = el.data("type");
            if(data.type === "connection_text")
                data.id_connection = el.data("id_connection");
            else if(data.type === "shape_text")
                data.parent = el.data("parent");

        }
        else if(el.type === 'path'){
            if(el.data('type') === 'hide'){
                data.parentID = el.data('parentID');
                data.type = "hide";
            } else if (el.data("type") === 'sub_path') {
                data.type = "sub_path";
            } else {
                data.fromTo = el.data("fromTo");
                data.type = "connection";
                data.id_connection = el.data("id_connection");
            }

        }
        else if(el.type === 'rect'){
            if(el.data('type') === 'decision'){
                data.type = "decision";

                el.rotate(-45);
                let cx = el.getBBox().x;
                let cy = el.getBBox().y;

                dx = cx - el.attr('x');
                dy = cy - el.attr('y');
            } else {
                data.desc = el.data("desc");
                data.type = "rect";
            }
        }
        console.log(data.type);


        // if dx and dy were not set
        if(!dx && !dy){
            dx = el.matrix.e;
            dy = el.matrix.f;
        }
        console.log("[saveGraph] dx, dy:",dx, dy);

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
    //console.log("[saveGraph] before post ",json);

    //console.log(graphDescription['description']);


    if(!editingGraph){
        // $.post("../../../DiaGenKri/public/visualisation/save",
        //     {
        //         data: json,
        //         name: graphDescription['name'],
        //         description: graphDescription['description'],
        //         gtype: graphDescription['gtype'],
        //         atype: graphDescription['atype']
        //     },
        //     function(data, status){
        //         //console.log("[saveGraph] in post(data: )",data, status);
        //         console.log('[saveGraph] SAVE:', status === "success" ? "saved successfuly" : "not saved successfuly", "\ndata:", data);
        //         //json = data;
        //     });
        $.ajax({
            type: "POST",
            url: "../../../DiaGenKri/public/visualisation/save",
            data: {
                data: json,
                name: graphDescription['name'],
                description: graphDescription['description'],
                gtype: graphDescription['gtype'],
                atype: graphDescription['atype']
            },
            success: function(data, status){
                console.log('[saveGraph] save', status === "success" ? "saved successfuly" : "not saved successfuly", "\ndata:", data);
                if(data === "1"){
                    $.notify("Algorithm successfuly saved",
                    { position: 'bottom center',
                    className: 'success',
                    gap: 5 }
                    );
                } else {
                    $.notify("Something went wrong, algorithm not saved",
                    { position: 'bottom center',
                    className: 'error',
                    gap: 5 }
                    );
                }
            }
        });
    } else {
        // $.post("../../../DiaGenKri/public/visualisation/edit",
        //     {
        //         data: json,
        //         id: graphId,
        //         name: graphDescription['name'],
        //         description: graphDescription['description'],
        //         gtype: graphDescription['gtype'],
        //         atype: graphDescription['atype']
        //     },
        //     function(data, status){
        //         console.log('[saveGraph]', status === "success" ? "saved successfuly" : "not saved successfuly", "\ndata:", data);
        //         $.notify("Algorithm successfuly saved!",
        //             { position: 'bottom center',
        //              className: 'success',
        //              gap: 5 }
        //         );
        //     });

        $.ajax({
            type: "POST",
            url: "../../../DiaGenKri/public/visualisation/edit",
            data: {
                data: json,
                id: graphId,
                name: graphDescription['name'],
                description: graphDescription['description'],
                gtype: graphDescription['gtype'],
                atype: graphDescription['atype']
            },
            success: function(data, status){
                console.log('[saveGraph] EDIT:', status === "success" ? "saved successfuly" : "not saved successfuly", "\ndata:", data);
                if(data === "1"){
                    $.notify("Algorithm successfuly saved!",
                    { position: 'bottom center',
                    className: 'success',
                    gap: 5 }
                    );
                } else {
                    $.notify("Something went wrong, algorithm not saved",
                    { position: 'bottom center',
                    className: 'error',
                    gap: 5 }
                    );
                }
            }
        });
    }

    //console.log("[saveGraph] after post",json);

    paper.clear();

    // when graph is saved, user can make new graph
    editingGraph = false;

    return true;

}

function loadGraph(json, pacient=false, viewonly=false) {
    // application should go in view only state
    viewonly_graph = viewonly;

    // graph is being loaded, so user will be definitly editing one
    editingGraph = true;

    // reset everything to make sure it will be ok
    connections = [];
    shapes = [];
    canvasSets = [];
    id = 0; // id for shapes, connections, probably obsolete right now
    // also resets variables in window

    if(pacient){

        console.log("CLEAR WINDOW CLEAR WINDOW CLEAR WINDOW CLEAR WINDOW")
        paper.fromJSON(json, function(el, data) {
            console.log(data.setName);
            console.log("before:", window[data.setName]);
            window[data.setName] = null;
            console.log("after:", window[data.setName]);

        });
        console.log("CLEAR WINDOW CLEAR WINDOW CLEAR WINDOW CLEAR WINDOW")
    }



    if(!viewonly_graph)
        disableInputs(true);

    console.log('[loadGraph] LOADING started');
    // paper = Raphael('content');

    // console.log("[loadGraph] paper:", paper);
    // if(1+1)
    //     return;

    paper.clear();

    paper.fromJSON(json, function(el, data) {
        el.id = data.id;
        console.log('START START START START START');

        console.log('[loadGraph] element id:',el.id, data.type);

        if(data.type !== 'connection' && data.type !== 'sub_path' && data.type !== 'connection_text'){
            console.log("NI KONEKŠN FOCK FOCK FOCK")
            // Recreate the set using the identifier
            if( !window[data.setName] ){
                window[data.setName] = paper.set();

                // window[data.setName].draggable();

                canvasSets.push(window[data.setName]);

                console.log("[loadGraph] data.setName:", data.setName, canvasSets);
            } else {
                console.log("[loadGraph] SET EXISTS EXISTS:", data.setName, window[data.setName])
            }

            // Place each element back into the set
            //console.log('setName POST:' +data.setName);
            window[data.setName].push(el);

            // make set draggable
            // window[data.setName].draggable();
        }

        // console.log('SAVING: ', window[data.setName]);

        // console.log('window :' +window[data.setName]);

        console.log("[loadGraph] type of element:", el.type);


        if(el.type === 'path'){
            if (data.type === 'hide'){
                let correct_set = getSet(el.id, 1);
                // console.log(el.id, correct_set);
                if(correct_set === null){
                    console.log("ERROR ERROR ERROR ERROR ERROR");
                    return;
                }
                let px = canvasSets[correct_set][0].getBBox().x;
                let py = canvasSets[correct_set][0].getBBox().y;

                let d = ["M", px+5, py+10, "l", 10, 0, "M", px+10, py+5, "l", 0, 10].join(",");

                // remove element and add it back
                // whole procedure(creating new path, remove & add are necesseray because otherwise the transformations of path are wrong)
                el.remove();
                window[data.setName].pop();

                el = paper.path(d).attr({"stroke-width": 3, stroke: Colors.green});
                window[data.setName].push(el);

                rainingEvents(el, "hide");
                console.log("[loadGraph] loaded HIDE path");
            } else if(data.type === 'connection') {
                console.log("[loadGraph] path fromTo:", el.data("fromTo"));
                let idSplit = data.fromTo.split(" ");
                el.remove();
                connections.push(paper.connection(paper.getById(idSplit[0]), paper.getById(idSplit[1]), "#000", data.id_connection));
                // remove text because you will add new(previous) later
                connections[connections.length - 1].text.remove();
                // console.log(connections[connections.length - 1].text);
                // remove two handlers, because they will be added later(on the bottom)
                connections[connections.length - 1].text.undblclick(addDblclickHandlers);
                connections[connections.length - 1].subpath.undblclick(addDblclickHandlers);

                rainingEvents(el, "connection");

                console.log("[loadGraph] loaded CONNECTION path");
            } else { //subpath, just remove because subpath is created when path(connection) is created
                el.remove();
                rainingEvents(el, "subpath")
                console.log("[loadGraph] loaded SUBPATH path");
            }
        }
        else if(el.type === 'text'){ // trick is to remove connection_text, because connection_text is created when path(connection) is created
            console.log("[loadGraph] loaded", data.type, "text");
            rainingEvents(el, data.type);
            if(data.type === "connection_text")
                el.data("id_connection", data.id_connection);
            else if(data.type === "shape_text")
                el.data("parent", data.parent);

        }
        else if(el.type === 'rect'){
            addToShapes(el);
            rainingEvents(el, data.type);
            if(data.type === "rect")
                el.data("desc", data.desc);
            console.log("[loadGraph] loaded", data.type, "rect");
        }
        // // console.log('[loadGraph] setName');
        el.setName = data.setName;

        // el.click(function () {
        //     console.log("click shape: matrix:", el.matrix);
        // })


        // return el;
        console.log('END END END END END');

    });

    // make sets draggable
    if(!viewonly_graph){
        for (let i = canvasSets.length - 1; i >= 0; i--) {
            canvasSets[i].draggable();
        }
    }

    // map texts to connections
    paper.forEach(function (element) {
        // console.log(element.id, ":", element);
        // console.log(element.data("id_connection"))
        if(element.data("type") === "connection_text") {
            for (let i = connections.length - 1; i >= 0; i--) {
                // console.log("[connections]", connections[i]);
                if(connections[i].id === element.data("id_connection")){
                    // console.log("WOHOOOOOOOOOOOO! before", connections[i].text, element);
                    connections[i].text = element
                    // console.log("WOHOOOOOOOOOOOO! after", connections[i].text, element);
                    // console.log("[pathEvents] type", type);
                    // add handlers
                    if(!viewonly_graph){
                        connections[i].line.dblclick(addDblclickHandlers);
                        connections[i].subpath.dblclick(addDblclickHandlers);
                    }
                    break;
                }
            }
        }

        // meantime change width of all text elements to correct size
        //if(element.data("type") === "shape_text")
        //    changeWidth(element);
    });

    // recalculate subpaths
    for (var i = connections.length - 1; i >= 0; i--) {
        calculateSubPath(connections[i].id)
    }

    // increment id, so next connection will have proper id
    if(connections.length > 0){
        id = connections[connections.length - 1].id + 2;
        // refresh things by "placing" just one connection, that way misplaced items will fix themselves
        // paper.connection(connections[connections.length - 1]);

    }

    // update connections
    for (let i = connections.length; i--;) {
        paper.connection(connections[i]);
    }


    console.log('[loadGraph] LOADING finished');


}














