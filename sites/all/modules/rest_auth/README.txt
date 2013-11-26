### Overview
This module allows users to login to the site using a RESTful web service. If
the user is associated with a Drupal user, that user is logged in. If not, a new
user is created.

This module assumes that the web service returns a JSON payload and that both a
username (or email) and a password are required for third-party authentication.

### Configuration
Settings can be found on Administration » Configuration » People » REST Auth

Host
  * The fully-formed URL of the authentication service.
Username parameter
  * Username parameter name that will get passed to the web service.
Password parameter
  * Password parameter name that will get passed to the web service.
Email parameter
  * If the user name is an email, this is not needed. Otherwise, enter the email
    parameter name that will be returned from the web service.
Authentication side
  * This option allows you to determine where authentication happens.
  * Provider: Authentication happens on the web service and you receive a
    fully-formed JSON object describing the user. HTTP codes determine success
    or failure.
  * Consumer: Authentication happens on Drupal. You will need to specify the
    proper location of the username and password in the response object. Drupal
    determines if the entered password matches the response password.

### Example
If your parameter settings are marked as

  * Username: `name`
  * Password: `pass`
  * Email: `mail`

the request payload will be structured as such:
  `name=drupal&pass=letmein`

based on those settings, the response payload should contain a "mail" parameter:
  `{"mail":"drupal@example.com", ...}`

This email will be used to create a user account that will contain other user
information as well as user roles. If the email parameter is empty, the module
will try to user the username as the email.

### Development
Refer to `rest_auth.api.php` for hooks provided by this module.

### Credits
  * Created by Victor Kareh (vkareh) - http://www.vkareh.net
  * Sponsored by Q, Ltd - http://www.qltd.com
