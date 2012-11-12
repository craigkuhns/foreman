
<?php
if (isset($instance[$field->id])) {
  $value = $instance[$field->id];
} else {
  $value = '';
}
?>
<label for="<?php echo $widget->get_field_id($field->id) ?>"><?php echo $field->name ?>:</label>
<input class="text widefat" type="text" name="<?php echo $widget->get_field_name($field->id) ?>" id="<?php echo $widget->get_field_id($field->id) ?>" value="<?php echo esc_attr($value) ?>" />
<?php if (!empty($field->description)) { ?>
  <span class='foreman-field-description'><?php echo $field->description ?></span>
<?php } ?>