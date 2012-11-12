<?php if(empty($value)) $value = array(); ?>
<div class="label">
  <label for="<?php echo foreman_field_id($field, $parent, $position) ?>"><?php echo $field->name ?></label>
</div>
<div class="input">
  <?php if ($editable == true) { ?>
    <?php foreach ($field->options as $index => $option) { ?>
      <div class="foreman-checkbox-input <?php if ($field->inline == true) echo 'inline' ?>">
        <label>
          <input type="checkbox" name="<?php echo foreman_field_name($field, $parent, $position) ?>[]" id="<?php echo foreman_field_id($field, $parent, $position).'-'.$index ?>" value="<?php echo $option['value'] ?>" <?php if (in_array($option['value'], $value)) echo 'checked="checked"' ?> />
          <?php echo $option['name'] ?>
        </label>
      </div>
    <?php } ?>
  <?php } else { ?>
    <p class="foreman-uneditable-form-value">
      <?php
        $selected = array();
        foreach ($field->options as $option) {
          if (in_array($option['value'], $value)) $selected[] = $option['name'];
        }
        echo join(', ', $selected);
      ?>
    </p>
  <?php } ?>  
  <?php if (!empty($field->description)) { ?>
    <p class='foreman-field-description'><?php echo $field->description ?></p>
  <?php } ?>
</div>

