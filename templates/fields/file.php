<?php if (empty($value)) $value = '' ?>
<div class="label">
  <label for="<?php echo foreman_field_id($field, $parent, $position) ?>"><?php echo $field->name ?></label>
</div>
<div class="input">
  <?php if ($editable == true) { ?>
    <input class="text-file" type="text" name="<?php echo foreman_field_name($field, $parent, $position) ?>" id="<?php echo foreman_field_id($field, $parent, $position) ?>" value="<?php echo $value ?>" />
    <input data-input-id="<?php echo foreman_field_id($field, $parent, $position) ?>" data-use-as-label="<?php echo $field->name ?>" class="button upload" type="button" value="Upload <?php echo $field->name ?>" />
    <?php if (!empty($field->description)) { ?>
      <p class='foreman-field-description'><?php echo $field->description ?></p>
    <?php } ?>
  <?php } else { ?>
    <p class="foreman-uneditable-form-value"><a href="<?php echo $value ?>" target="_blank">Open file</a></p>
  <?php } ?>
</div>