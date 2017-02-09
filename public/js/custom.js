/*!
 * Pikaday
 *
 * Copyright © 2014 David Bushell | BSD & MIT license | https://github.com/dbushell/Pikaday
 */

(function (root, factory) {
    'use strict';

    var moment;
    if (typeof exports === 'object') {
        // CommonJS module
        // Load moment.js as an optional dependency
        try {
            moment = require('moment');
        } catch (e) {
        }
        module.exports = factory(moment);
    } else if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(function (req) {
            // Load moment.js as an optional dependency
            var id = 'moment';
            try {
                moment = req(id);
            } catch (e) {
            }
            return factory(moment);
        });
    } else {
        root.Pikaday = factory(root.moment);
    }
}(this, function (moment) {
    'use strict';

    /**
     * feature detection and helper functions
     */
    var hasMoment = typeof moment === 'function',

        hasEventListeners = !!window.addEventListener,

        document = window.document,

        sto = window.setTimeout,

        addEvent = function (el, e, callback, capture) {
            if (hasEventListeners) {
                el.addEventListener(e, callback, !!capture);
            } else {
                el.attachEvent('on' + e, callback);
            }
        },

        removeEvent = function (el, e, callback, capture) {
            if (hasEventListeners) {
                el.removeEventListener(e, callback, !!capture);
            } else {
                el.detachEvent('on' + e, callback);
            }
        },

        fireEvent = function (el, eventName, data) {
            var ev;

            if (document.createEvent) {
                ev = document.createEvent('HTMLEvents');
                ev.initEvent(eventName, true, false);
                ev = extend(ev, data);
                el.dispatchEvent(ev);
            } else if (document.createEventObject) {
                ev = document.createEventObject();
                ev = extend(ev, data);
                el.fireEvent('on' + eventName, ev);
            }
        },

        trim = function (str) {
            return str.trim ? str.trim() : str.replace(/^\s+|\s+$/g, '');
        },

        hasClass = function (el, cn) {
            return (' ' + el.className + ' ').indexOf(' ' + cn + ' ') !== -1;
        },

        addClass = function (el, cn) {
            if (!hasClass(el, cn)) {
                el.className = (el.className === '') ? cn : el.className + ' ' + cn;
            }
        },

        removeClass = function (el, cn) {
            el.className = trim((' ' + el.className + ' ').replace(' ' + cn + ' ', ' '));
        },

        isArray = function (obj) {
            return (/Array/).test(Object.prototype.toString.call(obj));
        },

        isDate = function (obj) {
            return (/Date/).test(Object.prototype.toString.call(obj)) && !isNaN(obj.getTime());
        },

        isWeekend = function (date) {
            var day = date.getDay();
            return day === 0 || day === 6;
        },

        isLeapYear = function (year) {
            // solution by Matti Virkkunen: http://stackoverflow.com/a/4881951
            return year % 4 === 0 && year % 100 !== 0 || year % 400 === 0;
        },

        getDaysInMonth = function (year, month) {
            return [31, isLeapYear(year) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
        },

        setToStartOfDay = function (date) {
            if (isDate(date)) date.setHours(0, 0, 0, 0);
        },

        compareDates = function (a, b) {
            // weak date comparison (use setToStartOfDay(date) to ensure correct result)
            return a.getTime() === b.getTime();
        },

        extend = function (to, from, overwrite) {
            var prop, hasProp;
            for (prop in from) {
                hasProp = to[prop] !== undefined;
                if (hasProp && typeof from[prop] === 'object' && from[prop] !== null && from[prop].nodeName === undefined) {
                    if (isDate(from[prop])) {
                        if (overwrite) {
                            to[prop] = new Date(from[prop].getTime());
                        }
                    }
                    else if (isArray(from[prop])) {
                        if (overwrite) {
                            to[prop] = from[prop].slice(0);
                        }
                    } else {
                        to[prop] = extend({}, from[prop], overwrite);
                    }
                } else if (overwrite || !hasProp) {
                    to[prop] = from[prop];
                }
            }
            return to;
        },

        adjustCalendar = function (calendar) {
            if (calendar.month < 0) {
                calendar.year -= Math.ceil(Math.abs(calendar.month) / 12);
                calendar.month += 12;
            }
            if (calendar.month > 11) {
                calendar.year += Math.floor(Math.abs(calendar.month) / 12);
                calendar.month -= 12;
            }
            return calendar;
        },

        /**
         * defaults and localisation
         */
        defaults = {

            // bind the picker to a form field
            field: null,

            // automatically show/hide the picker on `field` focus (default `true` if `field` is set)
            bound: undefined,

            // position of the datepicker, relative to the field (default to bottom & left)
            // ('bottom' & 'left' keywords are not used, 'top' & 'right' are modifier on the bottom/left position)
            position: 'bottom left',

            // automatically fit in the viewport even if it means repositioning from the position option
            reposition: true,

            // the default output format for `.toString()` and `field` value
            format: 'YYYY-MM-DD',

            // the initial date to view when first opened
            defaultDate: null,

            // make the `defaultDate` the initial selected value
            setDefaultDate: false,

            // first day of week (0: Sunday, 1: Monday etc)
            firstDay: 0,

            // the default flag for moment's strict date parsing
            formatStrict: false,

            // the minimum/earliest date that can be selected
            minDate: null,
            // the maximum/latest date that can be selected
            maxDate: null,

            // number of years either side, or array of upper/lower range
            yearRange: 10,

            // show week numbers at head of row
            showWeekNumber: false,

            // used internally (don't config outside)
            minYear: 0,
            maxYear: 9999,
            minMonth: undefined,
            maxMonth: undefined,

            startRange: null,
            endRange: null,

            isRTL: false,

            // Additional text to append to the year in the calendar title
            yearSuffix: '',

            // Render the month after year in the calendar title
            showMonthAfterYear: false,

            // Render days of the calendar grid that fall in the next or previous month
            showDaysInNextAndPreviousMonths: false,

            // how many months are visible
            numberOfMonths: 1,

            // when numberOfMonths is used, this will help you to choose where the main calendar will be (default `left`, can be set to `right`)
            // only used for the first display or when a selected date is not visible
            mainCalendar: 'left',

            // Specify a DOM element to render the calendar in
            container: undefined,

            // internationalization
            i18n: {
                previousMonth: 'Previous Month',
                nextMonth: 'Next Month',
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                weekdays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                weekdaysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
            },

            // Theme Classname
            theme: null,

            // callback function
            onSelect: null,
            onOpen: null,
            onClose: null,
            onDraw: null
        },


        /**
         * templating functions to abstract HTML rendering
         */
        renderDayName = function (opts, day, abbr) {
            day += opts.firstDay;
            while (day >= 7) {
                day -= 7;
            }
            return abbr ? opts.i18n.weekdaysShort[day] : opts.i18n.weekdays[day];
        },

        renderDay = function (opts) {
            var arr = [];
            var ariaSelected = 'false';
            if (opts.isEmpty) {
                if (opts.showDaysInNextAndPreviousMonths) {
                    arr.push('is-outside-current-month');
                } else {
                    return '<td class="is-empty"></td>';
                }
            }
            if (opts.isDisabled) {
                arr.push('is-disabled');
            }
            if (opts.isToday) {
                arr.push('is-today');
            }
            if (opts.isSelected) {
                arr.push('is-selected');
                ariaSelected = 'true';
            }
            if (opts.isInRange) {
                arr.push('is-inrange');
            }
            if (opts.isStartRange) {
                arr.push('is-startrange');
            }
            if (opts.isEndRange) {
                arr.push('is-endrange');
            }
            return '<td data-day="' + opts.day + '" class="' + arr.join(' ') + '" aria-selected="' + ariaSelected + '">' +
                '<button class="pika-button pika-day" type="button" ' +
                'data-pika-year="' + opts.year + '" data-pika-month="' + opts.month + '" data-pika-day="' + opts.day + '">' +
                opts.day +
                '</button>' +
                '</td>';
        },

        renderWeek = function (d, m, y) {
            // Lifted from http://javascript.about.com/library/blweekyear.htm, lightly modified.
            var onejan = new Date(y, 0, 1),
                weekNum = Math.ceil((((new Date(y, m, d) - onejan) / 86400000) + onejan.getDay() + 1) / 7);
            return '<td class="pika-week">' + weekNum + '</td>';
        },

        renderRow = function (days, isRTL) {
            return '<tr>' + (isRTL ? days.reverse() : days).join('') + '</tr>';
        },

        renderBody = function (rows) {
            return '<tbody>' + rows.join('') + '</tbody>';
        },

        renderHead = function (opts) {
            var i, arr = [];
            if (opts.showWeekNumber) {
                arr.push('<th></th>');
            }
            for (i = 0; i < 7; i++) {
                arr.push('<th scope="col"><abbr title="' + renderDayName(opts, i) + '">' + renderDayName(opts, i, true) + '</abbr></th>');
            }
            return '<thead><tr>' + (opts.isRTL ? arr.reverse() : arr).join('') + '</tr></thead>';
        },

        renderTitle = function (instance, c, year, month, refYear, randId) {
            var i, j, arr,
                opts = instance._o,
                isMinYear = year === opts.minYear,
                isMaxYear = year === opts.maxYear,
                html = '<div id="' + randId + '" class="pika-title" role="heading" aria-live="assertive">',
                monthHtml,
                yearHtml,
                prev = true,
                next = true;

            for (arr = [], i = 0; i < 12; i++) {
                arr.push('<option value="' + (year === refYear ? i - c : 12 + i - c) + '"' +
                    (i === month ? ' selected="selected"' : '') +
                    ((isMinYear && i < opts.minMonth) || (isMaxYear && i > opts.maxMonth) ? 'disabled="disabled"' : '') + '>' +
                    opts.i18n.months[i] + '</option>');
            }

            monthHtml = '<div class="pika-label">' + opts.i18n.months[month] + '<select class="pika-select pika-select-month" tabindex="-1">' + arr.join('') + '</select></div>';

            if (isArray(opts.yearRange)) {
                i = opts.yearRange[0];
                j = opts.yearRange[1] + 1;
            } else {
                i = year - opts.yearRange;
                j = 1 + year + opts.yearRange;
            }

            for (arr = []; i < j && i <= opts.maxYear; i++) {
                if (i >= opts.minYear) {
                    arr.push('<option value="' + i + '"' + (i === year ? ' selected="selected"' : '') + '>' + (i) + '</option>');
                }
            }
            yearHtml = '<div class="pika-label">' + year + opts.yearSuffix + '<select class="pika-select pika-select-year" tabindex="-1">' + arr.join('') + '</select></div>';

            if (opts.showMonthAfterYear) {
                html += yearHtml + monthHtml;
            } else {
                html += monthHtml + yearHtml;
            }

            if (isMinYear && (month === 0 || opts.minMonth >= month)) {
                prev = false;
            }

            if (isMaxYear && (month === 11 || opts.maxMonth <= month)) {
                next = false;
            }

            if (c === 0) {
                html += '<button class="pika-prev' + (prev ? '' : ' is-disabled') + '" type="button">' + opts.i18n.previousMonth + '</button>';
            }
            if (c === (instance._o.numberOfMonths - 1)) {
                html += '<button class="pika-next' + (next ? '' : ' is-disabled') + '" type="button">' + opts.i18n.nextMonth + '</button>';
            }

            return html += '</div>';
        },

        renderTable = function (opts, data, randId) {
            return '<table cellpadding="0" cellspacing="0" class="pika-table" role="grid" aria-labelledby="' + randId + '">' + renderHead(opts) + renderBody(data) + '</table>';
        },


        /**
         * Pikaday constructor
         */
        Pikaday = function (options) {
            var self = this,
                opts = self.config(options);

            self._onMouseDown = function (e) {
                if (!self._v) {
                    return;
                }
                e = e || window.event;
                var target = e.target || e.srcElement;
                if (!target) {
                    return;
                }

                if (!hasClass(target, 'is-disabled')) {
                    if (hasClass(target, 'pika-button') && !hasClass(target, 'is-empty') && !hasClass(target.parentNode, 'is-disabled')) {
                        self.setDate(new Date(target.getAttribute('data-pika-year'), target.getAttribute('data-pika-month'), target.getAttribute('data-pika-day')));
                        if (opts.bound) {
                            sto(function () {
                                self.hide();
                                if (opts.field) {
                                    opts.field.blur();
                                }
                            }, 100);
                        }
                    }
                    else if (hasClass(target, 'pika-prev')) {
                        self.prevMonth();
                    }
                    else if (hasClass(target, 'pika-next')) {
                        self.nextMonth();
                    }
                }
                if (!hasClass(target, 'pika-select')) {
                    // if this is touch event prevent mouse events emulation
                    if (e.preventDefault) {
                        e.preventDefault();
                    } else {
                        e.returnValue = false;
                        return false;
                    }
                } else {
                    self._c = true;
                }
            };

            self._onChange = function (e) {
                e = e || window.event;
                var target = e.target || e.srcElement;
                if (!target) {
                    return;
                }
                if (hasClass(target, 'pika-select-month')) {
                    self.gotoMonth(target.value);
                }
                else if (hasClass(target, 'pika-select-year')) {
                    self.gotoYear(target.value);
                }
            };

            self._onKeyChange = function (e) {
                e = e || window.event;

                if (self.isVisible()) {

                    switch (e.keyCode) {
                        case 13:
                        case 27:
                            opts.field.blur();
                            break;
                        case 37:
                            e.preventDefault();
                            self.adjustDate('subtract', 1);
                            break;
                        case 38:
                            self.adjustDate('subtract', 7);
                            break;
                        case 39:
                            self.adjustDate('add', 1);
                            break;
                        case 40:
                            self.adjustDate('add', 7);
                            break;
                    }
                }
            };

            self._onInputChange = function (e) {
                var date;

                if (e.firedBy === self) {
                    return;
                }
                if (hasMoment) {
                    date = moment(opts.field.value, opts.format, opts.formatStrict);
                    date = (date && date.isValid()) ? date.toDate() : null;
                }
                else {
                    date = new Date(Date.parse(opts.field.value));
                }
                if (isDate(date)) {
                    self.setDate(date);
                }
                if (!self._v) {
                    self.show();
                }
            };

            self._onInputFocus = function () {
                self.show();
            };

            self._onInputClick = function () {
                self.show();
            };

            self._onInputBlur = function () {
                // IE allows pika div to gain focus; catch blur the input field
                var pEl = document.activeElement;
                do {
                    if (hasClass(pEl, 'pika-single')) {
                        return;
                    }
                }
                while ((pEl = pEl.parentNode));

                if (!self._c) {
                    self._b = sto(function () {
                        self.hide();
                    }, 50);
                }
                self._c = false;
            };

            self._onClick = function (e) {
                e = e || window.event;
                var target = e.target || e.srcElement,
                    pEl = target;
                if (!target) {
                    return;
                }
                if (!hasEventListeners && hasClass(target, 'pika-select')) {
                    if (!target.onchange) {
                        target.setAttribute('onchange', 'return;');
                        addEvent(target, 'change', self._onChange);
                    }
                }
                do {
                    if (hasClass(pEl, 'pika-single') || pEl === opts.trigger) {
                        return;
                    }
                }
                while ((pEl = pEl.parentNode));
                if (self._v && target !== opts.trigger && pEl !== opts.trigger) {
                    self.hide();
                }
            };

            self.el = document.createElement('div');
            self.el.className = 'pika-single' + (opts.isRTL ? ' is-rtl' : '') + (opts.theme ? ' ' + opts.theme : '');

            addEvent(self.el, 'mousedown', self._onMouseDown, true);
            addEvent(self.el, 'touchend', self._onMouseDown, true);
            addEvent(self.el, 'change', self._onChange);
            addEvent(document, 'keydown', self._onKeyChange);

            if (opts.field) {
                if (opts.container) {
                    opts.container.appendChild(self.el);
                } else if (opts.bound) {
                    document.body.appendChild(self.el);
                } else {
                    opts.field.parentNode.insertBefore(self.el, opts.field.nextSibling);
                }
                addEvent(opts.field, 'change', self._onInputChange);

                if (!opts.defaultDate) {
                    if (hasMoment && opts.field.value) {
                        opts.defaultDate = moment(opts.field.value, opts.format).toDate();
                    } else {
                        opts.defaultDate = new Date(Date.parse(opts.field.value));
                    }
                    opts.setDefaultDate = true;
                }
            }

            var defDate = opts.defaultDate;

            if (isDate(defDate)) {
                if (opts.setDefaultDate) {
                    self.setDate(defDate, true);
                } else {
                    self.gotoDate(defDate);
                }
            } else {
                self.gotoDate(new Date());
            }

            if (opts.bound) {
                this.hide();
                self.el.className += ' is-bound';
                addEvent(opts.trigger, 'click', self._onInputClick);
                addEvent(opts.trigger, 'focus', self._onInputFocus);
                addEvent(opts.trigger, 'blur', self._onInputBlur);
            } else {
                this.show();
            }
        };


    /**
     * public Pikaday API
     */
    Pikaday.prototype = {


        /**
         * configure functionality
         */
        config: function (options) {
            if (!this._o) {
                this._o = extend({}, defaults, true);
            }

            var opts = extend(this._o, options, true);

            opts.isRTL = !!opts.isRTL;

            opts.field = (opts.field && opts.field.nodeName) ? opts.field : null;

            opts.theme = (typeof opts.theme) === 'string' && opts.theme ? opts.theme : null;

            opts.bound = !!(opts.bound !== undefined ? opts.field && opts.bound : opts.field);

            opts.trigger = (opts.trigger && opts.trigger.nodeName) ? opts.trigger : opts.field;

            opts.disableWeekends = !!opts.disableWeekends;

            opts.disableDayFn = (typeof opts.disableDayFn) === 'function' ? opts.disableDayFn : null;

            var nom = parseInt(opts.numberOfMonths, 10) || 1;
            opts.numberOfMonths = nom > 4 ? 4 : nom;

            if (!isDate(opts.minDate)) {
                opts.minDate = false;
            }
            if (!isDate(opts.maxDate)) {
                opts.maxDate = false;
            }
            if ((opts.minDate && opts.maxDate) && opts.maxDate < opts.minDate) {
                opts.maxDate = opts.minDate = false;
            }
            if (opts.minDate) {
                this.setMinDate(opts.minDate);
            }
            if (opts.maxDate) {
                this.setMaxDate(opts.maxDate);
            }

            if (isArray(opts.yearRange)) {
                var fallback = new Date().getFullYear() - 10;
                opts.yearRange[0] = parseInt(opts.yearRange[0], 10) || fallback;
                opts.yearRange[1] = parseInt(opts.yearRange[1], 10) || fallback;
            } else {
                opts.yearRange = Math.abs(parseInt(opts.yearRange, 10)) || defaults.yearRange;
                if (opts.yearRange > 100) {
                    opts.yearRange = 100;
                }
            }

            return opts;
        },

        /**
         * return a formatted string of the current selection (using Moment.js if available)
         */
        toString: function (format) {
            return !isDate(this._d) ? '' : hasMoment ? moment(this._d).format(format || this._o.format) : this._d.toDateString();
        },

        /**
         * return a Moment.js object of the current selection (if available)
         */
        getMoment: function () {
            return hasMoment ? moment(this._d) : null;
        },

        /**
         * set the current selection from a Moment.js object (if available)
         */
        setMoment: function (date, preventOnSelect) {
            if (hasMoment && moment.isMoment(date)) {
                this.setDate(date.toDate(), preventOnSelect);
            }
        },

        /**
         * return a Date object of the current selection with fallback for the current date
         */
        getDate: function () {
            return isDate(this._d) ? new Date(this._d.getTime()) : new Date();
        },

        /**
         * set the current selection
         */
        setDate: function (date, preventOnSelect) {
            if (!date) {
                this._d = null;

                if (this._o.field) {
                    this._o.field.value = '';
                    fireEvent(this._o.field, 'change', {firedBy: this});
                }

                return this.draw();
            }
            if (typeof date === 'string') {
                date = new Date(Date.parse(date));
            }
            if (!isDate(date)) {
                return;
            }

            var min = this._o.minDate,
                max = this._o.maxDate;

            if (isDate(min) && date < min) {
                date = min;
            } else if (isDate(max) && date > max) {
                date = max;
            }

            this._d = new Date(date.getTime());
            setToStartOfDay(this._d);
            this.gotoDate(this._d);

            if (this._o.field) {
                this._o.field.value = this.toString();
                fireEvent(this._o.field, 'change', {firedBy: this});
            }
            if (!preventOnSelect && typeof this._o.onSelect === 'function') {
                this._o.onSelect.call(this, this.getDate());
            }
        },

        /**
         * change view to a specific date
         */
        gotoDate: function (date) {
            var newCalendar = true;

            if (!isDate(date)) {
                return;
            }

            if (this.calendars) {
                var firstVisibleDate = new Date(this.calendars[0].year, this.calendars[0].month, 1),
                    lastVisibleDate = new Date(this.calendars[this.calendars.length - 1].year, this.calendars[this.calendars.length - 1].month, 1),
                    visibleDate = date.getTime();
                // get the end of the month
                lastVisibleDate.setMonth(lastVisibleDate.getMonth() + 1);
                lastVisibleDate.setDate(lastVisibleDate.getDate() - 1);
                newCalendar = (visibleDate < firstVisibleDate.getTime() || lastVisibleDate.getTime() < visibleDate);
            }

            if (newCalendar) {
                this.calendars = [{
                    month: date.getMonth(),
                    year: date.getFullYear()
                }];
                if (this._o.mainCalendar === 'right') {
                    this.calendars[0].month += 1 - this._o.numberOfMonths;
                }
            }

            this.adjustCalendars();
        },

        adjustDate: function (sign, days) {

            var day = this.getDate();
            var difference = parseInt(days) * 24 * 60 * 60 * 1000;

            var newDay;

            if (sign === 'add') {
                newDay = new Date(day.valueOf() + difference);
            } else if (sign === 'subtract') {
                newDay = new Date(day.valueOf() - difference);
            }

            if (hasMoment) {
                if (sign === 'add') {
                    newDay = moment(day).add(days, "days").toDate();
                } else if (sign === 'subtract') {
                    newDay = moment(day).subtract(days, "days").toDate();
                }
            }

            this.setDate(newDay);
        },

        adjustCalendars: function () {
            this.calendars[0] = adjustCalendar(this.calendars[0]);
            for (var c = 1; c < this._o.numberOfMonths; c++) {
                this.calendars[c] = adjustCalendar({
                    month: this.calendars[0].month + c,
                    year: this.calendars[0].year
                });
            }
            this.draw();
        },

        gotoToday: function () {
            this.gotoDate(new Date());
        },

        /**
         * change view to a specific month (zero-index, e.g. 0: January)
         */
        gotoMonth: function (month) {
            if (!isNaN(month)) {
                this.calendars[0].month = parseInt(month, 10);
                this.adjustCalendars();
            }
        },

        nextMonth: function () {
            this.calendars[0].month++;
            this.adjustCalendars();
        },

        prevMonth: function () {
            this.calendars[0].month--;
            this.adjustCalendars();
        },

        /**
         * change view to a specific full year (e.g. "2012")
         */
        gotoYear: function (year) {
            if (!isNaN(year)) {
                this.calendars[0].year = parseInt(year, 10);
                this.adjustCalendars();
            }
        },

        /**
         * change the minDate
         */
        setMinDate: function (value) {
            if (value instanceof Date) {
                setToStartOfDay(value);
                this._o.minDate = value;
                this._o.minYear = value.getFullYear();
                this._o.minMonth = value.getMonth();
            } else {
                this._o.minDate = defaults.minDate;
                this._o.minYear = defaults.minYear;
                this._o.minMonth = defaults.minMonth;
                this._o.startRange = defaults.startRange;
            }

            this.draw();
        },

        /**
         * change the maxDate
         */
        setMaxDate: function (value) {
            if (value instanceof Date) {
                setToStartOfDay(value);
                this._o.maxDate = value;
                this._o.maxYear = value.getFullYear();
                this._o.maxMonth = value.getMonth();
            } else {
                this._o.maxDate = defaults.maxDate;
                this._o.maxYear = defaults.maxYear;
                this._o.maxMonth = defaults.maxMonth;
                this._o.endRange = defaults.endRange;
            }

            this.draw();
        },

        setStartRange: function (value) {
            this._o.startRange = value;
        },

        setEndRange: function (value) {
            this._o.endRange = value;
        },

        /**
         * refresh the HTML
         */
        draw: function (force) {
            if (!this._v && !force) {
                return;
            }
            var opts = this._o,
                minYear = opts.minYear,
                maxYear = opts.maxYear,
                minMonth = opts.minMonth,
                maxMonth = opts.maxMonth,
                html = '',
                randId;

            if (this._y <= minYear) {
                this._y = minYear;
                if (!isNaN(minMonth) && this._m < minMonth) {
                    this._m = minMonth;
                }
            }
            if (this._y >= maxYear) {
                this._y = maxYear;
                if (!isNaN(maxMonth) && this._m > maxMonth) {
                    this._m = maxMonth;
                }
            }

            randId = 'pika-title-' + Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 2);

            for (var c = 0; c < opts.numberOfMonths; c++) {
                html += '<div class="pika-lendar">' + renderTitle(this, c, this.calendars[c].year, this.calendars[c].month, this.calendars[0].year, randId) + this.render(this.calendars[c].year, this.calendars[c].month, randId) + '</div>';
            }

            this.el.innerHTML = html;

            if (opts.bound) {
                if (opts.field.type !== 'hidden') {
                    sto(function () {
                        opts.trigger.focus();
                    }, 1);
                }
            }

            if (typeof this._o.onDraw === 'function') {
                this._o.onDraw(this);
            }
            // let the screen reader user know to use arrow keys
            this._o.field.setAttribute('aria-label', 'Use the arrow keys to pick a date');
        },

        adjustPosition: function () {
            var field, pEl, width, height, viewportWidth, viewportHeight, scrollTop, left, top, clientRect;

            if (this._o.container) return;

            this.el.style.position = 'absolute';

            field = this._o.trigger;
            pEl = field;
            width = this.el.offsetWidth;
            height = this.el.offsetHeight;
            viewportWidth = window.innerWidth || document.documentElement.clientWidth;
            viewportHeight = window.innerHeight || document.documentElement.clientHeight;
            scrollTop = window.pageYOffset || document.body.scrollTop || document.documentElement.scrollTop;

            if (typeof field.getBoundingClientRect === 'function') {
                clientRect = field.getBoundingClientRect();
                left = clientRect.left + window.pageXOffset;
                top = clientRect.bottom + window.pageYOffset;
            } else {
                left = pEl.offsetLeft;
                top = pEl.offsetTop + pEl.offsetHeight;
                while ((pEl = pEl.offsetParent)) {
                    left += pEl.offsetLeft;
                    top += pEl.offsetTop;
                }
            }

            // default position is bottom & left
            if ((this._o.reposition && left + width > viewportWidth) ||
                (
                    this._o.position.indexOf('right') > -1 &&
                    left - width + field.offsetWidth > 0
                )
            ) {
                left = left - width + field.offsetWidth;
            }
            if ((this._o.reposition && top + height > viewportHeight + scrollTop) ||
                (
                    this._o.position.indexOf('top') > -1 &&
                    top - height - field.offsetHeight > 0
                )
            ) {
                top = top - height - field.offsetHeight;
            }

            this.el.style.left = left + 'px';
            this.el.style.top = top + 'px';
        },

        /**
         * render HTML for a particular month
         */
        render: function (year, month, randId) {
            var opts = this._o,
                now = new Date(),
                days = getDaysInMonth(year, month),
                before = new Date(year, month, 1).getDay(),
                data = [],
                row = [];
            setToStartOfDay(now);
            if (opts.firstDay > 0) {
                before -= opts.firstDay;
                if (before < 0) {
                    before += 7;
                }
            }
            var previousMonth = month === 0 ? 11 : month - 1,
                nextMonth = month === 11 ? 0 : month + 1,
                yearOfPreviousMonth = month === 0 ? year - 1 : year,
                yearOfNextMonth = month === 11 ? year + 1 : year,
                daysInPreviousMonth = getDaysInMonth(yearOfPreviousMonth, previousMonth);
            var cells = days + before,
                after = cells;
            while (after > 7) {
                after -= 7;
            }
            cells += 7 - after;
            for (var i = 0, r = 0; i < cells; i++) {
                var day = new Date(year, month, 1 + (i - before)),
                    isSelected = isDate(this._d) ? compareDates(day, this._d) : false,
                    isToday = compareDates(day, now),
                    isEmpty = i < before || i >= (days + before),
                    dayNumber = 1 + (i - before),
                    monthNumber = month,
                    yearNumber = year,
                    isStartRange = opts.startRange && compareDates(opts.startRange, day),
                    isEndRange = opts.endRange && compareDates(opts.endRange, day),
                    isInRange = opts.startRange && opts.endRange && opts.startRange < day && day < opts.endRange,
                    isDisabled = (opts.minDate && day < opts.minDate) ||
                        (opts.maxDate && day > opts.maxDate) ||
                        (opts.disableWeekends && isWeekend(day)) ||
                        (opts.disableDayFn && opts.disableDayFn(day));

                if (isEmpty) {
                    if (i < before) {
                        dayNumber = daysInPreviousMonth + dayNumber;
                        monthNumber = previousMonth;
                        yearNumber = yearOfPreviousMonth;
                    } else {
                        dayNumber = dayNumber - days;
                        monthNumber = nextMonth;
                        yearNumber = yearOfNextMonth;
                    }
                }

                var dayConfig = {
                    day: dayNumber,
                    month: monthNumber,
                    year: yearNumber,
                    isSelected: isSelected,
                    isToday: isToday,
                    isDisabled: isDisabled,
                    isEmpty: isEmpty,
                    isStartRange: isStartRange,
                    isEndRange: isEndRange,
                    isInRange: isInRange,
                    showDaysInNextAndPreviousMonths: opts.showDaysInNextAndPreviousMonths
                };

                row.push(renderDay(dayConfig));

                if (++r === 7) {
                    if (opts.showWeekNumber) {
                        row.unshift(renderWeek(i - before, month, year));
                    }
                    data.push(renderRow(row, opts.isRTL));
                    row = [];
                    r = 0;
                }
            }
            return renderTable(opts, data, randId);
        },

        isVisible: function () {
            return this._v;
        },

        show: function () {
            if (!this.isVisible()) {
                removeClass(this.el, 'is-hidden');
                this._v = true;
                this.draw();
                if (this._o.bound) {
                    addEvent(document, 'click', this._onClick);
                    this.adjustPosition();
                }
                if (typeof this._o.onOpen === 'function') {
                    this._o.onOpen.call(this);
                }
            }
        },

        hide: function () {
            var v = this._v;
            if (v !== false) {
                if (this._o.bound) {
                    removeEvent(document, 'click', this._onClick);
                }
                this.el.style.position = 'static'; // reset
                this.el.style.left = 'auto';
                this.el.style.top = 'auto';
                addClass(this.el, 'is-hidden');
                this._v = false;
                if (v !== undefined && typeof this._o.onClose === 'function') {
                    this._o.onClose.call(this);
                }
            }
        },

        /**
         * GAME OVER
         */
        destroy: function () {
            this.hide();
            removeEvent(this.el, 'mousedown', this._onMouseDown, true);
            removeEvent(this.el, 'touchend', this._onMouseDown, true);
            removeEvent(this.el, 'change', this._onChange);
            if (this._o.field) {
                removeEvent(this._o.field, 'change', this._onInputChange);
                if (this._o.bound) {
                    removeEvent(this._o.trigger, 'click', this._onInputClick);
                    removeEvent(this._o.trigger, 'focus', this._onInputFocus);
                    removeEvent(this._o.trigger, 'blur', this._onInputBlur);
                }
            }
            if (this.el.parentNode) {
                this.el.parentNode.removeChild(this.el);
            }
        }

    };

    return Pikaday;

}));

/*!
 * Pikaday jQuery plugin.
 *
 * Copyright © 2013 David Bushell | BSD & MIT license | https://github.com/dbushell/Pikaday
 */

(function (root, factory) {
    'use strict';

    if (typeof exports === 'object') {
        // CommonJS module
        factory(require('jquery'), require('../pikaday'));
    } else if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery', 'pikaday'], factory);
    } else {
        // Browser globals
        factory(root.jQuery, root.Pikaday);
    }
}(this, function ($, Pikaday) {
    'use strict';

    $.fn.pikaday = function () {
        var args = arguments;

        if (!args || !args.length) {
            args = [{}];
        }

        return this.each(function () {
            var self = $(this),
                plugin = self.data('pikaday');

            if (!(plugin instanceof Pikaday)) {
                if (typeof args[0] === 'object') {
                    var options = $.extend({}, args[0]);
                    options.field = self[0];
                    self.data('pikaday', new Pikaday(options));
                }
            } else {
                if (typeof args[0] === 'string' && typeof plugin[args[0]] === 'function') {
                    plugin[args[0]].apply(plugin, Array.prototype.slice.call(args, 1));

                    if (args[0] === 'destroy') {
                        self.removeData('pikaday');
                    }
                }
            }
        });
    };

}));


$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    setTimeout(function () {
        $('[data-toggle="tooltip"]').tooltip('show');
    }, 6000);

    $('.radio').click(function () {
        $(this).addClass("active");
        $(this).siblings(".radio").removeClass("active");
    });

    $('a[data-toggle="tab"]').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // first page
    /*

     $("#first_step_outer").fadeOut(700, function () {
     $('#first_step_outer').html($('#second_step_outer').removeClass('no-display-visibility').html());
     $('#second_step_outer').addClass('no-display');
     $("#first_step_outer").fadeIn(700, function () {
     */
    // setTimeout(function () {

    //  }, 7000);
    /*
     });
     });
     }, 7000); */

    $("#logout_button").on("click", function () {
        $("#hidden-logout").trigger("click");
    });


    $('#payment_info_button').click(function (e) {
        e.preventDefault();
        $('#payment_info_edit').removeClass('no-display');
    });

    $('#datepn').pikaday({format: 'MM/DD/YYYY', yearRange: [1920, 2000]});

    $('#contact_support').on('submit', function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        var formAction = $(this).attr('action');
        var formMethod = $(this).attr('method');

        $.ajax({
            type: formMethod,
            url: formAction,
            data: formData,
            cache: false,

            success: function (data) {
                toastr.success("Message was sent.", "Success");
            },

            error: function (jqXhr, json, errorThrown) {
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                $.each(errors, function (key, value) {
                    if (jQuery.isArray(value)) {
                        $.each(value, function (key, error) {
                            console.log(error);
                            errorsHtml += '<li>' + error + '</li>';
                        })
                    }

                });
                toastr.error(errorsHtml, "Error " + jqXhr.status + ': ' + errorThrown);
            }
        });

        return false;
    });

    $('#contact_join').on('submit', function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        var formAction = $(this).attr('action');
        var formMethod = $(this).attr('method');

        $.ajax({
            type: formMethod,
            url: formAction,
            data: formData,
            cache: false,

            success: function (data) {
                toastr.success("Message was sent.", "Success");
            },

        });

        return false;
    });

    $('#payment_edit_form').on('submit', function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        var formAction = $(this).attr('action');
        var formMethod = $(this).attr('method');

        $.ajax({
            type: formMethod,
            url: formAction,
            data: formData,
            cache: false,

            beforeSend: function () {
                //   console.log(formData);
            },

            success: function (data) {
                toastr.success("Payment information was updated", "Success");
            },

            error: function (jqXhr, json, errorThrown) {
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                $.each(errors, function (key, value) {
                    if (jQuery.isArray(value)) {
                        $.each(value, function (key, error) {
                            console.log(error);
                            errorsHtml += '<li>' + error + '</li>';
                        })
                    }

                });
                toastr.error(errorsHtml, "Error " + jqXhr.status + ': ' + errorThrown);
            }
        });

        return false;
    });


    // section with multiple progress bar/tabs
    if ($('.wait-report-section').length) {
        function centerModal() {
            $(this).css('display', 'block');
            var $dialog = $(this).find(".modal-dialog"),
                offset = ($(window).height() - $dialog.height()) / 2,
                bottomMargin = parseInt($dialog.css('marginBottom'), 10);

            // Make sure you don't hide the top part of the modal w/ a negative margin if it's longer than the screen height, and keep the margin equal to the bottom margin of the modal
            if (offset < bottomMargin) offset = bottomMargin;
            $dialog.css("margin-top", offset);
        }

        $(document).on('show.bs.modal', '.modal', centerModal);
        $(window).on("resize", function () {
            $('.modal:visible').each(centerModal);
        });
        setTimeout(function () {
            $('.personal-1').modal({
                backdrop: false
            });
        }, 7000);


        $('ul li #connectionProgressBar2').each(function (index, element) {
            $(element).delay(index * 8000).queue(function () {
                setTimeout(function () {
                    var title = $(element).data('title');
                    $('.horoscope-title').text(title);
                    $('.horoscope-text').text($(element).data('info'));
                    progressBarVertical(element);
                    setTimeout(function () {
                        //     $(element).prev().text('100% Complete');
                        //$(element).parent().addClass('progress_full');
                        $(element).addClass('progress_full');
                        //     $(element).parent('#connectionProgressId').parent().addClass('progress_full');
                        //    $(element).parent('#connectionProgressId').parent().parent().addClass('progress_full');
                    }, 8000);
                }, 100);
            });
        });

        move(600, 60, 'connectionProgressBar', '#timer', 'text');
        setTimeout(function () {
            window.location.href = "/readyMap?registration_token=" + $('#registration_token').val();
        }, 64000);

    }

    // connecting to * specialist
    if ($('.spinner-wrapper').length && $('#monitor-chat-modal-id').length == 0) {

        function centerModal() {
            $(this).css('display', 'block');
            var $dialog = $(this).find(".modal-dialog:not(#not-resize)"),
                offset = ($(window).height() - $dialog.height()) / 2,
                bottomMargin = parseInt($dialog.css('marginBottom'), 10);

            // Make sure you don't hide the top part of the modal w/ a negative margin if it's longer than the screen height, and keep the margin equal to the bottom margin of the modal
            if (offset < bottomMargin) offset = bottomMargin;
            $dialog.css("margin-top", offset);
        }

        $(document).on('show.bs.modal', '.modal', centerModal);
        $(window).on("resize", function () {
            $('.modal:visible').each(centerModal);
        });
        setTimeout(function () {
            //  $('.personal-1').modal({
            //      backdrop: false
            //   });
        }, 7000);

        move(120, 30);
        //  setTimeout(function () {
        //      $('#request-processing-modal-id').modal('show');
        //       move(50, 10, 'connectionProgressBar2', '#timer2');
        //   }, 12000);
        setTimeout(function () {
            console.log('redirect');
            window.location.href = "/signUpMapComplete?registration_token=" + $('#registration_token').val();
        }, 12000);
    }

    $('#18-year-confirm').click(function (e) {
        e.preventDefault();
        $('#confirm_question').slideDown(200).hide();
        $('#confirm_question_second').show();
    });

    // select sign page
    $('.select-sign .radio').click(function () {
        $(this).addClass("active");
        $(this).parent().siblings().find(".radio").removeClass("active");
    });

    // Select states
    $(".dropdown-menu li a").click(function () {
        $(this).parents(".btn-group").find('.btn').html($(this).text() + ' <img src="../images/arrow-up-down.png" alt=""/>');
        $(this).parents(".btn-group").find('input').val($(this).text());

        //Fill cities
        if ($(this).data('code')) {
            $.get('/dashboard/get-cities?state_code=' + $(this).data('code'), function (data) {

                $('#select_city').empty();

                $.each(data, function (index, city) {
                    $('#select_city').append('<li><a href="#">' + city.city + '</a></li>');
                });
                $(".dropdown-menu li a").click(function () {
                    $(this).parents(".btn-group").find('.btn').html($(this).text() + ' <img src="../images/arrow-up-down.png" alt=""/>');
                    $(this).parents(".btn-group").find('input').val($(this).text());
                });
            });
        }
    });

    $('#email_report').bind("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('.email-report-modal-id').modal();
        var report_id = $(this).data('id');
        $('.email-report-modal-id #email_report_button').bind("click", function (e) {
            $.ajax({
                type: "GET",
                async: false,
                url: '/payment/payForEmailReport/' + report_id,
                success: function (responce) {
                    $.ajax({
                        type: "GET",
                        async: false,
                        url: '/reports/email/' + report_id,
                        success: function (responce) {
                            toastr.success("Email with the report was sent.", "Success");
                            $('.email-report-modal-id').modal('hide');
                        },
                        error: function (responce) {
                            toastr.error(responce.responseText, "Error");
                        }
                    });
                },
                error: function (responce) {
                    toastr.error(responce.responseText, "Error");
                }
            });
        });
    });

    $(document).on("click", "#download_report", function (e) {
        e.preventDefault();
        $('.download-report-modal-id').modal();
        var report_id = $(this).data('id');
        $(document).on("click", "#download_report_button", function (e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                async: false,
                url: '/payment/payForDownloadPdfReport/' + report_id,
                success: function (responce) {
                    toastr.success("Download report will start soon", "Success");
                    $('.download-report-modal-id').modal('hide');
                    setTimeout(function () {
                        window.open(
                            '/reports/downloadpdf/' + report_id,
                            '_blank' // <- This is what makes it open in a new window.
                        );
                    }, 1000);


                },
                error: function (responce) {
                    toastr.error(responce.responseText, "Error");
                }
            });
        });
    });

    $(document).on("click", "#email_chat", function (e) {
        e.preventDefault();
        $('.email-chat-modal-id').modal();
        var chat_id = $(this).data('id');
        $(document).on("click", "#email_chat_button", function (e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                async: false,
                url: '/payment/payForEmailChat/' + chat_id,
                success: function (responce) {
                    $.ajax({
                        type: "GET",
                        async: false,
                        url: '/reports/emailChat/' + chat_id,
                        success: function (responce) {
                            toastr.success("Email with the chat was sent.", "Success");
                            $('.email-chat-modal-id').modal('hide');
                        },
                        error: function (responce) {
                            toastr.error(responce.responseText, "Error");
                        }
                    });
                },
                error: function (responce) {
                    toastr.error(responce.responseText, "Error");
                }
            });
        });
    });

    $(document).on("click", "#add_funds", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('#add-funds-modal-id').modal();

    });

    $(document).on("click", "#add_payment_info", function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('click', e);
        $('#add-minutes-checkout-modal-id').modal();

    });

    $(document).on("click", "#buy_future_report", function (e) {
        e.preventDefault();
        $(this).text('Loading...').val('Loading...');
        $(this).attr('disabled', 'disabled');

        $.ajax({
            type: "POST",
            url: '/payment/buyReport',
            data: {
                'sku': '521632',
            },
            success: function (responce) {
                toastr.success("You have bought Future Report. You will be redirected to it now.", "Success");
                $('#future-forecast-modal-id').modal('toggle');
                setTimeout(function () {
                    window.location.href = "/dashboard/show-report/Future-Forecast-Report"
                }, 500);
            },
            error: function (responce) {
                toastr.error(responce.responseText, "Error");
            }
        });
    });

    $(document).on("click", "#buy_love_report", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: '/dashboard/romantic-report',
            data: {
                'sku': '521631',
            },
            success: function (responce) {
                toastr.success("You have bought Romantic Report. You will be redirected to fill it.", "Success");
                $('#romantic-map-modal-id').modal('toggle');
                setTimeout(function () {
                    window.location.href = "/dashboard/romantic-report"
                }, 500);
            },
            error: function (responce) {
                toastr.error(responce.responseText, "Error");
            }
        });
    });

    $(document).on("click", "#buy_natal_report", function (e) {
        e.preventDefault();
        $(this).text('Loading...').val('Loading...');
        $(this).attr('disabled', 'disabled');

        $.ajax({
            type: "POST",
            url: '/payment/buyReport',
            data: {
                'sku': '521630',
            },
            success: function (responce) {
                toastr.success("You have bought Personal Map Report. You will be redirected to it now.", "Success");
                $('#personal-map-modal-id').modal('toggle');
                setTimeout(function () {
                    window.location.href = "/dashboard/show-report/Personal-Astrology-Report"
                }, 500);
            },
            error: function (responce) {
                toastr.error(responce.responseText, "Error");
            }
        });
    });

    $(document).on("click", "#buy_natal_report_new", function (e) {
        e.preventDefault();

        var button = $(this);
        var form = $('#report_form');
        button.text('Loading...').val('Loading...');
        button.attr('disabled', 'disabled');
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            dataType: 'json',
            data: form.serialize(),
            success: function (responce) {
                toastr.success("You have bought Personal Map Report. You will be redirected to it now.", "Success");
                $('.personal-map-new-modal-id').modal('toggle');
                setTimeout(function () {
                    window.location.href = "/reports/view-report/" + responce.id;
                }, 500);
            },
            error: function (responce) {
                $('.personal-map-new-modal-id').modal('toggle');
                toastr.error(responce.responseText, "Error");

                button.text('ACCESS NOW').val('ACCESS NOW');
                button.attr('disabled', false);
            }
        });
    });


    $(document).on("click", "#add_5_minutes", function (e) {
        e.preventDefault();
        if (!$(this).hasClass('clicked')) {
            $(this).html('<div style="width:60px;height:70px;"><img style="padding:15px;" src="/images/lightbox-ico-loading.gif" /></div>').addClass('clicked');
            $.ajax({
                type: "POST",
                url: '/payment/buyPackage',
                data: {
                    'sku': '521622',
                },
                success: function (responce) {
                    toastr.success("You have bought 5 minutes.", "Success");
                    $('#add-funds-modal-id').modal('hide');
                    setTimeout(window.location.reload(), 500);
                },
                error: function (responce) {
                    toastr.error(responce.responseText, "Error");
                }
            });
        }
    });


    $(document).on("submit", "#5_minutes_checkout", function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        var formMethod = $(this).attr('method');

        $.ajax({
            type: formMethod,
            url: '/payment/quickCheckout',
            data: formData,
            cache: false,

            beforeSend: function () {
                console.log(formData);
            },

            success: function (data) {
                toastr.success("You have bought 5 minutes", "Success");
                $('#add-minutes-checkout-modal-id').modal('hide');
                setTimeout(window.location.reload(), 500);
            },

            error: function (responce) {
                console.log(responce);
                toastr.error(responce.responseText, "Error");
            }
        });

        return false;
    });


    $(document).on("click", "#add_5_minutes_cheap", function (e) {
        e.preventDefault();
        if (!$(this).hasClass('clicked')) {
            $(this).html('<div style="width:30px;height:40px;"><img style="padding:5px;" src="/images/lightbox-ico-loading.gif" /></div>').addClass('clicked');
            $.ajax({
                type: "POST",
                url: '/payment/buyPackage',
                data: {
                    'sku': '521634',
                },
                success: function (responce) {
                    toastr.success("You have bought 5 minutes.", "Success");
                    $('#add-funds-modal-id').modal('hide');
                    setTimeout(window.location.reload(), 500);
                },
                error: function (responce) {
                    toastr.error(responce.responseText, "Error");
                }
            });
        }
    });

    $(document).on("click", "#add_10_minutes", function (e) {
        e.preventDefault();
        if (!$(this).hasClass('clicked')) {
            $(this).html('<div style="width:60px;height:70px;"><img style="padding:15px;" src="/images/lightbox-ico-loading.gif" /></div>').addClass('clicked');
            $.ajax({
                type: "POST",
                url: '/payment/buyPackage',
                data: {
                    'sku': '521623',
                },
                success: function (responce) {
                    toastr.success("You have bought 10 minutes.", "Success");
                    $('#add-funds-modal-id').modal('hide');
                    setTimeout(window.location.reload(), 500);
                },
                error: function (responce) {
                    toastr.error(responce.responseText, "Error");
                }
            });
        }
    });

    $(document).on("click", "#add_15_minutes", function (e) {
        e.preventDefault();
        if (!$(this).hasClass('clicked')) {
            $(this).html('<div style="width:60px;height:70px;"><img style="padding:15px;" src="/images/lightbox-ico-loading.gif" /></div>').addClass('clicked');
            $(this).off();
            $.ajax({
                type: "POST",
                url: '/payment/buyPackage',
                data: {
                    'sku': '521624',
                },
                success: function (responce) {
                    toastr.success("You have bought 15 minutes.", "Success");
                    $('#add-funds-modal-id').modal('hide');
                    setTimeout(window.location.reload(), 500);
                },
                error: function (responce) {
                    toastr.error(responce.responseText, "Error");
                }
            });
        }
    });

    $('#email_pop').popover('show');
    $('#email_pop').focus(function () {
        $('#email_pop').popover('destroy')
    });


    $.get('/dashboard/get-states', function (data) {
            $('#state').typeahead({
                source: data,
                afterSelect: function (val) {
                    $('#city').val('').text('').attr('disabled', true);
                    $('#city').typeahead('destroy');
                    $.getJSON('/dashboard/get-cities-auto?state=' + val).done(function (data) {

                            $('#city').typeahead({source: data}).bind('blur', function () {
                                console.log('city', $(this).val());
                                if (data.indexOf($(this).val()) === -1) {
                                    $(this).val('');
                                }
                            });
                        setTimeout(function () {
                            $('#city').val('').text('').attr('disabled', false);
                        }, 200);
                 //
                    });
                }
            });
            $('#state1').typeahead({
                source: data,
                afterSelect: function (val) {
                    $('#city1').typeahead('destroy')
                    $.get('/dashboard/get-cities-auto?state=' + val, function (data) {
                 //       setTimeout(function () {
                        $('#city1').val('').text('').attr('readonly', false);
                        $('#city1').typeahead({source: data}).bind('blur', function () {
                            console.log('city1', $(this).val());
                            if (data.indexOf($(this).val()) === -1) {
                                $(this).val('');
                            }
                        });
               //         }, 1000);
                    });
                }
            });
            $('#state2').typeahead({
                source: data,
                afterSelect: function (val) {
                    $('#city2').typeahead('destroy')
                    $.get('/dashboard/get-cities-auto?state=' + val, function (data) {
                   //     setTimeout(function () {
                        $('#city2').val('').text('').attr('readonly', false);
                        $('#city2').typeahead({source: data}).bind('blur', function () {
                            console.log('city2', $(this).val());
                            if (data.indexOf($(this).val()) === -1) {
                                $(this).val('');
                            }
                        });
                  //  }, 1000);
                    });
                }
            });
        }
    );


    $('#start_now_finish').click(function (e) {
        var first = $("#birth_time").val();
        if (first !== '') {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: '/startNow',
                data: {
                    'registration_token': $('#registration_token').val(),
                    'birth_time': first,
                },
                success: function (responce) {
                    $('#request-processing-modal-id').modal('show');
                    move(50, 10);
                    setTimeout(function () {
                        window.location.href = "/successPage?registration_token=" + $('#registration_token').val();
                    }, 5500);

                }
            });
        }
    });


    $('#datetimepicker1').datetimepicker({
        viewMode: 'days',
        format: 'MM/DD/YYYY',
        allowInputToggle: true
    });
    $('#datetimepicker2').datetimepicker({
        useCurrent: false,
        viewMode: 'days',
        format: 'MM/DD/YYYY',
        allowInputToggle: true
    });
    $("#datetimepicker1").on("dp.change", function (e) {
        $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker2").on("dp.change", function (e) {
        $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });
    
    
    $('.success-page-click').click(function(){
        window.location.href = "/accessReport?registration_token=" + $(this).data('token');
    });

});

function progressBar(element) {
    if ($(element)) {
        var width = 1;
        var id = setInterval(frame, 70);

        function frame() {
            if (width >= 100) {
                clearInterval(id);
            } else {
                width++;

                $(element).width(width + '%');
            }
        }
    }
}

function progressBarVertical(element) {
    if ($(element)) {
        var height = 1;
        var id = setInterval(frame, 50);

        function frame() {
            if (height >= 100) {
                clearInterval(id);
            } else {
                height++;

                $(element).height(height + '%');
            }
        }
    }
}

function move(interval, seconds, element, timer_element, text) {
    element = element || "connectionProgressBar";
    timer_element = timer_element || "#timer";

    var elem = document.getElementById(element);
    if (elem) {
        var width = 1;
        var id = setInterval(frame, interval);

        function frame() {
            if (width >= 100) {
                clearInterval(id);
            } else {
                width++;

                timer(width, seconds, timer_element);

                elem.style.width = width + '%';
                if (typeof text !== 'undefined') {
                    elem.textContent = 'Processing ' + width + '%';
                }
            }
        }
    }
}

function timer(width, seconds, element) {

    element = element || "#timer";

    switch (seconds) {
        case 60:
            if (width == 2)
                $(element).html(59);
            if (width == 4)
                $(element).html(58);
            if (width == 5)
                $(element).html(57);
            if (width == 6)
                $(element).html(56);
            if (width == 8)
                $(element).html(55);
            if (width == 9)
                $(element).html(54);
            if (width == 11)
                $(element).html(52);
            if (width == 13)
                $(element).html(50);
            if (width == 15)
                $(element).html(48);
            if (width == 17)
                $(element).html(47);
            if (width == 18)
                $(element).html(45);
            if (width == 20)
                $(element).html(43);
            if (width == 22)
                $(element).html(41);
            if (width == 24)
                $(element).html(40);
            if (width == 25)
                $(element).html(39);
            if (width == 28)
                $(element).html(38);
            if (width == 32)
                $(element).html(36);
            if (width == 34)
                $(element).html(34);
            if (width == 38)
                $(element).html(33);
            if (width == 40)
                $(element).html(31);
            if (width == 43)
                $(element).html(30);
            if (width == 48)
                $(element).html(28);
            if (width == 50)
                $(element).html(27);
            if (width == 55)
                $(element).html(25);
            if (width == 58)
                $(element).html(24);
            if (width == 62)
                $(element).html(22);
            if (width == 66)
                $(element).html(20);
            if (width == 69)
                $(element).html(19);
            if (width == 74)
                $(element).html(18);
            if (width == 78)
                $(element).html(16);
            if (width == 80)
                $(element).html(14);
            if (width == 82)
                $(element).html(13);
            if (width == 84)
                $(element).html(12);
            if (width == 86)
                $(element).html(11);
            if (width == 88)
                $(element).html(10);
            if (width == 90)
                $(element).html("09");
            if (width == 91)
                $(element).html("08");
            if (width == 92)
                $(element).html("07");
            if (width == 93)
                $(element).html("06");
            if (width == 95)
                $(element).html("05");
            if (width == 96)
                $(element).html("04");
            if (width == 97)
                $(element).html("03");
            if (width == 98)
                $(element).html("02");
            if (width == 99)
                $(element).html("01");
            if (width == 100)
                $(element).html("00");
            break;
        case 45:
            if (width == 2)
                $(element).html(44);
            if (width == 3)
                $(element).html(43);
            if (width == 5)
                $(element).html(41);
            if (width == 7)
                $(element).html(40);
            if (width == 10)
                $(element).html(39);
            if (width == 12)
                $(element).html(38);
            if (width == 14)
                $(element).html(36);
            if (width == 17)
                $(element).html(34);
            if (width == 20)
                $(element).html(33);
            if (width == 23)
                $(element).html(31);
            if (width == 27)
                $(element).html(30);
            if (width == 30)
                $(element).html(28);
            if (width == 33)
                $(element).html(27);
            if (width == 36)
                $(element).html(25);
            if (width == 39)
                $(element).html(24);
            if (width == 43)
                $(element).html(22);
            if (width == 50)
                $(element).html(20);
            if (width == 54)
                $(element).html(19);
            if (width == 58)
                $(element).html(18);
            if (width == 63)
                $(element).html(16);
            if (width == 67)
                $(element).html(14);
            if (width == 72)
                $(element).html(13);
            if (width == 77)
                $(element).html(12);
            if (width == 81)
                $(element).html(11);
            if (width == 85)
                $(element).html(10);
            if (width == 89)
                $(element).html("09");
            if (width == 91)
                $(element).html("08");
            if (width == 92)
                $(element).html("07");
            if (width == 93)
                $(element).html("06");
            if (width == 95)
                $(element).html("05");
            if (width == 96)
                $(element).html("04");
            if (width == 97)
                $(element).html("03");
            if (width == 98)
                $(element).html("02");
            if (width == 99)
                $(element).html("01");
            if (width == 100)
                $(element).html("00");
            break;
        case 30:
            if (width == 2)
                $(element).html(30);
            if (width == 5)
                $(element).html(28);
            if (width == 7)
                $(element).html(27);
            if (width == 10)
                $(element).html(25);
            if (width == 15)
                $(element).html(24);
            if (width == 20)
                $(element).html(22);
            if (width == 25)
                $(element).html(20);
            if (width == 30)
                $(element).html(19);
            if (width == 35)
                $(element).html(18);
            if (width == 37)
                $(element).html(16);
            if (width == 40)
                $(element).html(14);
            if (width == 45)
                $(element).html(13);
            if (width == 50)
                $(element).html(12);
            if (width == 55)
                $(element).html(11);
            if (width == 60)
                $(element).html(10);
            if (width == 65)
                $(element).html("09");
            if (width == 70)
                $(element).html("08");
            if (width == 75)
                $(element).html("07");
            if (width == 80)
                $(element).html("06");
            if (width == 85)
                $(element).html("05");
            if (width == 87)
                $(element).html("04");
            if (width == 91)
                $(element).html("03");
            if (width == 93)
                $(element).html("02");
            if (width == 96)
                $(element).html("01");
            if (width == 100)
                $(element).html("00");
            break;
        case 10:
            if (width == 7)
                $(element).html(10);
            if (width == 10)
                $(element).html("09");
            if (width == 20)
                $(element).html("08");
            if (width == 30)
                $(element).html("07");
            if (width == 40)
                $(element).html("06");
            if (width == 50)
                $(element).html("05");
            if (width == 60)
                $(element).html("04");
            if (width == 70)
                $(element).html("03");
            if (width == 80)
                $(element).html("02");
            if (width == 90)
                $(element).html("01");
            if (width == 100)
                $(element).html("00");
            break;
        default:
            if (width == 7)
                $(element).html(15);
            if (width == 14)
                $(element).html(14);
            if (width == 21)
                $(element).html(13);
            if (width == 29)
                $(element).html(12);
            if (width == 36)
                $(element).html(11);
            if (width == 40)
                $(element).html(10);
            if (width == 46)
                $(element).html("09");
            if (width == 52)
                $(element).html("08");
            if (width == 59)
                $(element).html("07");
            if (width == 65)
                $(element).html("06");
            if (width == 71)
                $(element).html("05");
            if (width == 78)
                $(element).html("04");
            if (width == 85)
                $(element).html("03");
            if (width == 92)
                $(element).html("02");
            if (width == 96)
                $(element).html("01");
            if (width == 100)
                $(element).html("00");
            break;
    }

}

