<?php if (empty($value)) $value = '' ?>
<div class="label">
  <label for="<?php echo foreman_field_id($field, $parent, $position) ?>"><?php echo $field->name ?></label>
</div>
<div class="input">
  <?php if ($editable == true) { ?>
    <input type="hidden" name="<?php echo foreman_field_name($field, $parent, $position) ?>" value="0" />
    <div class="foreman-checkbox-input">
      <label><input type="checkbox" name="<?php echo foreman_field_name($field, $parent, $position) ?>" value="1" <?php if ($value == 1) echo 'checked="checked"' ?> /></label>
    </div>
  <?php } else { ?>
  <p class="foreman-uneditable-form-value">
    <?php
      if ($value == 1) {
        echo "Yes";
      } else {
        echo "No";
      }
    ?>
  </p>
  <?php } ?>
  <?php if (!empty($field->description)) { ?>
    <p class='foreman-field-description'><?php echo $field->description ?></p>
  <?php } ?>
</div>
