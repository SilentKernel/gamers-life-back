/*
 * Bootstrap v3.3.5 (http://getbootstrap.com)
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

/*
 * Generated using the Bootstrap Customizer (http://getbootstrap.com/customize/?id=873a4fe860b1be8745d0)
 * Config saved to config.json and https://gist.github.com/873a4fe860b1be8745d0
 */
if (typeof jQuery === 'undefined') {
    throw new Error('Bootstrap\'s JavaScript requires jQuery')
}
+function ($) {
    'use strict';
    var version = $.fn.jquery.split(' ')[0].split('.')
    if ((version[0] < 2 && version[1] < 9) || (version[0] == 1 && version[1] == 9 && version[2] < 1)) {
        throw new Error('Bootstrap\'s JavaScript requires jQuery version 1.9.1 or higher')
    }
}(jQuery);

/* ========================================================================
 * Bootstrap: alert.js v3.3.5
 * http://getbootstrap.com/javascript/#alerts
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';

    // ALERT CLASS DEFINITION
    // ======================

    var dismiss = '[data-dismiss="alert"]'
    var Alert   = function (el) {
        $(el).on('click', dismiss, this.close)
    }

    Alert.VERSION = '3.3.5'

    Alert.TRANSITION_DURATION = 150

    Alert.prototype.close = function (e) {
        var $this    = $(this)
        var selector = $this.attr('data-target')

        if (!selector) {
            selector = $this.attr('href')
            selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
        }

        var $parent = $(selector)

        if (e) e.preventDefault()

        if (!$parent.length) {
            $parent = $this.closest('.alert')
        }

        $parent.trigger(e = $.Event('close.bs.alert'))

        if (e.isDefaultPrevented()) return

        $parent.removeClass('in')

        function removeElement() {
            // detach from parent, fire event then clean up data
            $parent.detach().trigger('closed.bs.alert').remove()
        }

        $.support.transition && $parent.hasClass('fade') ?
            $parent
                .one('bsTransitionEnd', removeElement)
                .emulateTransitionEnd(Alert.TRANSITION_DURATION) :
            removeElement()
    }


    // ALERT PLUGIN DEFINITION
    // =======================

    function Plugin(option) {
        return this.each(function () {
            var $this = $(this)
            var data  = $this.data('bs.alert')

            if (!data) $this.data('bs.alert', (data = new Alert(this)))
            if (typeof option == 'string') data[option].call($this)
        })
    }

    var old = $.fn.alert

    $.fn.alert             = Plugin
    $.fn.alert.Constructor = Alert


    // ALERT NO CONFLICT
    // =================

    $.fn.alert.noConflict = function () {
        $.fn.alert = old
        return this
    }


    // ALERT DATA-API
    // ==============

    $(document).on('click.bs.alert.data-api', dismiss, Alert.prototype.close)

}(jQuery);

/* ========================================================================
 * Bootstrap: button.js v3.3.5
 * http://getbootstrap.com/javascript/#buttons
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';

    // BUTTON PUBLIC CLASS DEFINITION
    // ==============================

    var Button = function (element, options) {
        this.$element  = $(element)
        this.options   = $.extend({}, Button.DEFAULTS, options)
        this.isLoading = false
    }

    Button.VERSION  = '3.3.5'

    Button.DEFAULTS = {
        loadingText: 'loading...'
    }

    Button.prototype.setState = function (state) {
        var d    = 'disabled'
        var $el  = this.$element
        var val  = $el.is('input') ? 'val' : 'html'
        var data = $el.data()

        state += 'Text'

        if (data.resetText == null) $el.data('resetText', $el[val]())

        // push to event loop to allow forms to submit
        setTimeout($.proxy(function () {
            $el[val](data[state] == null ? this.options[state] : data[state])

            if (state == 'loadingText') {
                this.isLoading = true
                $el.addClass(d).attr(d, d)
            } else if (this.isLoading) {
                this.isLoading = false
                $el.removeClass(d).removeAttr(d)
            }
        }, this), 0)
    }

    Button.prototype.toggle = function () {
        var changed = true
        var $parent = this.$element.closest('[data-toggle="buttons"]')

        if ($parent.length) {
            var $input = this.$element.find('input')
            if ($input.prop('type') == 'radio') {
                if ($input.prop('checked')) changed = false
                $parent.find('.active').removeClass('active')
                this.$element.addClass('active')
            } else if ($input.prop('type') == 'checkbox') {
                if (($input.prop('checked')) !== this.$element.hasClass('active')) changed = false
                this.$element.toggleClass('active')
            }
            $input.prop('checked', this.$element.hasClass('active'))
            if (changed) $input.trigger('change')
        } else {
            this.$element.attr('aria-pressed', !this.$element.hasClass('active'))
            this.$element.toggleClass('active')
        }
    }


    // BUTTON PLUGIN DEFINITION
    // ========================

    function Plugin(option) {
        return this.each(function () {
            var $this   = $(this)
            var data    = $this.data('bs.button')
            var options = typeof option == 'object' && option

            if (!data) $this.data('bs.button', (data = new Button(this, options)))

            if (option == 'toggle') data.toggle()
            else if (option) data.setState(option)
        })
    }

    var old = $.fn.button

    $.fn.button             = Plugin
    $.fn.button.Constructor = Button


    // BUTTON NO CONFLICT
    // ==================

    $.fn.button.noConflict = function () {
        $.fn.button = old
        return this
    }


    // BUTTON DATA-API
    // ===============

    $(document)
        .on('click.bs.button.data-api', '[data-toggle^="button"]', function (e) {
            var $btn = $(e.target)
            if (!$btn.hasClass('btn')) $btn = $btn.closest('.btn')
            Plugin.call($btn, 'toggle')
            if (!($(e.target).is('input[type="radio"]') || $(e.target).is('input[type="checkbox"]'))) e.preventDefault()
        })
        .on('focus.bs.button.data-api blur.bs.button.data-api', '[data-toggle^="button"]', function (e) {
            $(e.target).closest('.btn').toggleClass('focus', /^focus(in)?$/.test(e.type))
        })

}(jQuery);

/* ========================================================================
 * Bootstrap: carousel.js v3.3.5
 * http://getbootstrap.com/javascript/#carousel
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';

    // CAROUSEL CLASS DEFINITION
    // =========================

    var Carousel = function (element, options) {
        this.$element    = $(element)
        this.$indicators = this.$element.find('.carousel-indicators')
        this.options     = options
        this.paused      = null
        this.sliding     = null
        this.interval    = null
        this.$active     = null
        this.$items      = null

        this.options.keyboard && this.$element.on('keydown.bs.carousel', $.proxy(this.keydown, this))

        this.options.pause == 'hover' && !('ontouchstart' in document.documentElement) && this.$element
            .on('mouseenter.bs.carousel', $.proxy(this.pause, this))
            .on('mouseleave.bs.carousel', $.proxy(this.cycle, this))
    }

    Carousel.VERSION  = '3.3.5'

    Carousel.TRANSITION_DURATION = 600

    Carousel.DEFAULTS = {
        interval: 5000,
        pause: 'hover',
        wrap: true,
        keyboard: true
    }

    Carousel.prototype.keydown = function (e) {
        if (/input|textarea/i.test(e.target.tagName)) return
        switch (e.which) {
            case 37: this.prev(); break
            case 39: this.next(); break
            default: return
        }

        e.preventDefault()
    }

    Carousel.prototype.cycle = function (e) {
        e || (this.paused = false)

        this.interval && clearInterval(this.interval)

        this.options.interval
        && !this.paused
        && (this.interval = setInterval($.proxy(this.next, this), this.options.interval))

        return this
    }

    Carousel.prototype.getItemIndex = function (item) {
        this.$items = item.parent().children('.item')
        return this.$items.index(item || this.$active)
    }

    Carousel.prototype.getItemForDirection = function (direction, active) {
        var activeIndex = this.getItemIndex(active)
        var willWrap = (direction == 'prev' && activeIndex === 0)
            || (direction == 'next' && activeIndex == (this.$items.length - 1))
        if (willWrap && !this.options.wrap) return active
        var delta = direction == 'prev' ? -1 : 1
        var itemIndex = (activeIndex + delta) % this.$items.length
        return this.$items.eq(itemIndex)
    }

    Carousel.prototype.to = function (pos) {
        var that        = this
        var activeIndex = this.getItemIndex(this.$active = this.$element.find('.item.active'))

        if (pos > (this.$items.length - 1) || pos < 0) return

        if (this.sliding)       return this.$element.one('slid.bs.carousel', function () { that.to(pos) }) // yes, "slid"
        if (activeIndex == pos) return this.pause().cycle()

        return this.slide(pos > activeIndex ? 'next' : 'prev', this.$items.eq(pos))
    }

    Carousel.prototype.pause = function (e) {
        e || (this.paused = true)

        if (this.$element.find('.next, .prev').length && $.support.transition) {
            this.$element.trigger($.support.transition.end)
            this.cycle(true)
        }

        this.interval = clearInterval(this.interval)

        return this
    }

    Carousel.prototype.next = function () {
        if (this.sliding) return
        return this.slide('next')
    }

    Carousel.prototype.prev = function () {
        if (this.sliding) return
        return this.slide('prev')
    }

    Carousel.prototype.slide = function (type, next) {
        var $active   = this.$element.find('.item.active')
        var $next     = next || this.getItemForDirection(type, $active)
        var isCycling = this.interval
        var direction = type == 'next' ? 'left' : 'right'
        var that      = this

        if ($next.hasClass('active')) return (this.sliding = false)

        var relatedTarget = $next[0]
        var slideEvent = $.Event('slide.bs.carousel', {
            relatedTarget: relatedTarget,
            direction: direction
        })
        this.$element.trigger(slideEvent)
        if (slideEvent.isDefaultPrevented()) return

        this.sliding = true

        isCycling && this.pause()

        if (this.$indicators.length) {
            this.$indicators.find('.active').removeClass('active')
            var $nextIndicator = $(this.$indicators.children()[this.getItemIndex($next)])
            $nextIndicator && $nextIndicator.addClass('active')
        }

        var slidEvent = $.Event('slid.bs.carousel', { relatedTarget: relatedTarget, direction: direction }) // yes, "slid"
        if ($.support.transition && this.$element.hasClass('slide')) {
            $next.addClass(type)
            $next[0].offsetWidth // force reflow
            $active.addClass(direction)
            $next.addClass(direction)
            $active
                .one('bsTransitionEnd', function () {
                    $next.removeClass([type, direction].join(' ')).addClass('active')
                    $active.removeClass(['active', direction].join(' '))
                    that.sliding = false
                    setTimeout(function () {
                        that.$element.trigger(slidEvent)
                    }, 0)
                })
                .emulateTransitionEnd(Carousel.TRANSITION_DURATION)
        } else {
            $active.removeClass('active')
            $next.addClass('active')
            this.sliding = false
            this.$element.trigger(slidEvent)
        }

        isCycling && this.cycle()

        return this
    }


    // CAROUSEL PLUGIN DEFINITION
    // ==========================

    function Plugin(option) {
        return this.each(function () {
            var $this   = $(this)
            var data    = $this.data('bs.carousel')
            var options = $.extend({}, Carousel.DEFAULTS, $this.data(), typeof option == 'object' && option)
            var action  = typeof option == 'string' ? option : options.slide

            if (!data) $this.data('bs.carousel', (data = new Carousel(this, options)))
            if (typeof option == 'number') data.to(option)
            else if (action) data[action]()
            else if (options.interval) data.pause().cycle()
        })
    }

    var old = $.fn.carousel

    $.fn.carousel             = Plugin
    $.fn.carousel.Constructor = Carousel


    // CAROUSEL NO CONFLICT
    // ====================

    $.fn.carousel.noConflict = function () {
        $.fn.carousel = old
        return this
    }


    // CAROUSEL DATA-API
    // =================

    var clickHandler = function (e) {
        var href
        var $this   = $(this)
        var $target = $($this.attr('data-target') || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '')) // strip for ie7
        if (!$target.hasClass('carousel')) return
        var options = $.extend({}, $target.data(), $this.data())
        var slideIndex = $this.attr('data-slide-to')
        if (slideIndex) options.interval = false

        Plugin.call($target, options)

        if (slideIndex) {
            $target.data('bs.carousel').to(slideIndex)
        }

        e.preventDefault()
    }

    $(document)
        .on('click.bs.carousel.data-api', '[data-slide]', clickHandler)
        .on('click.bs.carousel.data-api', '[data-slide-to]', clickHandler)

    $(window).on('load', function () {
        $('[data-ride="carousel"]').each(function () {
            var $carousel = $(this)
            Plugin.call($carousel, $carousel.data())
        })
    })

}(jQuery);

/* ========================================================================
 * Bootstrap: dropdown.js v3.3.5
 * http://getbootstrap.com/javascript/#dropdowns
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';

    // DROPDOWN CLASS DEFINITION
    // =========================

    var backdrop = '.dropdown-backdrop'
    var toggle   = '[data-toggle="dropdown"]'
    var Dropdown = function (element) {
        $(element).on('click.bs.dropdown', this.toggle)
    }

    Dropdown.VERSION = '3.3.5'

    function getParent($this) {
        var selector = $this.attr('data-target')

        if (!selector) {
            selector = $this.attr('href')
            selector = selector && /#[A-Za-z]/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
        }

        var $parent = selector && $(selector)

        return $parent && $parent.length ? $parent : $this.parent()
    }

    function clearMenus(e) {
        if (e && e.which === 3) return
        $(backdrop).remove()
        $(toggle).each(function () {
            var $this         = $(this)
            var $parent       = getParent($this)
            var relatedTarget = { relatedTarget: this }

            if (!$parent.hasClass('open')) return

            if (e && e.type == 'click' && /input|textarea/i.test(e.target.tagName) && $.contains($parent[0], e.target)) return

            $parent.trigger(e = $.Event('hide.bs.dropdown', relatedTarget))

            if (e.isDefaultPrevented()) return

            $this.attr('aria-expanded', 'false')
            $parent.removeClass('open').trigger('hidden.bs.dropdown', relatedTarget)
        })
    }

    Dropdown.prototype.toggle = function (e) {
        var $this = $(this)

        if ($this.is('.disabled, :disabled')) return

        var $parent  = getParent($this)
        var isActive = $parent.hasClass('open')

        clearMenus()

        if (!isActive) {
            if ('ontouchstart' in document.documentElement && !$parent.closest('.navbar-nav').length) {
                // if mobile we use a backdrop because click events don't delegate
                $(document.createElement('div'))
                    .addClass('dropdown-backdrop')
                    .insertAfter($(this))
                    .on('click', clearMenus)
            }

            var relatedTarget = { relatedTarget: this }
            $parent.trigger(e = $.Event('show.bs.dropdown', relatedTarget))

            if (e.isDefaultPrevented()) return

            $this
                .trigger('focus')
                .attr('aria-expanded', 'true')

            $parent
                .toggleClass('open')
                .trigger('shown.bs.dropdown', relatedTarget)
        }

        return false
    }

    Dropdown.prototype.keydown = function (e) {
        if (!/(38|40|27|32)/.test(e.which) || /input|textarea/i.test(e.target.tagName)) return

        var $this = $(this)

        e.preventDefault()
        e.stopPropagation()

        if ($this.is('.disabled, :disabled')) return

        var $parent  = getParent($this)
        var isActive = $parent.hasClass('open')

        if (!isActive && e.which != 27 || isActive && e.which == 27) {
            if (e.which == 27) $parent.find(toggle).trigger('focus')
            return $this.trigger('click')
        }

        var desc = ' li:not(.disabled):visible a'
        var $items = $parent.find('.dropdown-menu' + desc)

        if (!$items.length) return

        var index = $items.index(e.target)

        if (e.which == 38 && index > 0)                 index--         // up
        if (e.which == 40 && index < $items.length - 1) index++         // down
        if (!~index)                                    index = 0

        $items.eq(index).trigger('focus')
    }


    // DROPDOWN PLUGIN DEFINITION
    // ==========================

    function Plugin(option) {
        return this.each(function () {
            var $this = $(this)
            var data  = $this.data('bs.dropdown')

            if (!data) $this.data('bs.dropdown', (data = new Dropdown(this)))
            if (typeof option == 'string') data[option].call($this)
        })
    }

    var old = $.fn.dropdown

    $.fn.dropdown             = Plugin
    $.fn.dropdown.Constructor = Dropdown


    // DROPDOWN NO CONFLICT
    // ====================

    $.fn.dropdown.noConflict = function () {
        $.fn.dropdown = old
        return this
    }


    // APPLY TO STANDARD DROPDOWN ELEMENTS
    // ===================================

    $(document)
        .on('click.bs.dropdown.data-api', clearMenus)
        .on('click.bs.dropdown.data-api', '.dropdown form', function (e) { e.stopPropagation() })
        .on('click.bs.dropdown.data-api', toggle, Dropdown.prototype.toggle)
        .on('keydown.bs.dropdown.data-api', toggle, Dropdown.prototype.keydown)
        .on('keydown.bs.dropdown.data-api', '.dropdown-menu', Dropdown.prototype.keydown)

}(jQuery);

/* ========================================================================
 * Bootstrap: modal.js v3.3.5
 * http://getbootstrap.com/javascript/#modals
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';

    // MODAL CLASS DEFINITION
    // ======================

    var Modal = function (element, options) {
        this.options             = options
        this.$body               = $(document.body)
        this.$element            = $(element)
        this.$dialog             = this.$element.find('.modal-dialog')
        this.$backdrop           = null
        this.isShown             = null
        this.originalBodyPad     = null
        this.scrollbarWidth      = 0
        this.ignoreBackdropClick = false

        if (this.options.remote) {
            this.$element
                .find('.modal-content')
                .load(this.options.remote, $.proxy(function () {
                    this.$element.trigger('loaded.bs.modal')
                }, this))
        }
    }

    Modal.VERSION  = '3.3.5'

    Modal.TRANSITION_DURATION = 300
    Modal.BACKDROP_TRANSITION_DURATION = 150

    Modal.DEFAULTS = {
        backdrop: true,
        keyboard: true,
        show: true
    }

    Modal.prototype.toggle = function (_relatedTarget) {
        return this.isShown ? this.hide() : this.show(_relatedTarget)
    }

    Modal.prototype.show = function (_relatedTarget) {
        var that = this
        var e    = $.Event('show.bs.modal', { relatedTarget: _relatedTarget })

        this.$element.trigger(e)

        if (this.isShown || e.isDefaultPrevented()) return

        this.isShown = true

        this.checkScrollbar()
        this.setScrollbar()
        this.$body.addClass('modal-open')

        this.escape()
        this.resize()

        this.$element.on('click.dismiss.bs.modal', '[data-dismiss="modal"]', $.proxy(this.hide, this))

        this.$dialog.on('mousedown.dismiss.bs.modal', function () {
            that.$element.one('mouseup.dismiss.bs.modal', function (e) {
                if ($(e.target).is(that.$element)) that.ignoreBackdropClick = true
            })
        })

        this.backdrop(function () {
            var transition = $.support.transition && that.$element.hasClass('fade')

            if (!that.$element.parent().length) {
                that.$element.appendTo(that.$body) // don't move modals dom position
            }

            that.$element
                .show()
                .scrollTop(0)

            that.adjustDialog()

            if (transition) {
                that.$element[0].offsetWidth // force reflow
            }

            that.$element.addClass('in')

            that.enforceFocus()

            var e = $.Event('shown.bs.modal', { relatedTarget: _relatedTarget })

            transition ?
                that.$dialog // wait for modal to slide in
                    .one('bsTransitionEnd', function () {
                        that.$element.trigger('focus').trigger(e)
                    })
                    .emulateTransitionEnd(Modal.TRANSITION_DURATION) :
                that.$element.trigger('focus').trigger(e)
        })
    }

    Modal.prototype.hide = function (e) {
        if (e) e.preventDefault()

        e = $.Event('hide.bs.modal')

        this.$element.trigger(e)

        if (!this.isShown || e.isDefaultPrevented()) return

        this.isShown = false

        this.escape()
        this.resize()

        $(document).off('focusin.bs.modal')

        this.$element
            .removeClass('in')
            .off('click.dismiss.bs.modal')
            .off('mouseup.dismiss.bs.modal')

        this.$dialog.off('mousedown.dismiss.bs.modal')

        $.support.transition && this.$element.hasClass('fade') ?
            this.$element
                .one('bsTransitionEnd', $.proxy(this.hideModal, this))
                .emulateTransitionEnd(Modal.TRANSITION_DURATION) :
            this.hideModal()
    }

    Modal.prototype.enforceFocus = function () {
        $(document)
            .off('focusin.bs.modal') // guard against infinite focus loop
            .on('focusin.bs.modal', $.proxy(function (e) {
                if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
                    this.$element.trigger('focus')
                }
            }, this))
    }

    Modal.prototype.escape = function () {
        if (this.isShown && this.options.keyboard) {
            this.$element.on('keydown.dismiss.bs.modal', $.proxy(function (e) {
                e.which == 27 && this.hide()
            }, this))
        } else if (!this.isShown) {
            this.$element.off('keydown.dismiss.bs.modal')
        }
    }

    Modal.prototype.resize = function () {
        if (this.isShown) {
            $(window).on('resize.bs.modal', $.proxy(this.handleUpdate, this))
        } else {
            $(window).off('resize.bs.modal')
        }
    }

    Modal.prototype.hideModal = function () {
        var that = this
        this.$element.hide()
        this.backdrop(function () {
            that.$body.removeClass('modal-open')
            that.resetAdjustments()
            that.resetScrollbar()
            that.$element.trigger('hidden.bs.modal')
        })
    }

    Modal.prototype.removeBackdrop = function () {
        this.$backdrop && this.$backdrop.remove()
        this.$backdrop = null
    }

    Modal.prototype.backdrop = function (callback) {
        var that = this
        var animate = this.$element.hasClass('fade') ? 'fade' : ''

        if (this.isShown && this.options.backdrop) {
            var doAnimate = $.support.transition && animate

            this.$backdrop = $(document.createElement('div'))
                .addClass('modal-backdrop ' + animate)
                .appendTo(this.$body)

            this.$element.on('click.dismiss.bs.modal', $.proxy(function (e) {
                if (this.ignoreBackdropClick) {
                    this.ignoreBackdropClick = false
                    return
                }
                if (e.target !== e.currentTarget) return
                this.options.backdrop == 'static'
                    ? this.$element[0].focus()
                    : this.hide()
            }, this))

            if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

            this.$backdrop.addClass('in')

            if (!callback) return

            doAnimate ?
                this.$backdrop
                    .one('bsTransitionEnd', callback)
                    .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
                callback()

        } else if (!this.isShown && this.$backdrop) {
            this.$backdrop.removeClass('in')

            var callbackRemove = function () {
                that.removeBackdrop()
                callback && callback()
            }
            $.support.transition && this.$element.hasClass('fade') ?
                this.$backdrop
                    .one('bsTransitionEnd', callbackRemove)
                    .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
                callbackRemove()

        } else if (callback) {
            callback()
        }
    }

    // these following methods are used to handle overflowing modals

    Modal.prototype.handleUpdate = function () {
        this.adjustDialog()
    }

    Modal.prototype.adjustDialog = function () {
        var modalIsOverflowing = this.$element[0].scrollHeight > document.documentElement.clientHeight

        this.$element.css({
            paddingLeft:  !this.bodyIsOverflowing && modalIsOverflowing ? this.scrollbarWidth : '',
            paddingRight: this.bodyIsOverflowing && !modalIsOverflowing ? this.scrollbarWidth : ''
        })
    }

    Modal.prototype.resetAdjustments = function () {
        this.$element.css({
            paddingLeft: '',
            paddingRight: ''
        })
    }

    Modal.prototype.checkScrollbar = function () {
        var fullWindowWidth = window.innerWidth
        if (!fullWindowWidth) { // workaround for missing window.innerWidth in IE8
            var documentElementRect = document.documentElement.getBoundingClientRect()
            fullWindowWidth = documentElementRect.right - Math.abs(documentElementRect.left)
        }
        this.bodyIsOverflowing = document.body.clientWidth < fullWindowWidth
        this.scrollbarWidth = this.measureScrollbar()
    }

    Modal.prototype.setScrollbar = function () {
        var bodyPad = parseInt((this.$body.css('padding-right') || 0), 10)
        this.originalBodyPad = document.body.style.paddingRight || ''
        if (this.bodyIsOverflowing) this.$body.css('padding-right', bodyPad + this.scrollbarWidth)
    }

    Modal.prototype.resetScrollbar = function () {
        this.$body.css('padding-right', this.originalBodyPad)
    }

    Modal.prototype.measureScrollbar = function () { // thx walsh
        var scrollDiv = document.createElement('div')
        scrollDiv.className = 'modal-scrollbar-measure'
        this.$body.append(scrollDiv)
        var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth
        this.$body[0].removeChild(scrollDiv)
        return scrollbarWidth
    }


    // MODAL PLUGIN DEFINITION
    // =======================

    function Plugin(option, _relatedTarget) {
        return this.each(function () {
            var $this   = $(this)
            var data    = $this.data('bs.modal')
            var options = $.extend({}, Modal.DEFAULTS, $this.data(), typeof option == 'object' && option)

            if (!data) $this.data('bs.modal', (data = new Modal(this, options)))
            if (typeof option == 'string') data[option](_relatedTarget)
            else if (options.show) data.show(_relatedTarget)
        })
    }

    var old = $.fn.modal

    $.fn.modal             = Plugin
    $.fn.modal.Constructor = Modal


    // MODAL NO CONFLICT
    // =================

    $.fn.modal.noConflict = function () {
        $.fn.modal = old
        return this
    }


    // MODAL DATA-API
    // ==============

    $(document).on('click.bs.modal.data-api', '[data-toggle="modal"]', function (e) {
        var $this   = $(this)
        var href    = $this.attr('href')
        var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
        var option  = $target.data('bs.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

        if ($this.is('a')) e.preventDefault()

        $target.one('show.bs.modal', function (showEvent) {
            if (showEvent.isDefaultPrevented()) return // only register focus restorer if modal will actually get shown
            $target.one('hidden.bs.modal', function () {
                $this.is(':visible') && $this.trigger('focus')
            })
        })
        Plugin.call($target, option, this)
    })

}(jQuery);

/* ========================================================================
 * Bootstrap: tooltip.js v3.3.5
 * http://getbootstrap.com/javascript/#tooltip
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';

    // TOOLTIP PUBLIC CLASS DEFINITION
    // ===============================

    var Tooltip = function (element, options) {
        this.type       = null
        this.options    = null
        this.enabled    = null
        this.timeout    = null
        this.hoverState = null
        this.$element   = null
        this.inState    = null

        this.init('tooltip', element, options)
    }

    Tooltip.VERSION  = '3.3.5'

    Tooltip.TRANSITION_DURATION = 150

    Tooltip.DEFAULTS = {
        animation: true,
        placement: 'top',
        selector: false,
        template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        trigger: 'hover focus',
        title: '',
        delay: 0,
        html: false,
        container: false,
        viewport: {
            selector: 'body',
            padding: 0
        }
    }

    Tooltip.prototype.init = function (type, element, options) {
        this.enabled   = true
        this.type      = type
        this.$element  = $(element)
        this.options   = this.getOptions(options)
        this.$viewport = this.options.viewport && $($.isFunction(this.options.viewport) ? this.options.viewport.call(this, this.$element) : (this.options.viewport.selector || this.options.viewport))
        this.inState   = { click: false, hover: false, focus: false }

        if (this.$element[0] instanceof document.constructor && !this.options.selector) {
            throw new Error('`selector` option must be specified when initializing ' + this.type + ' on the window.document object!')
        }

        var triggers = this.options.trigger.split(' ')

        for (var i = triggers.length; i--;) {
            var trigger = triggers[i]

            if (trigger == 'click') {
                this.$element.on('click.' + this.type, this.options.selector, $.proxy(this.toggle, this))
            } else if (trigger != 'manual') {
                var eventIn  = trigger == 'hover' ? 'mouseenter' : 'focusin'
                var eventOut = trigger == 'hover' ? 'mouseleave' : 'focusout'

                this.$element.on(eventIn  + '.' + this.type, this.options.selector, $.proxy(this.enter, this))
                this.$element.on(eventOut + '.' + this.type, this.options.selector, $.proxy(this.leave, this))
            }
        }

        this.options.selector ?
            (this._options = $.extend({}, this.options, { trigger: 'manual', selector: '' })) :
            this.fixTitle()
    }

    Tooltip.prototype.getDefaults = function () {
        return Tooltip.DEFAULTS
    }

    Tooltip.prototype.getOptions = function (options) {
        options = $.extend({}, this.getDefaults(), this.$element.data(), options)

        if (options.delay && typeof options.delay == 'number') {
            options.delay = {
                show: options.delay,
                hide: options.delay
            }
        }

        return options
    }

    Tooltip.prototype.getDelegateOptions = function () {
        var options  = {}
        var defaults = this.getDefaults()

        this._options && $.each(this._options, function (key, value) {
            if (defaults[key] != value) options[key] = value
        })

        return options
    }

    Tooltip.prototype.enter = function (obj) {
        var self = obj instanceof this.constructor ?
            obj : $(obj.currentTarget).data('bs.' + this.type)

        if (!self) {
            self = new this.constructor(obj.currentTarget, this.getDelegateOptions())
            $(obj.currentTarget).data('bs.' + this.type, self)
        }

        if (obj instanceof $.Event) {
            self.inState[obj.type == 'focusin' ? 'focus' : 'hover'] = true
        }

        if (self.tip().hasClass('in') || self.hoverState == 'in') {
            self.hoverState = 'in'
            return
        }

        clearTimeout(self.timeout)

        self.hoverState = 'in'

        if (!self.options.delay || !self.options.delay.show) return self.show()

        self.timeout = setTimeout(function () {
            if (self.hoverState == 'in') self.show()
        }, self.options.delay.show)
    }

    Tooltip.prototype.isInStateTrue = function () {
        for (var key in this.inState) {
            if (this.inState[key]) return true
        }

        return false
    }

    Tooltip.prototype.leave = function (obj) {
        var self = obj instanceof this.constructor ?
            obj : $(obj.currentTarget).data('bs.' + this.type)

        if (!self) {
            self = new this.constructor(obj.currentTarget, this.getDelegateOptions())
            $(obj.currentTarget).data('bs.' + this.type, self)
        }

        if (obj instanceof $.Event) {
            self.inState[obj.type == 'focusout' ? 'focus' : 'hover'] = false
        }

        if (self.isInStateTrue()) return

        clearTimeout(self.timeout)

        self.hoverState = 'out'

        if (!self.options.delay || !self.options.delay.hide) return self.hide()

        self.timeout = setTimeout(function () {
            if (self.hoverState == 'out') self.hide()
        }, self.options.delay.hide)
    }

    Tooltip.prototype.show = function () {
        var e = $.Event('show.bs.' + this.type)

        if (this.hasContent() && this.enabled) {
            this.$element.trigger(e)

            var inDom = $.contains(this.$element[0].ownerDocument.documentElement, this.$element[0])
            if (e.isDefaultPrevented() || !inDom) return
            var that = this

            var $tip = this.tip()

            var tipId = this.getUID(this.type)

            this.setContent()
            $tip.attr('id', tipId)
            this.$element.attr('aria-describedby', tipId)

            if (this.options.animation) $tip.addClass('fade')

            var placement = typeof this.options.placement == 'function' ?
                this.options.placement.call(this, $tip[0], this.$element[0]) :
                this.options.placement

            var autoToken = /\s?auto?\s?/i
            var autoPlace = autoToken.test(placement)
            if (autoPlace) placement = placement.replace(autoToken, '') || 'top'

            $tip
                .detach()
                .css({ top: 0, left: 0, display: 'block' })
                .addClass(placement)
                .data('bs.' + this.type, this)

            this.options.container ? $tip.appendTo(this.options.container) : $tip.insertAfter(this.$element)
            this.$element.trigger('inserted.bs.' + this.type)

            var pos          = this.getPosition()
            var actualWidth  = $tip[0].offsetWidth
            var actualHeight = $tip[0].offsetHeight

            if (autoPlace) {
                var orgPlacement = placement
                var viewportDim = this.getPosition(this.$viewport)

                placement = placement == 'bottom' && pos.bottom + actualHeight > viewportDim.bottom ? 'top'    :
                    placement == 'top'    && pos.top    - actualHeight < viewportDim.top    ? 'bottom' :
                        placement == 'right'  && pos.right  + actualWidth  > viewportDim.width  ? 'left'   :
                            placement == 'left'   && pos.left   - actualWidth  < viewportDim.left   ? 'right'  :
                                placement

                $tip
                    .removeClass(orgPlacement)
                    .addClass(placement)
            }

            var calculatedOffset = this.getCalculatedOffset(placement, pos, actualWidth, actualHeight)

            this.applyPlacement(calculatedOffset, placement)

            var complete = function () {
                var prevHoverState = that.hoverState
                that.$element.trigger('shown.bs.' + that.type)
                that.hoverState = null

                if (prevHoverState == 'out') that.leave(that)
            }

            $.support.transition && this.$tip.hasClass('fade') ?
                $tip
                    .one('bsTransitionEnd', complete)
                    .emulateTransitionEnd(Tooltip.TRANSITION_DURATION) :
                complete()
        }
    }

    Tooltip.prototype.applyPlacement = function (offset, placement) {
        var $tip   = this.tip()
        var width  = $tip[0].offsetWidth
        var height = $tip[0].offsetHeight

        // manually read margins because getBoundingClientRect includes difference
        var marginTop = parseInt($tip.css('margin-top'), 10)
        var marginLeft = parseInt($tip.css('margin-left'), 10)

        // we must check for NaN for ie 8/9
        if (isNaN(marginTop))  marginTop  = 0
        if (isNaN(marginLeft)) marginLeft = 0

        offset.top  += marginTop
        offset.left += marginLeft

        // $.fn.offset doesn't round pixel values
        // so we use setOffset directly with our own function B-0
        $.offset.setOffset($tip[0], $.extend({
            using: function (props) {
                $tip.css({
                    top: Math.round(props.top),
                    left: Math.round(props.left)
                })
            }
        }, offset), 0)

        $tip.addClass('in')

        // check to see if placing tip in new offset caused the tip to resize itself
        var actualWidth  = $tip[0].offsetWidth
        var actualHeight = $tip[0].offsetHeight

        if (placement == 'top' && actualHeight != height) {
            offset.top = offset.top + height - actualHeight
        }

        var delta = this.getViewportAdjustedDelta(placement, offset, actualWidth, actualHeight)

        if (delta.left) offset.left += delta.left
        else offset.top += delta.top

        var isVertical          = /top|bottom/.test(placement)
        var arrowDelta          = isVertical ? delta.left * 2 - width + actualWidth : delta.top * 2 - height + actualHeight
        var arrowOffsetPosition = isVertical ? 'offsetWidth' : 'offsetHeight'

        $tip.offset(offset)
        this.replaceArrow(arrowDelta, $tip[0][arrowOffsetPosition], isVertical)
    }

    Tooltip.prototype.replaceArrow = function (delta, dimension, isVertical) {
        this.arrow()
            .css(isVertical ? 'left' : 'top', 50 * (1 - delta / dimension) + '%')
            .css(isVertical ? 'top' : 'left', '')
    }

    Tooltip.prototype.setContent = function () {
        var $tip  = this.tip()
        var title = this.getTitle()

        $tip.find('.tooltip-inner')[this.options.html ? 'html' : 'text'](title)
        $tip.removeClass('fade in top bottom left right')
    }

    Tooltip.prototype.hide = function (callback) {
        var that = this
        var $tip = $(this.$tip)
        var e    = $.Event('hide.bs.' + this.type)

        function complete() {
            if (that.hoverState != 'in') $tip.detach()
            that.$element
                .removeAttr('aria-describedby')
                .trigger('hidden.bs.' + that.type)
            callback && callback()
        }

        this.$element.trigger(e)

        if (e.isDefaultPrevented()) return

        $tip.removeClass('in')

        $.support.transition && $tip.hasClass('fade') ?
            $tip
                .one('bsTransitionEnd', complete)
                .emulateTransitionEnd(Tooltip.TRANSITION_DURATION) :
            complete()

        this.hoverState = null

        return this
    }

    Tooltip.prototype.fixTitle = function () {
        var $e = this.$element
        if ($e.attr('title') || typeof $e.attr('data-original-title') != 'string') {
            $e.attr('data-original-title', $e.attr('title') || '').attr('title', '')
        }
    }

    Tooltip.prototype.hasContent = function () {
        return this.getTitle()
    }

    Tooltip.prototype.getPosition = function ($element) {
        $element   = $element || this.$element

        var el     = $element[0]
        var isBody = el.tagName == 'BODY'

        var elRect    = el.getBoundingClientRect()
        if (elRect.width == null) {
            // width and height are missing in IE8, so compute them manually; see https://github.com/twbs/bootstrap/issues/14093
            elRect = $.extend({}, elRect, { width: elRect.right - elRect.left, height: elRect.bottom - elRect.top })
        }
        var elOffset  = isBody ? { top: 0, left: 0 } : $element.offset()
        var scroll    = { scroll: isBody ? document.documentElement.scrollTop || document.body.scrollTop : $element.scrollTop() }
        var outerDims = isBody ? { width: $(window).width(), height: $(window).height() } : null

        return $.extend({}, elRect, scroll, outerDims, elOffset)
    }

    Tooltip.prototype.getCalculatedOffset = function (placement, pos, actualWidth, actualHeight) {
        return placement == 'bottom' ? { top: pos.top + pos.height,   left: pos.left + pos.width / 2 - actualWidth / 2 } :
            placement == 'top'    ? { top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2 } :
                placement == 'left'   ? { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth } :
                    /* placement == 'right' */ { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width }

    }

    Tooltip.prototype.getViewportAdjustedDelta = function (placement, pos, actualWidth, actualHeight) {
        var delta = { top: 0, left: 0 }
        if (!this.$viewport) return delta

        var viewportPadding = this.options.viewport && this.options.viewport.padding || 0
        var viewportDimensions = this.getPosition(this.$viewport)

        if (/right|left/.test(placement)) {
            var topEdgeOffset    = pos.top - viewportPadding - viewportDimensions.scroll
            var bottomEdgeOffset = pos.top + viewportPadding - viewportDimensions.scroll + actualHeight
            if (topEdgeOffset < viewportDimensions.top) { // top overflow
                delta.top = viewportDimensions.top - topEdgeOffset
            } else if (bottomEdgeOffset > viewportDimensions.top + viewportDimensions.height) { // bottom overflow
                delta.top = viewportDimensions.top + viewportDimensions.height - bottomEdgeOffset
            }
        } else {
            var leftEdgeOffset  = pos.left - viewportPadding
            var rightEdgeOffset = pos.left + viewportPadding + actualWidth
            if (leftEdgeOffset < viewportDimensions.left) { // left overflow
                delta.left = viewportDimensions.left - leftEdgeOffset
            } else if (rightEdgeOffset > viewportDimensions.right) { // right overflow
                delta.left = viewportDimensions.left + viewportDimensions.width - rightEdgeOffset
            }
        }

        return delta
    }

    Tooltip.prototype.getTitle = function () {
        var title
        var $e = this.$element
        var o  = this.options

        title = $e.attr('data-original-title')
            || (typeof o.title == 'function' ? o.title.call($e[0]) :  o.title)

        return title
    }

    Tooltip.prototype.getUID = function (prefix) {
        do prefix += ~~(Math.random() * 1000000)
        while (document.getElementById(prefix))
        return prefix
    }

    Tooltip.prototype.tip = function () {
        if (!this.$tip) {
            this.$tip = $(this.options.template)
            if (this.$tip.length != 1) {
                throw new Error(this.type + ' `template` option must consist of exactly 1 top-level element!')
            }
        }
        return this.$tip
    }

    Tooltip.prototype.arrow = function () {
        return (this.$arrow = this.$arrow || this.tip().find('.tooltip-arrow'))
    }

    Tooltip.prototype.enable = function () {
        this.enabled = true
    }

    Tooltip.prototype.disable = function () {
        this.enabled = false
    }

    Tooltip.prototype.toggleEnabled = function () {
        this.enabled = !this.enabled
    }

    Tooltip.prototype.toggle = function (e) {
        var self = this
        if (e) {
            self = $(e.currentTarget).data('bs.' + this.type)
            if (!self) {
                self = new this.constructor(e.currentTarget, this.getDelegateOptions())
                $(e.currentTarget).data('bs.' + this.type, self)
            }
        }

        if (e) {
            self.inState.click = !self.inState.click
            if (self.isInStateTrue()) self.enter(self)
            else self.leave(self)
        } else {
            self.tip().hasClass('in') ? self.leave(self) : self.enter(self)
        }
    }

    Tooltip.prototype.destroy = function () {
        var that = this
        clearTimeout(this.timeout)
        this.hide(function () {
            that.$element.off('.' + that.type).removeData('bs.' + that.type)
            if (that.$tip) {
                that.$tip.detach()
            }
            that.$tip = null
            that.$arrow = null
            that.$viewport = null
        })
    }


    // TOOLTIP PLUGIN DEFINITION
    // =========================

    function Plugin(option) {
        return this.each(function () {
            var $this   = $(this)
            var data    = $this.data('bs.tooltip')
            var options = typeof option == 'object' && option

            if (!data && /destroy|hide/.test(option)) return
            if (!data) $this.data('bs.tooltip', (data = new Tooltip(this, options)))
            if (typeof option == 'string') data[option]()
        })
    }

    var old = $.fn.tooltip

    $.fn.tooltip             = Plugin
    $.fn.tooltip.Constructor = Tooltip


    // TOOLTIP NO CONFLICT
    // ===================

    $.fn.tooltip.noConflict = function () {
        $.fn.tooltip = old
        return this
    }

}(jQuery);

/* ========================================================================
 * Bootstrap: popover.js v3.3.5
 * http://getbootstrap.com/javascript/#popovers
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';

    // POPOVER PUBLIC CLASS DEFINITION
    // ===============================

    var Popover = function (element, options) {
        this.init('popover', element, options)
    }

    if (!$.fn.tooltip) throw new Error('Popover requires tooltip.js')

    Popover.VERSION  = '3.3.5'

    Popover.DEFAULTS = $.extend({}, $.fn.tooltip.Constructor.DEFAULTS, {
        placement: 'right',
        trigger: 'click',
        content: '',
        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    })


    // NOTE: POPOVER EXTENDS tooltip.js
    // ================================

    Popover.prototype = $.extend({}, $.fn.tooltip.Constructor.prototype)

    Popover.prototype.constructor = Popover

    Popover.prototype.getDefaults = function () {
        return Popover.DEFAULTS
    }

    Popover.prototype.setContent = function () {
        var $tip    = this.tip()
        var title   = this.getTitle()
        var content = this.getContent()

        $tip.find('.popover-title')[this.options.html ? 'html' : 'text'](title)
        $tip.find('.popover-content').children().detach().end()[ // we use append for html objects to maintain js events
            this.options.html ? (typeof content == 'string' ? 'html' : 'append') : 'text'
            ](content)

        $tip.removeClass('fade top bottom left right in')

        // IE8 doesn't accept hiding via the `:empty` pseudo selector, we have to do
        // this manually by checking the contents.
        if (!$tip.find('.popover-title').html()) $tip.find('.popover-title').hide()
    }

    Popover.prototype.hasContent = function () {
        return this.getTitle() || this.getContent()
    }

    Popover.prototype.getContent = function () {
        var $e = this.$element
        var o  = this.options

        return $e.attr('data-content')
            || (typeof o.content == 'function' ?
                o.content.call($e[0]) :
                o.content)
    }

    Popover.prototype.arrow = function () {
        return (this.$arrow = this.$arrow || this.tip().find('.arrow'))
    }


    // POPOVER PLUGIN DEFINITION
    // =========================

    function Plugin(option) {
        return this.each(function () {
            var $this   = $(this)
            var data    = $this.data('bs.popover')
            var options = typeof option == 'object' && option

            if (!data && /destroy|hide/.test(option)) return
            if (!data) $this.data('bs.popover', (data = new Popover(this, options)))
            if (typeof option == 'string') data[option]()
        })
    }

    var old = $.fn.popover

    $.fn.popover             = Plugin
    $.fn.popover.Constructor = Popover


    // POPOVER NO CONFLICT
    // ===================

    $.fn.popover.noConflict = function () {
        $.fn.popover = old
        return this
    }

}(jQuery);

/* ========================================================================
 * Bootstrap: tab.js v3.3.5
 * http://getbootstrap.com/javascript/#tabs
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';

    // TAB CLASS DEFINITION
    // ====================

    var Tab = function (element) {
        // jscs:disable requireDollarBeforejQueryAssignment
        this.element = $(element)
        // jscs:enable requireDollarBeforejQueryAssignment
    }

    Tab.VERSION = '3.3.5'

    Tab.TRANSITION_DURATION = 150

    Tab.prototype.show = function () {
        var $this    = this.element
        var $ul      = $this.closest('ul:not(.dropdown-menu)')
        var selector = $this.data('target')

        if (!selector) {
            selector = $this.attr('href')
            selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
        }

        if ($this.parent('li').hasClass('active')) return

        var $previous = $ul.find('.active:last a')
        var hideEvent = $.Event('hide.bs.tab', {
            relatedTarget: $this[0]
        })
        var showEvent = $.Event('show.bs.tab', {
            relatedTarget: $previous[0]
        })

        $previous.trigger(hideEvent)
        $this.trigger(showEvent)

        if (showEvent.isDefaultPrevented() || hideEvent.isDefaultPrevented()) return

        var $target = $(selector)

        this.activate($this.closest('li'), $ul)
        this.activate($target, $target.parent(), function () {
            $previous.trigger({
                type: 'hidden.bs.tab',
                relatedTarget: $this[0]
            })
            $this.trigger({
                type: 'shown.bs.tab',
                relatedTarget: $previous[0]
            })
        })
    }

    Tab.prototype.activate = function (element, container, callback) {
        var $active    = container.find('> .active')
        var transition = callback
            && $.support.transition
            && ($active.length && $active.hasClass('fade') || !!container.find('> .fade').length)

        function next() {
            $active
                .removeClass('active')
                .find('> .dropdown-menu > .active')
                .removeClass('active')
                .end()
                .find('[data-toggle="tab"]')
                .attr('aria-expanded', false)

            element
                .addClass('active')
                .find('[data-toggle="tab"]')
                .attr('aria-expanded', true)

            if (transition) {
                element[0].offsetWidth // reflow for transition
                element.addClass('in')
            } else {
                element.removeClass('fade')
            }

            if (element.parent('.dropdown-menu').length) {
                element
                    .closest('li.dropdown')
                    .addClass('active')
                    .end()
                    .find('[data-toggle="tab"]')
                    .attr('aria-expanded', true)
            }

            callback && callback()
        }

        $active.length && transition ?
            $active
                .one('bsTransitionEnd', next)
                .emulateTransitionEnd(Tab.TRANSITION_DURATION) :
            next()

        $active.removeClass('in')
    }


    // TAB PLUGIN DEFINITION
    // =====================

    function Plugin(option) {
        return this.each(function () {
            var $this = $(this)
            var data  = $this.data('bs.tab')

            if (!data) $this.data('bs.tab', (data = new Tab(this)))
            if (typeof option == 'string') data[option]()
        })
    }

    var old = $.fn.tab

    $.fn.tab             = Plugin
    $.fn.tab.Constructor = Tab


    // TAB NO CONFLICT
    // ===============

    $.fn.tab.noConflict = function () {
        $.fn.tab = old
        return this
    }


    // TAB DATA-API
    // ============

    var clickHandler = function (e) {
        e.preventDefault()
        Plugin.call($(this), 'show')
    }

    $(document)
        .on('click.bs.tab.data-api', '[data-toggle="tab"]', clickHandler)
        .on('click.bs.tab.data-api', '[data-toggle="pill"]', clickHandler)

}(jQuery);

/* ========================================================================
 * Bootstrap: collapse.js v3.3.5
 * http://getbootstrap.com/javascript/#collapse
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';

    // COLLAPSE PUBLIC CLASS DEFINITION
    // ================================

    var Collapse = function (element, options) {
        this.$element      = $(element)
        this.options       = $.extend({}, Collapse.DEFAULTS, options)
        this.$trigger      = $('[data-toggle="collapse"][href="#' + element.id + '"],' +
            '[data-toggle="collapse"][data-target="#' + element.id + '"]')
        this.transitioning = null

        if (this.options.parent) {
            this.$parent = this.getParent()
        } else {
            this.addAriaAndCollapsedClass(this.$element, this.$trigger)
        }

        if (this.options.toggle) this.toggle()
    }

    Collapse.VERSION  = '3.3.5'

    Collapse.TRANSITION_DURATION = 350

    Collapse.DEFAULTS = {
        toggle: true
    }

    Collapse.prototype.dimension = function () {
        var hasWidth = this.$element.hasClass('width')
        return hasWidth ? 'width' : 'height'
    }

    Collapse.prototype.show = function () {
        if (this.transitioning || this.$element.hasClass('in')) return

        var activesData
        var actives = this.$parent && this.$parent.children('.panel').children('.in, .collapsing')

        if (actives && actives.length) {
            activesData = actives.data('bs.collapse')
            if (activesData && activesData.transitioning) return
        }

        var startEvent = $.Event('show.bs.collapse')
        this.$element.trigger(startEvent)
        if (startEvent.isDefaultPrevented()) return

        if (actives && actives.length) {
            Plugin.call(actives, 'hide')
            activesData || actives.data('bs.collapse', null)
        }

        var dimension = this.dimension()

        this.$element
            .removeClass('collapse')
            .addClass('collapsing')[dimension](0)
            .attr('aria-expanded', true)

        this.$trigger
            .removeClass('collapsed')
            .attr('aria-expanded', true)

        this.transitioning = 1

        var complete = function () {
            this.$element
                .removeClass('collapsing')
                .addClass('collapse in')[dimension]('')
            this.transitioning = 0
            this.$element
                .trigger('shown.bs.collapse')
        }

        if (!$.support.transition) return complete.call(this)

        var scrollSize = $.camelCase(['scroll', dimension].join('-'))

        this.$element
            .one('bsTransitionEnd', $.proxy(complete, this))
            .emulateTransitionEnd(Collapse.TRANSITION_DURATION)[dimension](this.$element[0][scrollSize])
    }

    Collapse.prototype.hide = function () {
        if (this.transitioning || !this.$element.hasClass('in')) return

        var startEvent = $.Event('hide.bs.collapse')
        this.$element.trigger(startEvent)
        if (startEvent.isDefaultPrevented()) return

        var dimension = this.dimension()

        this.$element[dimension](this.$element[dimension]())[0].offsetHeight

        this.$element
            .addClass('collapsing')
            .removeClass('collapse in')
            .attr('aria-expanded', false)

        this.$trigger
            .addClass('collapsed')
            .attr('aria-expanded', false)

        this.transitioning = 1

        var complete = function () {
            this.transitioning = 0
            this.$element
                .removeClass('collapsing')
                .addClass('collapse')
                .trigger('hidden.bs.collapse')
        }

        if (!$.support.transition) return complete.call(this)

        this.$element
            [dimension](0)
            .one('bsTransitionEnd', $.proxy(complete, this))
            .emulateTransitionEnd(Collapse.TRANSITION_DURATION)
    }

    Collapse.prototype.toggle = function () {
        this[this.$element.hasClass('in') ? 'hide' : 'show']()
    }

    Collapse.prototype.getParent = function () {
        return $(this.options.parent)
            .find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]')
            .each($.proxy(function (i, element) {
                var $element = $(element)
                this.addAriaAndCollapsedClass(getTargetFromTrigger($element), $element)
            }, this))
            .end()
    }

    Collapse.prototype.addAriaAndCollapsedClass = function ($element, $trigger) {
        var isOpen = $element.hasClass('in')

        $element.attr('aria-expanded', isOpen)
        $trigger
            .toggleClass('collapsed', !isOpen)
            .attr('aria-expanded', isOpen)
    }

    function getTargetFromTrigger($trigger) {
        var href
        var target = $trigger.attr('data-target')
            || (href = $trigger.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '') // strip for ie7

        return $(target)
    }


    // COLLAPSE PLUGIN DEFINITION
    // ==========================

    function Plugin(option) {
        return this.each(function () {
            var $this   = $(this)
            var data    = $this.data('bs.collapse')
            var options = $.extend({}, Collapse.DEFAULTS, $this.data(), typeof option == 'object' && option)

            if (!data && options.toggle && /show|hide/.test(option)) options.toggle = false
            if (!data) $this.data('bs.collapse', (data = new Collapse(this, options)))
            if (typeof option == 'string') data[option]()
        })
    }

    var old = $.fn.collapse

    $.fn.collapse             = Plugin
    $.fn.collapse.Constructor = Collapse


    // COLLAPSE NO CONFLICT
    // ====================

    $.fn.collapse.noConflict = function () {
        $.fn.collapse = old
        return this
    }


    // COLLAPSE DATA-API
    // =================

    $(document).on('click.bs.collapse.data-api', '[data-toggle="collapse"]', function (e) {
        var $this   = $(this)

        if (!$this.attr('data-target')) e.preventDefault()

        var $target = getTargetFromTrigger($this)
        var data    = $target.data('bs.collapse')
        var option  = data ? 'toggle' : $this.data()

        Plugin.call($target, option)
    })

}(jQuery);

/* ========================================================================
 * Bootstrap: transition.js v3.3.5
 * http://getbootstrap.com/javascript/#transitions
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';

    // CSS TRANSITION SUPPORT (Shoutout: http://www.modernizr.com/)
    // ============================================================

    function transitionEnd() {
        var el = document.createElement('bootstrap')

        var transEndEventNames = {
            WebkitTransition : 'webkitTransitionEnd',
            MozTransition    : 'transitionend',
            OTransition      : 'oTransitionEnd otransitionend',
            transition       : 'transitionend'
        }

        for (var name in transEndEventNames) {
            if (el.style[name] !== undefined) {
                return { end: transEndEventNames[name] }
            }
        }

        return false // explicit for ie8 (  ._.)
    }

    // http://blog.alexmaccaw.com/css-transitions
    $.fn.emulateTransitionEnd = function (duration) {
        var called = false
        var $el = this
        $(this).one('bsTransitionEnd', function () { called = true })
        var callback = function () { if (!called) $($el).trigger($.support.transition.end) }
        setTimeout(callback, duration)
        return this
    }

    $(function () {
        $.support.transition = transitionEnd()

        if (!$.support.transition) return

        $.event.special.bsTransitionEnd = {
            bindType: $.support.transition.end,
            delegateType: $.support.transition.end,
            handle: function (e) {
                if ($(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
            }
        }
    })

}(jQuery);


// END OF BOOTSTRAP BASE

/*
 * Project: Bootstrap Notify = v3.1.3
 * Description: Turns standard Bootstrap alerts into "Growl-like" notifications.
 * Author: Mouse0270 aka Robert McIntosh
 * License: MIT License
 * Website: https://github.com/mouse0270/bootstrap-growl
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS
        factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {
    // Create the defaults once
    var defaults = {
        element: 'body',
        position: null,
        type: "info",
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: "top",
            align: "right"
        },
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0}" role="alert"><button type="button" aria-hidden="true" class="close" data-notify="dismiss">&times;</button><span data-notify="icon"></span> <span data-notify="title">{1}</span> <span data-notify="message">{2}</span><div class="progress" data-notify="progressbar"><div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div><a href="{3}" target="{4}" data-notify="url"></a></div>'
    };

    String.format = function() {
        var str = arguments[0];
        for (var i = 1; i < arguments.length; i++) {
            str = str.replace(RegExp("\\{" + (i - 1) + "\\}", "gm"), arguments[i]);
        }
        return str;
    };

    function Notify ( element, content, options ) {
        // Setup Content of Notify
        var content = {
            content: {
                message: typeof content == 'object' ? content.message : content,
                title: content.title ? content.title : '',
                icon: content.icon ? content.icon : '',
                url: content.url ? content.url : '#',
                target: content.target ? content.target : '-'
            }
        };

        options = $.extend(true, {}, content, options);
        this.settings = $.extend(true, {}, defaults, options);
        this._defaults = defaults;
        if (this.settings.content.target == "-") {
            this.settings.content.target = this.settings.url_target;
        }
        this.animations = {
            start: 'webkitAnimationStart oanimationstart MSAnimationStart animationstart',
            end: 'webkitAnimationEnd oanimationend MSAnimationEnd animationend'
        }

        if (typeof this.settings.offset == 'number') {
            this.settings.offset = {
                x: this.settings.offset,
                y: this.settings.offset
            };
        }

        this.init();
    };

    $.extend(Notify.prototype, {
        init: function () {
            var self = this;

            this.buildNotify();
            if (this.settings.content.icon) {
                this.setIcon();
            }
            if (this.settings.content.url != "#") {
                this.styleURL();
            }
            this.styleDismiss();
            this.placement();
            this.bind();

            this.notify = {
                $ele: this.$ele,
                update: function(command, update) {
                    var commands = {};
                    if (typeof command == "string") {
                        commands[command] = update;
                    }else{
                        commands = command;
                    }
                    for (var command in commands) {
                        switch (command) {
                            case "type":
                                this.$ele.removeClass('alert-' + self.settings.type);
                                this.$ele.find('[data-notify="progressbar"] > .progress-bar').removeClass('progress-bar-' + self.settings.type);
                                self.settings.type = commands[command];
                                this.$ele.addClass('alert-' + commands[command]).find('[data-notify="progressbar"] > .progress-bar').addClass('progress-bar-' + commands[command]);
                                break;
                            case "icon":
                                var $icon = this.$ele.find('[data-notify="icon"]');
                                if (self.settings.icon_type.toLowerCase() == 'class') {
                                    $icon.removeClass(self.settings.content.icon).addClass(commands[command]);
                                }else{
                                    if (!$icon.is('img')) {
                                        $icon.find('img');
                                    }
                                    $icon.attr('src', commands[command]);
                                }
                                break;
                            case "progress":
                                var newDelay = self.settings.delay - (self.settings.delay * (commands[command] / 100));
                                this.$ele.data('notify-delay', newDelay);
                                this.$ele.find('[data-notify="progressbar"] > div').attr('aria-valuenow', commands[command]).css('width', commands[command] + '%');
                                break;
                            case "url":
                                this.$ele.find('[data-notify="url"]').attr('href', commands[command]);
                                break;
                            case "target":
                                this.$ele.find('[data-notify="url"]').attr('target', commands[command]);
                                break;
                            default:
                                this.$ele.find('[data-notify="' + command +'"]').html(commands[command]);
                        };
                    }
                    var posX = this.$ele.outerHeight() + parseInt(self.settings.spacing) + parseInt(self.settings.offset.y);
                    self.reposition(posX);
                },
                close: function() {
                    self.close();
                }
            };
        },
        buildNotify: function () {
            var content = this.settings.content;
            this.$ele = $(String.format(this.settings.template, this.settings.type, content.title, content.message, content.url, content.target));
            this.$ele.attr('data-notify-position', this.settings.placement.from + '-' + this.settings.placement.align);
            if (!this.settings.allow_dismiss) {
                this.$ele.find('[data-notify="dismiss"]').css('display', 'none');
            }
            if ((this.settings.delay <= 0 && !this.settings.showProgressbar) || !this.settings.showProgressbar) {
                this.$ele.find('[data-notify="progressbar"]').remove();
            }
        },
        setIcon: function() {
            if (this.settings.icon_type.toLowerCase() == 'class') {
                this.$ele.find('[data-notify="icon"]').addClass(this.settings.content.icon);
            }else{
                if (this.$ele.find('[data-notify="icon"]').is('img')) {
                    this.$ele.find('[data-notify="icon"]').attr('src', this.settings.content.icon);
                }else{
                    this.$ele.find('[data-notify="icon"]').append('<img src="'+this.settings.content.icon+'" alt="Notify Icon" />');
                }
            }
        },
        styleDismiss: function() {
            this.$ele.find('[data-notify="dismiss"]').css({
                position: 'absolute',
                right: '10px',
                top: '5px',
                zIndex: this.settings.z_index + 2
            });
        },
        styleURL: function() {
            this.$ele.find('[data-notify="url"]').css({
                backgroundImage: 'url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7)',
                height: '100%',
                left: '0px',
                position: 'absolute',
                top: '0px',
                width: '100%',
                zIndex: this.settings.z_index + 1
            });
        },
        placement: function() {
            var self = this,
                offsetAmt = this.settings.offset.y,
                css = {
                    display: 'inline-block',
                    margin: '0px auto',
                    position: this.settings.position ?  this.settings.position : (this.settings.element === 'body' ? 'fixed' : 'absolute'),
                    transition: 'all .5s ease-in-out',
                    zIndex: this.settings.z_index
                },
                hasAnimation = false,
                settings = this.settings;

            $('[data-notify-position="' + this.settings.placement.from + '-' + this.settings.placement.align + '"]:not([data-closing="true"])').each(function() {
                return offsetAmt = Math.max(offsetAmt, parseInt($(this).css(settings.placement.from)) +  parseInt($(this).outerHeight()) +  parseInt(settings.spacing));
            });
            if (this.settings.newest_on_top == true) {
                offsetAmt = this.settings.offset.y;
            }
            css[this.settings.placement.from] = offsetAmt+'px';

            switch (this.settings.placement.align) {
                case "left":
                case "right":
                    css[this.settings.placement.align] = this.settings.offset.x+'px';
                    break;
                case "center":
                    css.left = 0;
                    css.right = 0;
                    break;
            }
            this.$ele.css(css).addClass(this.settings.animate.enter);
            $.each(Array('webkit-', 'moz-', 'o-', 'ms-', ''), function(index, prefix) {
                self.$ele[0].style[prefix+'AnimationIterationCount'] = 1;
            });

            $(this.settings.element).append(this.$ele);

            if (this.settings.newest_on_top == true) {
                offsetAmt = (parseInt(offsetAmt)+parseInt(this.settings.spacing)) + this.$ele.outerHeight();
                this.reposition(offsetAmt);
            }

            if ($.isFunction(self.settings.onShow)) {
                self.settings.onShow.call(this.$ele);
            }

            this.$ele.one(this.animations.start, function(event) {
                hasAnimation = true;
            }).one(this.animations.end, function(event) {
                if ($.isFunction(self.settings.onShown)) {
                    self.settings.onShown.call(this);
                }
            });

            setTimeout(function() {
                if (!hasAnimation) {
                    if ($.isFunction(self.settings.onShown)) {
                        self.settings.onShown.call(this);
                    }
                }
            }, 600);
        },
        bind: function() {
            var self = this;

            this.$ele.find('[data-notify="dismiss"]').on('click', function() {
                self.close();
            })

            this.$ele.mouseover(function(e) {
                $(this).data('data-hover', "true");
            }).mouseout(function(e) {
                $(this).data('data-hover', "false");
            });
            this.$ele.data('data-hover', "false");

            if (this.settings.delay > 0) {
                self.$ele.data('notify-delay', self.settings.delay);
                var timer = setInterval(function() {
                    var delay = parseInt(self.$ele.data('notify-delay')) - self.settings.timer;
                    if ((self.$ele.data('data-hover') === 'false' && self.settings.mouse_over == "pause") || self.settings.mouse_over != "pause") {
                        var percent = ((self.settings.delay - delay) / self.settings.delay) * 100;
                        self.$ele.data('notify-delay', delay);
                        self.$ele.find('[data-notify="progressbar"] > div').attr('aria-valuenow', percent).css('width', percent + '%');
                    }
                    if (delay <= -(self.settings.timer)) {
                        clearInterval(timer);
                        self.close();
                    }
                }, self.settings.timer);
            }
        },
        close: function() {
            var self = this,
                $successors = null,
                posX = parseInt(this.$ele.css(this.settings.placement.from)),
                hasAnimation = false;

            this.$ele.data('closing', 'true').addClass(this.settings.animate.exit);
            self.reposition(posX);

            if ($.isFunction(self.settings.onClose)) {
                self.settings.onClose.call(this.$ele);
            }

            this.$ele.one(this.animations.start, function(event) {
                hasAnimation = true;
            }).one(this.animations.end, function(event) {
                $(this).remove();
                if ($.isFunction(self.settings.onClosed)) {
                    self.settings.onClosed.call(this);
                }
            });

            setTimeout(function() {
                if (!hasAnimation) {
                    self.$ele.remove();
                    if (self.settings.onClosed) {
                        self.settings.onClosed(self.$ele);
                    }
                }
            }, 600);
        },
        reposition: function(posX) {
            var self = this,
                notifies = '[data-notify-position="' + this.settings.placement.from + '-' + this.settings.placement.align + '"]:not([data-closing="true"])',
                $elements = this.$ele.nextAll(notifies);
            if (this.settings.newest_on_top == true) {
                $elements = this.$ele.prevAll(notifies);
            }
            $elements.each(function() {
                $(this).css(self.settings.placement.from, posX);
                posX = (parseInt(posX)+parseInt(self.settings.spacing)) + $(this).outerHeight();
            });
        }
    });

    $.notify = function ( content, options ) {
        var plugin = new Notify( this, content, options );
        return plugin.notify;
    };
    $.notifyDefaults = function( options ) {
        defaults = $.extend(true, {}, defaults, options);
        return defaults;
    };
    $.notifyClose = function( command ) {
        if (typeof command === "undefined" || command == "all") {
            $('[data-notify]').find('[data-notify="dismiss"]').trigger('click');
        }else{
            $('[data-notify-position="'+command+'"]').find('[data-notify="dismiss"]').trigger('click');
        }
    };

}));

/* ===================================================
 * bootstrap-markdown.js v2.9.0
 * http://github.com/toopay/bootstrap-markdown
 * ===================================================
 * Copyright 2013-2015 Taufan Aditya
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */

!function ($) {

    "use strict"; // jshint ;_;

    /* MARKDOWN CLASS DEFINITION
     * ========================== */

    var Markdown = function (element, options) {
        // @TODO : remove this BC on next major release
        // @see : https://github.com/toopay/bootstrap-markdown/issues/109
        var opts = ['autofocus', 'savable', 'hideable', 'width',
            'height', 'resize', 'iconlibrary', 'language',
            'footer', 'fullscreen', 'hiddenButtons', 'disabledButtons'];
        $.each(opts,function(_, opt){
            if (typeof $(element).data(opt) !== 'undefined') {
                options = typeof options == 'object' ? options : {}
                options[opt] = $(element).data(opt)
            }
        });
        // End BC

        // Class Properties
        this.$ns           = 'bootstrap-markdown';
        this.$element      = $(element);
        this.$editable     = {el:null, type:null,attrKeys:[], attrValues:[], content:null};
        this.$options      = $.extend(true, {}, $.fn.markdown.defaults, options, this.$element.data('options'));
        this.$oldContent   = null;
        this.$isPreview    = false;
        this.$isFullscreen = false;
        this.$editor       = null;
        this.$textarea     = null;
        this.$handler      = [];
        this.$callback     = [];
        this.$nextTab      = [];

        this.showEditor();
    };

    Markdown.prototype = {

        constructor: Markdown

        , __alterButtons: function(name,alter) {
            var handler = this.$handler, isAll = (name == 'all'),that = this;

            $.each(handler,function(k,v) {
                var halt = true;
                if (isAll) {
                    halt = false;
                } else {
                    halt = v.indexOf(name) < 0;
                }

                if (halt === false) {
                    alter(that.$editor.find('button[data-handler="'+v+'"]'));
                }
            });
        }

        , __buildButtons: function(buttonsArray, container) {
            var i,
                ns = this.$ns,
                handler = this.$handler,
                callback = this.$callback;

            for (i=0;i<buttonsArray.length;i++) {
                // Build each group container
                var y, btnGroups = buttonsArray[i];
                for (y=0;y<btnGroups.length;y++) {
                    // Build each button group
                    var z,
                        buttons = btnGroups[y].data,
                        btnGroupContainer = $('<div/>', {
                            'class': 'btn-group'
                        });

                    for (z=0;z<buttons.length;z++) {
                        var button = buttons[z],
                            buttonContainer, buttonIconContainer,
                            buttonHandler = ns+'-'+button.name,
                            buttonIcon = this.__getIcon(button.icon),
                            btnText = button.btnText ? button.btnText : '',
                            btnClass = button.btnClass ? button.btnClass : 'btn',
                            tabIndex = button.tabIndex ? button.tabIndex : '-1',
                            hotkey = typeof button.hotkey !== 'undefined' ? button.hotkey : '',
                            hotkeyCaption = typeof jQuery.hotkeys !== 'undefined' && hotkey !== '' ? ' ('+hotkey+')' : '';

                        // Construct the button object
                        buttonContainer = $('<button></button>');
                        buttonContainer.text(' ' + this.__localize(btnText)).addClass('btn-default btn-sm').addClass(btnClass);
                        if(btnClass.match(/btn\-(primary|success|info|warning|danger|link)/)){
                            buttonContainer.removeClass('btn-default');
                        }
                        buttonContainer.attr({
                            'type': 'button',
                            'title': this.__localize(button.title) + hotkeyCaption,
                            'tabindex': tabIndex,
                            'data-provider': ns,
                            'data-handler': buttonHandler,
                            'data-hotkey': hotkey
                        });
                        if (button.toggle === true){
                            buttonContainer.attr('data-toggle', 'button');
                        }
                        buttonIconContainer = $('<span/>');
                        buttonIconContainer.addClass(buttonIcon);
                        buttonIconContainer.prependTo(buttonContainer);

                        // Attach the button object
                        btnGroupContainer.append(buttonContainer);

                        // Register handler and callback
                        handler.push(buttonHandler);
                        callback.push(button.callback);
                    }

                    // Attach the button group into container dom
                    container.append(btnGroupContainer);
                }
            }

            return container;
        }
        , __setListener: function() {
            // Set size and resizable Properties
            var hasRows = typeof this.$textarea.attr('rows') !== 'undefined',
                maxRows = this.$textarea.val().split("\n").length > 5 ? this.$textarea.val().split("\n").length : '5',
                rowsVal = hasRows ? this.$textarea.attr('rows') : maxRows;

            this.$textarea.attr('rows',rowsVal);
            if (this.$options.resize) {
                this.$textarea.css('resize',this.$options.resize);
            }

            this.$textarea
                .on('focus',    $.proxy(this.focus, this))
                .on('keypress', $.proxy(this.keypress, this))
                .on('keyup',    $.proxy(this.keyup, this))
                .on('change',   $.proxy(this.change, this))
                .on('select',   $.proxy(this.select, this));

            if (this.eventSupported('keydown')) {
                this.$textarea.on('keydown', $.proxy(this.keydown, this));
            }

            // Re-attach markdown data
            this.$textarea.data('markdown',this);
        }

        , __handle: function(e) {
            var target = $(e.currentTarget),
                handler = this.$handler,
                callback = this.$callback,
                handlerName = target.attr('data-handler'),
                callbackIndex = handler.indexOf(handlerName),
                callbackHandler = callback[callbackIndex];

            // Trigger the focusin
            $(e.currentTarget).focus();

            callbackHandler(this);

            // Trigger onChange for each button handle
            this.change(this);

            // Unless it was the save handler,
            // focusin the textarea
            if (handlerName.indexOf('cmdSave') < 0) {
                this.$textarea.focus();
            }

            e.preventDefault();
        }

        , __localize: function(string) {
            var messages = $.fn.markdown.messages,
                language = this.$options.language;
            if (
                typeof messages !== 'undefined' &&
                typeof messages[language] !== 'undefined' &&
                typeof messages[language][string] !== 'undefined'
            ) {
                return messages[language][string];
            }
            return string;
        }

        , __getIcon: function(src) {
            return typeof src == 'object' ? src[this.$options.iconlibrary] : src;
        }

        , setFullscreen: function(mode) {
            var $editor = this.$editor,
                $textarea = this.$textarea;

            if (mode === true) {
                $editor.addClass('md-fullscreen-mode');
                $('body').addClass('md-nooverflow');
                this.$options.onFullscreen(this);
            } else {
                $editor.removeClass('md-fullscreen-mode');
                $('body').removeClass('md-nooverflow');

                if (this.$isPreview == true) this.hidePreview().showPreview()
            }

            this.$isFullscreen = mode;
            $textarea.focus();
        }

        , showEditor: function() {
            var instance = this,
                textarea,
                ns = this.$ns,
                container = this.$element,
                originalHeigth = container.css('height'),
                originalWidth = container.css('width'),
                editable = this.$editable,
                handler = this.$handler,
                callback = this.$callback,
                options = this.$options,
                editor = $( '<div/>', {
                    'class': 'md-editor',
                    click: function() {
                        instance.focus();
                    }
                });

            // Prepare the editor
            if (this.$editor === null) {
                // Create the panel
                var editorHeader = $('<div/>', {
                    'class': 'md-header btn-toolbar'
                });

                // Merge the main & additional button groups together
                var allBtnGroups = [];
                if (options.buttons.length > 0) allBtnGroups = allBtnGroups.concat(options.buttons[0]);
                if (options.additionalButtons.length > 0) allBtnGroups = allBtnGroups.concat(options.additionalButtons[0]);

                // Reduce and/or reorder the button groups
                if (options.reorderButtonGroups.length > 0) {
                    allBtnGroups = allBtnGroups
                        .filter(function(btnGroup) {
                            return options.reorderButtonGroups.indexOf(btnGroup.name) > -1;
                        })
                        .sort(function(a, b) {
                            if (options.reorderButtonGroups.indexOf(a.name) < options.reorderButtonGroups.indexOf(b.name)) return -1;
                            if (options.reorderButtonGroups.indexOf(a.name) > options.reorderButtonGroups.indexOf(b.name)) return 1;
                            return 0;
                        });
                }

                // Build the buttons
                if (allBtnGroups.length > 0) {
                    editorHeader = this.__buildButtons([allBtnGroups], editorHeader);
                }

                if (options.fullscreen.enable) {
                    editorHeader.append('<div class="md-controls"><a class="md-control md-control-fullscreen" href="#"><span class="'+this.__getIcon(options.fullscreen.icons.fullscreenOn)+'"></span></a></div>').on('click', '.md-control-fullscreen', function(e) {
                        e.preventDefault();
                        instance.setFullscreen(true);
                    });
                }

                editor.append(editorHeader);

                // Wrap the textarea
                if (container.is('textarea')) {
                    container.before(editor);
                    textarea = container;
                    textarea.addClass('md-input');
                    editor.append(textarea);
                } else {
                    var rawContent = (typeof toMarkdown == 'function') ? toMarkdown(container.html()) : container.html(),
                        currentContent = $.trim(rawContent);

                    // This is some arbitrary content that could be edited
                    textarea = $('<textarea/>', {
                        'class': 'md-input',
                        'val' : currentContent
                    });

                    editor.append(textarea);

                    // Save the editable
                    editable.el = container;
                    editable.type = container.prop('tagName').toLowerCase();
                    editable.content = container.html();

                    $(container[0].attributes).each(function(){
                        editable.attrKeys.push(this.nodeName);
                        editable.attrValues.push(this.nodeValue);
                    });

                    // Set editor to blocked the original container
                    container.replaceWith(editor);
                }

                var editorFooter = $('<div/>', {
                        'class': 'md-footer'
                    }),
                    createFooter = false,
                    footer = '';
                // Create the footer if savable
                if (options.savable) {
                    createFooter = true;
                    var saveHandler = 'cmdSave';

                    // Register handler and callback
                    handler.push(saveHandler);
                    callback.push(options.onSave);

                    editorFooter.append('<button class="btn btn-success" data-provider="'
                        + ns
                        + '" data-handler="'
                        + saveHandler
                        + '"><i class="icon icon-white icon-ok"></i> '
                        + this.__localize('Save')
                        + '</button>');


                }

                footer = typeof options.footer === 'function' ? options.footer(this) : options.footer;

                if ($.trim(footer) !== '') {
                    createFooter = true;
                    editorFooter.append(footer);
                }

                if (createFooter) editor.append(editorFooter);

                // Set width
                if (options.width && options.width !== 'inherit') {
                    if (jQuery.isNumeric(options.width)) {
                        editor.css('display', 'table');
                        textarea.css('width', options.width + 'px');
                    } else {
                        editor.addClass(options.width);
                    }
                }

                // Set height
                if (options.height && options.height !== 'inherit') {
                    if (jQuery.isNumeric(options.height)) {
                        var height = options.height;
                        if (editorHeader) height = Math.max(0, height - editorHeader.outerHeight());
                        if (editorFooter) height = Math.max(0, height - editorFooter.outerHeight());
                        textarea.css('height', height + 'px');
                    } else {
                        editor.addClass(options.height);
                    }
                }

                // Reference
                this.$editor     = editor;
                this.$textarea   = textarea;
                this.$editable   = editable;
                this.$oldContent = this.getContent();

                this.__setListener();

                // Set editor attributes, data short-hand API and listener
                this.$editor.attr('id',(new Date()).getTime());
                this.$editor.on('click', '[data-provider="bootstrap-markdown"]', $.proxy(this.__handle, this));

                if (this.$element.is(':disabled') || this.$element.is('[readonly]')) {
                    this.$editor.addClass('md-editor-disabled');
                    this.disableButtons('all');
                }

                if (this.eventSupported('keydown') && typeof jQuery.hotkeys === 'object') {
                    editorHeader.find('[data-provider="bootstrap-markdown"]').each(function() {
                        var $button = $(this),
                            hotkey = $button.attr('data-hotkey');
                        if (hotkey.toLowerCase() !== '') {
                            textarea.bind('keydown', hotkey, function() {
                                $button.trigger('click');
                                return false;
                            });
                        }
                    });
                }

                if (options.initialstate === 'preview') {
                    this.showPreview();
                } else if (options.initialstate === 'fullscreen' && options.fullscreen.enable) {
                    this.setFullscreen(true);
                }

            } else {
                this.$editor.show();
            }

            if (options.autofocus) {
                this.$textarea.focus();
                this.$editor.addClass('active');
            }

            if (options.fullscreen.enable && options.fullscreen !== false) {
                this.$editor.append('<div class="md-fullscreen-controls">'
                    + '<a href="#" class="exit-fullscreen" title="Exit fullscreen"><span class="' + this.__getIcon(options.fullscreen.icons.fullscreenOff) + '">'
                    + '</span></a>'
                    + '</div>');
                this.$editor.on('click', '.exit-fullscreen', function(e) {
                    e.preventDefault();
                    instance.setFullscreen(false);
                });
            }

            // hide hidden buttons from options
            this.hideButtons(options.hiddenButtons);

            // disable disabled buttons from options
            this.disableButtons(options.disabledButtons);

            // Trigger the onShow hook
            options.onShow(this);

            return this;
        }

        , parseContent: function(val) {
            var content;

            // parse with supported markdown parser
            var val = val || this.$textarea.val();

            if (this.$options.parser) {
                content = this.$options.parser(val);
            } else if (typeof markdown == 'object') {
                content = markdown.toHTML(val);
            } else if (typeof marked == 'function') {
                content = marked(val);
            } else {
                content = val;
            }

            return content;
        }

        , showPreview: function() {
            var options = this.$options,
                container = this.$textarea,
                afterContainer = container.next(),
                replacementContainer = $('<div/>',{'class':'md-preview','data-provider':'markdown-preview'}),
                content,
                callbackContent;

            if (this.$isPreview == true) {
                // Avoid sequenced element creation on missused scenario
                // @see https://github.com/toopay/bootstrap-markdown/issues/170
                return this;
            }

            // Give flag that tell the editor enter preview mode
            this.$isPreview = true;
            // Disable all buttons
            this.disableButtons('all').enableButtons('cmdPreview');

            // Try to get the content from callback
            callbackContent = options.onPreview(this);
            // Set the content based from the callback content if string otherwise parse value from textarea
            content = typeof callbackContent == 'string' ? callbackContent : this.parseContent();

            // Build preview element
            replacementContainer.html(content);

            if (afterContainer && afterContainer.attr('class') == 'md-footer') {
                // If there is footer element, insert the preview container before it
                replacementContainer.insertBefore(afterContainer);
            } else {
                // Otherwise, just append it after textarea
                container.parent().append(replacementContainer);
            }

            // Set the preview element dimensions
            replacementContainer.css({
                width: container.outerWidth() + 'px',
                height: container.outerHeight() + 'px'
            });

            if (this.$options.resize) {
                replacementContainer.css('resize',this.$options.resize);
            }

            // Hide the last-active textarea
            container.hide();

            // Attach the editor instances
            replacementContainer.data('markdown',this);

            if (this.$element.is(':disabled') || this.$element.is('[readonly]')) {
                this.$editor.addClass('md-editor-disabled');
                this.disableButtons('all');
            }

            return this;
        }

        , hidePreview: function() {
            // Give flag that tell the editor quit preview mode
            this.$isPreview = false;

            // Obtain the preview container
            var container = this.$editor.find('div[data-provider="markdown-preview"]');

            // Remove the preview container
            container.remove();

            // Enable all buttons
            this.enableButtons('all');
            // Disable configured disabled buttons
            this.disableButtons(this.$options.disabledButtons);

            // Back to the editor
            this.$textarea.show();
            this.__setListener();

            return this;
        }

        , isDirty: function() {
            return this.$oldContent != this.getContent();
        }

        , getContent: function() {
            return this.$textarea.val();
        }

        , setContent: function(content) {
            this.$textarea.val(content);

            return this;
        }

        , findSelection: function(chunk) {
            var content = this.getContent(), startChunkPosition;

            if (startChunkPosition = content.indexOf(chunk), startChunkPosition >= 0 && chunk.length > 0) {
                var oldSelection = this.getSelection(), selection;

                this.setSelection(startChunkPosition,startChunkPosition+chunk.length);
                selection = this.getSelection();

                this.setSelection(oldSelection.start,oldSelection.end);

                return selection;
            } else {
                return null;
            }
        }

        , getSelection: function() {

            var e = this.$textarea[0];

            return (

                ('selectionStart' in e && function() {
                    var l = e.selectionEnd - e.selectionStart;
                    return { start: e.selectionStart, end: e.selectionEnd, length: l, text: e.value.substr(e.selectionStart, l) };
                }) ||

                    /* browser not supported */
                function() {
                    return null;
                }

            )();

        }

        , setSelection: function(start,end) {

            var e = this.$textarea[0];

            return (

                ('selectionStart' in e && function() {
                    e.selectionStart = start;
                    e.selectionEnd = end;
                    return;
                }) ||

                    /* browser not supported */
                function() {
                    return null;
                }

            )();

        }

        , replaceSelection: function(text) {

            var e = this.$textarea[0];

            return (

                ('selectionStart' in e && function() {
                    e.value = e.value.substr(0, e.selectionStart) + text + e.value.substr(e.selectionEnd, e.value.length);
                    // Set cursor to the last replacement end
                    e.selectionStart = e.value.length;
                    return this;
                }) ||

                    /* browser not supported */
                function() {
                    e.value += text;
                    return jQuery(e);
                }

            )();
        }

        , getNextTab: function() {
            // Shift the nextTab
            if (this.$nextTab.length === 0) {
                return null;
            } else {
                var nextTab, tab = this.$nextTab.shift();

                if (typeof tab == 'function') {
                    nextTab = tab();
                } else if (typeof tab == 'object' && tab.length > 0) {
                    nextTab = tab;
                }

                return nextTab;
            }
        }

        , setNextTab: function(start,end) {
            // Push new selection into nextTab collections
            if (typeof start == 'string') {
                var that = this;
                this.$nextTab.push(function(){
                    return that.findSelection(start);
                });
            } else if (typeof start == 'number' && typeof end == 'number') {
                var oldSelection = this.getSelection();

                this.setSelection(start,end);
                this.$nextTab.push(this.getSelection());

                this.setSelection(oldSelection.start,oldSelection.end);
            }

            return;
        }

        , __parseButtonNameParam: function(nameParam) {
            var buttons = [];

            if (typeof nameParam == 'string') {
                buttons = nameParam.split(',')
            } else {
                buttons = nameParam;
            }

            return buttons;
        }

        , enableButtons: function(name) {
            var buttons = this.__parseButtonNameParam(name),
                that = this;

            $.each(buttons, function(i, v) {
                that.__alterButtons(buttons[i], function (el) {
                    el.removeAttr('disabled');
                });
            });

            return this;
        }

        , disableButtons: function(name) {
            var buttons = this.__parseButtonNameParam(name),
                that = this;

            $.each(buttons, function(i, v) {
                that.__alterButtons(buttons[i], function (el) {
                    el.attr('disabled','disabled');
                });
            });

            return this;
        }

        , hideButtons: function(name) {
            var buttons = this.__parseButtonNameParam(name),
                that = this;

            $.each(buttons, function(i, v) {
                that.__alterButtons(buttons[i], function (el) {
                    el.addClass('hidden');
                });
            });

            return this;
        }

        , showButtons: function(name) {
            var buttons = this.__parseButtonNameParam(name),
                that = this;

            $.each(buttons, function(i, v) {
                that.__alterButtons(buttons[i], function (el) {
                    el.removeClass('hidden');
                });
            });

            return this;
        }

        , eventSupported: function(eventName) {
            var isSupported = eventName in this.$element;
            if (!isSupported) {
                this.$element.setAttribute(eventName, 'return;');
                isSupported = typeof this.$element[eventName] === 'function';
            }
            return isSupported;
        }

        , keyup: function (e) {
            var blocked = false;
            switch(e.keyCode) {
                case 40: // down arrow
                case 38: // up arrow
                case 16: // shift
                case 17: // ctrl
                case 18: // alt
                    break;

                case 9: // tab
                    var nextTab;
                    if (nextTab = this.getNextTab(),nextTab !== null) {
                        // Get the nextTab if exists
                        var that = this;
                        setTimeout(function(){
                            that.setSelection(nextTab.start,nextTab.end);
                        },500);

                        blocked = true;
                    } else {
                        // The next tab memory contains nothing...
                        // check the cursor position to determine tab action
                        var cursor = this.getSelection();

                        if (cursor.start == cursor.end && cursor.end == this.getContent().length) {
                            // The cursor already reach the end of the content
                            blocked = false;
                        } else {
                            // Put the cursor to the end
                            this.setSelection(this.getContent().length,this.getContent().length);

                            blocked = true;
                        }
                    }

                    break;

                case 13: // enter
                    blocked = false;
                    break;
                case 27: // escape
                    if (this.$isFullscreen) this.setFullscreen(false);
                    blocked = false;
                    break;

                default:
                    blocked = false;
            }

            if (blocked) {
                e.stopPropagation();
                e.preventDefault();
            }

            this.$options.onChange(this);
        }

        , change: function(e) {
            this.$options.onChange(this);
            return this;
        }
        , select: function (e) {
            this.$options.onSelect(this);
            return this;
        }
        , focus: function (e) {
            var options = this.$options,
                isHideable = options.hideable,
                editor = this.$editor;

            editor.addClass('active');

            // Blur other markdown(s)
            $(document).find('.md-editor').each(function(){
                if ($(this).attr('id') !== editor.attr('id')) {
                    var attachedMarkdown;

                    if (attachedMarkdown = $(this).find('textarea').data('markdown'),
                        attachedMarkdown === null) {
                        attachedMarkdown = $(this).find('div[data-provider="markdown-preview"]').data('markdown');
                    }

                    if (attachedMarkdown) {
                        attachedMarkdown.blur();
                    }
                }
            });

            // Trigger the onFocus hook
            options.onFocus(this);

            return this;
        }

        , blur: function (e) {
            var options = this.$options,
                isHideable = options.hideable,
                editor = this.$editor,
                editable = this.$editable;

            if (editor.hasClass('active') || this.$element.parent().length === 0) {
                editor.removeClass('active');

                if (isHideable) {
                    // Check for editable elements
                    if (editable.el !== null) {
                        // Build the original element
                        var oldElement = $('<'+editable.type+'/>'),
                            content = this.getContent(),
                            currentContent = this.parseContent(content);

                        $(editable.attrKeys).each(function(k,v) {
                            oldElement.attr(editable.attrKeys[k],editable.attrValues[k]);
                        });

                        // Get the editor content
                        oldElement.html(currentContent);

                        editor.replaceWith(oldElement);
                    } else {
                        editor.hide();
                    }
                }

                // Trigger the onBlur hook
                options.onBlur(this);
            }

            return this;
        }

    };

    /* MARKDOWN PLUGIN DEFINITION
     * ========================== */

    var old = $.fn.markdown;

    $.fn.markdown = function (option) {
        return this.each(function () {
            var $this = $(this)
                , data = $this.data('markdown')
                , options = typeof option == 'object' && option;
            if (!data) $this.data('markdown', (data = new Markdown(this, options)))
        })
    };

    $.fn.markdown.messages = {};

    $.fn.markdown.defaults = {
        /* Editor Properties */
        autofocus: false,
        hideable: false,
        savable: false,
        width: 'inherit',
        height: 'inherit',
        resize: 'none',
        iconlibrary: 'glyph',
        language: 'en',
        initialstate: 'editor',
        parser: null,

        /* Buttons Properties */
        buttons: [
            [{
                name: 'groupFont',
                data: [{
                    name: 'cmdBold',
                    hotkey: 'Ctrl+B',
                    title: 'Bold',
                    icon: { glyph: 'glyphicon glyphicon-bold', fa: 'fa fa-bold', 'fa-3': 'icon-bold' },
                    callback: function(e){
                        // Give/remove ** surround the selection
                        var chunk, cursor, selected = e.getSelection(), content = e.getContent();

                        if (selected.length === 0) {
                            // Give extra word
                            chunk = e.__localize('strong text');
                        } else {
                            chunk = selected.text;
                        }

                        // transform selection and set the cursor into chunked text
                        if (content.substr(selected.start-2,2) === '**'
                            && content.substr(selected.end,2) === '**' ) {
                            e.setSelection(selected.start-2,selected.end+2);
                            e.replaceSelection(chunk);
                            cursor = selected.start-2;
                        } else {
                            e.replaceSelection('**'+chunk+'**');
                            cursor = selected.start+2;
                        }

                        // Set the cursor
                        e.setSelection(cursor,cursor+chunk.length);
                    }
                },{
                    name: 'cmdItalic',
                    title: 'Italic',
                    hotkey: 'Ctrl+I',
                    icon: { glyph: 'glyphicon glyphicon-italic', fa: 'fa fa-italic', 'fa-3': 'icon-italic' },
                    callback: function(e){
                        // Give/remove * surround the selection
                        var chunk, cursor, selected = e.getSelection(), content = e.getContent();

                        if (selected.length === 0) {
                            // Give extra word
                            chunk = e.__localize('emphasized text');
                        } else {
                            chunk = selected.text;
                        }

                        // transform selection and set the cursor into chunked text
                        if (content.substr(selected.start-1,1) === '_'
                            && content.substr(selected.end,1) === '_' ) {
                            e.setSelection(selected.start-1,selected.end+1);
                            e.replaceSelection(chunk);
                            cursor = selected.start-1;
                        } else {
                            e.replaceSelection('_'+chunk+'_');
                            cursor = selected.start+1;
                        }

                        // Set the cursor
                        e.setSelection(cursor,cursor+chunk.length);
                    }
                },{
                    name: 'cmdHeading',
                    title: 'Heading',
                    hotkey: 'Ctrl+H',
                    icon: { glyph: 'glyphicon glyphicon-header', fa: 'fa fa-header', 'fa-3': 'icon-font' },
                    callback: function(e){
                        // Append/remove ### surround the selection
                        var chunk, cursor, selected = e.getSelection(), content = e.getContent(), pointer, prevChar;

                        if (selected.length === 0) {
                            // Give extra word
                            chunk = e.__localize('heading text');
                        } else {
                            chunk = selected.text + '\n';
                        }

                        // transform selection and set the cursor into chunked text
                        if ((pointer = 4, content.substr(selected.start-pointer,pointer) === '### ')
                            || (pointer = 3, content.substr(selected.start-pointer,pointer) === '###')) {
                            e.setSelection(selected.start-pointer,selected.end);
                            e.replaceSelection(chunk);
                            cursor = selected.start-pointer;
                        } else if (selected.start > 0 && (prevChar = content.substr(selected.start-1,1), !!prevChar && prevChar != '\n')) {
                            e.replaceSelection('\n\n### '+chunk);
                            cursor = selected.start+6;
                        } else {
                            // Empty string before element
                            e.replaceSelection('### '+chunk);
                            cursor = selected.start+4;
                        }

                        // Set the cursor
                        e.setSelection(cursor,cursor+chunk.length);
                    }
                }]
            },{
                name: 'groupLink',
                data: [{
                    name: 'cmdUrl',
                    title: 'URL/Link',
                    hotkey: 'Ctrl+L',
                    icon: { glyph: 'glyphicon glyphicon-link', fa: 'fa fa-link', 'fa-3': 'icon-link' },
                    callback: function(e){
                        // Give [] surround the selection and prepend the link
                        var chunk, cursor, selected = e.getSelection(), content = e.getContent(), link;

                        if (selected.length === 0) {
                            // Give extra word
                            chunk = e.__localize('enter link description here');
                        } else {
                            chunk = selected.text;
                        }

                        link = prompt(e.__localize('Insert Hyperlink'),'http://');

                        if (link !== null && link !== '' && link !== 'http://' && link.substr(0,4) === 'http') {
                            var sanitizedLink = $('<div>'+link+'</div>').text();

                            // transform selection and set the cursor into chunked text
                            e.replaceSelection('['+chunk+']('+sanitizedLink+')');
                            cursor = selected.start+1;

                            // Set the cursor
                            e.setSelection(cursor,cursor+chunk.length);
                        }
                    }
                },{
                    name: 'cmdImage',
                    title: 'Image',
                    hotkey: 'Ctrl+G',
                    icon: { glyph: 'glyphicon glyphicon-picture', fa: 'fa fa-picture-o', 'fa-3': 'icon-picture' },
                    callback: function(e){
                        // Give ![] surround the selection and prepend the image link
                        var chunk, cursor, selected = e.getSelection(), content = e.getContent(), link;

                        if (selected.length === 0) {
                            // Give extra word
                            chunk = e.__localize('enter image description here');
                        } else {
                            chunk = selected.text;
                        }

                        link = prompt(e.__localize('Insert Image Hyperlink'),'http://');

                        if (link !== null && link !== '' && link !== 'http://' && link.substr(0,4) === 'http') {
                            var sanitizedLink = $('<div>'+link+'</div>').text();

                            // transform selection and set the cursor into chunked text
                            e.replaceSelection('!['+chunk+']('+sanitizedLink+' "'+e.__localize('enter image title here')+'")');
                            cursor = selected.start+2;

                            // Set the next tab
                            e.setNextTab(e.__localize('enter image title here'));

                            // Set the cursor
                            e.setSelection(cursor,cursor+chunk.length);
                        }
                    }
                }]
            },{
                name: 'groupMisc',
                data: [{
                    name: 'cmdList',
                    hotkey: 'Ctrl+U',
                    title: 'Unordered List',
                    icon: { glyph: 'glyphicon glyphicon-list', fa: 'fa fa-list', 'fa-3': 'icon-list-ul' },
                    callback: function(e){
                        // Prepend/Give - surround the selection
                        var chunk, cursor, selected = e.getSelection(), content = e.getContent();

                        // transform selection and set the cursor into chunked text
                        if (selected.length === 0) {
                            // Give extra word
                            chunk = e.__localize('list text here');

                            e.replaceSelection('- '+chunk);
                            // Set the cursor
                            cursor = selected.start+2;
                        } else {
                            if (selected.text.indexOf('\n') < 0) {
                                chunk = selected.text;

                                e.replaceSelection('- '+chunk);

                                // Set the cursor
                                cursor = selected.start+2;
                            } else {
                                var list = [];

                                list = selected.text.split('\n');
                                chunk = list[0];

                                $.each(list,function(k,v) {
                                    list[k] = '- '+v;
                                });

                                e.replaceSelection('\n\n'+list.join('\n'));

                                // Set the cursor
                                cursor = selected.start+4;
                            }
                        }

                        // Set the cursor
                        e.setSelection(cursor,cursor+chunk.length);
                    }
                },
                    {
                        name: 'cmdListO',
                        hotkey: 'Ctrl+O',
                        title: 'Ordered List',
                        icon: { glyph: 'glyphicon glyphicon-th-list', fa: 'fa fa-list-ol', 'fa-3': 'icon-list-ol' },
                        callback: function(e) {

                            // Prepend/Give - surround the selection
                            var chunk, cursor, selected = e.getSelection(), content = e.getContent();

                            // transform selection and set the cursor into chunked text
                            if (selected.length === 0) {
                                // Give extra word
                                chunk = e.__localize('list text here');
                                e.replaceSelection('1. '+chunk);
                                // Set the cursor
                                cursor = selected.start+3;
                            } else {
                                if (selected.text.indexOf('\n') < 0) {
                                    chunk = selected.text;

                                    e.replaceSelection('1. '+chunk);

                                    // Set the cursor
                                    cursor = selected.start+3;
                                } else {
                                    var list = [];

                                    list = selected.text.split('\n');
                                    chunk = list[0];

                                    $.each(list,function(k,v) {
                                        list[k] = '1. '+v;
                                    });

                                    e.replaceSelection('\n\n'+list.join('\n'));

                                    // Set the cursor
                                    cursor = selected.start+5;
                                }
                            }

                            // Set the cursor
                            e.setSelection(cursor,cursor+chunk.length);
                        }
                    },
                    {
                        name: 'cmdCode',
                        hotkey: 'Ctrl+K',
                        title: 'Code',
                        icon: { glyph: 'glyphicon glyphicon-asterisk', fa: 'fa fa-code', 'fa-3': 'icon-code' },
                        callback: function(e) {
                            // Give/remove ** surround the selection
                            var chunk, cursor, selected = e.getSelection(), content = e.getContent();

                            if (selected.length === 0) {
                                // Give extra word
                                chunk = e.__localize('code text here');
                            } else {
                                chunk = selected.text;
                            }

                            // transform selection and set the cursor into chunked text
                            if (content.substr(selected.start-4,4) === '```\n'
                                && content.substr(selected.end,4) === '\n```') {
                                e.setSelection(selected.start-4, selected.end+4);
                                e.replaceSelection(chunk);
                                cursor = selected.start-4;
                            } else if (content.substr(selected.start-1,1) === '`'
                                && content.substr(selected.end,1) === '`') {
                                e.setSelection(selected.start-1,selected.end+1);
                                e.replaceSelection(chunk);
                                cursor = selected.start-1;
                            } else if (content.indexOf('\n') > -1) {
                                e.replaceSelection('```\n'+chunk+'\n```');
                                cursor = selected.start+4;
                            } else {
                                e.replaceSelection('`'+chunk+'`');
                                cursor = selected.start+1;
                            }

                            // Set the cursor
                            e.setSelection(cursor,cursor+chunk.length);
                        }
                    },
                    {
                        name: 'cmdQuote',
                        hotkey: 'Ctrl+Q',
                        title: 'Quote',
                        icon: { glyph: 'glyphicon glyphicon-comment', fa: 'fa fa-quote-left', 'fa-3': 'icon-quote-left' },
                        callback: function(e) {
                            // Prepend/Give - surround the selection
                            var chunk, cursor, selected = e.getSelection(), content = e.getContent();

                            // transform selection and set the cursor into chunked text
                            if (selected.length === 0) {
                                // Give extra word
                                chunk = e.__localize('quote here');

                                e.replaceSelection('> '+chunk);

                                // Set the cursor
                                cursor = selected.start+2;
                            } else {
                                if (selected.text.indexOf('\n') < 0) {
                                    chunk = selected.text;

                                    e.replaceSelection('> '+chunk);

                                    // Set the cursor
                                    cursor = selected.start+2;
                                } else {
                                    var list = [];

                                    list = selected.text.split('\n');
                                    chunk = list[0];

                                    $.each(list,function(k,v) {
                                        list[k] = '> '+v;
                                    });

                                    e.replaceSelection('\n\n'+list.join('\n'));

                                    // Set the cursor
                                    cursor = selected.start+4;
                                }
                            }

                            // Set the cursor
                            e.setSelection(cursor,cursor+chunk.length);
                        }
                    }]
            },{
                name: 'groupUtil',
                data: [{
                    name: 'cmdPreview',
                    toggle: true,
                    hotkey: 'Ctrl+P',
                    title: 'Preview',
                    btnText: 'Preview',
                    btnClass: 'btn btn-primary btn-sm',
                    icon: { glyph: 'glyphicon glyphicon-search', fa: 'fa fa-search', 'fa-3': 'icon-search' },
                    callback: function(e){
                        // Check the preview mode and toggle based on this flag
                        var isPreview = e.$isPreview,content;

                        if (isPreview === false) {
                            // Give flag that tell the editor enter preview mode
                            e.showPreview();
                        } else {
                            e.hidePreview();
                        }
                    }
                }]
            }]
        ],
        additionalButtons:[], // Place to hook more buttons by code
        reorderButtonGroups:[],
        hiddenButtons:[], // Default hidden buttons
        disabledButtons:[], // Default disabled buttons
        footer: '',
        fullscreen: {
            enable: true,
            icons: {
                fullscreenOn: {
                    fa: 'fa fa-expand',
                    glyph: 'glyphicon glyphicon-fullscreen',
                    'fa-3': 'icon-resize-full'
                },
                fullscreenOff: {
                    fa: 'fa fa-compress',
                    glyph: 'glyphicon glyphicon-fullscreen',
                    'fa-3': 'icon-resize-small'
                }
            }
        },

        /* Events hook */
        onShow: function (e) {},
        onPreview: function (e) {},
        onSave: function (e) {},
        onBlur: function (e) {},
        onFocus: function (e) {},
        onChange: function(e) {},
        onFullscreen: function(e) {},
        onSelect: function (e) {}
    };

    $.fn.markdown.Constructor = Markdown;


    /* MARKDOWN NO CONFLICT
     * ==================== */

    $.fn.markdown.noConflict = function () {
        $.fn.markdown = old;
        return this;
    };

    /* MARKDOWN GLOBAL FUNCTION & DATA-API
     * ==================================== */
    var initMarkdown = function(el) {
        var $this = el;

        if ($this.data('markdown')) {
            $this.data('markdown').showEditor();
            return;
        }

        $this.markdown()
    };

    var blurNonFocused = function(e) {
        var $activeElement = $(document.activeElement);

        // Blur event
        $(document).find('.md-editor').each(function(){
            var $this            = $(this),
                focused          = $activeElement.closest('.md-editor')[0] === this,
                attachedMarkdown = $this.find('textarea').data('markdown') ||
                    $this.find('div[data-provider="markdown-preview"]').data('markdown');

            if (attachedMarkdown && !focused) {
                attachedMarkdown.blur();
            }
        })
    };

    $(document)
        .on('click.markdown.data-api', '[data-provide="markdown-editable"]', function (e) {
            initMarkdown($(this));
            e.preventDefault();
        })
        .on('click focusin', function (e) {
            blurNonFocused(e);
        })
        .ready(function(){
            $('textarea[data-provide="markdown"]').each(function(){
                initMarkdown($(this));
            })
        });

}(window.jQuery);

/**
 * French translation for bootstrap-markdown
 * Benoît Bourgeois <bierdok@gmail.com>
 */
(function ($) {
    $.fn.markdown.messages.fr = {
        'Bold': "Gras",
        'Italic': "Italique",
        'Heading': "Titre",
        'URL/Link': "Insérer un lien HTTP",
        'Image': "Insérer une image",
        'List': "Liste à puces",
        'Preview': "Prévisualiser",
        'strong text': "texte important",
        'emphasized text': "texte italic",
        'heading text': "texte d'entête",
        'enter link description here': "entrez la description du lien ici",
        'Insert Hyperlink': "Insérez le lien hypertexte",
        'enter image description here': "entrez la description de l'image ici",
        'Insert Image Hyperlink': "Insérez le lien hypertexte de l'image",
        'enter image title here': "entrez le titre de l'image ici",
        'list text here': "texte à puce ici"
    };
}(jQuery));
