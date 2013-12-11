<th scope="row" valign="top">
  <label for="<?php echo foreman_field_id($field) ?>"><?php echo $field['name'] ?></label>
</th>
<td>
  <select name="<?php echo foreman_field_name($field) ?>" id="<?php echo foreman_field_id($field) ?>">
    <?php foreach ($field['options'] as $option) { ?>
      <option value="<?php echo $option['value'] ?>" <?php if ($option['value'] == $meta) echo "selected='selected'" ?>><?php echo $option['name'] ?></option>
    <?php } ?>
  </select>
  <?php if (!empty($field['description'])) { ?>
    <p class='foreman-field-description'><?php echo $field['description'] ?></p>
  <?php } ?>
</td>