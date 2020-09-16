 <div id="page-wrapper" >
        <div class="header"> 
          <h1 class="page-header">
            Commodity 
          </h1>
          <ol class="breadcrumb">
           <li><a href="backend/dashboard">Home</a></li>
           <li><a href="backend/commodity">Commodity</a></li>
           <li class="active">Tables</li>
         </ol> 

       </div>

       <div id="page-inner">            
        <div class="row">
          <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
              <div class="panel-heading">
               List of Commodity Tables
             </div>    
             <div class="panel-body">      
              <button type="button" class="btn btn-primary active" onclick="window.location.href = 'backend/commodity/add';">Add Commodity</button>         
            </div>     
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                    <tr>
                      <th>Thumbnail On</th>
                      <th>Thumbnail Off</th>
                      <th>Commodity Name</th> 
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $no=0; foreach($datas as $p ): $no++;?>
                  <tr class="odd gradeX">
                    <td>
                    <img src="<?php echo base_url();?>assets/thumbnail/<?php echo $p->thumbnail_on;?>" height="100px" width="100px" >
                    </td>	
                    <td>
                    <img src="<?php echo base_url();?>assets/thumbnail/<?php echo $p->thumbnail_off;?>" height="100px" width="100px" >
                    </td>	
                    <td>
                    <?php echo $p->commodity_name;?>
                    </td>
                    <td class="center">
                    <a href="<?php echo site_url('backend/commodity/edit/'.$p->id_commodity);?>">
                    <i class="fa fa-pencil-square-o"></i>edit</a>&nbsp;&nbsp;
                    <a href="<?php echo site_url('backend/commodity/delete/'.$p->id_commodity);?>"> <i class="fa fa-times"></i>delete</a>
                    </td>
                  </tr>
		              <?php endforeach;?>
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