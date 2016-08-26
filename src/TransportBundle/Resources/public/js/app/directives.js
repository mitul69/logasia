function datePicker(){
		var directive = {
        link: link,
        require: "ngModel",
        restrict: 'A'
	    };
	    return directive;
	
	    function link(scope, element, attrs, ngModelCtrl) {
			var updateModel = function (dateText) {
                scope.$apply(function () {
                    ngModelCtrl.$setViewValue(dateText);
                });
            };
            var options = {
                dateFormat: "yy-mm-dd",
                onSelect: function (dateText) {
                    updateModel(dateText);
                }
            };
            element.datepicker(options);
	    }
	}