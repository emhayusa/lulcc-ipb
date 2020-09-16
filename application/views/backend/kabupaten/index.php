 <div id="page-wrapper" >
  <div class="header"> 
    <h1 class="page-header">
      Kabupaten 
    </h1>
    <ol class="breadcrumb">
     <li><a href="backend/dashboard">Home</a></li>
     <li><a href="backend/kabupaten">Kabupaten</a></li>
     <li class="active">Tables</li>
   </ol> 

 </div>

 <div id="page-inner">                
  <div class="row">
    <div class="col-md-12">
      <!-- Advanced Tables -->
      <div class="panel panel-default">
        <div class="panel-heading">
         List of Kabupaten Tables
       </div>    
       <div class="panel-body">      
        <button type="button" class="btn btn-primary active" onclick="window.location.href = 'backend/kabupaten/add';">Add Kabupaten</button>         
      </div>     
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>Kabupaten Code</th>
                <th>Kabupaten Name</th> 
                <th>Province</th> 
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              
             <?php
             
             foreach($datas as $p){
             //var_dump($p);
               echo '<tr class="odd gradeX">';
               echo '<td>'.$p->id_kabupaten.'</td>';
               echo '<td>'.$p->nama_kabupaten.'</td>';
               echo '<td>'.$p->id_provinsi.'</td>';
               echo '<td class="center"><a href="backend/kabupaten/edit/'.$p->id_kabupaten.'"> <i class="fa fa-pencil-square-o"></i>edit</a>&nbsp;&nbsp;<a href="backend/kabupaten/delete/'.$p->id_kabupaten.'"> <i class="fa fa-times"></i>delete</a></td>';
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