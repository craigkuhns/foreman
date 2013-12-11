<label for="<?php echo $obj->get_field_id($field['id']) ?>"><?php echo $field['name'] ?>:</label><br />
<?php foreach ($field['options'] as $index => $option) { ?>
  <label>
    <input type="checkbox" name="<?php echo $obj->get_field_name($field['id']) ?>[]" id="<?php echo $obj->get_field_id($field['id']).'-'.$index ?>" value="<?php echo $option['value'] ?>" <?php if (in_array($option['value'], $meta)) echo 'checked="checked"' ?> />
    <?php echo $option['name'] ?>
  </label>
  <br />
<?php } ?>
<?php if (!empty($field['description'])) { ?>
  <span class='foreman-field-description'><?php echo $field['description'] ?></span>
<?php } ?>