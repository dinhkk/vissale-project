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
        datepickerClass: '.date-picker',
        datepickerFieldClass: '.date-picker-field',
        init: function () {
            var self = this;
            var searchInput = [
                this.inputClass,
                this.datepickerClass,
            ];
            this.searchInput = [
                this.inputClass,
                this.datepickerClass,
            ];
            $('body').on('click', this.submitClass, function () {
                var $form = $(this).closest(self.formClass);
                var action = $form.data('action');
                var data = $form.find(':input').serialize();
                var req = $.post(action, data, function (res) {
                    if (res.error === 0) {
                        alert('<?php echo __('save_successful_message') ?>');
                        self.reload($form);
                    } else {
                        var html = res.data.html;
                        $form.html(html);
                        $(document).trigger('fbsale.ajaxsubmiterror', [$form]);
                    }
                }, 'json');

                req.error(function (xhr, status, error) {
                    alert("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
                });
            });
            $('body').on('click', this.searchSubmitClass, function () {
                var $container = $(this).closest(self.containerClass);
                var action = $container.data('action');
                var data = $container.find(searchInput.join(',')).serialize();
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
                var data = $container.find(searchInput.join(',')).serialize();
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
                var $self = $(this);
                var req = $.get(action, {}, function (res) {
                    if (res.error === 0) {
                        alert('<?php echo __('delete_successful_message') ?>');
                        self.reload($self);
                    } else {
                        alert('<?php echo __('delete_error_message') ?>');
                    }
                }, 'json');

                req.error(function (xhr, status, error) {
                    alert("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
                });
            });
            if (jQuery().datepicker) {
                this.initdatepicker();
                this.initdatepickerField();
            }
            $(document).on('fbsale.ajaxsearch', function () {
                if (jQuery().datepicker) {
                    self.initdatepicker();
                    self.initdatepickerField();
                }
            });
            $(document).on('fbsale.ajaxreload', function () {
                if (jQuery().datepicker) {
                    self.initdatepicker();
                    self.initdatepickerField();
                }
            });
            $(document).on('fbsale.ajaxsubmiterror', function () {
                if (jQuery().datepicker) {
                    self.initdatepicker();
                    self.initdatepickerField();
                }
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
        initdatepicker: function () {
            var self = this;
            $(this.datepickerClass).datepicker({
                autoclose: true,
                todayBtn: true,
                todayHighlight: true,
                clearBtn: true,
                format: "yyyy-mm-dd",
            });
            $(this.datepickerClass).on('changeDate', function () {
                var $container = $(this).closest(self.containerClass);
                var action = $container.data('action');
                var data = $container.find(self.searchInput.join(',')).serialize();
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
        },
        initdatepickerField: function () {
            $(this.datepickerFieldClass).datepicker({
                autoclose: true,
                todayBtn: true,
                todayHighlight: true,
                clearBtn: true,
                format: "yyyy-mm-dd",
            });
        },
    };
    $(function () {
        fbsale.ajaxForm.init();
    });
</script>