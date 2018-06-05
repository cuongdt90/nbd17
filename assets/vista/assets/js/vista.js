(function ($) {
    $.fn.nbTab = function (options) {
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
    $.fn.nbDropdown = function (options) {
        var defaults = {};
        var opts = $.extend({}, $.fn.nbDropdown.defaults, options);
        return this.each(function () {
            var sefl = this;
            var $btn = $(this).find('.v-btn-dropdown');
            var $menu = $(this).find('.v-dropdown-menu');

            $(this).nbClickOutSite({
                'targetE' : $(this),
                'removeClass': 'active'
            });

            $btn.on('click', function () {
                if ($(sefl).hasClass('active')) {
                    $(sefl).removeClass('active');
                }else {
                    $(sefl).addClass('active');
                }
            });
        });
    };

    $.fn.nbClickOutSite = function (options) {
        var defaults = {
            'targetE' : null,
            'removeClass' : ''
        };
        var opts = $.extend({}, $.fn.nbClickOutSite.defaults, options);
        return this.each(function () {
            var sefl = this;
            var $win = $(document);
            $win.on("click", function(event){
                if ($(sefl).has(event.target).length == 0 && !$(sefl).is(event.target)){
                    opts.targetE.removeClass(opts.removeClass);
                }
            });
        });
    };

    $.fn.nbPerfectScrollbar = function () {
        return this.each(function () {
            new PerfectScrollbar(this);
        });
    };

    $(document).ready(function () {
        $('.nbd-vista .v-tabs').nbTab();
        $('.nbd-vista .v-dropdown').nbDropdown();
        $('.nbd-vista .v-scrollbar').nbPerfectScrollbar();
    });
})(jQuery);