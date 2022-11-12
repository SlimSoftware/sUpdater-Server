# sUpdater-Server
If you want to run your own app information server for sUpdater you can use this official backend software to host and manage it.

## Requirements
- MySQL
- PHP 8+
  - For required PHP extentions see https://laravel.com/docs/9.x/deployment#server-requirements
- A webserver
  - Nginx is recommended and will be used in the installation instructions, but apache2 works too

## Installation
*to be added*

## Setting up the development environment
1. Make sure you have [Docker and WSL](https://docs.docker.com/desktop/windows/install/) (WSL is only needed if you are using Windows) set up properly. 
1. Clone the repository with Git. If you use Windows, make sure you do this in a WSL terminal in your home directory. If you use VS Code as IDE, you should install [this extension](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-wsl).
1. Install the Composer dependencies with [this method](https://laravel.com/docs/9.x/sail#installing-composer-dependencies-for-existing-projects) (as we do not have access to Sail just yet)
1. Now we have access to Sail. You can [configure a bash alias](https://laravel.com/docs/9.x/sail#configuring-a-bash-alias) so you can type `sail` instead of `././vendor/bin/sail`. Put this alias in the (new) file `~/.bash_aliases` (under WSL if you use this).
1. Create a .env file in the root of the project directory: a example configuration is included with the repo in the `.env.sample` file in the root directory.
1. Execute the `sail up -d` command to build and run the container. This will take a while the first time. You will need to execute this command every time you want to run the app again. `sail down` stops the app/container.
1. Once the containers are started, run `sail artisan migrate` to create the required database tables.
1. Go to [http://localhost](http://localhost) in your browser to view the web app. The first time you will see an error about the app encryption key. Click the generate button and refresh the page. The app and your development environment should now be up and running.
1. If you want to edit CSS styling or JavaScript, make sure to run `sail npm run watch` before making changes so these are reflected in your browser. This will compile the front-end assets for development. Make sure to run `sail npm run production` before moving to production.
