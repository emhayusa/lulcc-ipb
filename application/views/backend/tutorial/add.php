 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        Tutorial 
    </h1>
    <ol class="breadcrumb">
       <li><a href="backend/dashboard">Home</a></li>
       <li><a href="backend/tutorial">Tutorial</a></li>
       <li class="active">Form Add Tutorial</li>
   </ol> 

</div>

<div id="page-inner"> 
  <?php echo form_open("backend/tutorial/insert", array('class' => 'form-horizontal')); ?>   

  <div class="row">
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card-title">
                    <div class="title">Tutorial Form</div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputTutorialTitle" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-7">
                        <input type="input" class="form-control" id="TutorialTitle" name="TutorialTitle" placeholder="Tutorial Title" value="<?php echo set_value('TutorialTitle'); ?>">
                        <span class="text-danger"><?php echo form_error('TutorialTitle'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="selectTypeofMedia" class="col-sm-2 control-label">Type of Media</label>
                    <div class="col-sm-10">
                      <div class="radio1 radio-check radio-inline">
                        <input type="radio" id="radio1" name="media_type" value="1" >
                        <label for="radio1">Video</label>
                    </div>
                    <div class="radio1 radio-check radio-success radio-inline">
                        <input type="radio" id="radio2" name="media_type" value="2">
                        <label for="radio2">pdf</label>
                    </div>    
                </div>

            </div>    
            <div class="form-group">
                <label for="selectActive" class="col-sm-2 control-label">Active ?</label>
                <div class="col-sm-10">
                  <div class="radio1 radio-check radio-inline" >
                    <input type="radio" id="radio1" name="active" value="1" >
                    <label for="radio1">Yes</label>
                </div>
                <div class="radio1 radio-check radio-success radio-inline">
                    <input type="radio" id="radio2" name="active" value="2">
                    <label for="radio2">No</label>
                </div> 
            </div>            
        </div>
        <div class="form-group">
            <label for="InputFile" class="col-sm-2 control-label">File input</label>
            <div class="col-sm-7">
                <input type="file" id="InputThumbnail" name="Thumbnail" placeholder="Thumbnail"  value="<?php echo set_value('Thumbnail'); ?>">
                <span class="text-danger"><?php echo form_error('Thumbnail'); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputURLTutorial" class="col-sm-2 control-label">URL Tutorial</label>
            <div class="col-sm-9">
                <input type="input" class="form-control" id="URLTutorial" name="URLTutorial" placeholder="URL Tutorial" value="<?php echo set_value('URLTutorial'); ?>">
                <span class="text-danger"><?php echo form_error('URLTutorial'); ?></span>      
            </div>
        </div>

        <div class="form-group">
            <label for="InputFile" class="col-sm-2 control-label">Upload File</label>
            <div class="col-sm-7 control-label">
                <input type="file" id="UploadFile" name="UploadFile" placeholder="Upload File"  value="<?php echo set_value('UploadFile'); ?>">
                <span class="text-danger"><?php echo form_error('UploadFile'); ?></span>
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