<?php if (empty($value)) $value = $value; ?>
<div class="label">
  <label for="<?php echo foreman_field_id($field, $parent, $position) ?>"><?php echo $field->name ?></label>
</div>
<div class="input">
  <?php if ($editable == true) { ?>
    <?php wp_editor($value, foreman_field_name($field, $parent, $position), $field->options); ?>
  <?php } else { ?>
    <p class="foreman-uneditable-form-value"><?php echo $value ?></p>
  <?php } ?>
  <?php if (!empty($field->description)) { ?>
    <p class='foreman-field-description'><?php echo $field->description ?></p>
  <?php } ?>
</div>


