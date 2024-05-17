<?php include ('header.php') ?>
<div class="container-fluid">
	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fa fa-fw fa-newspaper"></i>
			Task Table
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Title</th>
							<th>Description</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Nullam sem dolor, ultrices a sapien ut, blandit ferm</td>
							<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lacinia neque a
								scelerisque varius. Mauris consequat, massa vel tristique viverra, mi mi mattis magna,
								eu sodales augue nunc eget nulla. Cras consequat arcu sed imperdiet placerat. Nunc
								ornare sit amet ligula eu interdum. Nunc felis tellus, volutpat ut nulla a, tincidunt
								euismod tortor</td>
							<td>12th Sep 2019</td>
						</tr>
						<tr>
							<td>Lorem ipsum dolor sit</td>
							<td>Sed egestas eros lorem, sed congue orci dapibus sed. Nullam ut pulvinar mi. Duis auctor
								lorem est. Nulla quis ante risus. Vestibulum ante ipsum primis in faucibus orci luctus
								et ultrices posuere cubilia Curae; Maecenas lobortis sagittis sapien, sit amet molestie
								nisl elementum a. Fusce a vehicula eros. Integer enim ipsum, faucibus id feugiat vitae,
								finibus eu turpis.</td>
							<td>14th Sep 2019</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
<?php include ('footer.php') ?>