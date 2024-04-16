# Changelog

## Current Version

### v11.3.01.a-pm18 - Public Release (Platinum Master)
#### Released on 17 June 2023
- Fixed a bug in beatpress.js which caused unintended changes during beat listening.
- Minor CSS adjustments.

## Previous Versions

### v11.2.46.0101-pm12 - Public Release (Platinum Master)
#### Released on 1 March 2020
- Added an option to prevent page authority spread with beat landing pages (set as noindex when using this option).

### v11.2.45.2901-pm10 - Public Release (Platinum Master)
#### Released on 29 January 2020
- Bugfixes and improvements.

### v11.1.22.3112-pm9 - Public Release (Platinum Master)
#### Released on 31 December 2019
- Added custom genre catalogs on genre archive pages.
- Enhanced support for most WordPress themes with genre catalogs.
- Implemented code injection in active theme directory upon BeatPress plugin activation.
- Added support for WordPress 5.3.2.
- Removed syntax PHP errors causing logs in error_log.
- Added Google Analytics code detection via JavaScript.
- Redesigned BeatPress Player with a new color scheme and additional controls.
- Introduced collaboration artist tags and indicators for beats with hooks.

### v10.3.4.0710-pm8 - Public Release (Platinum Master)
#### Released on 7 October 2019
- Added support for Google Analytics Events.
- Styling changes in the Dashboard.
- Fixed two bugs in the BeatPress CSS stylings which prevented cache plugins to properly minify the styles.
- Added 'Beat Title' row in the Instrumentals WordPress Panel.
- Added 'Visit plugin site' button in the WordPress plugins section.
- Graphics rebranding.
- Fixed a bug in jQuery code which prevented it to work when minified with different cache plugins.
- Resized PHP processed requests logo to make server handled petitions smaller.
- Sanitized some settings fields with wp_kses_post to allow HTML content but no harmful code.
- Modified modal boxes background color in mobile devices to fit full height.
- Fugbixes!

### v10.2.2509-pm2-1 - Public Release (Platinum Master)
#### Released on 25 September 2019
- Fixed a bug while uploading MP3s into Instrumentals, mistakenly added during bulk text editing for translations.

### v10.1.2509-pm1-1 - Public Release (Platinum Master)
#### Released on 25 September 2019
- Oh sh*t... Here we go again.

### v9.25.2409-gm1 - Private Release (Golden Master)
#### Released on 24 September 2019
- Added WordPress support for translations.
- Deleted Google+ in Sharing Widget since it's no longer available.
- Deleted Google+ in BeatPress Tools Widget.
- Resized the whole Dashboard to fit translations properly.

### v8.11.2209-gm16 - Private Release (Golden Master)
#### Released on 21 September 2019
- Fixed a jQuery/CSS issue where pppspinner never disappeared.
- Fixed a jQuery/CSS issue with pppspinner in the featured beat caller.
- Added material design animation on catalog clicks.
- Added scrolling / draggable option on the player bubbles (doesn't work on mobiles).
- Added a loading circle in the play/pause button using the jPlayer seeking event.
- Added a separator between the latest beat in the catalog and the load more catalog button.
- The search bar now does have opacity to fit different website colors and color changes smoothly on hover.
- Fixed a problem in the featured beat catalog text description that was showed only with tablet resolutions.
- The beatholder class (the beats box showed up in the catalog) now works smoothly with animations.
- Added an option to hide the SEO Introduction text that's showed by default in the featured beat box.
- Redesigned the whole way how external purchase mode works, the workflow was buggy and the available elements too.
- Added interlinking to external purchase mode to increase interaction and decrease bounce rate.
- Fixed a little CSS issue in the beatholder property that appeared when we added an animation.
- We've increased the fadeOut animation of the ppplistening property from 7000 to 10000.
- Added a missing space between the play icon and the title.
- Fixed CSS opacity in ppplistening property.
- I hate to add that so much changes, that means more things to fix bihhhhhhhh.
- Removed noopener and noreferer relationships from external links.
- Fixed a bug in the plshare property.
- Fixed a bug while exclusive buttons weren't getting showed as expected.
- Fixed a bug in the purchase buttons, added CSS flexibility, they should fit always.
- A lot of deprecated code let's see how do we remove it all without breaking everything.
- Added a small padding in the catalog buttons while modal box is not enabled.
- Uncommented and fixed a bunch of deprecated jQuery code.
- We've also modified the CSS border-radius of the modal windows to fit the new design.
- Removed an absolutely non-sense padding:1px; in modal boxes that caused all text to be blurry in desktops.
- Added gradient to the modals based on the selected theme color.
- Redesigned some elements in the Beatpress Dashboard (yes, here!).
- Added a preloader while the Dashboard is loading elements.
- We've added a new option to the genre boxes at the catalog bottom to show only genres containing more than 5 beats inside.
- Added support to multiple catalog stylings in the CSS code and PHP queries.
- Added a CSS property to the beat player to avoid users to select text on it.
- Fixed some issues in the ppplistening property that wasn't being showed in the same in different websites / themes.
- Resized the beat player.
- Added material design on click animation to beatholder class.
- Several improvements and tweaks in jQuery player.
- Additional state buffering for jQuery player.
- Fixed an issue where a class was missed in the featured beat caller.
- Removed bugs and added some more as usual, changes are bugs.

### v7.12.1010-g4 - Private Release (Golden Master)
#### Released on 12 September 2019
- Changed volume bar to fit audio bar color in all different color schemes.
- Encrypted audio paths and BeatPress Direct links are now encrypted with different keys for each website automatically.

### v6.08.05010-g3 - Private Release (Golden Master)
#### Released on 10 September 2019
- Loads of tweaks in the now playing section of each beat when you click on a beat.
- Added multiple catalog viewing options, compact (shrinked catalog) and fluid (wider catalog).
- Added a way to remove the 'ADD' text from purchase buttons and make them smaller to fit in mobile screens.
- Fixes and improvements in Beatpress stylesheets and CSS code.
- Fixes in the BeatPress Dashboard (yes, it's here!).
- Fugbixes.

### v6.07.26008-g2 - Private Release (Golden Master)
#### Released on 26 August 2019
- Added an option to make External Service links nofollow to prevent domain authority drop.
- Bugs smashed, Surce pest control is on point.

### v6.06.1008-g1 - Private Release (Golden Master)
#### Released on 10 August 2019
- Added custom PayPal logo at BeatPress Direct checkout pages.
- Important issue fixed in the non-intrusive BeatPress advertising parallax.
- A lot of bugfixing bruh.

### v6.05.2405-r4 - Private Release (Silver Master)
#### Released on 24 May 2019
- Removed the extra subscription button in the 'Latest Beats' module.
- Added a way to check if Easy Digital Downloads is installed (or active) while Easy Digital Downloads selling mode is active.
- Added a warning notice to let admin know that Easy Digital Downloads is not installed or active while Easy Digital Downloads selling mode is active.
- Added some minor changes in the backdash code used in the Genre Archives customization settings.
- In BeatPress Direct purchases now the website URL will be showed in the receipt and purchase.
- Changed blue color to darker blue.
- Fixed round borders issue in the search box (only happening iOS).

### v6.04.1005c-r1 - Private Release (Silver Master)
#### Released on 10 May 2019
- Fixed optional Catalog H1 Heading CSS styling issues.
- Moved the optional Catalog H1 Heading before the banner (if any).
- We've introduced BeatPress Documentation, you can now read any option documentation by clicking "Documentation" in the settings.

### v6.03.0305c - Private Release (Stable)
#### Released on 3 May 2019
- Minor changes in purchase buttons stylings and @media rules.
- BeatPress is now able to auto-host its MP3 files, you can upload them right in the '' BeatPress Page Generator'' window.
- Removed bloat code used to make the previous MP3 support work.
- We've also made changes in the auto-generated Structured Data in each beat page due to Google changes in needed information.
- Changes in the BeatPress ADs module to make it fit in any WordPress available theme.
- Changes in the BeatPress ADs module CSS styling.
- Added BeatStars and Airbit in the social networks panel (aren't they?).
- Updated auto-included Font Awesome to the latest released version.
- Fixed some bugs in the MP3 auto-host file system.

### v5.33.1704d - Private Release (Stable)
#### Released on 17 April 2019
- Changed BeatPress Page Generator textarea max values to 500.
- Changed BeatPress Page Generator input max values to 150.
- Added placeholders in the BeatPress Page Generator fields.
- Added new settings tab '' Selling'' to select your purchase mode.
- Added three options to sell your beats (BeatPress Direct, Easy Digital Downloads and External Services) under the '' Selling'' tab.
- Added a small landing page to the encrypted streaming links.
- Added the metatags ''noindex nofollow'' to the automatically generated encrypted streaming links pages, some of them were indexed in Google so it's a must.
- Added a small landing page to the automatically generated BeatPress Direct Purchase popup windows.
- Added the metatags ''noindex nofollow'' to the automatically generated BeatPress Direct Purchase popup windows to prevent indexing.
- Resized the beats player for better integration in mobile devices.
- Added  Orange,  Pink and  Limegreen colors.
- Minor changes in jQuery functions to match theme colors (dependant of jp-play-bar class).

### v4.15.0403e - Private Release (Stable)
#### Released on 4 March 2019
- Added a play button in the archive pages when the ''Archive Styling'' option is active to decrease bounce rate.
- Added extra CSS stylings for this new play button.
- Minor changes in the JavaScript code to make it able to run together with the following critical error.
- Critical error fixed due to a PHP typo which contained an space while generating extra thumbnails for BeatPress stylings.
- If you're running into image issues with this version use  this plugin to regenerate your thumbnails.
- Fresh installations should not have problems, use the previous plugin only if you come from older versions.

### v4.04.0303e - Private Release (Stable)
#### Released on 3 March 2019
- CSS Styling improvements.

### v4.031.2702d - Private Release (Stable)
#### Released on 27 February 2019
- Added support to show producers social networks in catalog page.
- Added Reddit social network in 'Producer' settings tab.

### v4.03.1702c - Private Release (Stable)
#### Released on 17 February 2019
- Changes in the the purchase buttons CSS styling, now they look gorgeous, they'll convert more.
- Added support for different purchase buttons stylings (SuperStars, AeroBit, BeatClick).
- Fixed CSS styling issues with long titled beats, titles were cutted off, not anymore.
- Fixed CSS styling in the "ADD" and "Add to cart" buttons.
- Fixed some typos, my main language is spanish so...

### v3.54.3001d - Private Release (Stable)
#### Released on 27 January 2019
- Major changes in the HTML markup for better cross-browser integration.
- Major changes in the CSS and JS assets to make the new HTML markup work properly.

### v3.18.2701b - Private Release (Stable)
#### Released on 27 January 2019
- Added a custom BeatPress clearfix for different styling purposes.
- Added interlinking in the Genre archives for better user experience and internal LinkJuice distribution.
- Now it match your BeatPress theme color when you move your mouse around your beats / catalog!
- We've created two CSS classes for the genre boxes, the clickable and the informational.
- No bugs spotted yet.

### v3.16.2001c - Private Release (Stable)
#### Released on 20 January 2019
- Added Disqus support in individual beat pages to increase engagement.
- No bugs spotted yet.

### v3.12.1701d - Private Release (Stable)
#### Released on 17 January 2019
- The previous improvements made in the desktop player weren't working in the Modal Widget Play button, so we've fixed that.
- I mean, I've fixed that. I'm a person, not a company... Yet.
- What are bugs bro.

### v3.06.1601c - Private Release (Stable)
#### Released on 16 January 2019
- Added an option for URL forwarding to external services such as BeatStars or AirBit.
- Still no bugs bro let's pray.

### v3.05.1501e - Private Release (Stable)
#### Released on 15 January 2019
- Removed the option to show all genres in each beat page, beat pages PageRank was spreading over all genres instead of the related ones.
- Removed additional jQuery code to make the genres thing possible in each beat page.
- Improvements in the Desktop player, now it shows the beat artwork and the beat name.
- Compatibility for WordPress 5.0.3.
- Bruhfixing.

### v3.04.0901d - Private Release (Stable)
#### Released on 9 January 2019
- Fixed CSS classes that weren't properly parsed when using minification processes from cache plugins such as Swift Performance or WP-Rocket.
- Added an option to completely disable the Instrumentals taxonomy ''Beat Tags''.
- I've added this option to prevent PageRank re-distribution to thin content pages that often are marked by site admins as no-follow.
- The bugfixing was intense bro.

### v3.03.0401c - Private Release (Stable)
#### Released on 4 January 2019
- Fixed a SEO Yoast integration problem with "the_content" filter used to output the catalog
- Fixed CSS main compatibility problems
- Fixed color scheme metadata
- Disabled useless options that may decrease compatibility with popular themes
- Fixed a shitload of bugs
- New colors added.

### v2.83.2312g - Private Release (Stable)
#### Released on 23 December 2018
- Compatibility Issues with common WordPress Themes.

### v2.82.2212f - Private Release (Stable)
#### Released on 22 December 2018
- Removed PHP Errors
- Compatibility for PHP 7.3
- Improvements in BeatPress Payment Gateway.

### v1.53.1412d - Private Release (Stable)
#### Released on 13 December 2018
- Bugfixes.

### Beta Builds
#### Private Release (Early build)
- Released on 1 August 2018
- So many thanks to all our beta-testers and supporters: Surce Beats, Brainiac Beats, Adrián Barrio, Clioenllamas, and Fat Kingdom.
