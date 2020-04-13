<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>How to Delete or Remove Data From Mysql in Laravel 6 using Ajax</title>
    <!-- jquery Cdn -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <!-- DataTables Js CDN -->
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Bootstrap Js CDN -->
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>   
    <!-- DataTables Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <!-- Bootstrap Own JS Plugin -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">    
      <br />
      <h3 align="center">How to Delete or Remove Data From Mysql in Laravel 6 using Ajax</h3>
      <br />
      <div align="right">
        <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Create Record</button>
      </div>
      <br />
      <div class="table-responsive">
        <table id="user_table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th width="35%">First Name</th>
              <th width="35%">Last Name</th>
              <th width="30%">Refresh</th>
            </tr>
          </thead>
          
        </table>
      </div>
      <br />
      <br />
    </div>
  </body>
</html>

<div id="formModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title">Add New Record</h4>
      		</div>
      		<div class="modal-body">
      			<span id="form_result"></span>

      			<form method="post" id="sample_form"  class="form-horizontal" autocomplete="off">
      				@csrf
      				<div class="form-group">
        				<label class="control-label col-md-4" >First Name : </label>
        				<div class="col-md-8">
        					<input type="text" name="first_name" id="first_name" class="form-control" />
        				</div>
        			</div>
        			<div class="form-group">
        				<label class="control-label col-md-4">Last Name : </label>
        				<div class="col-md-8">
        					<input type="text" name="last_name" id="last_name" class="form-control" />
        				</div>
        			</div>

              <br />
              <div class="form-group" align="center">
                <input type="hidden" name="action" id="action" value="Add" />
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
              </div>
      			</form>
      		</div>
    	</div>
    </div>
</div> 


<script>
  $(document).ready(function(){
    // DataTable() method will initialize jQuery Datatable plugin On this Table
    // under this Method 1st we have to set processing true. it will enable Table Process - Table Data
    // 2nd we have to write serverSide true. it will enable ServerSide Processing
    // In 3rd Option we Have Write ajax
    // and under this we have write url . which has been set Laravel Route
    // below this we have write columns option. which has been used define table column details.
    // under this array we have set "data" and "name" option for each Table Column
    //
    $('#user_table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('sample.index') }}",
      },
      columns: [
        {
          data: 'first_name',
          name: 'first_name'
        },
        {
          data: 'last_name',
          name: 'last_name'
        },
        {
          data: 'action',
          name: 'action',
          // for stop this table column sorting we have to set orderable option false
          orderable: false
        }
      ]
    }); //end of #user_table

    
    $('#create_record').click(function(){
      $('.modal-title').text('Add New Record');
      $('#action_button').val('Add')
      $('#action').val('Add');
      $('#form_result').html('');

      $('#formModal').modal('show');

    }); //end of #create_record

    $('#sample_form').on('submit', function(event){
      event.preventDefault();
      let action_url = '';


      if( $('#action').val() == 'Add' ){
        action_url = "{{ route('sample.store')}}";
      }

      if( $('#action').val() == 'Edit'){
        action_url = "{{ route('sample.update')}}";
      }
      

      $.ajax({
        url: action_url,
        method: "POST",
        //encode form data
        data: $(this).serialize(),
        //return data type that we have to received
        dataTyepe: "json",
        // if ajax request complited successfully
        success: function(data){
          // we have to show message 
          let html = '';
          
          if( data.errors){
            html = '<div class="alert alert-danger" >';
            for( let count= 0 ; count < data.errors.length ;count++){
              html += '<p>'+ data.errors[count]+'</p>';
            }
            html +="</div>";
          }

          if(data.success){
            html = '<div class="alert alert-success">' + data.success + '</div>';
            //reset modal form
            $('#sample_form')[0].reset();
            //reload Table
            $('#user_table').DataTable().ajax.reload();
          }

          $('#form_result').html(html);

        }

      });

    }); // end of #sample_form

    $(document).on('click', '.edit', function(){

      let id= $(this).attr('id');
      $('#form_result').html('');

      $.ajax({
        url: "sample/"+id+"/edit",
        dataType: "json",
        success: function(data){
          $('#first_name').val(data.user_record.first_name);
          $('#last_name').val(data.user_record.last_name);
          $('#hidden_id').val(id);
          $('.modal-title').text('Edit Record');
          $('#action_button').val('Edit');
          $('#action').val('Edit');

          $('#formModal').modal('show');
        }
      })

    }); // end of "edit" functionality


  });
</script>


