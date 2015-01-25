<?php
include ('./header_angular.php');

if($tipKorisnika != 4)
{
	echo $tipKorisnika;
}

?>

<section>
	<div ng-controller="tablica" data-ng-init="init()">
    	<div class="container">
    		<div class="row">
    	 		<div class="col-md-9 col-md-offset-2">
    	 			<div class="table-responsive">
    	 				<table  class="table">
    	 					<thead>
    	 						<tr>
    	 							<th>Ime</th>
    	 							<th>Naziv Regije</th>
    	 							<th>Datum Kreiranja</th>
    	 						</tr>
    	 					</thead>
    	 						<tbody>
    	 							<tr data-ng-repeat="element in data">
								    	<td>{{element.regija_id}}</td>
								    	<td>{{element.naziv}}</td>
								    	<td>{{element.datum_kreiranja}}</td>
								    </tr>
								</tbody>
							</table>
						</div>

						<form class="form-horizontal" ng-submit="processForm()">

						<div class="control-group">
							<label class="control-label" for="textinput">Unesite naziv regije:</label>
						  	<div class="controls">
						    	<input id="textinput" name="textinput" type="text"ng-model="formData.name" placeholder="Unesi regiju" class="input-xlarge">
						  	</div>
						  	<br>
						</div>
						    <button id="singlebutton" name="singlebutton" ng-click ="add()" class="btn btn-primary btn-sm">Dodaj na listu</button>
						</form>
					</div>
				</div>
			</div>
		</div>
    </div>
</section>
<?php
include ('./footer.php');
?>