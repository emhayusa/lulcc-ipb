 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        setting 
    </h1>
    <ol class="breadcrumb">
     <li><a href="backend/dashboard">Home</a></li>
     <li><a href="backend/setting">setting</a></li>
     <li class="active">Form Edit setting</li>
 </ol> 

</div>

<div id="page-inner"> 
  <?php //echo form_open("backend/setting/update", array('class' => 'form-horizontal')); ?>

  <form class="form-horizontal" action="<?php echo site_url('backend/setting/update/');?>" method="post" enctype="multipart/form-data">

  <input type="hidden" id="id" name="id" value="<?php echo $data->id_setting; ?>" />

  <div class="row">
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card-title">
                    <div class="title">setting Form</div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputTitle" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="Title" name="Title" placeholder="Title" value="<?php echo set_value('Title', $data->title); ?>">
                        <span class="text-danger"><?php echo form_error('Title'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputFile" class="col-sm-2 control-label">Logo WebGIS</label>
                    <div class="col-sm-10">
                        <img src="<?php echo base_url();?>assets/images/<?php echo $data->logo;?>" height="100" width="100" >   <br><br>
                        <input type="file" id="Logo" name="Logo" placeholder="Logo Webgis">
                    </div>
                </div>
                <div class="form-group">
                    <label for="textinfo" class="col-sm-2 control-label">Information</label>
                    <div class="col-sm-10">
                    <?php
                    $detos = array(
                        'name'        => 'About',
                        'id'          => 'About',
                        'value'       => $data->about,
                        'rows'        => '5',
                        'cols'        => '10',
                        'style'       => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;',
                        );

                    echo form_textarea($detos);
                    ?>
                        <span class="text-danger"><?php echo form_error('Information'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputFooter" class="col-sm-2 control-label">Footer</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="Footer" name="Footer" placeholder="Footer" value="<?php echo set_value('Footer', $data->footer); ?>">
                        <span class="text-danger"><?php echo form_error('Footer'); ?></span>      
                    </div>
                </div>                        

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<?php //echo form_close();?>