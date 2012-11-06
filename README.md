#Manifest-Creator-for-HTML5
==========================

A class to dynamically generate .manifest file for HTML5 webapps that uses Application Cache

##Requirements
* Apache2
* PHP5

##Usage
###Method1: Stand-alone
1. Copy ManifestCreator.php into your webserver
2. Edit the last string of the file like the example below:
	$manifest = new ManifestCreator($filename, $path, $network);
	Replace the parameters with appropriate values, see the code for documentation
3. Launch it from your webserver (i.e http://localhost/ManifestCreator.php)

###Method2: from your webapp folder
1. Copy ManifestCreator.php into the root of your webapp
2. Edit the last string of the file like the example below:
	$manifest = new ManifestCreator($filename, $path, $network);
	Replace the parameters with appropriate values, see the code for documentation, leave the first parameter null
3. Launch it from your webserver (i.e http://localhost/myWebApp/ManifestCreator.php)


##Important
If you use the second method, remember to delete the ManifestCreator.php!

##Support
For further information contact me via mail at tiz.basile@gmail.com or via skype, my username is tizionario
