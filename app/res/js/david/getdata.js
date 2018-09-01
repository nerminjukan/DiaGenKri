function gup( name, url ) {
    if (!url) url = location.href;
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    let regexS = "[\\?&]"+name+"=([^&#]*)";
    let regex = new RegExp( regexS );
    let results = regex.exec( url );
    return results == null ? null : results[1];
}
const id_graph_load = gup('id', window.location.href)
console.log(id_graph_load, window.location.href);
// let a = gup('q', 'hxxp://example.com/editor?q=abc')
// console.log(a, window.location.href);


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
		console.log(data, status);
		const myArray = $.parseJSON(data);
		// const podatki = $.parseJSON(myArray["data"]);
		// window["f_json"] = myArray["data"]
		console.log("[getData.js] myArray:", myArray);
		// console.log(podatki);

		loadGraph(myArray["data"]);
	}
	);
});