function gup( name, url ) {
    if (!url) url = location.href;
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    let regexS = "[\\?&]"+name+"=([^&#]*)";
    let regex = new RegExp( regexS );
    let results = regex.exec( url );
    return results == null ? null : results[1];
}
// extract id 
const id_graph_load = gup('id', window.location.href)
console.log(id_graph_load, window.location.href);

$(function(){
	// no id was given
	if(id_graph_load === null)
		return;


	console.log("ID of graph to be loaded:", id_graph_load);

	// $.post("visualisation/edit",
	//   {
	//       id: $(this).attr('id')
	//   },
	//   function(data, status){
	//       //console.log("[saveGraph] in post(data: )",data, status);
	//       if(status === "success"){
	//       	console.log("done:",data, status);
	//   	}
	//       //json = data;
	//   });

	$.post("../../public/visualisation/load",
	{
		id: id_graph_load
	},
	function(data, status){
		// console.log(data, status);
		try {
			const myArray = $.parseJSON(data);
			// const podatki = $.parseJSON(myArray["data"]);
			// window["f_json"] = myArray["data"]
			// console.log("[viewonly.js] myArray:", myArray);
			// console.log(podatki);

			// json, diagnose for pacients, viewonly
			// loadGraph(myArray["data"], false, true);
			loadGraph(myArray["data"], false, true);
			$.notify("Algorithm successfuly loaded",
	            { position: 'bottom center',
	            className: 'success',
	            gap: 5 }
            );
		} catch(err){
			$.notify("Something went wrong, try again",
                { position: 'bottom center',
                className: 'error',
                gap: 5 }
            );
		}
	}
	);


	// listener on table cell, td
	$('tr.tr-viewonly-click').click(function(){
		console.log("TR CLICKED CLICKED CLICKED", this);
	// get id of graph 
		const id_graph = $(this).attr('id');

	// load the graph on invisible canvas
		$.post("../../public/visualisation/load",
		{
			id: id_graph
		},
		function(data, status){
			// console.log(data, status);
			try {
				const myArray = $.parseJSON(data);
				// const podatki = $.parseJSON(myArray["data"]);
				// window["f_json"] = myArray["data"]
				// console.log("[getData.js] myArray:", myArray);
				// console.log(podatki);

				// loadGraph(myArray["data"], true, true);
				loadGraph(myArray["data"], true, true);
				$.notify("Algorithm successfuly loaded",
		            { position: 'bottom center',
		            className: 'success',
		            gap: 5 }
                );
			} catch(err){
				$.notify("Something went wrong, try again",
	                { position: 'bottom center',
	                className: 'error',
	                gap: 5 }
                );
			}


			// and display modal for it		
			//setModal(); 
		}
		);
	});

});