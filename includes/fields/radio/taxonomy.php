<th scope="row" valign="top">
  <label for="<?php echo foreman_field_id($field) ?>"><?php echo $field['name'] ?></label>
</th>
<td>
  <?php foreach ($field['options'] as $index => $option) { ?>
    <div class="foreman-checkbox-input <?php if ($field['inline'] == true) echo 'inline' ?>">
      <label>
        <input type="radio" name="<?php echo foreman_field_name($field) ?>" id="<?php echo foreman_field_id($field).'-'.$index ?>" value="<?php echo $option['value'] ?>" <?php if ($option['value'] == $meta) echo 'checked="checked"' ?> />
        <?php echo $option['name'] ?>
      </label>
    </div>
  <?php } ?>
  <?php if (!empty($field['description'])) { ?>
    <p class='foreman-field-description'><?php echo $field['description'] ?></p>
  <?php } ?>
</td>