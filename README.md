# Introduction
Chromebooks On Demand (CBOD) is a utility that uses device information exported from Google Workspace and presents it in an easy to use webUI.

CBOD is written in PHP/HTML and uses a MySQL database to store device info. CBOD requires an AMP instance - it has been built and tested extensively with WAMPSERVER. I imagine MAMP, XAMPP or any custom LAMP configuration would also work.

CBOD requires a working instance of GAMADV-XTD3 (https://github.com/taers232c/GAMADV-XTD3).

# Windows Installation Example
1. Let's assume you already have a working installation of GAMADV-XTD3 on your local machine, and it is located at **C:\GAMADV-XTD3**.
   - Following these instructions: https://github.com/taers232c/GAMADV-XTD3/wiki/How-to-Install-Advanced-GAM#windows
   - ABSOLUTELY CRITICAL: https://github.com/taers232c/GAMADV-XTD3/wiki/How-to-Install-Advanced-GAM#set-system-path-and-gam-configuration-directory
2. Download and install WAMPSERVER (https://sourceforge.net/projects/wampserver/) on your local machine.
3. We will accept all the default install options for WAMPSERVER and install to **C:\wamp64**.
   -  When WAMPSERVER is running, you should see a green "W" in system tray.
4. Open http://localhost/phpmyadmin/ in a browser and login to phpMyAdmin using "root" and no password.
   - This is a default setting which you can change at any time.
5. From the navigation menu across the top click User Accounts, then Add User Account in the new page that appears.
6. Enter in a User Name, leave Host Name as is, enter in Password, and then re-type Password.
7. Scroll down to Global Privileges and just underneath that setting select Data and Structure. This will enable the necessary sub-settings.
8. Scroll down a little more and click Go.
   - You should now see a message "You have added a new user."
9. Download CBOD and expand the files.
10. Move the CBOD folder into **C:\wamp64\www**
    - You can always rename CBOD folder to something else, but for this example let's assume we're working in **C:\wamp64\www\CBOD**
11. Within the CBOD sub-folder, open **variables.php** in your favorite text editor.
12. Fill in the 5 required variables (keeping the quotes):
    - $DBserver is usually **127.0.0.1** but sometimes it needs to be **localhost** instead.
    - $DBuser is the username you specified in a previous step using phpMyAdmin
    - $DBpass is the password you specified in a previous step using phpMyAdmin
    - $DBname can be anything you want, in this example I will use "cbod_import"
    - $GAMpath is the exact full path to your gam executable, in this example **C:\GAMADV-XTD3\gam.exe**
13. Save the **variables.php** file with these new settings.
14. In your browser on the local machine, visit http://localhost/CBOD/utilities_step1.php
15. Click the STEP 1 button to allow Advanced GAM to collect device information on all ACTIVE and DISABLED Chromebooks.
    - On average, I find it takes 50-60 seconds for 5000 devices. However, YMMV.
16. When the script has completed, go to STEP 2 and click that button to import everything into the MySQL database.

# History & Purpose
I have over 20 years experience in IT - exclusively in K-12 environments. I have spent the last 10+ years as a Google Admin and have been using Chromebooks since the Samsung Series 3 (the thin, silver XE303). Our district switched to Dell Chromebooks shortly after and have been using various Dell models ever since.

As our team has expanded, so has our needs. Our experience has been that not everyone is comfortable with the command line. Not everyone needs the same level of access (admin vs. non-admin). Some team members are more technical while others are more clerical. We built individual tools as needs arose, and those tools grew into an entire collection or suite - most of them are presented here.

Simply stated, this utility is intended to gather all relevant information about the Chromebooks in your organization and allow you to interact with that information efficiently. This is not a GUI frontend for Advanced GAM. This does not replace the Google Admin Console.

Without a doubt, everything in this project starts with GAMADV-XTD3. It cannot be stressed enough that without the efforts behind GAMADV-XTD3, this project would not exist.

# Pronunciation
Method 1: Say it as you spell it, like cee-bee-oh-dee

Method 2: Two words, like CEE BOD or SEA BOD
