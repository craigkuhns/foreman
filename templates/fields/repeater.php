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
            <?php
              $attributes = array();
              $attributes['id'] = foreman_field_wrapper_id($child_field->id, $field, $position);
              $attributes['class'] = 'cf';
              if (is_array($child_field->visible_on)) {
                $attributes['class'] = $attributes['class'].' foreman-visible-on';
                $attributes['data-visible-on-id'] = '#'.foreman_field_id($child_field->visible_on['id'], $field, $position);
                $attributes['data-visible-on-value'] = join($child_field->visible_on['value'], ',');
                $attributes['style'] = 'display: none;';
              }
            ?>
            <li <?php echo foreman_html_attrs_from_array($attributes) ?>>
              <?php echo $child_field->render($item[$child_field->id], $editable, true, $position) ?>
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
        <?php
          $attributes = array();
          $attributes['id'] = foreman_field_wrapper_id($child_field->id, $field);
          $attributes['class'] = 'cf';
          if (is_array($child_field->visible_on)) {
            $attributes['class'] = $attributes['class'].' foreman-visible-on';
            $attributes['data-visible-on-id'] = '#'.foreman_field_id($child_field->visible_on['id'], $field);
            $attributes['data-visible-on-value'] = join($child_field->visible_on['value'], ',');
            $attributes['style'] = 'display: none;';
          }
        ?>
        <li <?php echo foreman_html_attrs_from_array($attributes) ?>>
          <?php echo $child_field->render('', $editable, $field) ?>
        </li>
      <?php } ?>
    </ul>
  </li>
</ul>
<?php if ($editable == true) { ?>
  <a class="foreman-add-repeater-block button" data-selector=".repeater-<?php echo $field->id ?>" href="#">Add new <?php echo $field->singular ?></a>
<?php } ?>
