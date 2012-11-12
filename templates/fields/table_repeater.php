<?php if (empty($value)) $value = '' ?>
<div class="label">
  <label for="<?php echo $field->id ?>"><?php echo $field->name ?></label>
  <?php if (!empty($field->description)) { ?>
    <p class='foreman-field-description'><?php echo $field->description ?></p>
  <?php } ?>
</div>

<table class="wp-list-table widefat foreman-table-repeater repeater-<?php echo $field->id ?> <?php if ($field->sortable == true && $editable == true) echo "sortable" ?>">
  <thead>
    <tr>
      <?php if ($field->sortable == true && $editable == true) { ?>
        <th></th>
      <?php } ?>
      <?php foreach ($this->fields as $child_field) { ?>
        <th><?php echo $child_field->name ?></th>
      <?php } ?>
      <?php if ($editable == true) { ?>
        <th>Actions</th>
      <?php } ?>
    </tr>
  </thead>
  <tbody>
    <?php if (is_array($value) && !empty($value)) { ?>
      <?php foreach ($value as $position => $item) { ?>
        <tr class="foreman-table-repeater-row">
          <?php if ($field->sortable == true && $editable == true) { ?>
            <th class="handle"><i class="icon-resize-vertical"></i></th>
          <?php } ?>
          <?php foreach ($field->fields as $child_field) { ?>
            <td><?php echo $child_field->render($item[$child_field->id], $editable, $field, $position) ?></td>
          <?php } ?>
          <?php if ($editable == true) { ?>
            <td class="trash"><a href="#" class="foreman-remove-table-repeater-row destructive"><i class="icon-trash"></i></a></td>
          <?php } ?>
        </tr>
      <?php } ?>
    <?php } ?>
    <tr class="foreman-table-repeater-row repeater-template" style="display: none;">
      <?php if ($field->sortable == true && $editable == true) { ?>
        <th class="handle"><i class="icon-resize-vertical"></i></th>
      <?php } ?>
      <?php foreach ($field->fields as $child_field) { ?>
        <td><?php echo $child_field->render('', $editable, $field) ?></td>
      <?php } ?>
      <?php if ($editable == true) { ?>
        <td class="trash"><a href="#" class="foreman-remove-table-repeater-row destructive"><i class="icon-trash"></i></a></td>
      <?php } ?>
    </tr>
  </tbody>
</table>
<?php if ($editable == true) { ?>
  <p><a class="foreman-add-table-repeater-row button" data-selector=".repeater-<?php echo $field->id ?>" href="#">Add new <?php echo $field->singular ?></a></p>
<?php } ?>

