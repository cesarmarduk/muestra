(function ($) {
    var defaults = {
        page: 1,
        pages: 1,
        left: 1,
        right: 1,
        delay: 1000,
        field: 'page',
        link: true,
        scroll: false,
        keyNavigation: false,
        url: "",
		skin: null,
        sepText: "...",
        el: "li",
		pageClass: "",
        pageActiveClass: "current",
        onPageSubmit: new Function("page", ""),
        popstate: new Function("page", ""),
		prevNext: false,
		prevText: "В«",
		nextText: "В»",
		prevNextClass: "prevNext",
		prevNextDisabledClass: "disabled"
    };
    
    var methods = {
        setOption: function (option, value) {
            var val = "";
            var $this = $(this),
                data = $this.data('pagination');
            switch (option) {
                case 'page':
                case 'pages':
                case 'left':
                case 'right':
                case 'delay':
                    //if (value.match('^[0-9]+$')) {
                        val = parseInt(value, 10);
                    //} else {
                    //	return false;
                    //}
                    break;
                case 'field':
				case 'pageActiveClass':
				case 'sepText':
				case 'sepClass':
				case 'el':
				case 'pageClass':
				case 'prevText':
				case 'nextText':
				case 'prevNextClass':
				case 'prevNextDisabledClass':
				case 'url':
				case 'anchor':
				case 'skin':
					val = value;
                    if (val === "")
                        val = defaults[option];
                    break;
				case 'onPageSubmit':
				case 'popstate':
					val =  new Function("page", value);
                    break;
                case 'scroll':
                    val = Boolean(value);
                    if (!val) {
						$this.on('scroll touchmove mousewheel', function (e) {
							e.preventDefault();
							e.stopPropagation();
							return false;
						});
                        $this.unbind('scrollEvent');
                    } else {
                        methods._scrollEvent($this);
                    }
                    break;
                case 'link':
				case 'prevNext':
                    val = Boolean(value);
                    break;
                case 'keyNavigation':
                    val = Boolean(value);
                    if (!val) {
						$this.unbind('eventKeyDown');
                    } else {
						methods._keyNavigationEvent($this);
                    }
                    break;
            }
            data.options[option] = val;
            return true;     
        },
        init: function (params) {
            var options = $.extend({}, defaults, params),
                $this = $(this),
                data = $this.data('pagination'),
                timerId;
            options = $.extend({}, options, $this.data());
            if (!data) {
                $(this).data('pagination', {
                    target  : $this,
                    options : options,
                    timerId : timerId
                });
                var $this = $(this),
                    data = $this.data('pagination');
                $this.pagination('update');

				var histAPI = !!(window.history && history.pushState);
				window.onload = function () {
					if (histAPI) {
						window.setTimeout(function () {
							window.addEventListener("popstate",
								function (e) {
									if (data.options.field !== "" && e.state !== null) {
										data.options.page = e.state[data.options.field];
										$this.pagination('update');
										data.options.popstate(data.options.page);
									}
									return false;
								},
								false);
						}, 1);
					}
					return false;
				};
                
                methods._scroll($this);
                if (options.scroll) {
                    methods._scrollEvent($this);
                }
				methods._keyNavigation($this);
                if (options.keyNavigation) {
                    methods._keyNavigationEvent($this);
                }
            }
            return this;
        },
		update: function () {
			var html = '', arrPages = [];
            var $this = $(this),
                data = $this.data('pagination'),
				blocks = 5 + data.options.left + data.options.right,
                from = data.options.page - data.options.left,
                i = 0;
			$this.empty().removeClass().addClass('pagination');
			if (data.options.skin)
				$this.addClass(data.options.skin);
            arrPages.push(methods._addPage($this, 1, 1, "page"));
            if (from > 3 && data.options.pages > blocks) {
				var sep = '<' + data.options.el + '><a>' + data.options.sepText + '</a></' + data.options.el + '>';
				if (typeof data.options.sepClass !== "undefined")
					$(sep).addClass(data.options.sepClass);
				arrPages.push(sep);
            }
            if (data.options.page < blocks - data.options.right - 1 || data.options.pages <= blocks) {
                from = 2;
            } else if (data.options.page > data.options.pages - data.options.right - 3) {
                from = data.options.pages - blocks + 3;
            }
            while ((i < blocks - 4 || (from === 2 && i < blocks - 3)) && i + from < data.options.pages) {
				arrPages.push(methods._addPage($this, i + from, i + from, "page"));
                ++i;
            }
            if (data.options.page <= data.options.pages - data.options.left - 2 && data.options.pages > blocks) {
				var sep = '<' + data.options.el + '><a>' + data.options.sepText + '</a></' + data.options.el + '>';
                if (typeof data.options.sepClass !== "undefined")
                    $(sep).addClass(data.options.sepClass);
                arrPages.push(sep);
            } else if (i + from <= data.options.pages) {
				arrPages.push(methods._addPage($this, i + from, i + from, "page"));
            }
            if (i + from < data.options.pages) {
				arrPages.push(methods._addPage($this, data.options.pages, data.options.pages, "page"));
            }
			if (data.options.prevNext) {
				arrPages.unshift(methods._addPage($this, data.options.page == 1 ? 1 : data.options.page - 1, data.options.prevText, "page " + data.options.prevNextClass + (data.options.page == 1 ? (" " + data.options.prevNextDisabledClass) : "")));
				arrPages.push(methods._addPage($this, data.options.page == data.options.pages ? data.options.pages : (parseInt(data.options.page, 10) + 1), data.options.nextText, "page " + data.options.prevNextClass + (data.options.page == data.options.pages ? (" " + data.options.prevNextDisabledClass) : "")));
			}
			var paginator = $this.html(arrPages.join(''));
			if (typeof data.options.pageActiveClass !== "undefined")
                paginator.find(data.options.el + ':not(.prevNext)[data-page="' + data.options.page + '"]').addClass(data.options.pageActiveClass);
			if (!data.options.link) {
                paginator.find(data.options.el + '.page').bind('click', function () {
                    data.options.page = parseInt($(this).attr('data-page'), 10);
                    paginator.pagination('update');
					methods._updateUrl(data.options);
                    data.options.onPageSubmit(data.options.page);
					return false;
                });
            }
            return paginator;
        },
        reload: function(elem) {
            elem.pagination('update');
            elem.data('pagination').options.onPageSubmit(elem.data('pagination').options.page);
			return false;
        },
        getOptions: function() {
            return $(this).data('pagination').options;
        },
		_addPage: function (elem, pageNumber, pageText, customClass) {
            var data = elem.data('pagination');
			var a = '<a';
			if (data.options.link)
				a += ' href="'+methods._getUrl(data.options, pageNumber)+'"';
			a += ('>' + pageText + '</a>');
			var button = '<' + data.options.el + ' class="' + customClass + '" data-page="' + pageNumber + '">' + a + '</' + data.options.el + '>';
			if (data.options.pageclass !== "undefined")
				$(button).addClass(data.options.pageClass);
			return button;
        },
		_updateUrl: function (options) {
            var obj = {};
			obj[options.field] = options.page;
			history.pushState(obj, "paginationHistory", methods._getUrl(options, options.page));
			return false;
        },
		_getUrl: function (options, page) {
            var params = {},
                tmp = [],
                flag = false,
				url = options.url;
            if (location.search !== "") {
                var items = location.search.substr(1).split("&");
                for (var index = 0; index < items.length; index++) {
                    tmp = items[index].split("=");
                    if (tmp[0] === options.field) {
                        if (page !== false) {
                            params[options.field] = decodeURIComponent(page);
                        }
                        flag = true;
                    } else
                        params[tmp[0]] = tmp[1];
                }
            }
            if (page !== false && options.field !== "") {
                if (!flag) {
                    if (options.field !== "/") {
                        params[options.field] = decodeURIComponent(page);
                        url += "?";
                    } else {
                        url += "/" + page;
                        if (Object.keys(params).length > 0) {
                            url += "?";
                        }
                    }
                } else {
                    url += "?";
                }
            }
            url += decodeURIComponent($.param(params));
            if (typeof options.anchor !== "undefined")
                url += "#" + options.anchor;
            return url;
        },
        _keyNavigation: function (elem) {
			var f_enter = false,
				f_move = false,
                x = 0, y = 0;
            elem.mouseenter(function(e) {
				if (!f_enter) {
					f_enter = true;
					elem.mousemove(function(e) {
						if (!f_move && !(x === 0 && y === 0)) {
							if (x !== e.clientX || y !== e.clientY) {
								f_move = true;
								elem.triggerHandler({
									type: 'eventKeyDown',
									elem: elem
								});
							}
						} else {
							x = e.clientX;
							y = e.clientY;
						}
					});
                }
				return false;
            });
            elem.mouseleave(function() {
                f_enter = f_move = false;
				x = y = 0;
                $(document).unbind('keydown');
				return false;
            });
			return false;
        },
        _keyNavigationEvent: function(elem) {
            elem.on('eventKeyDown', function(event) {
                $(document).on('keydown', function(e){
                    if (e.keyCode === 37 || e.keyCode === 40) {
                        if (elem.data('pagination').options.page > 1) {
                            -- elem.data('pagination').options.page;
                            elem.pagination('update');
                        }
						methods._timer(elem);
						return false;
                    } else if (e.keyCode === 38 || e.keyCode === 39) { 
                        if (elem.data('pagination').options.page < elem.data('pagination').options.pages) {
                            ++ elem.data('pagination').options.page;
                            elem.pagination('update');
  
                        }
						methods._timer(elem);
						return false;
                    }
					return false;
                });
				return false;
            });
			return false;
        },
        _scroll: function (elem) {
            var f_enter = false,
				f_move = false,
                x = 0, y = 0;
            elem.mouseenter(function(e) {
				if (!f_enter) {
					f_enter = true;
					elem.mousemove(function(e) {
						if (!f_move && !(x === 0 && y === 0)) {
							if (x !== e.clientX || y !== e.clientY) {
								f_move = true;
								elem.triggerHandler({
									type: 'scrollEvent',
									elem: elem
								});
							}
						} else {
							x = e.clientX;
							y = e.clientY;
						}
						return false;
					});
                }
				return false;
            });
            elem.mouseleave(function() {
                f_enter = f_move = false;
				x = y = 0;
                elem.unmousewheel();
                elem.on('scroll touchmove unmousewheel', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                });
            });
			return false;
        },
        _scrollEvent: function(elem) {
            elem.on('scrollEvent', function(event) {
                elem.mousewheel(function (event, delta, deltaX, deltaY) {
					if (delta > 0)
						++ elem.data('pagination').options.page;
					else
						-- elem.data('pagination').options.page;
                    if (elem.data('pagination').options.page < 1)
                        elem.data('pagination').options.page = 1;
                    else if (elem.data('pagination').options.page > elem.data('pagination').options.pages)
                        elem.data('pagination').options.page = elem.data('pagination').options.pages;
                    elem.pagination('update');
                    methods._timer(elem);
					return false;
                });
                elem.on('scroll touchmove mousewheel', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                });
				return false;
            });
			return false;
        },
        _timer: function(elem) {
            if (typeof elem.data('pagination').timerId !== "undefined")
                clearTimeout(elem.data('pagination').timerId);
                elem.data('pagination').timerId = setTimeout(function () {
                    methods._updateUrl(elem.data('pagination').options);
                    methods.reload(elem);
					return false;
                }, elem.data('pagination').options.delay);
			return false;
        }
    };

    $.fn.pagination = function (method) {
        if (methods[method] && method.charAt(0) !== '_') {
            return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method "' + method + '" does not exist on jQuery.pagination');
        }
		return false;
    };
	var types = ['DOMMouseScroll', 'mousewheel'];
	$.event.special.mousewheel = {
		setup: function() {
			if ( this.addEventListener )
				for ( var i=types.length; i; )
					this.addEventListener( types[--i], handler, false );
			else
				this.onmousewheel = handler;
		},
		teardown: function() {
			if ( this.removeEventListener )
				for ( var i=types.length; i; )
					this.removeEventListener( types[--i], handler, false );
			else
				this.onmousewheel = null;
		}
	};
	$.fn.extend({
		mousewheel: function(fn) {
			return fn ? this.bind("mousewheel", fn) : this.trigger("mousewheel");
		},
		unmousewheel: function(fn) {
			return this.unbind("mousewheel", fn);
		}
	});
	function handler(event) {
		var args = [].slice.call( arguments, 1 ), delta = 0, returnValue = true;
		event = $.event.fix(event || window.event);
		event.type = "mousewheel";
		if ( event.originalEvent.wheelDelta ) delta = event.originalEvent.wheelDelta/120;
		if ( event.originalEvent.detail     ) delta = -event.originalEvent.detail/3;
		args.unshift(event, delta);
		return $.event.dispatch.apply(this, args);
	}
})(jQuery);