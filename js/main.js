var app = angular.module('chat', [], function($httpProvider) {
  // Use x-www-form-urlencoded Content-Type
  $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

  /**
   * The workhorse; converts an object to x-www-form-urlencoded serialization.
   * @param {Object} obj
   * @return {String}
   */ 
  var param = function(obj) {
    var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

	for(name in obj) {
		value = obj[name];

		if(value instanceof Array) {
			for(i=0; i<value.length; ++i) {
				subValue = value[i];
				fullSubName = name + '[' + i + ']';
				innerObj = {};
				innerObj[fullSubName] = subValue;
				query += param(innerObj) + '&';
			}
		} else if(value instanceof Object) {
			for(subName in value) {
				subValue = value[subName];
				fullSubName = name + '[' + subName + ']';
				innerObj = {};
				innerObj[fullSubName] = subValue;
				query += param(innerObj) + '&';
			}
		} else if(value !== undefined && value !== null)
		query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
	}
    return query.length ? query.substr(0, query.length - 1) : query;
  };

  // Override $http service's default transformRequest
	$httpProvider.defaults.transformRequest = [function(data) {
		return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
	}];
});
app.directive("fileread", [function () {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                scope.$apply(function () {
                    scope.fileread = changeEvent.target.files[0];
                    // or all selected files:
                    // scope.fileread = changeEvent.target.files;
                });
            });
        }
    }
}]);
app.controller('mainCtrl', function($scope, $http){
	$scope.showCode = false;
	$scope.message = '';
	$scope.language = "text";
	$scope.sendmessage = function(userid, recipientid){
		var fd = new FormData();
		fd.append('action', 'send_message');
		fd.append('userid', userid);
		fd.append('recipientid', recipientid);
		fd.append('message', $scope.message);
		fd.append('language', $scope.language);
		fd.append('fileUpload', $scope.fileUpload);
		console.log( $scope.fileUpload);
		$http({
			method: 'POST',
			url: 'ajax.php',
			headers: {
				"Content-Type": undefined
			},
			data: fd,
			transformRequest: function (data, headersGetter) {
				var formData = new FormData();
				angular.forEach(data, function (value, key) {
					formData.append(key, value);
				});
				var headers = headersGetter();
				delete headers['Content-Type'];
				return formData;
			}
		}).then(successCallback, onAjaxError);
		performAjax = true;
	}
	function successCallback(response){
		console.log(response);
	}
	function onAjaxError(response){
		console.log(response);
	}
});

function show()  
{  
	
	var recipientid = jQuery('#message_style').attr('data-recipient');
	jQuery.ajax({  
		url: "ajax.php",  
		method: 'POST',
		dataType: 'json',
		data: {'action':'get_messages', 'recipient': recipientid},
		success: function(data){
			console.log(data);
			var messagesBox = $('#message_style');
			messagesBox.empty().html(data.messages).scrollTop(messagesBox.prop("scrollHeight"));
		}
	});  
}  

jQuery(document).ready(function(){  
	show();  
	setInterval('show()',10000);  
});  