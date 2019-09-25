<div class="container">
	<div class="content">
		<form action="" method="post" enctype="multipart/form-data">
			<div class="toolbar">
				<h2><?=$page_heading?? ''?></h2>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<input placeholder="Placeholder" name="title" id="title" type="text" class="validate" value="<?= ( isset($form_data) && isset($form_data['title'])?$form_data['title'] : '') ?>" />
	        <label for="title">Title</label>
				</div>
				<div class="input-field col s12">
			    <select name="category" id="category" >
			      <option value="" disabled selected> -- Select -- </option>
			      <?php
			      if($this->category_result && is_array($this->category_result) && count($this->category_result) > 0){
			      	foreach ($this->category_result as $key => $category) {
				      	?>
				      	<option value="<?=$category['id']?>" <?=( isset($form_data) && isset($form_data['category']) && $form_data['category'] == $category['id'])? 'selected' : ''?> > <?=ucfirst($category['category'])?></option>
				      	<?php
			      	}
			      }
			      ?>
			      
			    </select>
			    <label>Materialize Select</label>
			  </div>
			  <div class="input-field col s12">
          <textarea id="content" rows="5" name="content" class="materialize-textarea"><?= ( isset($form_data) && isset($form_data['content'])?$form_data['content'] : '') ?></textarea>
          <label for="content">Content</label>
        </div>
				<div class="col s12">
					<div class="file-field input-field">
			      <div class="btn">
			        <span>Image</span>
			        <input type="file" onchange="previewImage(this);" name="image" id="image" />
			      </div>
			      <div class="file-path-wrapper">
			        <input class="file-path validate" type="text" />
			      </div>
			      <div class="preview-image">
			      	<?php
			      	if(isset($form_data) && isset($form_data['files']) && count($form_data['files']) > 0){
			      		$file = $form_data['files']['details'][0];
			      		?>
			      		<div class="close-wrapper preview-files" style="display: inline-block;">
			      			<a href="javascript:void(0);" class="close">+</a>
			      			<a href="<?=$this->base_url.$form_data['files']['file_path'].$file['name']?>" target="_blank" class="download">Download</a>
			      			<?php 
			      			if(is_numeric(strpos($file['type'], 'image')) && strpos($file['type'], 'image') >= 0){
			      				echo sprintf('<img src="%s" alt="" width="200px"/>', $this->base_url.$form_data['files']['file_path'].$file['name']);
			      			}
			      			else{
			      				echo $file['name'];
			      			}
			      			?>
			      			<input type="hidden" name="pre_file" value="<?=$file['name']?>" />
			      		</div>
			      		<?php
			      	}
			      	?>
			      </div>
			    </div>
				</div>
				<div class="input-field col s12">
					<!-- Switch -->
				  <div class="switch">
				    <label>
				      Inactive
				      <input type="checkbox" name="status" value="1" <?=(isset($form_data) && ((isset($form_data['status']) && $form_data['status'] == 1) || !isset($form_data['status'])) )? 'checked' : ''?> id="status" />
				      <span class="lever"></span>
				      Active
				    </label>
				  </div>	
				</div>
				<div class="col s12">
					<a href="<?=$this->page_url?>" class="waves-effect waves-light btn"><i class="material-icons right">fast_rewind</i>Go Back</a>
					<button type="submit" value="save" name="doSave" class="waves-effect waves-light btn"><i class="material-icons right">save</i>Save</button>

				</div>
			</div>
		</form>
	</div>
</div>
<script>
function previewImage(input, element = '.preview-image', width = '200px') {
  if (input.files && input.files[0]) {
  	var file = input.files[0];
  	if (file.type.match('image.*')) {
	    var reader = new FileReader();
	    reader.onload = function (e) {
	    	$(element).html('<img src="'+e.target.result+'" width="'+width+'" alt="" />');
	    }
      reader.readAsDataURL(input.files[0]);
    }
  }
}
</script>