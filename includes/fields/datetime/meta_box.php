<div class="label">
  <label for="<?php echo foreman_field_id($field) ?>"><?php echo $field['name'] ?></label>
</div>
<div class="input">
  <?php if ($editable == true) { ?>
    <input class="text-datetime" type="text" name="<?php echo foreman_field_name($field) ?>" id="<?php echo foreman_field_id($field) ?>" value="<?php echo $meta ?>" />
  <?php } else { ?>
    <p class="foreman-uneditable-form-value"><?php echo $meta ?></p>
  <?php } ?>
  <?php if (!empty($field['description'])) { ?>
    <p class='foreman-field-description'><?php echo $field['description'] ?></p>
  <?php } ?>
</div>