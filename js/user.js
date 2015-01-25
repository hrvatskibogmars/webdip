(function() {
  'use strict';

  var app = angular.module('app', []);

  app.filter('offset', function() {
    return function(input, start) {
      start = parseInt(start, 10);
      return input.slice(start);
    };
  });

  app.controller('main', function($sce, $scope, $http) {

    $scope.artefacts = []
    $scope.artefact = {
      region: "",
      place: "",
      name: "",
      content: ""
    }

    $scope.itemsPerPage = 20;
    $scope.currentPage = 0;
    $scope.items = [];

    for (var i=0; i<50; i++) {
      $scope.items.push({
        id: i, name: "name "+ i, description: "description " + i
      });
    }

    $scope.prevPage = function() {
      if ($scope.currentPage > 0) {
        $scope.currentPage--;
      }
    };

    $scope.prevPageDisabled = function() {
      return $scope.currentPage === 0 ? "disabled" : "";
    };

    $scope.pageCount = function() {
      return Math.ceil($scope.items.length/$scope.itemsPerPage)-1;
    };

    $scope.nextPage = function() {
      if ($scope.currentPage < $scope.pageCount()) {
        $scope.currentPage++;
      }
    };

    $scope.nextPageDisabled = function() {
      return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
    };

    $scope.setPage = function(n) {
      $scope.currentPage = n;
    };

    $('.ui-helper-hidden-accessible .ng-pristine .ng-valid').css({'z-indes': 2050});
    $scope.regions = [];

    $scope.add_artefact = function() {
      $('#add_artefact').modal();
    }

    $scope.show_filters = function() {
      $(".btn-filter").click();
    };

    $http.get('../../../skripte/region.php')
      .success(function(data, status, headers, config) {
        console.log(data);
        $scope.regions = data;

        $scope.render_region = function(region_id) {
          console.log("trazim za");
          console.log(region_id);

          for (var obj in $scope.regions) {
            //console.log($scope.regions[obj]);
            var id = parseInt($scope.regions[obj].id);
            console.log(id);
            console.log(region_id)
            if (id == region_id) {
              console.log("Pronadeno");
              console.log($scope.regions[obj].id);
              console.log($scope.regions[obj].name);
              return $sce.trustAsHtml($scope.regions[obj].name);; 
            }
          }
        }
      });

    var city = new Array();
    $http.get("http://arka.foi.hr/WebDiP/2013/materijali/dz3_dio2/gradovi.json")
       .success(function(data, status, headers, config) {
          $.each(data, function(key, val) {
             //console.log(val);
             city.push(val);
          });
    },'json');

    $('#place').autocomplete({
        source: city
    });


    $http.get('../../../skripte/artefacts.php')
      .success(function(data, status, headers, config) {
        console.log(data);

        $scope.artefacts = data;
      });
  });

  document.getElementById('links').onclick = function (event) {
      event = event || window.event;
      var target = event.target || event.srcElement,
          link = target.src ? target.parentNode : target,
          options = {index: link, event: event},
          links = this.getElementsByTagName('a');
      blueimp.Gallery(links, options);
  };
}());

$(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});