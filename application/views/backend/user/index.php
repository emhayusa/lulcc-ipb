 <div id="page-wrapper" >
  <div class="header"> 
    <h1 class="page-header">
      User 
    </h1>
    <ol class="breadcrumb">
     <li><a href="backend/dashboard">Home</a></li>
     <li><a href="backend/user">User</a></li>
     <li class="active">Tables</li>
   </ol> 

 </div>

 <div id="page-inner">                
  <div class="row">
    <div class="col-md-12">
      <!-- Advanced Tables -->
      <div class="panel panel-default">
        <div class="panel-heading">
         List of User Tables
       </div>    
       <div class="panel-body">      
        <button type="button" class="btn btn-primary active" onclick="window.location.href = 'backend/user/add';">Add User</button>         
      </div>     
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th> 
              </tr>
            </thead>
            <tbody>

             <?php

             foreach($datas as $p){
						 //var_dump($p);
               echo '<tr class="odd gradeX">';
               echo '<td>'.$p->fullname.'</td>';
               echo '<td>'.$p->username.'</td>';
               echo '<td>'.$p->email.'</td>';
               echo '<td>'.$p->role_id.'</td>';
						 //echo '<td>'.$p->year.'</td>';
						 //echo '<td>'.$p->license.'</td>';
               echo '<td class="center"><a href="backend/user/edit/'.$p->id_user.'"> <i class="fa fa-pencil-square-o"></i>edit</a>&nbsp;&nbsp;<a href="backend/user/delete/'.$p->id_user.'"> <i class="fa fa-times"></i>delete</a></td>';
               echo '</tr>';
             }

             ?>
           </tbody>
         </table>
       </div>                            
     </div>
   </div>
   <!--End Advanced Tables -->
 </div>
</div>

<script>
  $(document).ready(function () {
    $('#dataTables-example').dataTable();
  });
</script>