$(function(){
   $('button.edit-graph-button').click(function(){
   	const id_graph = $(this).attr('id');
	// console.log( id_graph);

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

	// similar behavior as an HTTP redirect
	window.location.replace("../../../DiaGenKri/public/visualisation/editor?id=" + id_graph);
   });
});