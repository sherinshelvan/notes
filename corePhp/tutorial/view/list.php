<div class="content">
	<form action="" method="post" enctype="multipart/form-data">
		<div class="toolbar">
			<h2><?=$page_heading?? ''?></h2>
			<a href="<?=$this->page_url?>?action=add">Add New</a>
		</div>
		<table>
			<thead>
				<tr>
					<th>Id</th>
					<th>Title</th>
					<th>Category</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(isset($result) && is_array($result) && count($result) > 0){
					foreach ($result as $key => $value) {
						$id       = $value['id'];
						$category = array_search($value['category'], array_column($this->category_result, 'id'));
						if(is_numeric($category)){
							$category = $this->category_result[$category]['category'];
						}
						else{
							$category = 'Category not found';
						}
						?>
						<tr>
							<td>#<?=$value['id']?></td>
							<td><?=ucfirst($value['title'])?></td>
							<td><?=ucfirst($category)?></td>
							<td><?=($value['status']? "Active" : "Inactive")?></td>
							<td>
								<a href="<?=$this->detail_page?>?id=<?=$id?>" title="Details"><i class="material-icons">search</i></a>
								<a href="<?=$this->page_url?>?action=edit&id=<?=$id?>" title="Edit"><i class="material-icons">mode_edit</i></a>
								<a href="<?=$this->page_url?>?action=delete&id=<?=$id?>" title="Delete"><i class="material-icons">delete</i></a>
							</td>
						</tr>
					<?php
					}
				}
				else{
					?>
					<tr>
						<td colspan="5">No result found</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</form>
</div>

