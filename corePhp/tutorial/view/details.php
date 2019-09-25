<div class="content">
	<form action="" method="post" enctype="multipart/form-data">
		<div class="toolbar">
			<h2><?=$page_heading?? ''?></h2>
		</div>
		<div class="row">
			<div class="col s12 detail-content">
				<h4><?=ucfirst($this->tutorial_result['title'])?></h4>				
				<div class="category">
					<?php 
					if(count($this->category_result) > 0 ){
						echo '<h6>Category : '.ucfirst($this->category_result['category']).'</h6>';
					}
					?>
				</div>
				<div class="content">
					<?=$this->tutorial_result['content']?>
				</div>
				<div class="file">
					<?php 
					if(count($this->tutorial_result['files']) > 0){
						$file_path = $this->tutorial_result['files']['file_path'];
						$file      = $this->tutorial_result['files']['details'][0];
						if(is_numeric(strpos($file['type'], 'image')) && strpos($file['type'], 'image') >= 0){
							echo sprintf('<img src="%s" alt="" width="400px"/>', $this->base_url.$file_path.$file['name']);
						}
						echo sprintf('<p><a href="%s" target="_blank" class="waves-effect waves-light btn" title="Download File" ><i class="material-icons left">file_download</i> Download File</a></p>',  $this->base_url.$file_path.$file['name']);
					}
					?>
				</div>
				<div class="status">Status : <?=$this->tutorial_result['status']? "Active" : "Inactive"?></div>
				<div class="actions">
					<a href="<?=$this->goback_url?>" class="waves-effect waves-light btn"><i class="material-icons left">fast_rewind</i> Go Back</a>
				</div>
			</div>
		</div>
	</form>
</div>

