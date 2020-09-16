 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        Commodity 
    </h1>
    <ol class="breadcrumb">
     <li><a href="backend/dashboard">Home</a></li>
     <li><a href="backend/commodity">Commodity</a></li>
     <li class="active">Form Add Commodity</li>
 </ol> 

</div>

<div id="page-inner"> 
<form class="form-horizontal" action="<?php echo site_url('backend/commodity/inserto/');?>" method="post" enctype="multipart/form-data">
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
                        <label for="inputCommodityName" class="col-sm-2 control-label">Commodity Name</label>
                        <div class="col-sm-10">
                            <input type="input" class="form-control" id="CommodityName" name="CommodityName" placeholder="Commodity Name">
                            <span class="text-danger"><?php echo form_error('CommodityName'); ?></span>      
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="InputFile" class="col-sm-2 control-label">Thumbnail On</label>
                        <div class="col-sm-10">
                            <input type="file" id="Logo" name="Logo" placeholder="Thumbnail On">
                        </div>
                    </div>  

                    <div class="form-group">
                        <label for="InputFile" class="col-sm-2 control-label">Thumbnail Off</label>
                        <div class="col-sm-10">
                            <input type="file" id="Logo_off" name="Logo_off" placeholder="Thumbnail Off">
                        </div>
                    </div>                 

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>    
</div>
<?php //echo form_close();?>