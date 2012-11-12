<?php if(empty($value)) $value = '' ?>
<div class="label">
  <label for="<?php echo foreman_field_id($field, $parent, $position) ?>"><?php echo $field->name ?></label>
</div>
<div class="input">
  <?php if ($editable == true) { ?>
    <?php foreach ($field->options as $key => $option) { ?>
      <div class="foreman-radio-input <?php if ($field->inline == true) echo 'inline' ?>">
        <label>
          <input id="<?php echo foreman_field_id($field, $parent, $position).'-'.$key ?>" type="radio" name="<?php echo foreman_field_name($field, $parent, $position) ?>" value="<?php echo $option['value'] ?>" <?php if ($value == $option['value']) echo 'checked="checked"' ?> />
          <?php echo $option['name'] ?>
        </label>
      </div>
    <?php } ?>
  <?php } else { ?>
  <p class="foreman-uneditable-form-value">
    <?php
      foreach ($field->options as $key => $option) {
        if ($option['value'] == $value) echo $option['name'];
      }
    ?>
  </p>
  <?php } ?>
  <?php if (!empty($field->description)) { ?>
    <p class='foreman-field-description'><?php echo $field->description ?></p>
  <?php } ?>
</div>
