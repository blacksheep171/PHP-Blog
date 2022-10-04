$(document).ready(function() {
    $.ajax({
        url: "http://localhost/php-blog/users",
        type: "GET",
        dataType: "json",
        success: function(data, textStatus, xhr) {
            console.log(data);
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log("Error loading");
        }
    });
});

	// function run() {

	// 	// Creating Our XMLHttpRequest object
	// 	var xhr = new XMLHttpRequest();

	// 	// Making our connection
	// 	var url = 'https://jsonplaceholder.typicode.com/todos/1';
	// 	xhr.open("GET", url, true);

	// 	// function execute after request is successful
	// 	xhr.onreadystatechange = function () {
	// 		if (this.readyState == 4 && this.status == 200) {
	// 			console.log(this.responseText);
	// 		}
	// 	}
	// 	// Sending our request
	// 	xhr.send();
	// }
	// run();
