Dogmazic
========

This of the repo of every single developpment made for dogmazic.net.
It's here for collaboration and sharing purpose.

Install your own version
=======================

Dogmazic is built upon existing software with some specific feature. In
this repo, you'll find only what's been modified. Therefore, if you want
a local version of Dogmazic, you'll need to install those software and
symlink what's been modified

WORDPRESS
========

Used for the official association's blog

1) Download and install WP http://wordpress.org/download/
2) Go into wp-content and do ln -s /path/to/repo/blog/jsspamblock 
3) ln -s /path/to/repo/blog/themes 

Vanilla Forum
=============

1) Download and install vanilla http://vanillaforums.org/download
2) Go into you're installation folder's themes
3) Do ln -s /path/to/repo/forum/themes/dogma

There's few other files that are hacked versions of the core files to
allow php crypt's authentication. Unless you want to test that don't
mind them

TODO : Modifiying core files is BAD, and it's been done for we were in a
hurry. Let's make a proper plugin out of that. To find the mods : grep
-r "FACTODO" .

Yiiuser
=======

This is the user managment headquarter. It allows user to register
themselves and manage themselves simultaneously in several MySQL databases.

1) Download and install yii framework http://www.yiiframework.com/
2) untar "framework" in you server's root (or whereever you like) and
set the proper rights. I'd suggest you to follow this tutorial
http://www.yiiframework.com/doc/guide/1.1/en/quickstart.first-app if
you're not familiar with yii.
3) Go in the folder where "framework" is.
4) Do ln -s /path/to/repo/yiiuser
5) put your own values in protected/config.example/
6) Rename it config
7) Do the same thing for protected/component/copyValues.php.example

WARNING : You obviously need a proper vanilla installation since yiiuser
wants to copy values into its database !

PHING SYNC AND DEPLOY
=====================

Dogma is deployed in several environements (local/dev server/prod
servers/github) and we want all of them to be in sync with their
respective credentials. That's what "build.xlm" is made for. You need to
install phing in order to use it
(http://www.phing.info/trac/wiki/Users/Installation)

You have to create a build.*your env*.properties (e.g. :
build.local.properties) then launch the script with "phing -Denv=*your
env*" (e.g. : phing -Denv=local). There's an example with the settings
you need to fill in this folder.

The proper line to upgrade the site is this one : 
phing -Denv=prod && git push origin master && git ftp push && phing
-Denv=local
(I strongly suggest you to create an alias in .bashrc).
The command above :
1) switches the files to prod credentials
2) pushes to github
3) sync the website with ftp
4) Goes back to local credential

Use the work for your website
=============================

It's released under GNU GPL v3 Licence, feel free to use any feature
we've build for your own website. It's not properly pluginified yet, ask
if you don't know where's what you looking for.

