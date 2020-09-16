 <div id="page-wrapper" >
  <div class="header"> 
    <h1 class="page-header">
      Basemap 
    </h1>
    <ol class="breadcrumb">
     <li><a href="backend/dashboard">Home</a></li>
     <li><a href="backend/basemap">Basemap</a></li>
     <li class="active">Tables</li>
   </ol> 

 </div>

 <div id="page-inner">                
  <div class="row">
    <div class="col-md-12">
      <!-- Advanced Tables -->
      <div class="panel panel-default">
        <div class="panel-heading">
         List of Basemap Tables
       </div>    
       <div class="panel-body">      
        <button type="button" class="btn btn-primary active" onclick="window.location.href = 'backend/basemap/add';">Add Basemap</button>     
        <button type="button" class="btn btn-warning active" id ="save">save config</button>          
      </div>     
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>Thumbnails</th>
                <th>Basemap Name</th> 
                <th>is Active ?</th>
                <th>Default</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>

             <?php
             
             foreach($datas as $p){
             //var_dump($p);
               echo '<tr class="odd gradeX">';
               echo '<td>'.$p->thumbnail.'</td>';
               echo '<td>'.$p->basemap_name.'</td>';
               $label = $p->active == 1 ? 'checked':'';
               echo '<td><div class="checkbox3 checkbox-inline checkbox-check checkbox-light">
               <input type="checkbox" name="active_'.$p->id_basemap.'" value="'.$p->id_basemap.'" '.$label.'>
               <label for="checkbox-fa-light-1">

               </label>
               </div></td>';
               $label = $p->main == 1 ? 'checked':'';
               echo '<td><div class="radio3 radio-check radio-inline">
               <input type="radio" name="main" value="'.$p->id_basemap.'"   '.$label.'>
               <label for="radio4">

               </label>
               </div></td>';
             //echo '<td>'.$p->resolution.'</td>';
             //echo '<td>'.$p->data_source.'</td>';
             //echo '<td>'.$p->year.'</td>';
             //echo '<td>'.$p->license.'</td>';
               echo '<td class="center"><a href="backend/basemap/edit/'.$p->id_basemap.'"> <i class="fa fa-pencil-square-o"></i>edit</a>&nbsp;&nbsp;<a href="backend/basemap/delete/'.$p->id_basemap.'"> <i class="fa fa-times"></i>delete</a></td>';
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
          function update(active, main) {
            $.ajax
            ({
              type: "POST",
                //the url where you want to sent the userName and password to
                url: 'backend/basemap/update_config',
                //dataType: 'json',
               // async: false,
                //json object to sent to the authentication url
                data: { "active": active, "main" : main },
                success: function (data) {
                  if(data == 'Sukses')
                   alert("Data Updated!");
                 else
                  alert(data);
                  //console.log(data);
                }
              })
          }
          $('#save').click(function(){
            //alert ('tes');

            var active = [];

            $.each($("input[type='checkbox']:checked"), function(){

              active.push($(this).val());

            });

            //alert("My active list are: " + active.join(", "));
            //console.log( );
            main = $("input[name='main']:checked").val();
            //alert("default main is " + main);
            update(active, main);
          });
        });
      </script>