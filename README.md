# sUpdater-Server
If you want to run your own app information server for sUpdater you can use this official backend software to host and manage it.

## Requirements
- MySQL
- PHP
- A webserver (Apache2 is recommended for out-of-the-box url rewriting)

## Installation
Installing sUpdater Server is easy:
1. Create a MySQL database and a database user. You can use [this SQL script](https://gist.github.com/SlimSoftware/0cbec5cafb9283857a1fdb79613f4a6d) to let this be set up for you. If you choose to do so, you will only need to specify a password for the database user in the SQL script (see the comment for the place where it needs to go) and run it.
2. Download [the latest sUpdater Server release](https://github.com/SlimSoftware/sUpdater-Server/releases) and unzip the archive to the desired folder in the webserver root folder.
3. Go to http://*webserver url*/install.php in your webbrowser. Follow the instructions on screen and you are done.
