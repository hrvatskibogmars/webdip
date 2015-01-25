(function(){
  'use strict';

  var app = angular.module('app', ['ngGrid']);

  app.controller('main', function($rootScope, $http) {
    $('#mytabs a').click(function(e) {
      e.preventDefault();
      $(this).tab('show');
    });
  });

  app.controller('region_controller', function($scope, $http) {

    $scope.region_list = [];
    $scope.region_name = "";
    $scope.selection = {
      ids: {},
      current_edit: 0
    };

    $scope.save_region = function() {
      console.log("Saving region ");
      console.log($scope.region_name);

      $http.post('../../region.php', { "action": "add", "data": $scope.region_name })
        .success(function(data, status, headers, config) {

          if (data != "null") {
              $scope.region_list.push({ id: data, name: $scope.region_name });
          }
          $scope.region_name = "";

        });
    };

    $scope.delete_region = function(region_id) {
      $http.post('../../region.php', { "action": "delete", "data": region_id })
        .success(function(data, status, headers, config) {
          console.log(data);
          for (var index = 0; index < $scope.region_list.length; ++index) {
            if ($scope.region_list[index].id == region_id)
              $scope.region_list.splice(index, 1);
          }
        });
    }

    $scope.get_regions = function() {
      console.log("Retrieving regions...");
      $http.get('../../region.php')
        .success(function(data, status, headers, config) {
            console.log($scope.region_list);
            $scope.region_list = data;
      });
    }();

    $scope.get_users = function() {
      console.log("Retrieving users...");
      $http.get('../../users.php')
        .success(function(data, status, headers, config) {
          $scope.user_list = data;
          console.log($scope.user_list);
        });
    }();

    $scope.edit_moderators = function(region_id) {
      console.log(region_id);
      $scope.selection.current_edit = region_id;
      $scope.selection.ids = {};
      $('#edit_moderators').modal();
      $http.post('../../region.php', { "action": "edit_moderators", "region_id": region_id })
        .success(function(data, status, headers, config) {
          console.log(data);
          for (var index = 0; index < data.length; ++index) {
            var object = data[index];
            $scope.selection.ids[object.user_id] = true;
          }
          //$scope.$apply();
        });
    }

    $scope.save_moderators = function() {
      $http.post('../../region.php',
        { "action": "save_moderators" , "data": $scope.selection.ids, "region_id": $scope.selection.current_edit })
        .success(function(data, status, headers, config) {
          console.log(data);
          $('#edit_moderators').modal('toggle');
        });
    }

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

  app.controller('logs_controller', function($scope, $http) {
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
                $http.post('../../log.php', { action: "get_log" }).success(function (largeLoad) {    
                    data = largeLoad.filter(function(item) {
                        return JSON.stringify(item).toLowerCase().indexOf(ft) != -1;
                    });

                    $scope.setPagingData(data,page,pageSize);
                });            
            } else {
                $http.post('../../log.php', { action: "get_log" }).success(function (largeLoad) {
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

    $scope.gridOptions = { 
      data: 'myData',
      enablePaging: true,
      showFooter: true,
      totalServerItems: 'totalServerItems',
      pagingOptions: $scope.pagingOptions,
      filterOptions: $scope.filterOptions
     };
  });

  app.controller('users_controller', function($scope, $http) {
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
                $http.get('../../users.php').success(function (largeLoad) {    
                    delete largeLoad['password'];
                    data = largeLoad.filter(function(item) {
                        return JSON.stringify(item).toLowerCase().indexOf(ft) != -1;
                    });

                    $scope.setPagingData(data,page,pageSize);
                });            
            } else {
                $http.get('../../users.php').success(function (largeLoad) {
                    delete largeLoad['password'];
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

    $scope.mySelections = [];

    $scope.gridOptions = { 
      data: 'myData',
      enablePaging: true,
      showFooter: true,
      //totalServerItems: 'totalServerItems',
      pagingOptions: $scope.pagingOptions,
      filterOptions: $scope.filterOptions,
      selectedItems: $scope.mySelections,
      multiSelect: false
     };

     $scope.unblock_selected = function() {
      console.log($scope.mySelections);
      if ($scope.mySelections[0] != undefined) {
        $http.post('../../unblock.php', { id: $scope.mySelections[0].id })
          .success(function(dt) {
            location.reload(); 
        })
      }
    }
  });

  app.controller('config_controller', function($scope, $http) {
    $scope.config = {}
    $scope.max_login_count = 3

    $http.post('../../config.php', { action: "get_config"})
      .success(function(data, status, headers, config) {
        if (Object.keys(data).length === 0)
          $scope.reset_config();

        $scope.config = data;

        console.log(data);
      });

    $scope.save_config = function() {
      console.log($scope.config.max_login_count);

      $http.post('../../config.php', { action: "save_config", data: $scope.config })
        .success(function(data, status, headers, config) {
          console.log(data);

        });
    }

    $scope.reset_config = function() {
      $http.post('../../config.php', { action: "reset_config" })
        .success(function(data, status, headers, config) {
          //console.log(data);
          //$scope.config = data;
        });
    }
  });
}());
