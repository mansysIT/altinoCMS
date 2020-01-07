<button id="sidebarCollapse">X</button>
	<div class="tableholder">
	<form class="form-inline" method="post" action="">
        <button type="submit" class="btn btn-danger mb-2" name="filterByData">Clear</button>
		<div class="form-group mx-sm-3 mb-2">
			<label class="sr-only">Woord</label>
			<input type="text" class="form-control" id="inputPassword2" name="word" placeholder="Key Word">
		</div>
		<div class="form-group mx-sm-3 mb-2">
			<label class="sr-only">Vanaf</label>
			<input type="date" class="form-control" id="inputPassword2" name="vanaf" value="2019-01-01">
		</div>
		<div class="form-group mx-sm-3 mb-2">
			<label class="sr-only">Tot</label>
			<input type="date" class="form-control" id="inputPassword2" value="2019-12-31" name="tot">
		</div>
		<button type="submit" class="btn btn-danger mb-2" name="filterByData">Confirm identity</button>
	</form>
	<div class="table-responsive">
	<table class="table table-striped" id="myTable2">
		<thead>
				<tr>
					<th onclick="sortTable(0)">ID</th>
					<th onclick="sortTable(1)">CITY</th>
					<th onclick="sortTable(2)">ADDRES</th>
					<th onclick="sortTable(3)">BEDRAG</th>
					<th onclick="sortTable(4)">INKOMSTEN</th>
					<th onclick="sortTable(5)">UITGAVEN</th>
					<th onclick="sortTable(6)">WINST</th>
				</tr>
		</thead>
		<tbody>
			<?php foreach($sidebarController->getAdress() as $row): ?>
				<tr>
					<td><a style="color: #000!important;" href="#"><?php echo $row[0]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[1]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[2]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[3]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[4]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[5]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[6]; ?></a></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
	</div>