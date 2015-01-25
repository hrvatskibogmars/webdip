(function(){
  'use strict';

  var app = angular.module('app', ['ngGrid']);

  app.controller('main', function($rootScope, $http) {

    $('#mytabs a').click(function(e) {
      e.preventDefault();
      $(this).tab('show');
    });

  });

 

  app.controller('artefacts_controller', function($scope, $http) {
    $scope.logs = [];
    
    $scope.filterOptions = {
        filterText: "",
        useExternalFilter: true
    }; 
    $scope.totalServerItems = 0;
    $scope.pagingOptions = {
        pageSizes: [250, 500, 1000],
        pageSize: 250,
        currentPage: 1
    };  
    $scope.setPagingData = function(data, page, pageSize){  
        var pagedData = data.slice((page - 1) * pageSize, page * pageSize);
        $scope.myData = pagedData;
        $scope.totalServerItems = data.length;
        if (!$scope.$$phase) {
            $scope.$apply();
        }
    };
    $scope.getPagedDataAsync = function (pageSize, page, searchText) {
        setTimeout(function () {
            var data;
            if (searchText) {
                var ft = searchText.toLowerCase();
                $http.get('../../all_artefacts.php').success(function (largeLoad) {    
                    data = largeLoad.filter(function(item) {
                        return JSON.stringify(item).toLowerCase().indexOf(ft) != -1;
                    });

                    $scope.setPagingData(data,page,pageSize);
                });            
            } else {
                $http.get('../../all_artefacts.php').success(function (largeLoad) {
                    $scope.setPagingData(largeLoad,page,pageSize);
                });
            }
        }, 100);
    };
  
    $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);
  
    $scope.$watch('pagingOptions', function (newVal, oldVal) {
        if (newVal !== oldVal && newVal.currentPage !== oldVal.currentPage) {
          $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
        }
    }, true);
    $scope.$watch('filterOptions', function (newVal, oldVal) {
        if (newVal !== oldVal) {
          $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
        }
    }, true);

    $scope.selected_artefact = [];

    $scope.gridOptions = { 
      data: 'myData',
      enablePaging: true,
      showFooter: true,
      //totalServerItems: 'totalServerItems',
      selectedItems: $scope.selected_artefact,
      multiSelect: false,
      pagingOptions: $scope.pagingOptions,
      filterOptions: $scope.filterOptions
     };

     $scope.accept_artefact = function() {
      console.log("accepting artefact");
      
      var artefact = $scope.selected_artefact[0];
      
      if (artefact) {
        artefact.approved = $scope.selected_artefact[0].approved = true;
        console.log(artefact);
        $http.post('../../update_artefact.php', { data: artefact })
          .success(function(data) {
            console.log(data);
            //location.reload();
          });

      } else {
        console.log("niste selektirali artefakt");
      }
     }

     $scope.decline_artefact = function() {
        console.log("decline artefact");
        
        var artefact = $scope.selected_artefact[0];
        
        if (artefact) {
          artefact.approved = $scope.selected_artefact[0].approved = false;
          console.log(artefact);
          $http.post('../../update_artefact.php', artefact)
            .success(function(data) {
              console.log(data);
              //location.reload();
            });

        } else {
          console.log("niste selektirali artefakt");
        }
       }
  });

  app.controller('stats_controller', function($scope, $http) {
    $scope.stats = [];
    $http.post('../../statistics.php', { action: "get_statistics"})
      .success(function(data, status, headers, config) {
        console.log(data);
        $scope.stats = data;
      });
  });

  

 

  
}());
