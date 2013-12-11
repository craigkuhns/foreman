<th scope="row" valign="top">
  <label for="<?php echo foreman_field_id($field) ?>"><?php echo $field['name'] ?></label>
  <?php if (!empty($field['description'])) { ?>
    <p class='foreman-field-description'><?php echo $field['description'] ?></p>
  <?php } ?>
</th>
<td>
  <ul class="foreman-repeater repeater-<?php echo $field['id'] ?> <?php if ($field['sortable'] == true) echo "sortable" ?>">
    <?php if (is_array($meta) && !empty($meta)) { ?>
      <?php foreach ($meta as $position => $item) { ?>
        <li class="foreman-repeater-block">
          <?php if ($field['sortable'] == true) { ?>
            <div class="handle">
              <div class="up"><i class="icon-arrow-up"></i></div>
              <div class="down"><i class="icon-arrow-down"></i></div>
            </div>
          <?php } ?>
          <a href="#" class="foreman-remove-repeater-block font-awesome-icon destructive"><i class="icon-remove-sign"></i></a>
          <ul class="foreman-repeater-block-fields">
            <?php foreach ($field['fields'] as $child_field) { ?>
              <?php $child_field['parent'] = $field; ?>
              <?php $child_field['position'] = $position; ?>
              <li <?php echo foreman_field_wrapper_attributes($child_field) ?>>
                <?php $value_for_field = (isset($item[$child_field['id']])) ? $item[$child_field['id']] : null ?>
                <?php do_action('foreman_render_'.$child_field['type'], 'repeater', $value_for_field, $child_field); ?>
              </li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>
    <?php } ?>
    <li class="foreman-repeater-block repeater-template" style="display: none;">
      <?php if ($field['sortable'] == true) { ?>
        <div class="handle">
          <div class="up"><i class="icon-arrow-up"></i></div>
          <div class="down"><i class="icon-arrow-down"></i></div>
        </div>
      <?php } ?>
      <a href="#" class="foreman-remove-repeater-block font-awesome-icon destructive"><i class="icon-remove-sign"></i></a>
      <ul class="foreman-repeater-block-fields">
        <?php foreach ($field['fields'] as $child_field) { ?>
          <?php $child_field['parent'] = $field; ?>
          <li <?php echo foreman_field_wrapper_attributes($child_field) ?>>
            <?php do_action('foreman_render_'.$child_field['type'], 'repeater', null, $child_field); ?>
          </li>
        <?php } ?>
      </ul>
    </li>
  </ul>
  <a class="foreman-add-repeater-block button" data-selector=".repeater-<?php echo $field['id'] ?>" href="#">Add new <?php echo $field['name'] ?></a>
</td>