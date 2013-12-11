<label for="<?php echo $obj->get_field_id($field['id']) ?>"><?php echo $field['name'] ?>:</label>
<input class="text-date widefat" type="text" name="<?php echo $obj->get_field_name($field['id']) ?>" id="<?php echo $obj->get_field_id($field['id']) ?>" value="<?php echo esc_attr($meta) ?>" />
<?php if (!empty($field['description'])) { ?>
  <span class='foreman-field-description'><?php echo $field['description'] ?></span>
<?php } ?>