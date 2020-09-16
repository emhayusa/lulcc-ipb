 <div id="page-wrapper" >
  <div class="header"> 
    <h1 class="page-header">
      Province 
    </h1>
    <ol class="breadcrumb">
     <li><a href="backend/dashboard">Home</a></li>
     <li><a href="backend/province">Province</a></li>
     <li class="active">Tables</li>
   </ol> 

 </div>

 <div id="page-inner">                
  <div class="row">
    <div class="col-md-12">
      <!-- Advanced Tables -->
      <div class="panel panel-default">
        <div class="panel-heading">
         List of Province Tables
       </div>    
       <div class="panel-body">      
        <button type="button" class="btn btn-primary active" onclick="window.location.href = 'backend/province/add';">Add Province</button>         
      </div>     
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>Province Code</th>
                <th>Province Name</th> 
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              
             <?php
             
             foreach($datas as $p){
             //var_dump($p);
               echo '<tr class="odd gradeX">';
               echo '<td>'.$p->id_provinsi.'</td>';
               echo '<td>'.$p->nama_provinsi.'</td>';
               echo '<td class="center"><a href="backend/province/edit/'.$p->id_provinsi.'"> <i class="fa fa-pencil-square-o"></i>edit</a>&nbsp;&nbsp;<a href="backend/province/delete/'.$p->id_provinsi.'"> <i class="fa fa-times"></i>delete</a></td>';
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