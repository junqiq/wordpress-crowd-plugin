<html>
<head></head>
<body>
<div class="wrap">
<h1><?= __('Crowd Login', 'crowd-login') ?> v0.2</h1>
<form method="POST" action="<?= str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>&amp;updated=true">
<h2 class="title"><?= __('Crowd Settings', 'crowd-login'); ?></h2>
<table class="form-table">
<tbody>
  <tr>
    <th scope="row"><label for="blogname"><?= __('Application Name', 'crowd-login'); ?></label></th>
    <td>
      <input name="crowd_app_name" id="crowd_app_name" value="<?= $cw_app_name; ?>" class="regular-text" type="text" placeholder="crowd-appname">
      <p class="description"><?= __('*The application name given to you by your Crowd administrator.', 'crowd-login'); ?></p>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="blogname"><?= __('Application Password', 'crowd-login'); ?></label></th>
    <td>
      <input name="crowd_app_password" id="crowd_app_password" value="<?= $cw_app_password; ?>" class="regular-text" type="password" placeholder="crowd-password">
      <p class="description"><?= __('*The application password given to you by your Crowd administrator.', 'crowd-login'); ?></p>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="blogname"><?= __('Crowd URL', 'crowd-login'); ?></label></th>
    <td>
      <input name="crowd_url" id="crowd_url" value="<?= $cw_url; ?>" class="regular-text" type="text" placeholder="https://crowd.example.com:8443/crowd">
      <p class="description"><?= __('*Example: https://crowd.example.com:8443/crowd', 'crowd-login'); ?></p>
    </td>
  </tr>
</tbody>
</table>
<h2 class="title"><?= __('Advanced mode', 'crowd-login'); ?></h2>
<table class="form-table">
<tbody>
  <tr>
    <th scope="row"><label for="blogname"><?= __('Login mode', 'crowd-login'); ?></label></th>
    <td>
      <fieldset>
        <legend class="screen-reader-text"><span><?= __('Login mode', 'crowd-login'); ?></span></legend>
        <p>
          <label><input type="radio" name="crowd_login_mode" value="mode_create" <?= $cw_logmode_create_check ?>><?= __('<strong>Auto Creation</strong> (default)', 'crowd-login'); ?></label>
          <p><?= __('Create Wordpress accounts for anyone who successfully authenticates against Crowd. (default)', 'crowd-login'); ?></p>
          <label><input type="radio" name="crowd_login_mode" value="mode_manual" <?= $cw_logmode_manual_check ?>><?= __('<strong>Manual</strong>', 'crowd-login'); ?></label>
          <p><?= __('Authenticate Wordpress users against Crowd. I will create the accounts in Wordpress myself.', 'crowd-login'); ?></p>
        </p>
      </fieldset>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="blogname"><?= __('Security mode', 'crowd-login'); ?></label></th>
    <td>
      <fieldset>
        <legend class="screen-reader-text"><span><?= __('Security mode', 'crowd-login'); ?></span></legend>
        <p>
          <label><input name="crowd_security_mode" type="radio" id="security_low" value="security_low" <?= $cw_secmode_low_check ?> ><?= __('<strong>Low</strong> (default)', 'crowd-login'); ?></label>
          <p class="description"><?= __('Default mode. First attempts to login with Crowd accounts, failing that, it attempts to login using the local Wordpress password. If you intend to use a mixture of local and Crowd accounts, leave this mode enabled.', 'crowd-login'); ?></p>
          <br>
          <label><input name="crowd_security_mode" type="radio" id="security_high" value="security_high" <?= $cw_secmode_high_check ?> ><?= __('<strong>High</strong>', 'crowd-login'); ?></label>
          <p class="description"><?= __('Restrict login to only Crowd accounts. If a Wordpress username fails to authenticate against Crowd, login will fail. More secure.', 'crowd-login'); ?></p>
        </p>
      </fieldset>
    </td>
  </tr>
</tbody>
</table>
<p class="submit">
  <input type="hidden" name="stage" value="process" />
  <input name="submit" id="submit" class="button button-primary" value="<?= __('Save changes', 'crowd-login'); ?>" type="submit">
</p>
</form>
<hr>

<!-- TEST CONSOLE -->
<h2 class="title" id="test"><?= __('Setting Test', 'crowd-login'); ?></h2>
<p><?= __('Use this form as a authentication test for those settings you saved.', 'crowd-login'); ?></p>
<div class="crowd_style_test">
<form method="POST" action="<?= str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="stage" value="test" />
<div class="tablenav bottom">
  <div class="alignleft actions bulkactions">
    <label for="bulk-action-selector-bottom" class="screen-reader-text"><?= __('Setting Test', 'crowd-login'); ?></label>
    <input name="test_username" type="text" size="35" placeholder="username" value="<?= $_POST['test_username'] ?>">
    <input name="test_password" type="password" size="35" placeholder="password" value="<?= $_POST['test_password'] ?>">
    <input id="submit" class="button action" value="<?= __('Test connection', 'crowd-login'); ?>" type="submit">
  </div>
</div>
</form>
<p><strong><?= __('Test Results:', 'crowd-login'); ?></strong> <?= $test_comment ?></p>
<!-- TEST CONSOLE -->

</div><!-- /wrap -->
</body>
</html>