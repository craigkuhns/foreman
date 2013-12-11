<div class="label">
  <label for="<?php echo foreman_field_id($field) ?>"><?php echo $field['name'] ?></label>
</div>
<div class="input">
  <?php if ($editable == true) { ?>
    <input class="text" type="hidden" name="<?php echo foreman_field_name($field) ?>" value="0" />
    <div class="foreman-checkbox-input">
      <label><input type="checkbox" name="<?php echo foreman_field_name($field) ?>" value="1" <?php if ($meta == 1) echo 'checked="checked"' ?> /></label>
    </div>
  <?php } else { ?>
    <p class="foreman-uneditable-form-value">
    <?php
      $val = ($meta == 1) ? "Yes" : "No";
      echo $val;
    ?>
  </p>
  <?php } ?>
  <?php if (!empty($field['description'])) { ?>
    <p class='foreman-field-description'><?php echo $field['description'] ?></p>
  <?php } ?>
</div>