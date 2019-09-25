<div class="content">
	<form action="" method="post" enctype="multipart/form-data">
		<div class="toolbar">
			<h2><?=$page_heading?? ''?></h2>
		</div>
		<div class="row">
      <div class="input-field col s12">
        <input placeholder="Username" id="username" name="username" type="text" class="validate" value="<?= ( isset($this->post_data) && isset($this->post_data['username'])?$this->post_data['username'] : '') ?>" />
        <label for="username">Username</label>
      </div>
      <div class="input-field col s12">
        <input placeholder="Password" id="password" name="password"  type="password" class="validate" value="<?= ( isset($this->post_data) && isset($this->post_data['password'])?$this->post_data['password'] : '') ?>" />
        <label for="password">Password</label>
      </div>
      <div class="col s12">
					<button type="submit" value="login" name="doLogin" class="waves-effect waves-light btn">Sign In</button>

				</div>
    </div>
	</form>
</div>

