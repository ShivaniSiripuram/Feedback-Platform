Author: Shivani Siripuram

Prerequisites & Installation
XAMPP must be installed on your system.
PHP (included in XAMPP), MySQL, and Apache.
Composer installed globally (for Google OAuth Client).
Clone or copy the feedback-platform folder into /opt/lampp/htdocs/.
Run the following to install Google Client:
cd /opt/lampp/htdocs/feedback-platform
composer require google/apiclient:^2.0
This will create the vendor/ directory and autoload.php, which are required for loading Google API libraries.

Google OAuth API Setup and Usage
Visit Google Cloud Console
Create a new project.
Go to APIs & Services > Credentials.
Click + Create Credentials > OAuth client ID.
Choose Web Application.
Set Authorized redirect URI to http://localhost/feedback-platform/callback.php
Copy your Client ID and Client Secret.
Replace placeholders in login.php and callback.php accordingly.
OAuth allows users to securely log in using their Google accounts. After authorization, their profile information is retrieved and stored in the session (and optionally, in the database).
The Google OAuth API is included using Composer, which automatically pulls the required dependencies into the vendor/ folder. The autoload file (vendor/autoload.php) is used in PHP scripts to load the Google Client Library and its classes.

Terminal Instructions
student@shiva:~$ sudo /opt/lampp/manager-linux-x64.run
Start Apache and MySQL servers from the XAMPP manager.
Open Project in VS Code
cd /opt/lampp/htdocs/feedback-platform
code .
Browser Access
Open your browser.
Visit: http://localhost/feedback-platform/login.php
Click Login to redirect to Google account for login.

After Login
Once successfully logged in, users are taken to the feedback interface:
Multiple products are displayed.
Each product shows its name and provides dropdowns to select a feedback category (Product Features, Product Pricing, Product Usability).
Users can give a star rating (1–5) and write comments.
Submitted feedback is shown below each product, categorized and tagged with the user's name and star rating.
Products that don’t have feedback in a category will indicate "No feedback yet."

Logout
Option provided to logout from the session.
There is a Logout option at the top for ending the session.
