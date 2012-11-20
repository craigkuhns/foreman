<?php
if(empty($value)) $value = array();
$criteria = array(
  'post_type' => $field->options['post_type'],
  'numberposts' => -1,
);
if (isset($_GET['post'])) {
  $criteria['exclude'] = array($_GET['post']);
}
$possibilities = get_posts($criteria);
?>

<div class="label">
  <label for="<?php echo foreman_field_id($field, $parent, $position) ?>"><?php echo $field->name ?></label>
</div>
<div class="input">
  <?php if ($editable == true) { ?>
    <div class="foreman-related-posts-select">
      <select class="available" multiple="multiple">
        <?php foreach ($possibilities as $possible) { ?>
          <?php if (!in_array($possible->ID, $value)) { ?>
            <option value="<?php echo $possible->ID ?>"><?php echo $possible->post_title ?></option>
          <?php } ?>
        <?php } ?>
      </select>
      <div class="controls">
        <button class='button make-selection'><i class="icon-arrow-right"></i></button>
        <button class='button remove-selection'><i class="icon-arrow-left"></i></button>
      </div>
      <select multiple="multiple" class="selected" name="<?php echo foreman_field_name($field, $parent, $position) ?>[]" id="<?php echo foreman_field_id($field, $parent, $position) ?>">
        <?php foreach ($possibilities as $possible) { ?>
          <?php if (in_array($possible->ID, $value)) { ?>
            <option selected="selected" value="<?php echo $possible->ID ?>"><?php echo $possible->post_title ?></option>
          <?php } ?>
        <?php } ?>
      </select>
    </div>
  <?php } else { ?>
    <p class="foreman-uneditable-form-value">
      It's not editable
    </p>
  <?php } ?>
  <?php if (!empty($field->description)) { ?>
    <p class='foreman-field-description'><?php echo $field->description ?></p>
  <?php } ?>
</div>
