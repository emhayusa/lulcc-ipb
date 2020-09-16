 <div id="page-wrapper" >
  <div class="header"> 
    <h1 class="page-header">
      Reporting 
    </h1>
    <ol class="breadcrumb">
     <li><a href="backend/dashboard">Home</a></li>
     <li><a href="backend/reporting">Reporting</a></li>
     <li class="active">Tables</li>
   </ol> 

 </div>

 <div id="page-inner">                
  <div class="row">
    <div class="col-md-12">
      <!-- Advanced Tables -->
      <div class="panel panel-default">
        <div class="panel-heading">
         List of Reporting Tables
       </div>    
       <div class="panel-body">      
        <button type="button" class="btn btn-primary active" onclick="window.location.href = 'backend/reporting/add';">Add Reporting</button>         
      </div>     
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>Province</th>
                <th>District</th> 
                <th>Sub District</th>
                <th>Forest Gain (ha)</th>
                <th>Forest Loss (ha)</th>               
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              
             <?php
             
             foreach($datas as $p){
						 //var_dump($p);
               echo '<tr class="odd gradeX">';
               /*
               echo '<td>'.$p->province_id.'</td>';
               echo '<td>'.$p->kabupaten_id.'</td>';
               echo '<td>'.$p->kecamatan_id.'</td>';
               */
               echo '<td>'.$p->nama_provinsi.'</td>';
               echo '<td>'.$p->nama_kabupaten.'</td>';
               echo '<td>'.$p->nama_kecamatan.'</td>';
               echo '<td>'.$p->forest_gain.'</td>';
               echo '<td>'.$p->forest_loss.'</td>';               
               echo '<td class="center"><a href="backend/reporting/edit/'.$p->id_reporting.'"> <i class="fa fa-pencil-square-o"></i>edit</a>&nbsp;&nbsp;<a href="backend/reporting/delete/'.$p->id_reporting.'"> <i class="fa fa-times"></i>delete</a></td>';
               echo '</tr>';
             }
					/*
					<tr class="odd gradeX">
                      <td>Palm Oil</td>
                      <td>150000</td> 
                      <td>KLHK</td>   
                      <td>2019</td> 
                      <td>IPB</td>                                     
                      <td class="center"><a href="backend/services/edit"> <i class="fa fa-pencil-square-o"></i>edit</a>&nbsp;&nbsp;<a href="backend/services/delete"> <i class="fa fa-times"></i>delete</a></td>                                            
                    </tr>
					*/
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