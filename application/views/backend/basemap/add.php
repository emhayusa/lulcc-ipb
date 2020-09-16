 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        Basemap 
    </h1>
    <ol class="breadcrumb">
     <li><a href="backend/dashboard">Home</a></li>
     <li><a href="backend/basemap">Basemap</a></li>
     <li class="active">Form Add Basemap</li>
 </ol> 

</div>

<div id="page-inner"> 
  <?php echo form_open("backend/basemap/insert", array('class' => 'form-horizontal')); ?>   

  <div class="row">
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card-title">
                    <div class="title">Basemap Form</div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputbasemapId" class="col-sm-2 control-label">Basemap Id</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="BasemapId" name="BasemapId" placeholder="Basemap Id" value="<?php echo set_value('BasemapId'); ?>">
                        <span class="text-danger"><?php echo form_error('BasemapId'); ?></span>      
                    </div>
                </div>
				<div class="form-group">
                    <label for="inputbasemapName" class="col-sm-2 control-label">Basemap Name</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="BasemapName" name="BasemapName" placeholder="Basemap Name" value="<?php echo set_value('BasemapName'); ?>">
                        <span class="text-danger"><?php echo form_error('BasemapName'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputURLBasemap" class="col-sm-2 control-label">URL Basemap</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="URLBasemap" name="URLBasemap" placeholder="URL Basemap" value="<?php echo set_value('URLBasemap'); ?>">
                        <span class="text-danger"><?php echo form_error('URLBasemap'); ?></span>      
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="InputFile" class="col-sm-2 control-label">File input</label>
                    <div class="col-sm-7 control-label">
                        <input type="file" id="InputThumbnail" name="Thumbnail" placeholder="Thumbnail"  value="<?php echo set_value('Thumbnail'); ?>">
                        <span class="text-danger"><?php echo form_error('Thumbnail'); ?></span>
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
</div>
<?php echo form_close();?>