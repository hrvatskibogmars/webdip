
(function() { 

    var app = angular.module('app', []);

    
    app.controller('main', function($sce, $scope, $http) {
    	console.log("main kontroler ucitana");
        
        $scope.regions = [];
        $http.get('skripte/region.php')
            .success(function(data, status, headers, config) {
                console.log(data);
                $scope.regions = data;
            });


        $scope.artefacts = [];
        $http.get('skripte/all_artefacts.php')
            .success(function(data, status, headers, config) {
                console.log(data);
                $scope.artefacts = data;
            });


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

	
    app.controller('regije', function($scope, $http) {
    	console.log("regije kontroler ucitan");
    	
    });

}());

$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });

    $('#myCarousel').carousel({
		interval:   4000
	});
	
	var clickEvent = false;
	$('#myCarousel').on('click', '.nav a', function() {
			clickEvent = true;
			$('.nav li').removeClass('active');
			$(this).parent().addClass('active');		
	}).on('slid.bs.carousel', function(e) {
		if(!clickEvent) {
			var count = $('.nav').children().length -1;
			var current = $('.nav li.active');
			current.removeClass('active').next().addClass('active');
			var id = parseInt(current.data('slide-to'));
			if(count == id) {
				$('.nav li').first().addClass('active');	
			}
		}
		clickEvent = false;
	});
});