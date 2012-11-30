<?php
if (isset($instance[$field->id])) {
  $value = $instance[$field->id];
} else {
  $value = '';
}
?>
<label for="<?php echo $widget->get_field_id($field->id) ?>"><?php echo $field->name ?>:</label>
<div class="input">
  <input class="text-file text widefat" type="text" name="<?php echo $widget->get_field_name($field->id) ?>" id="<?php echo $widget->get_field_id($field->id) ?>" value="<?php echo esc_attr($value) ?>" />
  <input data-input-id="<?php echo $widget->get_field_id($field->id) ?>" data-use-as-label="<?php echo $field->name ?>" class="button upload" type="button" value="Upload <?php echo $field->name ?>" />
  <?php if (!empty($field->description)) { ?>
    <p class='foreman-field-description'><?php echo $field->description ?></p>
  <?php } ?>
</div>