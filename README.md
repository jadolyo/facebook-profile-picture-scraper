FBpp
========

Facebook Profiles Pictures Scraper
It's a very simple tool till now all it does scrap pictures from Facebook profiles and  generate a hash value for the image, It's Hexadecimal values, Then stores the hashed values inside MySQL database, Compare uploaded picture with hashed pictures in the DB and shows similar pictures if found.

What's new?
============

2014-10-04 Ahmed Jadelrab <ahmad.jadelrab@gmail.com>

*Now I am using Phasher class, Perceptual hashing is a method to generate a hash of an image which allows multiple images to be compared by an index of similarity.

Thanks to Kenneth Rapp you can find this class on the following link:
https://github.com/kennethrapp/phasher

What is my vision?
===================

*My vision is to make image reverse search tool for Facebook profiles pictures, I want to use OpenCV for face recognition too in the future.

What is the advantages of this tool?
=====================================

*It might be used for predicting things in some countries, or to count something like:

-How many people are supporting certain political figure?

-Maybe some events make people change their profile picture to a specific picture supporting that event.

-You might find someone looks like you, Who knows! :)

*There are a lot of possibilities to use this idea in useful things in social media statistics and other fields.


How to install?
================

1- You need to create the database first, You will find fbpp.sql file inside DB folder.

2- You need to Edit some variables inside config.php

3- You need to run scraper.php to scrap some pictures.