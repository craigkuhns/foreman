<?php if (empty($value)) $value = '' ?>
<th valign="top" scope="row">
  <label for="<?php echo foreman_field_id($field, $parent, $position) ?>"><?php echo $field->name ?></label>
</th>
<td>
  <div class="input">
    <input type="hidden" name="<?php echo foreman_field_name($field, $parent, $position) ?>" value="0" />
    <div class="foreman-checkbox-input">
      <label><input type="checkbox" name="<?php echo foreman_field_name($field, $parent, $position) ?>" value="1" <?php if ($value == 1) echo 'checked="checked"' ?> /></label>
    </div>
    <?php if (!empty($field->description)) { ?>
      <p class='foreman-field-description'><?php echo $field->description ?></p>
    <?php } ?>
  </div>
</td>