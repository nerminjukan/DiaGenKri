$(function(){
   // delete algorithm
	$('button.save-permissions').click(function(){
		let email = this.id;
		let name = this.name;

		let admin_c = document.getElementById("admin"+name).checked;
		let read_c = document.getElementById("read"+name).checked;
		let edit_c = document.getElementById("edit"+name).checked;
		let delete_c = document.getElementById("delete"+name).checked;
		let add_c = document.getElementById("add"+name).checked;
		let confirm_c = document.getElementById("confirm"+name).checked;

		console.log("[update user permissions]", email, name, admin_c,read_c,edit_c,delete_c,add_c,confirm_c);


		$.post("../../public/administrate/savePR",
		{
			userChange: email,
			option1: admin_c ? "on" : "off",
			option2: read_c ? "on" : "off",
			option3: edit_c ? "on" : "off",
			option4: delete_c ? "on" : "off",
			option5: add_c ? "on" : "off",
			option6: confirm_c ? "on" : "off"
		},
		function(data, status){
			console.log(data);
			if(data === "1"){
				let string = "Permissions for " + email + " successfuly updated";
				$.notify(string,
		            { position: 'top center',
		            className: 'success',
		            gap: 5 }
	            );
			} else {
				$.notify("Something went wrong, try again",
	                { position: 'top center',
	                className: 'error',
	                gap: 5 }
	            );
			}
		}
		);
	});

});

