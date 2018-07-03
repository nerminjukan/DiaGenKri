$(function(){
   $('button.dpacient-button').click(function(){
   	// get id of graph 
   	const id_graph = $(this).attr('id');

   	// load the graph on invisible canvas
   	$.post("../../../DiaGenKri/public/visualisation/load",
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

		// and display modal for it		
   		setModal(); 
	}
	);
   });
});