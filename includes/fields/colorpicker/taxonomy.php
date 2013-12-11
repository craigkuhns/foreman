<th scope="row" valign="top">
  <label for="<?php echo foreman_field_id($field) ?>"><?php echo $field['name'] ?></label>
</th>
<td>
  <input class="text-colorpicker" type="text" name="<?php echo foreman_field_name($field) ?>" id="<?php echo foreman_field_id($field) ?>" value="#<?php echo $meta ?>" />
  <?php if (!empty($field['description'])) { ?>
    <p class='foreman-field-description'><?php echo $field['description'] ?></p>
  <?php } ?>
</td>