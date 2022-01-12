<?php if (is_user_logged_in()) {?>
<table class="table  table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">Image</th>
    </tr>
  </thead>
  <?php
  $files = get_post_meta(319, 'files');
  //print_r($files[0]);
  $current_user = wp_get_current_user();
  $upload_dir = wp_upload_dir();
  //print_r($upload_dir['baseurl'] . '/' . $current_user->user_login . '/');
  foreach ($files as $file) {
    foreach ($file as $key) {
      print_r($key);
      ?>
      <tr>
        <td> <img src="<?php echo $upload_dir['baseurl'] . '/' . $current_user->user_login . '/' . $key; ?>" class="img-fluid img-thumbnail" width="100"></td>
      </tr>
      <a href="<?php echo $upload_dir['baseurl'] . '/' . $current_user->user_login . '/' . $key; ?>">Download</a>
      <?php
    }
  }
  ?>
</tbody>
</table>
<?php
}