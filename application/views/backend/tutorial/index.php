 <div id="page-wrapper" >
        <div class="header"> 
          <h1 class="page-header">
            Tutorial 
          </h1>
          <ol class="breadcrumb">
           <li><a href="backend/dashboard">Home</a></li>
           <li><a href="backend/tutorial">Tutorial</a></li>
           <li class="active">Tables</li>
         </ol> 

       </div>

       <div id="page-inner">                
        <div class="row">
          <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
              <div class="panel-heading">
               List of Tutorial Tables
             </div>    
             <div class="panel-body">      
              <button type="button" class="btn btn-primary active" onclick="window.location.href = 'backend/tutorial/add';">Add Tutorial</button>         
            </div>     
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                    <tr>
                      <th>Thumbnails</th>
                      <th>Title</th> 
                      <th>Type</th> 
                      <th>is Active ?</th> 
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
				  
					<?php
					
					   foreach($datas as $p){
						 //var_dump($p);
						 echo '<tr class="odd gradeX">';
						 echo '<td>'.$p->thumbnail.'</td>';
						 echo '<td>'.$p->title.'</td>';
             if ($p->media_type == 1) {
                $label1 = 'video';
              }else if ($p->media_type == 2) {
                $label1 = 'pdf';
              }else{
                $label1 = 'undefined';
              }
						 echo '<td>'.$label1.'</td>';

             if ($p->active == 1) {
                $label2 = 'Yes';
              }else if ($p->active == 2) {
                $label2 = 'No';
              }else{
                $label2 = 'undefined';
              }
						 echo '<td>'.$label2.'</td>';
             
						 echo '<td class="center"><a href="backend/tutorial/edit/'.$p->id_tutorial.'"> <i class="fa fa-pencil-square-o"></i>edit</a>&nbsp;&nbsp;<a href="backend/tutorial/delete/'.$p->id_tutorial.'"> <i class="fa fa-times"></i>delete</a></td>';
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