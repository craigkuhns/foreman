<th scope="row" valign="top">
  <label for="<?php echo foreman_field_id($field) ?>"><?php echo $field['name'] ?></label>
</th>
<td>
  <input class="text-file" type="text" name="<?php echo foreman_field_name($field) ?>" id="<?php echo foreman_field_id($field) ?>" value="<?php echo $meta ?>" />
  <input data-input-id="<?php echo $field['id'] ?>" data-use-as-label="<?php echo $field['name'] ?>" class="button upload" type="button" value="Upload <?php echo $field['name'] ?>" />
  <?php if (!empty($field['description'])) { ?>
    <p class='foreman-field-description'><?php echo $field['description'] ?></p>
  <?php } ?>
</td>