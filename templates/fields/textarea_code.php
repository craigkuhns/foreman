<?php if (empty($value)) $value = '' ?>
<div class="label">
  <label for="<?php echo foreman_field_id($field, $parent, $position) ?>"><?php echo $field->name ?></label>
</div>
<div class="input">
  <?php if ($editable == true) { ?>
    <textarea class="textarea-code" type="text" name="<?php echo foreman_field_name($field, $parent, $position) ?>" id="<?php echo foreman_field_id($field, $parent, $position) ?>"><?php echo $value ?></textarea>
  <?php } else { ?>
    <p class="foreman-uneditable-form-value"><?php echo $value ?></p>
  <?php } ?>
  <?php if (!empty($field->description)) { ?>
    <p class='foreman-field-description'><?php echo $field->description ?></p>
  <?php } ?>
</div>

