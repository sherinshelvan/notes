<div class="container">
	<div class="content">
		<form action="" method="post" enctype="multipart/form-data">
			<div class="toolbar">
				<h2><?=$page_heading?? ''?></h2>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<input placeholder="Placeholder" name="category" id="category" type="text" class="validate" value="<?= ( isset($form_data) && isset($form_data['category'])?$form_data['category'] : '') ?>" />
	        <label for="category">Category</label>
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