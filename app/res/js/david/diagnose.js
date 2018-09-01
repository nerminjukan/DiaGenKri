$(function(){
   $('button.dpacient-button').click(function(){
   	// get id of graph 
   	const id_graph = $(this).attr('id');

   	// load the graph on invisible canvas
   	$.post("../../public/visualisation/load",
	{
		id: id_graph
	},
	function(data, status){
		// console.log(data, status);
		const myArray = $.parseJSON(data);
		// const podatki = $.parseJSON(myArray["data"]);
		// window["f_json"] = myArray["data"]
		console.log("[getData.js] myArray:", myArray);
		// console.log(podatki);

		loadGraph(myArray["data"], true);

		// const k = null;
		// try{
		// 	console.log(id_graph);
		// 	k = tree_vertices["fsr17"].height - tree_vertices[id_graph].height;
		// } catch(err){
		// 	console.log("[diagnose.js]", err)
		// }
		// and display modal for it		
   		// setModal(k); 
   		setModal();
	}
	);
   });
});