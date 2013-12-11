<label for="<?php echo $obj->get_field_id($field['id']) ?>"><?php echo $field['name'] ?>:</label>
<input type="hidden" name="<?php echo $obj->get_field_name($field['id']) ?>" value="0" />
<input class="checkbox" type="checkbox" id="<?php echo $obj->get_field_id($field['id']) ?>" name="<?php echo $obj->get_field_name($field['id']) ?>" value="1" <?php if ($meta == 1) echo 'checked="checked"' ?> />
<?php if (!empty($field['description'])) { ?>
  <span class='foreman-field-description'><?php echo $field['description'] ?></span>
<?php } ?>