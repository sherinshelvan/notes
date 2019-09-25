<div class="content">
	<form action="" method="post" enctype="multipart/form-data">
		<div class="toolbar">
			<h2><?=$page_heading?? ''?></h2>
		</div>
		<div class="container">
		 	<div class="row">
		    <div class="col s12">
		      <ul class="tabs">
		      	<?php
		      	echo '<li class="tab col s3"><a href="#all-result">All</a></li>';
		      	$category_group = array();
		      	if($this->category_result && count($this->category_result) > 0){
		      		
		      		foreach($this->category_result as $category){
		      			$category_group[$category['id']] = array();
		      			echo sprintf('<li class="tab col s3"><a href="#%s">%s</a></li>', $category['id'], ucfirst($category['category']));
		      		}
		      	}
		      	?>
		      </ul>
		    </div>
		    <?php
		    if($this->category_result && count($this->category_result) > 0 &&
		    	$this->tutorial_result && count($this->tutorial_result) > 0
		  	){
		  		
		  		echo '<div id="all-result" class="tab col s12">
		  					<div class="row">';
		  		foreach ($this->tutorial_result as $key => $tutorial) {
		  			if(array_key_exists($tutorial['category'], $category_group)){
		  				$category_group[$tutorial['category']][] = $tutorial;
		  			}
		  			$content = (strlen($tutorial['content']) > 200) ? substr($tutorial['content'],0,200).'...' :$tutorial['content'];
		  			?>
						<div class="col s4">
							<div class="card">
				        <div class="card-content">
				        	<span class="card-title"><?=ucfirst($tutorial['title'])?></span>
				          <p><?=$content?></p>
				        </div>
				        <div class="card-action">
				          <a href="<?=$this->base_url."tutorial/details.php?id=".$tutorial['id']."&from=home"?>">Read More...</a>
				        </div>
				      </div>
						</div>
		  			<?php
		  		}
		  		echo '</div></div>';	  		
		  		foreach ($category_group as $key => $category) {
		  			echo sprintf('<div id="%s" class="tab col s12">
		  					<div class="row">', $key);
		  			if(count($category) > 0){
		  				foreach ($category as $cat_key => $value) {
		  					$content = (strlen($value['content']) > 200) ? substr($tutorial['content'],0,200).'...' :$value['content'];
			  				?>
								<div class="col s4">
									<div class="card">
						        <div class="card-content">
						        	<span class="card-title"><?=ucfirst($value['title'])?></span>
						          <p><?=$content?></p>
						        </div>
						        <div class="card-action">
						          <a href="<?=$this->base_url."tutorial/details.php?id=".$value['id']."&from=home"?>">Read More...</a>
						        </div>
						      </div>
								</div>
				  			<?php
			  			}
		  			}
		  			else{
		  				echo "No result found.";
		  			}
		  			
		  			echo '</div></div>';
		  		}
		    	?>
		    	
		    	<?php
      		

      	}
      	else{
      		echo '<div id="all-result" class="tab col s12">Category or Tutorials not found.</div>';
      	}
      	?>
		  </div>
		</div>
	</form>
</div>

