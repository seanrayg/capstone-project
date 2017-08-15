function SelectPrintAction(){

	var e = document.getElementById("SelectQuery");
	var strOption = e.options[e.selectedIndex].value;

	var action = "reports." + strOption;

	document.getElementById('print').action = "{{ route('"+ action +"') }}";

}