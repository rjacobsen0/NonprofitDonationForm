# NonprofitDonationForm

The task is to complete a hypothetical client request. A client has asked for a simple donation form on their
Drupal 8 site. The client already uses Stripe for processing payments at their events and would like to use it
for the donation form as well. The client needs to collect who is making the donation, how much it’s for and of
course collect the credit card payment.

# Requirements

User story: As a nonprofit entity which is dependant on donations, I want to collect credit card donations along
with information about who is donating and how much money they are donating, from philanthropists who come to our
web site, so that our nonprofit entity can collect funds which will allow us to continue to do good work.

# Notes

 - Started a repository https://github.com/rjacobsen0/NonprofitDonationForm.git for this work. I've been using SVN,
 not git, so I have a bit of learning to do to complete this. Yet another new environment to pick up. :)

 - Next, install drupal 8 on my Windows 10 machine based on instructions on 
 https://www.drupal.org/docs/develop/local-server-setup/windows-development-environment/installing-drupal-on-windows-for

 - Got XAMPP from https://www.apachefriends.org/index.html (note start control panel using \xampp\xampp-control.exe)
 but already had IIS installed on port 80. Had a conflict. Reconfigured Apache to listen on port 8080. This should be
 ok; people set up dev ports all the time. But I don't find this acceptable because it could lead to conflict between
 the two web servers in the future. Since I don't want to do that kind of troubleshooting I prefer to run Apache on port
 80. I uninstalled IIS. But port 80 is still blocked by something! After much searching around, I found this page helpful
 https://www.sitepoint.com/unblock-port-80-on-windows-run-apache/ It helped me find out that SSRS was listening on
 port 80. I stopped the SSRS service and Apache started up. I realize this is not a secure setup because MariaDB root
 has no password and there are other security holes. If I were going to run this in production I would not use this
 package.

 - Following instructions on https://www.drupal.org/docs/8/install/step-1-get-the-code downloaded and unpackaged Drupal.
 But I ended up using bitnami. This package already knows how to set up Drupal on top of XAMPP. I have limited time for
 setup. People who make configuration easy should be celebrated!

 - 
