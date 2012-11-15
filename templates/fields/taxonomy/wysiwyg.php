<?php if (empty($value)) $value = $value; ?>
<th valign="top" scope="row">
  <label for="<?php echo foreman_field_id($field, $parent, $position) ?>"><?php echo $field->name ?></label>
</th>
<td>
  <div class="input">
    <?php wp_editor($value, foreman_field_name($field, $parent, $position), $field->options); ?>
    <?php if (!empty($field->description)) { ?>
      <p class='foreman-field-description'><?php echo $field->description ?></p>
    <?php } ?>
  </div>
</td>