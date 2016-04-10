<script>
    var fbsale = {};
    fbsale.ajaxForm = {
        formClass: '.ajax-form',
        submitClass: '.ajax-submit',
        containerClass: '.ajax-container',
        searchFormClass: '.ajax-search-form',
        searchSubmitClass: '.ajax-search-submit',
        controlClass: '.ajax-control',
        inputClass: '.ajax-input',
        deleteClass: '.ajax-delete',
        init: function () {
            var self = this;
            $('body').on('click', this.submitClass, function () {
                var $form = $(this).closest(self.formClass);
                var action = $form.data('action');
                var data = $form.find(':input').serialize();
                var req = $.post(action, data, function (res) {
                    if (res.error === 0) {
                        alert('<?php echo __('save_successful_message') ?>');
                        self.reload();
                    } else {
                        var html = res.data.html;
                        $form.html(html);
                    }
                }, 'json');

                req.error(function (xhr, status, error) {
                    alert("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
                });
            });
            $('body').on('click', this.searchSubmitClass, function () {
                var $container = $(this).closest(self.containerClass);
                var action = $container.data('action');
                var data = $container.find(self.inputClass).serialize();
                var $element = $(this).closest(self.searchFormClass);
                var req = $.get(action, data, function (html) {
                    $container.html(html);
                    $container.data('action', action);
                    $(document).trigger('fbsale.ajaxsearch', [$element]);
                });

                req.error(function (xhr, status, error) {
                    alert("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
                });
            });
            $('body').on('change', this.inputClass, function () {
                var $container = $(this).closest(self.containerClass);
                var action = $container.data('action');
                var data = $container.find(self.inputClass).serialize();
                var $element = $(this).closest(self.searchFormClass);
                var req = $.get(action, data, function (html) {
                    $container.html(html);
                    $container.data('action', action);
                    $(document).trigger('fbsale.ajaxsearch', [$element]);
                });

                req.error(function (xhr, status, error) {
                    alert("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
                });
            });
            $('body').on('click', this.deleteClass, function () {
                var action = $(this).data('action');
                var req = $.get(action, {}, function (res) {
                    if (res.error === 0) {
                        alert('<?php echo __('delete_successful_message') ?>');
                        self.reload();
                    } else {
                        alert('<?php echo __('delete_error_message') ?>');
                    }
                }, 'json');

                req.error(function (xhr, status, error) {
                    alert("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
                });
            });
        },
        reload: function ($element) {
            var self = this;
            if ($element) {
                var $container = $element.closest(self.containerClass);
            } else {
                var $container = $(self.containerClass);
            }
            var action = $container.data('action');
            var req = $.get(action, {}, function (html) {
                $container.html(html);
                $container.data('action', action);
                $(document).trigger('fbsale.ajaxreload', [$element]);
            });

            req.error(function (xhr, status, error) {
                alert("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
            });
        },
    };
    $(function () {
        fbsale.ajaxForm.init();
    });
</script>