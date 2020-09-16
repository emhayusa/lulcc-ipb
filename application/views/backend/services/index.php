 <div id="page-wrapper" >
  <div class="header"> 
    <h1 class="page-header">
      Services 
    </h1>
    <ol class="breadcrumb">
     <li><a href="backend/dashboard">Home</a></li>
     <li><a href="backend/services">Services</a></li>
     <li class="active">Tables</li>
   </ol> 

 </div>

 <div id="page-inner">                
  <div class="row">
    <div class="col-md-12">
      <!-- Advanced Tables -->
      <div class="panel panel-default">
        <div class="panel-heading">
         List of Services Tables
       </div>    
       <div class="panel-body">      
        <button type="button" class="btn btn-primary active" onclick="window.location.href = 'backend/services/add';">Add Services</button>         
      </div>     
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>Commodity</th>
                <th>Services Name</th>
                <th>Type</th>
                <th>Resolution</th>                
                <th>Year</th>
                <th>License</th>   
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

             <?php

             foreach($datas as $p){
						 //var_dump($p);
              echo '<tr class="odd gradeX">';
              echo '<td>'.$p->commodity_id.'</td>';
              echo '<td>'.$p->name.'</td>';
               //$label = $p->type == 1 ? 'ArcGIS':'OGC';
              if ($p->type == 1) {
                $label = 'ArcGIS';
              }else if ($p->type == 2) {
                $label = 'OGC';
              }else{
                $label = 'undefined';
              }
              echo '<td>'.$label.'</td>';
              echo '<td>'.$p->resolution.'</td>';              
              echo '<td>'.$p->year.'</td>';
              echo '<td>'.$p->license.'</td>';
              echo '<td class="center"><a href="backend/services/edit/'.$p->id_service.'"> <i class="fa fa-pencil-square-o"></i>edit</a>&nbsp;&nbsp;<a href="backend/services/delete/'.$p->id_service.'"> <i class="fa fa-times"></i>delete</a></td>';
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