Boogi App Changelog
==========================================================

For versioning used template *major.minor[.build[.revision]]*

Boogi app version 0.8.1 - 2015-11-25
----------------------------------------------------------

* Show only active gigs on promoter page
* Fix chat text box position
* Update base configs
* Fix gig type on edit
* Update mailer system
* Fix account registration
* Add gig update messages to log
* Update search on artist booking
* Disable artist bookings update in admin panel
* Remove auto login in admin

Boogi app version 0.8 - 2015-11-17
----------------------------------------------------------
* Update base admin commands
* Update AlloyUI to version 3.0.1
* New Features and 404 pages
* Update Contacts and pages metadata
* Set booking currency the same as in gig
* Remove backward validation on booking steps
* Change base layout position
* Fix active gigs and bookings order and highlight
* Update team and contacts page
* Prevent load partials before page ready
* Add api docs skeleton
* Update router and add metainfo
* Update pages structure and especially profile pricing
* Fix live data events, update active tab on booking link to dashboard

Boogi app version 0.7.2 - 2015-10-28
----------------------------------------------------------

* Update gig visibility in model filter
* Fix booking visibility on map
* Fix google autocomplete on booking form
* Update login menu
* Split composer config
* Remove wtf code, update image uploader
* Update booking calculators
* Add validation rule for set time range
* Fix default booking TZ
* Add version support
* Update dashboard forms
* Fix potential fee on dashboard forms
* Fix lazy registration for registered users

Boogi app version 0.7.1 - 2015-10-16
----------------------------------------------------------

* Migrate to AlloyUI
* Global refactoring of gig/book SQL queries
* Update booking dates behaviour, add TZ info
* Fix booking owner and timings
* New 404 page
* Add auto resize feature to bookings panel
* Fix popover widgets overheads
* Add gig/book form listeners
* Add revenue calculator
* Fix virtual login/registration
* Fix profile and default TZ
* Update admin panel
* Disable local stats
* Add pricing page
* Add booking form validation
* Add autocomplete extension
* Hide artist buttons for closed booking 
* Update template skeleton
* Update Unit Tests
* Remove gig details from artist booking
* Update artist booking panel
* Added calendar widget to book form
* New notification bar


Boogi app version 0.7 - 2015-07-30
----------------------------------------------------------

* New design for base pages
* Add Live toolbar and  LiveUpdate behaviour
* Add responsive design
* New toolbars
* New render for common panels 
* Migrate to PHP5.4, Yii 1.1.16
* New cache system for front models
* Update behaviour for fake registration/login
* Fix user menu auto hide
* Add active/past gig switcher
* Add switch account functionality
* Add new statuses and transfer types
* Add approved status for promoter and artist
* Make clickable promoter links
* Update infrastructure
* Update events model
* Update extensions, move promoter bookings data to model
* Update booking renderer
* Create Musicmama parser
* Update templates structure
* Fix empty gigs in periodic emails
* Add mailer test mode
* Update and merge periodic commands into one
* Update terms and conditions
* Add social links


Boogi app version 0.6 -- 2015-03-09
----------------------------------------------------------

* Update image tags in email templates
* Update Mandrill data format
* Add Google Plus link
* Update account booking emails behaviour
* Fix booking cookie


Boogi app version 0.5.4 -- 2015-02-17
----------------------------------------------------------

* Add Mandrill and Mailchimp support
* Update Mandrill Email Wrapper
* Unify mailer system for delivery options
* Some hooks for Firefox
* Add artist profile tracker
* Update artist counters
* Update account behavior, add merge on login


Boogi app version 0.5.3 -- 2015-02-10
----------------------------------------------------------

* Restrict editing for past gigs
* Add payment tab to profile,  add back profile link
* Update virtual registration
* Dashboard updates
* Fix promoter profile map (floating bug)
* Remove additional filter on FB search
* Add PayPal subscriptions
* Add booking notification emails
* Add user emails, gig in radius, retention and etc
* Add Google Analytics tracker
* Add Google Webmaster tracker
* Add Crazy Egg tracker
* Upgrade email helper, add MailChimp support
* Add message overlay
* Hide tracked promoters and gig list
* Update router "catcher"


Boogi app version 0.5.2 -- 2015-01-05
----------------------------------------------------------

* Add batch import from RA
* Add search artist on facebook
* Add automatic artist import from Facebook
* Add automatic artist gigs import
* Update form validation system
* Fix images system
* Limit past gigs in dashboard
* Update booking panels
* Update promoter and artist profiles


Boogi app version 0.5.1 -- 2014-11-27
----------------------------------------------------------

* Fix artist update in admin
* Add ResidentAdvisor parser
* Fix virtual registration
* New landing page
* Update router architecture
* Update database object relations


Boogi app version 0.5 -- 2014-11-17
----------------------------------------------------------

* New landing page
* Updated artist dashboard
* Update edit panels
* Booking form fixes
* Update layout to be flexible
* Add lazy registration
* Add past gig markers
* Fix form widgets
* Add booking form page
* Split booking form
* Update artists info from facebook


Boogi app version 0.4 -- 2014-10-16
----------------------------------------------------------

* Fix artist dashboard
* Fix dashboard edit form update
* Update edit panels
* Fix booking form
* Update base layout, new template skeleton
* Update frontpage, background fixes
* Add lazy registration
* Fix layout, layers positions, add past gig markers
* Add booking form page
* Split booking form
* Restore update artist info from facebook


Boogi app version 0.3.2 -- 2014-09-26
----------------------------------------------------------

* Add base statuses
* Update profile page
* Update artist bookings
* Add booking time
* Add event status
* Fit blocks to notebook height
* Add trackings page
* Add events page
* Update top menu icons, update bookings
* Update dashboard


Boogi app version 0.3.1 -- 2014-07-14
----------------------------------------------------------

* Add artist book status
* Refactor image storage
* Add email merger
* Add index page tests
* Migrate to PHPUnit Selenium v2, add register tests
* Template rebranding
* Update email templates, logo and loader
* Update artist booking form
* Update Terms and Conditions page
* Add Gig clusters
* Add in radius attribute for trackings
* Widget updates
* Merge artist gig markers
* Add update messages
* Replace get artist on API
* Update booking management page
* Add booking edit form, add booking sidebar
* Add artist gig update
* Add gig update
* Add flexible booking panel, update messages behavior
* Add events pagination
* Update Api Models
* Fix venue on booking
* Fix events on import
* Update util scripts


Boogi app version 0.3 -- 2014-06-03
----------------------------------------------------------

* Fix front model callback
* Add YUI compressor
* Update application error handler/logger
* Add iselect and calendar widgets
* Update artist markup, add login overlay
* Fix distance calculation, add server side implementation
* Add file sync command
* Fix artist calendar, pagination and dashboard
* Fix first message, update message panel style
* Add About and 404 error page
* Update admin links, code cleanup
* Split front and admin applications
* Add booking accordion
* Update dashboard booking table
* Migrate booking data
* Add auto update for gig booking fields
* Update front and admin templates
* Fix dummy emails
* Update data source providers
* Fix event email renderer
* Add messaging system skeleton and message panel


Boogi app version 0.2 -- 2014-04-08
----------------------------------------------------------

* Update cli commands output
* Fix caching
* Fix error handlers
* Add colored booking status
* Update dashboard strings for tracked objects
* Finish email constructor
* Fix update profile image
* Update event messages
* Fix map after new booking
* Update map navigation behaviour
* Fix facebook event id on import
* Add event debug dashboard
* Update import, fix artist view counters
* Update markers
* Add marker clusters
* Update import logic
* Artist module optimizations
* Add admin dashboard
* Create Event Email decorator
* Update event map
* Add message queue skeleton
* Add all events
* Update core config
* Update email templates, add contact form
* Add debug config option
* Add email templates
* Update artist view, minor fixes
* Add booking description
* Fix book form overlay
* Update admin site
* Replace events with callbacks in artist view
* Fix add artist from admin site


Boogi app version 0.1.2 -- 2014-04-02
----------------------------------------------------------

* Add bandsintown import
* Fix register link
* Update bookings template, minor fixes
* Return install.bat, clean composer
* Remove php docs
* Add events handlebar helper
* Add artist search
* Remove events DB links
* Add router
* Add Vagrant to project
* Add PHP docs and code metrics
* Update utils
* Add global error handler
* Add event view
* Add event model


Boogi app version 0.1.1 -- 2014-03-31
----------------------------------------------------------

* Fix updating aliases
* Add user echo widget
* Add system command for alias update with UTF support
* Add alias update
* Fix front routes (hash)
* Facebook fixes
* Update global menu, minor fixes
* Fix global config, login/logout
* New reset password behavior, minor fixes
* Add DB script, fix migration
* Add install scripts, update readme
* Add design directory
* Update backend icons
* Update promoter model
* Add promoter follow action
* Add global "follow" action
* Update icon theme
* Add dashboard bookings and trackings
* Update dashboard panel
* Add venue/promoter info windows, fix navigation
* Add venue list, fix navigation
* Add artist map
* Update map menu style


Boogi app version 0.1 -- 2014-02-07
----------------------------------------------------------

* Add map menu
* Update markers, minor fixes
* Add date to gig markers
* Major backend update
* Fix promoter backend
* Disable panel autoclose
* Add transfer info
* Fix calendar start/end selection
* Add truckduck script
* New calendar rules
* Add install script
* Fix artist calendar
* Reset calendar logic
* Add book form processing
* YUI style overrides
* Fix facebook import
* Add book form panel
* Add profile map
* Add overlay extension
* Fix login, add reset password
* Fix config in artist view
* Add fb events import, add gigatools import, minor fixes
* Fix FB login
* Fix facebook import and login
* Update admin rights
* Add facebook integration
* Update booking form


Boogi app version 0.0.b -- 2014-01-30
----------------------------------------------------------

* Add YUI support
* Update calendar logic
* Add calendar rule checker
* Add songkick support
* Add registration, uploader; fix login/logout
* Add booking form
* Relations page skeleton
* Promoter profile
* Add profile
* Update general app structure
* Remove log file
* Add subscription, minor fixes
* Update code formatting, gitignore, readme. Add template  images
* Add radius check and calendar iw event
* Change map data structure
* Add calendar and promoter radius
* Add support for map center
* Update controller names for linux fs capability
* Add artist view
* Add artist info window
* Add artist markers
* Add navigation, google map
* Add artist view, restore artist-promoter model
* Add promoter API
* Add base application
* YUI structure updates, add extensions


Boogi app version 0.0.a -- 2013-12-05
----------------------------------------------------------

* Add last.fm and soundcloud libraries
* Add app script
* Add artist follow/unfollow
* Add artist follow and subscriptions
* Add google analytics
* Add smarty support
* Set last image as main
* Add admins to promoter controller
* Fix venue<->file relation
* Add map to artist view
* Add geocoder for venue address
* Add artist list to gigs, show latlong in venue
* Add gigs list to artist
* Add artist<->gig relation
* Update artist view
* Update user rights, update map center
* Add messages, update user login
* Add frontpage map
* Add user location, update model/controller
* Update models structure, add login/logout/register actions
* Add promoter registration
* Add file upload to major objects
* Add file relations to venue and gig
* Add base modules
* Add composer facebook php sdk, remove test index file
* Add file table, file relations, gig status
* Add DB migrations, update console config, update gitignore
* Add default app


*Project start date 2013-10-09*