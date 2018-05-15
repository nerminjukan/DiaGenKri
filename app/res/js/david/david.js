// connection implementation between two objects
Raphael.fn.connection = function (obj1, obj2, line, id_c, bg) {
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
        var color = typeof line == "string" ? line : "#000";
        return {
            bg: bg && bg.split && this.path(path).attr({stroke: bg.split("|")[0], fill: "none", "stroke-width": bg.split("|")[1] || 3}),
            line: this.path(path).attr({stroke: color, fill: "none"}),
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

// array for shapes(circles, rectangles)
let shapes = [];
// array for connection between shapes
let connections = [];
// id of connections
let id = 0;
// if adding connections is possible
let add_connection = false;


// ############## START OF REMOVE ##############
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
    for(let i = 0; i < shapes.length; i++){
        if(shapes[i].id === this.id)
            index = i;
    }
    if (index > -1) {
        console.log("removing", this.id);
        shapes.splice(index, 1);
        this.remove();
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
                console.log("remove connection on index", j, " with id:", connections[j].id, "that is connecting:", connections[j].from.id,
                    "and", connections[j].to.id);
                connections[j].line.remove();
                connections.splice(j, 1);
                //c_ids.splice(i, 1); // optimization, also increment i to get to correct index
                console.log("successfuly removed");
            }
        }
    }   
}

// ############## END OF REMOVE ##############

// ############## START OF CONNECTING SHAPES ##############
let line_first_shape_id = null, 
line_second_shape_id = null; // when thoose are both something but null, connect two shapes
function connectTwoShapes(){
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

// ############## END OF CONNECTING SHAPES ##############
window.onload = function () {
    var dragger = function () {
        this.ox = this.type == "rect" ? this.attr("x") : this.attr("cx");
        this.oy = this.type == "rect" ? this.attr("y") : this.attr("cy");
        this.animate({"fill-opacity": .2}, 500);
    },
        move = function (dx, dy) {
            var att = this.type == "rect" ? {x: this.ox + dx, y: this.oy + dy} : {cx: this.ox + dx, cy: this.oy + dy};
            this.attr(att);
            for (var i = connections.length; i--;) {
                r.connection(connections[i]);
            }
            //r.safari();
        },
        up = function () {
            this.animate({"fill-opacity": 0}, 500);
        },
        element = document.getElementById('content'),
        positionInfo = element.getBoundingClientRect(),
        height = positionInfo.height,
        width = positionInfo.width;

    var r = Raphael(document.getElementById('content'), width, height);
	console.log("[main] paper canvas:", r.canvas);

    // TESTING    
    connections = [];
    shapes = [  r.ellipse(190, 100, 30, 20),
                r.rect(290, 80, 60, 40, 10),
                r.rect(290, 180, 60, 40, 2),
                r.ellipse(450, 100, 20, 20),
                r.rect(100, 400, 60, 40, 2),
                r.rect(400, 250, 60, 40, 2)
            ];

    // create set for objects
  	// var mySet = r.set();

    // create shapes
    for (var i = 0, ii = shapes.length; i < ii; i++) {
        var color = Raphael.getColor();
        shapes[i].attr({fill: color, stroke: color, "fill-opacity": 0, "stroke-width": 2, cursor: "move"});
        // save reference to paper
        shapes[i].data("paper", r);
        shapes[i].drag(move, dragger, up);
        shapes[i].dblclick(doubleClick);
        shapes[i].click(connectTwoShapes);
    }
    // add connections between shapes
    connections.push(r.connection(shapes[0], shapes[1], "#000", id++));
    connections.push(r.connection(shapes[1], shapes[2], "#000", id++));
    connections.push(r.connection(shapes[1], shapes[3], "#000", id++));
    connections.push(r.connection(shapes[2], shapes[3], "#000", id++));

    for(let i = 0; i < connections.length; i++)
        console.log(connections[i].from.id, ":", connections[i].to.id, connections[i].id);

    // mySet.push(r.circle(50, 50, 50).attr('fill', 'red'));
	// mySet.push(r.circle(50, 50, 40).attr('fill', 'white'));
	// mySet.push(r.circle(50, 50, 30).attr('fill', 'red'));
	// mySet.push(r.circle(50, 50, 20).attr('fill', 'white'));
	// mySet.push(r.circle(50, 50, 10).attr('fill', 'red'));
  
  	// make set draggable
  	// mySet.draggable();


    // connections.push(r.connection(shapes[1], shapes[2], "#fff", "#fff|5"));
    // connections.push(r.connection(shapes[1], shapes[3], "#000", "#fff"));
};
