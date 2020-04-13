<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Normal Search</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">    
  			<br />
  			<h3 align="center">Normal Search in Datatables</h3>
  			<br />
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="user_table">
			        <thead>
				        <tr>
				            <th>Customer Name</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Postal Code</th>
                    <th>Country</th>
				        </tr>
			        </thead>
			    </table>
			</div>
			<br />
			<br />
		</div>
	</body>
</html>


<script>
$(document).ready(function(){

	$('#user_table').DataTable({
		processing: true,
		serverSide: true,
		ajax:{
			url: "{{ route('full-text-search.normal-search') }}",
		},
		columns:[
			{
				data: 'CustomerName',
				name: 'CustomerName'
			},
			{
				data: 'Gender',
				name: 'Gender'
			},
			{
        data: 'Address',
        name: 'Address'
      },
      {
        data: 'City',
        name: 'City'
      },
      {
        data: 'PostalCode',
        name: 'PostalCode'
      },
      {
        data: 'Country',
        name: 'Country'
      }
		]
	});

});
</script>

