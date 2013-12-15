Slimstart
=========

Slimstart is an Open Source based setup compiled by [80 Ridge Street Media AB](http://ridgestreet.com) for getting up to speed with your PHP web quickly. It is based on:

- Slim Framework (Sinatra-like lightweight PHP framework)
- Mustache (Logicless templating for PHP and JS)
- Sass - Compass (soon Bourbon.io instead)
- [Twitter Bootstrap Sass-version](https://github.com/jlong/sass-twitter-bootstrap)
- CoffeeScript
- jQuery
- [Mustache.js](https://github.com/janl/mustache.js/)
- [Grunt.js](http://gruntjs.com) for build steps and other repetitive tasks

Sass
----

You need to have [SASS](http://sass-lang.com) and Compass installed

`$ gem update --system`

`$ gem install compass`


First time you run Slimstart
----------------------------

`$ cd {project_home}`

`$ npm install`

Installs all needed grunt modules to your local environment


Run environment
---------------

`$ cd {project_home}`

`$ grunt`

`$ compass watch www`


Test it
-------

Everything should work from start (if you are using nginx you have to modify the nginx.conf file according to your local setup), go to 

http://slimstart.dev/hello/

and you should see "Hello world"

Go to

http://slimstart.dev/hello/ridgestreet

and you should see "Hello ridgestreet"
