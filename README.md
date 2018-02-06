# NonprofitDonationForm

Started a repository https://github.com/rjacobsen0/NonprofitDonationForm.git for this work. I've been using SVN,
not git, so I have a bit of learning to do to complete this. Yet another new environment to pick up. :)

The task is to complete a hypothetical client request. A client has asked for a simple donation form on their
Drupal 8 site. The client already uses Stripe for processing payments at their events and would like to use it
for the donation form as well. The client needs to collect who is making the donation, how much it’s for and of
course collect the credit card payment.

Next step was to install drupal 8 based on instructions on 
https://www.drupal.org/docs/develop/local-server-setup/windows-development-environment/installing-drupal-on-windows-for

 - got XAMPP from https://www.apachefriends.org/index.html (note start control panel using \xampp\xampp-control.exe)
 but already had IIS installed on port 80. Had a conflict. Reconfigured Apache to listen on port 8080. This should be
 ok; people set up dev ports all the time.


