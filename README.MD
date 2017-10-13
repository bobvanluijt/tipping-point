# TippingPoint - Aircraft Weight & Balance

_NOTE: This is a clone of the open source version of tipping point on [source force](https://sourceforge.net/projects/tippingpoint). Project isn't updated since 2012. This code base contains some minor bug fixes._

- OLD: http://sourceforge.net/p/tippingpoint
- NEW: https://github.com/bobvanluijt/tipping-point

Tipping point is a web-based aircraft weight and balance calculator with
graphing. It has support for multiple aircraft and administrators. The software
requires PHP and MySQL, and utilizes the pChart graphing library.

### Info

This is a final pre-production release.

Things we would like to add in the future:
* Multiple organizations (with aircraft) from a single install
* Automated installer
	- Genericize database
* Code cleanup
* Multiple weight envelopes on the graph (ie: normal category, utility category)
* "e-file" weight and balance (no printing and signing)

### Install

_Note optimized for php7.1_

To Install:
0) Make sure to install php7.0-xml.
1) Download the code and SQL file
2) Use the SQL file to create to create the blank database
3) Manually add a user account to the "users" table in the database,
   leave the password field blank
4) Extract the code
5) Edit "func.inc", fill in your MySQL server information