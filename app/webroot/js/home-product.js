var listProduct = angular.module('listProduct', []);
listProduct.controller('product', function($scope, $http) {
    //$http({
    //    url: '/api/get_products',
    //    method: 'POST',
    //    data: $.param({id: "365"}),
    //    headers: {
    //        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
    //    }
    //}).success(function(data, status, headers, config) {
    //    // this callback will be called asynchronously
    //    // when the response is available
    //    $scope.name = data.data.name;
    //    $scope.price = data.data.price;
    //    $scope.descriptions = data.data.described;
    //    $scope.category = data.data.category[0].name;
    //    $scope.brand = data.data.brand.brand_name;
    //    $scope.state = data.data.condition;
    //
    //    if(typeof(data.data.video) !== 'undefined') {
    //        $scope.videodisplay = 'display: block;';
    //        //$scope.url = data.data.video.url;
    //    } else {
    //        alert('khong co video');
    //        $scope.videodisplay = 'display: none;';
    //    }
    //
    //}).error(function(data, status, headers, config) {
    //    // called asynchronously if an error occurs
    //    // or server returns response with an error status.
    //});

});
