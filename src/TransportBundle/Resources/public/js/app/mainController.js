HomeController.$inject = [ 'dataservice' ];
function HomeController(dataservice) {
	var vm = this;
	vm.montlyData = [];
	vm.request = null;
	vm.categories = [];
	var date = new Date();
	vm.monthNames = month;
	vm.month = date.getMonth();
	vm.year = date.getFullYear();
	vm.getDataBoxWidth = getDataBoxWidth;
	vm.showPopover = showPopover;
	vm.saveRequestQty = saveRequestQty;
	vm.loadData = loadData;
	vm.oldRequest = null;
	vm.bulkOperation = bulkOperation;
	vm.bulk = {};
	vm.changeMonth = changeMonth;
	function loadData() {
		dataservice.getMontlyData(vm.month, vm.year).then(function(data) {
			vm.montlyData = data.data;
			vm.categories = data.categories
		});
	}
	vm.loadData();

	function getDataBoxWidth() {
		return Object.keys(vm.montlyData).length * 100
	}
	function saveRequestQty(request, day) {
		var data = {};
		data.day = day;
		data.request = request;
		data.month = vm.month;
		data.year = vm.year;
		dataservice.saveData(data).then(function(data) {
			if (data.status == 200) {
				vm.request.showQtyPopoverStyle = "display:'none'";
				vm.request.showPricePopoverStyle = "display:'none'";
				vm.oldRequest = null;
				vm.loadData();
			} else {
				alert(data.message);
			}
		});
	}

	function bulkOperation() {
		var data = {};
		data.bulkData = vm.bulk;
		dataservice.bulkOperation(data).then(function(data) {
			if (data.status == 200) {
				if (vm.request) {
					vm.request.showQtyPopoverStyle = "display:'none'";
					vm.request.showPricePopoverStyle = "display:'none'";
				}
				vm.oldRequest = null;
				vm.loadData();
			} else {
				alert(data.message);
			}
		});
	}

	function showPopover(type, request) {
		if (vm.request != null) {
			if (vm.oldRequest) {
				vm.request.qty = vm.oldRequest.qty;
				vm.request.price = vm.oldRequest.price;
			}
			vm.request.showQtyPopoverStyle = "display:'none'";
			vm.request.showPricePopoverStyle = "display:'none'";
		}
		vm.request = request;
		vm.oldRequest = angular.copy(request);
		if (type == "qty") {
			vm.request.showQtyPopoverStyle = "display:block";
		} else if (type == "price") {
			vm.request.showPricePopoverStyle = "display:block";
		}
	}
	
	function changeMonth(numOfmonths){
		vm.month = vm.month + numOfmonths;
		if(vm.month == 12){
			vm.month = 0;
			vm.year++;
		}
		if(vm.month == -1){
			vm.month =11;
			vm.year--;
		}
		vm.loadData();
	}

}
