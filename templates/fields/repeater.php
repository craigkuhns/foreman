<?php if (empty($value)) $value = '' ?>
<div class="label">
  <label for="<?php echo $field->id ?>"><?php echo $field->name ?></label>
  <?php if (!empty($field->description)) { ?>
    <p class='foreman-field-description'><?php echo $field->description ?></p>
  <?php } ?>
</div>
<ul class="foreman-repeater repeater-<?php echo $field->id ?> <?php if ($field->sortable == true && $editable == true) echo "sortable" ?>">
  <?php if (is_array($value) && !empty($value)) { ?>
    <?php foreach ($value as $position => $item) { ?>
      <li class="foreman-repeater-block">
        <?php if ($field->sortable && $editable == true) { ?>
          <div class="handle">
            <div class="up"><i class="icon-arrow-up"></i></div>
            <div class="down"><i class="icon-arrow-down"></i></div>
          </div>
        <?php } ?>
        <?php if ($editable == true) { ?>
          <a href="#" class="foreman-remove-repeater-block font-awesome-icon destructive"><i class="icon-remove-sign"></i></a>
        <?php } ?>
        <ul class="foreman-repeater-block-fields">
          <?php foreach ($field->fields as $child_field) { ?>
            <li <?php echo foreman_field_wrapper_attributes($child_field, $field, $position) ?>>
              <?php echo $child_field->render($item[$child_field->id], $editable, $field, $position) ?>
            </li>
          <?php } ?>
        </ul>
      </li>
    <?php } ?>
  <?php } ?>
  <li class="foreman-repeater-block repeater-template <?php if ($field->sortable == true && $editable == true) echo "sortable" ?>" style="display: none;">
    <?php if ($field->sortable && $editable == true) { ?>
      <div class="handle">
        <div class="up"><i class="icon-arrow-up"></i></div>
        <div class="down"><i class="icon-arrow-down"></i></div>
      </div>
    <?php } ?>
    <?php if ($editable == true) { ?>
      <a href="#" class="foreman-remove-repeater-block font-awesome-icon destructive"><i class="icon-remove-sign"></i></a>
    <?php } ?>
    <ul class="foreman-repeater-block-fields">
      <?php foreach ($field->fields as $child_field) { ?>
        <li <?php echo foreman_field_wrapper_attributes($child_field, $field) ?>>
          <?php echo $child_field->render('', $editable, $field) ?>
        </li>
      <?php } ?>
    </ul>
  </li>
</ul>
<?php if ($editable == true) { ?>
  <a class="foreman-add-repeater-block button" data-selector=".repeater-<?php echo $field->id ?>" href="#">Add new <?php echo $field->singular ?></a>
<?php } ?>
