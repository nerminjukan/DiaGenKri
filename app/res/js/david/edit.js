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

   // do something hen user clicks view button
   $('button.view-graph-button').click(function(){
		const id_graph = $(this).attr('id');
		console.log("id:", id_graph);
		window.location.replace("../../../DiaGenKri/public/visualisation/viewonly?id=" + id_graph);
   });


   // delete algorithm
	$('.fa-times').click(function(){
		var el = this;
		var id_graph_delete = this.id;
		console.log("[delete algorithm]", id_graph_delete);

		let confirmation = confirm("Do you realy want to delete algorithm? This action cannot be reversed");
		if(!confirmation)
			return;

		// confirmation = confirm("Please confirm your choice again");
		// if(!confirmation)
		// 	return;

		$.post("../../../DiaGenKri/public/visualisation/delete",
		{
			id: id_graph_delete
		},
		function(data, status){
			if(data === "1"){
				$(el).closest('tr').css('background','tomato');
				$(el).closest('tr').fadeOut(800, function(){ 
					$(this).remove();
				});

				$.notify("Algorithm successfuly deleted",
		            { position: 'bottom center',
		            className: 'success',
		            gap: 5 }
	            );
			} else {
				$.notify("Something went wrong, try again",
	                { position: 'bottom center',
	                className: 'error',
	                gap: 5 }
	            );
			}
		}
		);
	});

});

