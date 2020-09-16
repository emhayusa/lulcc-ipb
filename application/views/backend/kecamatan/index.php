 <div id="page-wrapper" >
  <div class="header"> 
    <h1 class="page-header">
      Kecamatan 
    </h1>
    <ol class="breadcrumb">
     <li><a href="backend/dashboard">Home</a></li>
     <li><a href="backend/kecamatan">Kecamatan</a></li>
     <li class="active">Tables</li>
   </ol> 

 </div>

 <div id="page-inner">                
  <div class="row">
    <div class="col-md-12">
      <!-- Advanced Tables -->
      <div class="panel panel-default">
        <div class="panel-heading">
         List of Kecamatan Tables
       </div>    
       <div class="panel-body">      
        <button type="button" class="btn btn-primary active" onclick="window.location.href = 'backend/kecamatan/add';">Add Kecamatan</button>         
      </div>     
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>Kecamatan Code</th>
                <th>Kecamatan Name</th> 
                <th>Kabupaten</th>                 
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>

             <?php
             
             foreach($datas as $p){
             //var_dump($p);
               echo '<tr class="odd gradeX">';
               echo '<td>'.$p->id_kecamatan.'</td>';
               echo '<td>'.$p->nama_kecamatan.'</td>';
               echo '<td>'.$p->id_kabupaten.'</td>';           
               echo '<td class="center"><a href="backend/kecamatan/edit/'.$p->id_kecamatan.'"> <i class="fa fa-pencil-square-o"></i>edit</a>&nbsp;&nbsp;<a href="backend/kecamatan/delete/'.$p->id_kecamatan.'"> <i class="fa fa-times"></i>delete</a></td>';
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