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

Can we de-dup on the fly when a donor returns without logging in?

As a new philanthropist can I create a new account before making a donation or is making a donation the only way to
create an account?

What characters and how long should a user name be? We should suggest a user name based on the philanthropist's name,
one that doesn't already exist because user names must be unique.

Is there a maximum donation allowed? Minimum?

# Notes

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

 - Following instructions on https://www.drupal.org/docs/8/install/step-1-get-the-code downloaded and unpackaged Drupal.
 But I ended up using bitnami. This package already knows how to set up Drupal on top of XAMPP. I have limited time for
 setup. People who make configuration easy should be celebrated!

 - 
