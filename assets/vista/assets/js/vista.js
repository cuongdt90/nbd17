(function ($) {
    $.fn.nbTab = function (options) {
        var sefl = this;
        var defaults = {};
        var opts = $.extend({}, $.fn.nbTab.default, options);
        return this.each(function () {
            var $tab = $(this).find('.v-tab');
            var $tabContent = $('.v-tab-contents .v-tab-content');
            $tab.on('click', function () {
                var tabId = $(this).attr('data-tab');
                $tab.removeClass('active');
                $(this).addClass('active');
                $tabContent.removeClass('active');
                $('.v-tab-contents #' + tabId).addClass('active');
            });
        });
    };
    $(document).ready(function () {
        $('.nbd-vista .v-tabs').nbTab();
        var ps = new PerfectScrollbar('#v-text-toolbar .v-scrollbar');
        var ps1 = new PerfectScrollbar('#v-design-toolbar .v-scrollbar');
    });
})(jQuery);