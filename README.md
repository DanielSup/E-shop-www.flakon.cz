# E-shop at www.flakon.cz

This is a repository with source codes of the e-shop Opencart version 1.5.6.4 at www.flakon.cz. This repository doesn't include config.php, because it contains credentials to the database.

This repository contains especially the directories admin, catalog, sledovacicisla and system. These directories contains parts of source code which are mine.

The directory `admin` and `catalog` contain parts of my source code for adding photos to the table for showing order, adding further styles and other functionalities.

The directory sledovacicisla contains source code of a simple application which can add a record about the tracking number of the given order (there is given the identificator of the order) and getting the tracking number of the order with the given id.

In the system directory I modified the url.php file with a line, which ensures returning URL adresses starting with https:// (never http://).

This repository also contains my source codes which are saved in another repositories.

The first interesting part of my source code is the module for showing countries and for each country shipping methods. This part of my source code is placed on GitHub: [https://github.com/DanielSup/Module-shipping-countries](https://github.com/DanielSup/Module-shipping-countries).

The second interesting part of my source code for adding an information about the cost for cash on delivery for some shipping methods is placed in a repository on GitHub: [https://github.com/DanielSup/Opencart-adding-COD-fee](https://github.com/DanielSup/Opencart-adding-COD-fee).

The third interesting part of my source code for adding a record about the tracking number and showing the tracking number for the order with the given identificator is placed in a repository on GitHub: [https://github.com/DanielSup/Tracking-numbers-for-e-shop](https://github.com/DanielSup/Tracking-numbers-for-e-shop).