 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        Commodity 
    </h1>
    <ol class="breadcrumb">
       <li><a href="backend/dashboard">Home</a></li>
       <li><a href="backend/commodity">Commodity</a></li>
       <li class="active">Form Delete Commodity</li>
   </ol> 

</div>

<div id="page-inner"> 
  <?php echo form_open("backend/commodity/remove", array('class' => 'form-horizontal')); ?>
  <input type="hidden" id="id" name="id" value="<?php echo $data->id_commodity; ?>" />
  <div class="row">
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card-title">
                    <div class="title">Commodity Form</div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-2">Commodity Name</div>
                    <div class="col-sm-10">
                        <?php echo $data->commodity_name; ?>      
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Thumbnail</div>
                    <div class="col-sm-10">
                        <?php echo $data->thumbnail_on; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
<?php echo form_close();?>