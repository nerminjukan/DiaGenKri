let _k = 0;
let previous = null; // store the id of previous node, so user can return to it
let current = null; // in which node user currently is

let history = {}; // dictionary(key: id of vertex, value: id of previous vertex)
// Previous is determined like that:
/*
 * Vertex(V) can have multiple parents. Parents are vertices that has outgoing connection into V.
 * Previous is a vertex, that is in parents and is current.
 * Current is always set to the current node user is in.
 * Example: 
 *  1st: p = null
 *       c = A
 *  2nd: p = A, F, or G. A is stored in c, therfore previous = A
 *       c = B
 */

function setModal(id = null) {
    if(canvasSets.length !== 0){
        let node_data = findNode(id);
        console.log('FOUND: ', node_data);
        if(node_data)
            setNode(node_data);
    }
    else{
        // alert('No elements on the canvas!!');
        $.notify("Something went wrong",
        { position: 'top center',
        className: 'error',
        gap: 5 }
        );
    }


}

function findNode(node_id) {
    console.log('node_id: ', node_id);
    if(!node_id){
        for(let i = 0; i < shapes.length; i++){
            console.log(shapes[i].data("root"));
            if(shapes[i].data("root") === true){
                console.log("[findNode] našel sem", shapes[i].id, "višina:", tree_vertices[shapes[i].id].height);
                _k = tree_vertices[shapes[i].id].height;
                console.log("KEJ KEJ:", _k);
                // return shapes[i];
                return {
                        shape: shapes[i], 
                        height: tree_vertices[shapes[i].id].height
                        };
            }
        }
        console.log('Couldn\'t find first node.');
    }
    else{
        for(let i = 0; i < shapes.length; i++){
            if(shapes[i].id === node_id){
                console.log("[findNode] našel sem", shapes[i].id, "višina:", tree_vertices[shapes[i].id].height);

                // return shapes[i];
                return {
                        shape: shapes[i], 
                        height: tree_vertices[shapes[i].id].height,
                        parent: tree_vertices[shapes[i].id].parent
                        };
            }
        }
        console.log('Couldn\'t find correct node.');
    }

}

// k is number of visited nodes before this one(node)
function setNode(node) {
    console.log("SET NODE SET NODE SET NODE CALLED WITH node", node.shape);
    let testdiv = document.getElementById('testdiv');
    let headder = document.getElementById('h3id');
    let question = document.getElementById('question');

    while (testdiv.firstChild) {
        testdiv.removeChild(testdiv.firstChild);
    }

    let conns = getConns(node.shape);

    if(conns.length === 0){
        let p = document.createElement("P");

        console.log('THE END');
    }


    let set_index = getSet(node.shape.id);

    let set = canvasSets[set_index];

    if(set.length === 3){
        headder.innerHTML = set[2].attr("text");
        question.innerHTML = set[0].data("desc");
    }
    else{
        headder.innerHTML = set[1].attr("text");
    }


    for(let i = 0; i < conns.length; i++){
        let btn = document.createElement("BUTTON");
        btn.id = conns[i].to.id;
        if(paper.getById(btn.id).data('root') === true){
            console.log('ZANKA!');
            continue;
        }
        btn.classList.add('btn');
        btn.classList.add('btn-block');
        btn.classList.add('btn-primary');
        // btn.innerHTML = conns[i].text.attr("text");
        btn.innerHTML = conns[i].to.id;

        btn.addEventListener('click', restart);
        testdiv.appendChild(btn);
    }
    headder.innerHTML = headder.innerHTML + " " + node.shape.id;
    // previous = node.parent || null;
    // previous = current === node.shape.id ? previous : current;
    // current = node.shape.id;
    // console.log("[test.js] current and previous:", current, previous);

    // v history dodaj samo, če se node ne nahaja v history[current]

    // if(history[node.shape.id] === undefined){
    //     console.log("[test.js] adding to history");
        if(history[node.shape.id] === undefined)
            history[node.shape.id] = [];

        if(history[current] === undefined)
            history[current] = [];

        if(!checkPresence(node.shape.id, current))
            history[node.shape.id].push(current);
    // }
    current = node.shape.id;
    previous = history[current][history[current].length - 1];

    console.log("[test.js] history:", history);
    console.log("[test.js] current:", current);
    console.log("[test.js] previous:", previous);




    // alert(set[0].data("subtree_height"));
    try {
        // get progress bar element
        const progress = document.getElementById("myBar"); 
        // const width =  (100 / set[0].data("subtree_height"));
        let width = (100 / (tree_vertices[node.shape.id].height === 2 ? 2 : tree_vertices[node.shape.id].height));
        const k = _k - tree_vertices[node.shape.id].height; // calculate how many vertices was alread visited
        width += width * (1 - (1 / (1 + k)));
        width = Math.min(100, width); // in the last step it excedes 100
        width = round_N(width, 2);

        console.log("HEHEHEHEHEHEHE:", node.shape.id + ", " + width, tree_vertices[node.shape.id].height);
        progress.style.width = width + "%"; 
        progress.innerHTML = width * 1 + "%";

        // progress.innerHTML = Math.round(width) + "%";
    } catch(err){
        console.log(err);
    }

    $("#testmodal").modal();
}

// rounds up number(@num) to specified places(@places)
function round_N(num, places) 
{ 
    return +(Math.round(num + "e+" + places)  + "e-" + places);
}

function getConns(node) {

    let found = [];

    for(let i = 0; i < connections.length; i++){
        if(connections[i].from.id === node.id){
            found.push(connections[i]);
        }
    }
    return found;
}

function restart() {
    console.log('RESTART', this.id);
    setModal(this.id);
}

// @node is present in history[@current] ? return true : return false
// if true is returned, it means, that @current is child of @node, because @node is in @current's history list,
// therefore, one shall not go A -> B -> C -> B -> C with "previous button", but that should only be possible
// with connection "button(s)"
function checkPresence(node, current){
    for (let i = history[current].length - 1; i >= 0; i--) {
        if(history[current][i] === node){
            console.log("[test.js checkPresence] return true");
            return true;
        }
    }

    console.log("[test.js checkPresence] return false");
    return false;
}

// @current is already present in history[@node] ? return true : return false
// this can happen if you travel A -> B -> C -> B -> C
function checkAlreadyInHistory(node, current){
    for (let i = history[node].length - 1; i >= 0; i--) {
        if(history[node][i] === current){
            console.log("[test.js checkAlreadyInHistory] return true");
            return true;
        }
    }

    console.log("[test.js checkAlreadyInHistory] return false");
    return false;
}

// add event listener for back button (to move to previous node)
$( document ).ready(function() {
    $ ("#go_back_button").click(function(){
        // alert("lets restart");
        setModal(previous);
    });
});