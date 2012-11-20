jQuery(function() {
  repeater.init();
  table_repeater.init();
  datepickers.init();
  file_uploader.init();
  colorpicker.init();
  sortables.init();
  visible_on.init();
  related_posts.init();

  post_form.init();
});

var visible_on = {
  init: function() {
    jQuery('li.foreman-visible-on').each(function() {
      var el = jQuery(this);
      jQuery(jQuery(el).attr('data-visible-on-id')).change(function() {
        var visible_on_options = jQuery(el).attr('data-visible-on-value').split(',');
        if (jQuery.inArray(jQuery(this).val(), visible_on_options) != -1) {
          jQuery(el).show();
        } else {
          jQuery(el).hide();
        }
      });

      var visible_on_id = jQuery(el).attr('data-visible-on-id');
      var current = jQuery(visible_on_id).val();
      var visible_on_options = jQuery(el).attr('data-visible-on-value').split(',');
      if (jQuery.inArray(current, visible_on_options) != -1) {
        jQuery(el).show();
      } else {
        jQuery(el).hide();
      }
    });
  }
}

var datepickers = {
  globaly_initialized: false,
  init: function() {
    jQuery('.foreman-field-list .text-date').datepicker();
    jQuery('.foreman-field-list .text-datetime').datetimepicker({ampm:true});
    if (datepickers.globaly_initialized == false) jQuery("#ui-datepicker-div").wrap('<div class="foreman_element" />');
    if (datepickers.globaly_initialized == false) datepickers.globaly_initialized = true;
  }
}

var file_uploader = {
  current_field_id: '',
  init: function() {
    jQuery(".upload").live('click', function() {
      var field_id = "#"+jQuery(this).attr('data-input-id');
      var field_label = "Use as "+jQuery(this).attr('data-use-as-label');
      file_uploader.current_field_id = field_id;
      formfield = jQuery(field_id).attr('name');
      tb_show('', 'media-upload.php?type=file&foreman_force_send=true&foreman_send_label='+field_label+'&TB_iframe=true');

      var old_send_to_editor = window.send_to_editor;
      window.send_to_editor = function(html) {
        if (jQuery('img', '<div>'+html+'</div>').attr('src')) {
          var url = jQuery('img', '<div>'+html+'</div>').attr('src');
        } else {
          var url = jQuery('a', '<div>'+html+'</div>').attr('href');
        }
        jQuery(file_uploader.current_field_id).val(url);
        tb_remove();
        file_uploader.current_field_id = '';
        window.send_to_editor = old_send_to_editor;
      }
      return false;
    });
  }
};

var colorpicker = {
  count: 0,
  init: function() {
    jQuery('.foreman-field-list .text-colorpicker').each(function () {
      if (!jQuery(this).hasClass('hasColorpicker')) {
        colorpicker.count = colorpicker.count + 1;
        jQuery(this).after('<div id="picker-' + colorpicker.count + '" style="z-index: 1000; background: #EEE; border: 1px solid #CCC; position: absolute; display: block;"></div>');
        jQuery('#picker-' + colorpicker.count).hide().farbtastic(jQuery(this));
        jQuery(this).addClass('hasColorpicker');
        jQuery(this).focus(function() {
          jQuery(this).next().show();
        })
        .blur(function() {
          jQuery(this).next().hide();
        });
      }
    });
  }
}

var repeater = {
  init: function() {
    jQuery('.foreman-repeater').each(function() {
      var repeater_template = jQuery(this).find('li.repeater-template').clone().wrap('<div>').parent().html();
      jQuery(this).find('li.repeater-template').remove();
      jQuery(this).data('repeater_template', repeater_template);
    });

    jQuery('.foreman-remove-repeater-block').live('click', function() {
      jQuery(this).parent().fadeOut(function() {
        jQuery(this).remove();
      });
      return false;
    });

    jQuery('.foreman-add-repeater-block').live('click', function() {
      var repeater_block = jQuery(jQuery(this).attr('data-selector'));
      var next_index = jQuery(repeater_block).find('> li').size();
      var repeater_template = jQuery(repeater_block).data('repeater_template');
      var el_str = repeater_template.replace(/{position-placeholder}/g, next_index);
      jQuery(repeater_block).append(el_str);
      datepickers.init();
      colorpicker.init();
      visible_on.init();
      jQuery(repeater_block).find('> li:last-child').hide().fadeIn().find('.ForemanWysiwygField .input').html('<p class="foreman-notice">Save this post in order to edit using the wysiwyg editor.</p>');
      return false;
    });
  }
}

var table_repeater = {
  init: function() {
    jQuery('.foreman-table-repeater').each(function() {
      var repeater_template = jQuery(this).find('tr.repeater-template').clone().wrap('<div>').parent().html();
      jQuery(this).find('tr.repeater-template').remove();
      jQuery(this).data('repeater_template', repeater_template);
    });

    jQuery('.foreman-remove-table-repeater-row').live('click', function() {
      jQuery(this).parent().parent().fadeOut(function() {
        jQuery(this).remove();
      });
      return false;
    });

    jQuery('.foreman-add-table-repeater-row').live('click', function() {
      var repeater_block = jQuery(jQuery(this).attr('data-selector'));
      var next_index = jQuery(repeater_block).find('tbody tr').size();
      var repeater_template = jQuery(repeater_block).data('repeater_template');
      var el_str = repeater_template.replace(/{position-placeholder}/g, next_index);
      jQuery(repeater_block).find('tbody').append(el_str);
      datepickers.init();
      colorpicker.init();
      visible_on.init();
      jQuery(repeater_block).find('tbody tr:last-child').hide().fadeIn();
      return false;
    });
  }
}

var sortables = {
  init: function() {
    jQuery("ul.sortable").sortable({handle: ".handle"});
    jQuery("table.sortable tbody").sortable({handle: ".handle"});
  }
}

var related_posts = {
  init: function() {
    jQuery(".foreman-related-posts-select .controls button.make-selection").live('click', function() {
      var container = jQuery(this).parent().parent();
      var available = jQuery(container).find("select.available");
      var selected = jQuery(container).find("select.selected");

      jQuery(available).find("option:selected").each(function() {
        var id = jQuery(this).attr('value');
        var text = jQuery(this).text();
        jQuery(selected).append('<option value="'+id+'">'+text+'</option>');
        jQuery(this).remove();
      });
      related_posts.set_selected(container);
      return false;
    });

    jQuery(".foreman-related-posts-select .controls button.remove-selection").live('click', function() {
      var container = jQuery(this).parent().parent();
      var available = jQuery(container).find("select.available");
      var selected = jQuery(container).find("select.selected");

      jQuery(selected).find("option:selected").each(function() {
        var id = jQuery(this).attr('value');
        var text = jQuery(this).text();
        jQuery(available).append('<option value="'+id+'">'+text+'</option>');
        jQuery(this).remove();
      });
      related_posts.set_selected(container);
      return false;
    });
  },

  set_selected: function(container) {
    var available = jQuery(container).find("select.available");
    var selected = jQuery(container).find("select.selected");

    jQuery(available).find('option').each(function() {
      jQuery(this).attr('selected', false);
    });

    jQuery(selected).find('option').each(function() {
      jQuery(this).attr('selected', 'selected');
    });
  }
}

var post_form = {
  init: function() {
    jQuery("form#post").submit(function() {
      jQuery(this).find(".foreman-related-posts-select").each(function() {
        related_posts.set_selected(this);
      });
    });
  }
}