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
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(isset($result) && is_array($result) && count($result) > 0){
					foreach ($result as $key => $value) {
						$id = $value['id'];
						?>
						<tr>
							<td>#<?=$value['id']?></td>
							<td><?=ucfirst($value['category'])?></td>
							<td><?=($value['status']? "Active" : "Inactive")?></td>
							<td>
								<a href="<?=$this->page_url?>?action=edit&id=<?=$id?>"><i class="material-icons">mode_edit</i></a>
								<a href="<?=$this->page_url?>?action=delete&id=<?=$id?>"><i class="material-icons">delete</i></a>
							</td>
						</tr>
					<?php
					}
				}
				else{
					?>
					<tr>
						<td colspan="4">No result found</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</form>
</div>

