class Vertex {
	constructor(id) {
	    this.vertex_id = id; // id as string
	    this.children = {}; // array of Vertex objects
	    this.sizeOfChildren = 0; // how many children does vertex have
	    // console.log("[Vertex] created new vertex with id:", this.vertex_id);
	    this.height = 1; // tree height of vertex
	    this.incomingConns = false; // determine wheter vertex has incoming connections, if it doesnt, than it might be root node
        this.incomingConns_count = 0;
  	}

  	// parameter @v is Vertex
	addChild(v){
		// console.log("Added", v.vertex_id, "as child off", this.vertex_id);
		this.children[v.vertex_id] = v;
		this.sizeOfChildren++;
	}

	// returns height of @vertex vertices (sub)tree
	static treeHeight(vertex){
		if(vertex.sizeOfChildren === 0){
			// console.log("[treeHeight] no children", vertex, "returning 1");
			vertex.height = 1;
			return 1;
		}
		let heights = [];
		// console.log("[treeHeight] vertex:", vertex, "children:", vertex.children, vertex.children.length);
		for (const [key, el] of Object.entries(vertex.children)) {
			// console.log("[treeHeight] checking children:", el);

			const el_height = Vertex.treeHeight(el);
			heights.push(el_height);
		};
		// update max height
			// if (el_height + max_height > max_height)
				// max_height = el_height + max_height;
		vertex.height = Math.max(...heights) + 1;
		return vertex.height;
    }

    getChildren(){
    	for (const [key, value] of Object.entries(this.children)) {
			console.log("id:", key, "object:", value);
		}
    }
}