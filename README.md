# NonprofitDonationForm

The task is to complete a hypothetical client request. A client has asked for a simple donation form on their
Drupal 8 site. The client already uses Stripe for processing payments at their events and would like to use it
for the donation form as well. The client needs to collect who is making the donation, how much it’s for and of
course collect the credit card payment.

# Requirements

User story: As a nonprofit entity which is dependant on donations, I want to collect credit card donations along
with information about who is donating and how much money they are donating, from philanthropists who come to our
web site, so that our nonprofit entity can collect funds which will allow us to continue to do good work.

As a philanthropist who is new to the client site I want to make a donation so that I feel good about helping the
nonprofit's mission.

As a philanthropist who has donated before I want to make another donation to the nonprofit.

As the nonprofit client I want to use stripe to collect donations so that I am familiar with the technology being
used. (Add benefits of using stripe here.)

As the nonprofit client I want to collect information about the philanthropist so that I can send thanks and keep
good records for an audit.

Questions to consider:

Does a philanthropist have to log in before donating? Could be a barrier to donation. Can we collect account information
upon donation and auto-create an account? Yes. No-password accounts. Not really an account but only an identifier like
name of the philanthropist.

How do we protect the privacy of philanthropists? We don't want a list of names and PII, but we would want to match
recognized philanthropists with existing donors.

The form inputs will be guided by the requirements of Stripe. If there is a lot of PII (Personally Identifiable
Information), we will ask the user to create a password and make it a real secure account before a new philanthropist
donates.

Can we de-dup on the fly when a donor returns without logging in? Perhaps we force a login before donating.

As a new philanthropist can I create a new account before making a donation or is making a donation the only way to
create an account?

What characters and how long should a user name be? We should suggest a user name based on the philanthropist's name,
one that doesn't already exist because user names must be unique.

Is there a maximum donation allowed? Minimum?

Does the amount have to be in US dollars? Yes.

Are there restrictions on the donor's name? Should it be unique? What's the maximum length?

Does the credit card require billing address? Perhaps we should get the donor's address.

Does the donor get an e-mail confirmation of their donation? If so we need email address.

Couldn't we fill in the user's name for them if they're logged in?

# Installation Notes

 - Started a repository https://github.com/rjacobsen0/NonprofitDonationForm.git for this work. I've been using SVN,
 not git, so I have a bit of learning to do to complete this. A new environment to pick up. :)

 - Next, install drupal 8 on my Windows 10 machine based on instructions on 
 https://www.drupal.org/docs/develop/local-server-setup/windows-development-environment/installing-drupal-on-windows-for

 - Got XAMPP from https://www.apachefriends.org/index.html (note start control panel using \xampp\xampp-control.exe)
 but already had IIS installed on port 80. Had a conflict. Reconfigured Apache to listen on port 8080. This should be
 ok; people set up dev ports all the time. But I don't find this acceptable because it could lead to conflict between
 the two web servers in the future. Since I don't want to do that kind of troubleshooting I prefer to run Apache on port 80.
 I uninstalled IIS. But port 80 is still blocked by something! After much searching around, I found this page helpful
 https://www.sitepoint.com/unblock-port-80-on-windows-run-apache/ It helped me find out that SSRS was listening on
 port 80. I stopped the SSRS service and Apache started up. I realize this is not a secure setup because MariaDB root
 has no password and there are other security holes. If I were going to run this in production I would not use this
 package.
    + includes PHP 7.2.1

 - Installed an evaluation copy of JetBrains' PHPStorm.

 - Went here https://www.drupal.org/project/project_module and searched for Stripe. Found 34 matching modules. Chose
 the one with the simplest name 'Stripe' and downloaded beta 8.x-1.0-beta. It's not obvious where to put it. I put it
 on E:\stripe temporarily. Documentation is here https://stripe.com/docs/api/php#intro but there's nothing about
 installation. I'll look for more documentation later when I'm ready for it.

Wrong turn begins here:
 - Following instructions on https://www.drupal.org/docs/8/install/step-1-get-the-code downloaded and unpackaged Drupal.
 But I ended up using bitnami. This package already knows how to set up Drupal on top of XAMPP. I have limited time for
 setup. People who make configuration easy should be celebrated!

 - Cloned repository D8HWexample https://www.drupal.org/docs/8/creating-custom-modules/a-hello-world-custom-page-module
 which I found a link to on this page. Still trying to get a foothold. But I couldn't get it to run. It appears that
 the directory structure needs to be a certain way and mine is not, so I looked at Apache documentation on this page
 https://httpd.apache.org/docs/trunk/urlmapping.html and moved the D8HWexample into C:\Bitnami\drupal-8.4.4-0\apps\drupal\D8HWexample
 but the requested page could not be found when I went to http://localhost:81/drupal/D8HWexample. So I'm still not
 understanding the necessary structure and configuration.

 - Got on slack Drupal support group. Heard drupal console will generate code, for example for a 'hello world' custom
 page module. Considering seeing where it puts generated code and if that code will actually run in a browser. Since
 I'm having trouble with this, I'm also considering backing up a few steps and installing using composer instead of
 the bitnami package. https://community.bitnami.com/t/can-you-host-multiple-and-separate-drupal-sites-locally/7511
 indicates that other people have trouble with this distribution as well. That's the clincher. Time to backtrack and
 try another installation.

  - Uninstalled bitnami drupal stack.

  - This little detour shows how a package can have good intentions (to make life easier on new Drupal users) but it
  can go wrong if something is too far away from standard or needs too much education to use it or is too restrictive.

Wrong turn ends here.

  - Installed composer https://getcomposer.org/doc/00-intro.md#installation-windows.

  - Went to https://www.drupal.org/docs/user_guide/en/install-composer.html. Followed the instructions and installed 
  Drupal core in C:\xampp\htdocs\drupal (htdocs is Apache's web root directory) and installed dependancies using
  composer. So glad I finally got to good documentation! It's crazy that there are two complete sets of Drupal
  documentation!

  - In a web browser went to http://localhost/drupal (More success! Yay!) and went through the setup. Got two warnings
    + PHP OPCODE CACHING Not enabled PHP OPcode caching can improve your site's performance considerably. It is highly
    recommended to have OPcache installed on your server.
    + LIMITED DATE RANGE Your PHP installation has a limited date range. You are running on a system where PHP is
    compiled or limited to using 32-bit integers. This will limit the range of dates and timestamps to the years
    1901-2038. Read about the limitations of 32-bit PHP.
    + I'm continuing anyway for now, but I may want to revisit this later.

  - Set up database. 
    + Database name: donationDB
    + Database username: root
    + Host: localhost
    + Port number: 3306
    + Table name prefix: donation
  
  - Configure Drupal site. 
    + Site name: Rebecca's First Drupal Site
    + Site email: rjacobsen0@gmail.com
    + Maintenance account Username: rjacobsen0
    + Default Country: United States
    + Default time zone: Los Angeles

  - Installing the Stripe module using instructions on https://www.drupal.org/docs/user_guide/en/config-install.html
  using the administrative interface. Oh, um, nevermind. Since Stripe is not on the list I have to find a way to
  install it in the list before installing it in the site. Found it! Adding a module docs are here
  https://www.drupal.org/docs/user_guide/en/extend-module-install.html. No longer need the one I downloaded earlier.

# Module Creation Notes

  - Found a good piece of documentation that will help me create a module. https://www.drupal.org/docs/8/creating-custom-modules/getting-started-background-prerequisites-drupal-8.
  
  - Everything was going well, until I got to the instruction at the bottom of this page
  https://www.drupal.org/docs/8/creating-custom-modules/add-a-routing-file to go to the front page of the site. Had
  to do some troubleshooting. Realized that the routing.yml contains the namespace of the controller, not the path.

  - On ASP.NET MVC all routes go through a controller, so I didn't realize right away that in Drupal a form does not
  need a controller.

  - Possibilities for how to integrate Stripe:
    + stripe_webform (someone else has done work on this, but it has poor documentation)
    + Use Checkout (go directly to form and script via a controller outputting markup)
    + Stripe.js and Elements

  - I'm going to first try stripe_webform and see what that's like. Install first, then read the code to see if I
  can figure out how to call it. Also need to install the dependencies Webform and Contribute. Was worried that
  it would be one dependancy after another but two (Webform and Contribute) is not too bad. While this looks
  promising it is un-usable for now. Needs to be documented. Rolling back.

  - I'm having more success with Stripe's https://stripe.com/docs/quickstart guide on the frontend.
  
  - I added code for the server-side to get the payment and I'm getting errors. Seems that the Stripe library
  is multiply defined or not defined. Can't resolve the needed symbols like Stripe\Stripe::setApiKey() and
  Stripe\Charge::create(). Installed with composer, but still no luck. Commenting it out and putting this on
  ice for a while.
      + composer require drupal/stripe
  
  - Now I want to add javascript of my own, plus the javascript from stripe. Found documentation:
    + https://www.drupal.org/docs/8/creating-custom-modules/adding-stylesheets-css-and-javascript-js-to-a-drupal-8-module
    + https://www.drupal.org/forum/support/module-development-and-code-questions/2016-08-08/adding-js-to-the-block-through-module
    + https://drupal.stackexchange.com/questions/223260/whats-the-correct-way-to-include-javascript-dependencies-into-modules
    + https://www.drupal.org/node/2605130
    + https://atendesigngroup.com/blog/mastering-drupal-8%E2%80%99s-libraries-api
  - It's not cool to pull the stipe.js file into this module because it prevents independent upgrades and is against
  the Drupal licensing/contrib guidelines regarding third party code, so I will include it from it's current location
  if possible. Working on that now.
  
  - I'm backing off and starting over with a fresh install of stripe. I'm carefully going over each dependency. One
  that I missed before is that stripe requires <script src="https://js.stripe.com/v3/"></script> to be included
  https://www.drupal.org/docs/8/theming-drupal-8/adding-stylesheets-css-and-javascript-js-to-a-drupal-8-theme#external
  and it should come directly from https://js.stripe.com. I put that in, but that is not the only problem, apparently.
  
  - Still getting script errors. Tried a twig template with {{ attach_library('drupal/stripe') }} in it. Still no
  luck.
  
  - I installed drupal/libraries using composer. Not sure it's appropriate for D8. Now I have to learn how to use it.
  