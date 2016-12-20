YUI.add('calendar-extension', function (Y) {

    Y.CalendarExtension = function () {

        this.GIG_CLASS           = 'artist-gig';
        this.GIG_IN_RADIUS_CLASS = 'artist-gig-in-radius';
        this.PAST_GIG_CLASS      = 'artist-past-gig';

        this.GIG_FROM_CLASS      = 'artist-gig-from';

        this.DATE_SELECTED_CLASS = 'artist-date-selected';
        this.DATE_DISABLED_CLASS = 'artist-date-disabled';

        this.CURRENT_DATE_CLASS  = 'current-date';

        // Show calendar on page
        this.initCalendar = function(target, rules) {
            this.log('Init calendar');

            // Init calendar
            var selectedDate = this.get('calendarFirstDate'),
                container = this.get('container'),
                calendar = new Y.Calendar({
                    contentBox          : target,
                    width               : '380px',
                    showPrevMonth       : true,
                    showNextMonth       : true,
                    date                : selectedDate
                });

            // Add current and selected date
            this.addRule(rules, new Date, this.CURRENT_DATE_CLASS);
            this.addRule(rules, selectedDate, this.DATE_SELECTED_CLASS, true);

            // Add rules check
            calendar.set('customRenderer', {
                rules: rules,
                filterFunction: this.filterFunction
            });

            // And finally render calendar
            calendar.render();

            // Listen to calendar's selectionChange event.
            calendar.on('selectionChange', Y.bind(function (e) {
                // Selection date
                var newDate = e.newSelection[0],
                    dtdate = Y.DataType.Date;

                container.fire('calendar:selected', { date: dtdate.format(newDate) });
            }, this));

            // Listen to calendar's change month events.
            this.bindMonthEvents();

            // Save calendar instance
            this.calendar = calendar;
        };

        // Update calendar
        this.updateCalendar = function(selectedDate, rules, markers) {
            this.log('Update calendar');

            // Clean temp rules
            this.cleanRules(rules);

            // Sort markers by date
            markers.sort(this.sortByDate);

            // Prepare data
            var currentDate = Y.Date.parse(selectedDate),
                startDate = this.getStartDate(selectedDate, markers),
                endDate = this.getEndDate(selectedDate, markers);

            // Add range rules
            if (startDate != endDate) {
                var start = new Date(startDate);
                var end = new Date(endDate);

                while (start < end) {
                    this.addRule(rules, start, this.DATE_SELECTED_CLASS);

                    var newDate = start.setDate(start.getDate() + 1);
                    start = new Date(newDate);
                }
            }

            // Add rule for selected day
            this.addRule(rules, currentDate, this.GIG_FROM_CLASS);

            // Add current date
            this.addRule(rules, new Date, this.CURRENT_DATE_CLASS);

            // Set new calendar rules
            this.calendar.set('customRenderer', {
                rules: rules,
                filterFunction: this.filterFunction
            });

            // And again render calendar
            this.calendar.render();

            // Update internal
            this.set('selectedDate', selectedDate);
            this.set('startDate', startDate);
            this.set('endDate', endDate);
        };

        // Convert lat/lng data to calendar rules
        this.prepareRulesFromGigs = function(data, force_selected) {
            var rules = {},
                today = new Date,
                date, rule;

            for (var i = 0; i < data.length; i++) {
                // Check if current point in user radius
                rule = data[i].isGigInRadius ? this.GIG_IN_RADIUS_CLASS : this.GIG_CLASS;

                // Check today and add rule
                date = Y.Date.parse(data[i].date);
                if (date >= today) {
                    this.checkCalendarFirstDate(date, force_selected);
                    this.addRule(rules, date, rule);
                } else {
                    this.addRule(rules, date, this.PAST_GIG_CLASS);
                }
            }

            return rules;
        };

        // Add single rule to rules object
        this.addRule = function(rules, date, ruleName, force) {
            var skip_rules = [this.GIG_CLASS, this.PAST_GIG_CLASS, this.GIG_IN_RADIUS_CLASS],
                path = {
                    year  : Y.Date.format(date, { format: '%Y' }),
                    month : Y.Date.format(date, { format: '%m' }) - 1, // PHP to JS date.month capability
                    day   : Y.Date.format(date, { format: '%d' })
                };

            // Check previous rules
            !rules[path['year']] && (rules[path['year']] = {});
            !rules[path['year']][path['month']] && (rules[path['year']][path['month']] = {});
            !rules[path['year']][path['month']][path['day']] && (rules[path['year']][path['month'][path['day']]] = {});

            // Adding rule name and return
            if (force || skip_rules.indexOf(rules[path['year']][path['month']][path['day']]) == -1) {
                rules[path['year']][path['month']][path['day']] = ruleName;
            }
        };

        // Clean temp rules
        this.cleanRules = function(rules) {
            var skip_rules = [this.GIG_CLASS, this.PAST_GIG_CLASS, this.GIG_IN_RADIUS_CLASS];

            for (var year in rules) {
                if (rules.hasOwnProperty(year)) {
                    for (var month in rules[year]) {
                        if (rules[year].hasOwnProperty(month)) {
                            for (var day in rules[year][month]) {
                                if (rules[year][month].hasOwnProperty(day)) {
                                    if (skip_rules.indexOf(rules[year][month][day]) == -1) {
                                        delete rules[year][month][day];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        };

        // Filter function fo calendar
        this.filterFunction = Y.bind(function(date, node, rules) {
            if (rules.indexOf(this.GIG_CLASS) >= 0) {
                node.addClass(this.GIG_CLASS);
            }
            if (rules.indexOf(this.GIG_IN_RADIUS_CLASS) >= 0) {
                node.addClass(this.GIG_IN_RADIUS_CLASS);
            }
            if (rules.indexOf(this.PAST_GIG_CLASS) >= 0) {
                node.addClass(this.PAST_GIG_CLASS);
            }
            if (rules.indexOf(this.GIG_FROM_CLASS) >= 0) {
                node.addClass(this.GIG_FROM_CLASS);
            }
            if (rules.indexOf(this.DATE_SELECTED_CLASS) >= 0) {
                node.addClass(this.DATE_SELECTED_CLASS);
            }
            if (rules.indexOf(this.DATE_DISABLED_CLASS) >= 0) {
                node.addClass(this.DATE_DISABLED_CLASS);
            }
            if (rules.indexOf(this.CURRENT_DATE_CLASS) >= 0) {
                node.addClass(this.CURRENT_DATE_CLASS);
            }
        }, this);

        this.sortByDate = function(a, b) {
            return ((a.date < b.date) ? -1 : ((a.date > b.date) ? 1 : 0));
        };

        this.getStartDate = function (date, markers) {
            var today = Y.Date.format(new Date, { format: '%Y-%m-%d' });

            for (var i = 0; i < markers.length; i++) {
                if (markers[i].date > date) {
                    return  i > 0 ? (markers[i - 1].date > today ? markers[i - 1].date : today) : date;
                }
            }

            return date;
        };

        this.getEndDate = function (date, markers) {
            for (var i = 0; i < markers.length; i++) {
                if (markers[i].date > date) {
                    return markers[i].date;
                }
            }

            return date;
        };

        this.bindMonthEvents = function () {
            var container = this.get('container');

            container.one('.yui3-calendarnav-nextmonth').after('click', Y.bind(function () {
                container.fire('calendar:monthChanged', { month: this.getCalendarMonth() });
            }, this));
            container.one('.yui3-calendarnav-prevmonth').after('click', Y.bind(function () {
                container.fire('calendar:monthChanged', { month: this.getCalendarMonth() });
            }, this));
        };

        this.getCalendarMonth = function () {
            var header = this.get('container').one('.yui3-calendar-header-label').get('text');
            return Y.Date.parse('01 ' + header); // FF hook
        };

        this.checkCalendarFirstDate = function(date, force) {
            var currentDate = this.get('calendarFirstDate');
            if (currentDate == null || currentDate > date || force) {
                this.set('calendarFirstDate', date);
            }
        }
    }
},
'0.1',
{
    requires: [
        'node',
        'calendar',
        'datatype-date',
        'cssbutton'
    ]
});
