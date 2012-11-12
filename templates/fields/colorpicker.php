<?php if (empty($value)) $value = '' ?>
<div class="label">
  <label for="<?php echo foreman_field_id($field, $parent, $position) ?>"><?php echo $field->name ?></label>
</div>
<div class="input">
  <?php if ($editable == true) { ?>
    <input class="text-colorpicker" type="text" name="<?php echo foreman_field_name($field, $parent, $position) ?>" id="<?php echo foreman_field_id($field, $parent, $position) ?>" value="#<?php echo $value ?>" />
    <?php if (!empty($field->description)) { ?>
      <p class='foreman-field-description'><?php echo $field->description ?></p>
    <?php } ?>
  <?php } else { ?>
  <p class="foreman-uneditable-form-value">#<?php echo $value ?> <span style="background-color: #<?php echo $value ?>; color: #<?php echo $value ?>;">#<?php echo $value ?></span></p>
  <?php } ?>
</div>


