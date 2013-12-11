<th scope="row" valign="top">
  <label for="<?php echo foreman_field_id($field) ?>"><?php echo $field['name'] ?></label>
</th>
<td>
  <input class="text" type="hidden" name="<?php echo foreman_field_name($field) ?>" value="0" />
  <div class="foreman-checkbox-input">
    <label><input type="checkbox" name="<?php echo foreman_field_name($field) ?>" value="1" <?php if ($meta == 1) echo 'checked="checked"' ?> /></label>
  </div>
  <?php if (!empty($field['description'])) { ?>
    <p class='foreman-field-description'><?php echo $field['description'] ?></p>
  <?php } ?>
</td>