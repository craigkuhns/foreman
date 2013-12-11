<div class="label">
  <label for="<?php echo foreman_field_id($field) ?>"><?php echo $field['name'] ?></label>
</div>
<div class="input">
  <?php if ($editable == true) { ?>
    <?php wp_editor($meta, foreman_field_name($field), $field['options']); ?>
  <?php } else { ?>
    <p class="foreman-uneditable-form-value"><?php echo $meta ?></p>
  <?php } ?>
  <?php if (!empty($field['description'])) { ?>
    <p class='foreman-field-description'><?php echo $field['description'] ?></p>
  <?php } ?>
</div>