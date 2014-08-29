# hdms - Hartlepool Aspire Trust Document Management System

This repository contains the source code for the new Document Mananagement
System for Hartlepool Aspire Trust ([Catcote Academy](http://catcoteacademy.co.uk)).

It is a replacement for the [OpenDocMan](https://github.com/jones139/opendocman) based system that we used as part of the conversion to an Academy.

While the [OpenDocMan](https://github.com/jones139/opendocman) based system has
proved useful there are some shortfalls with it which we need to address to 
give a long term solution, and I decided that rather than fix those it would 
be better to produce a new system based on an established software framework 
whcih will be easier to maintain in the future.

## HDMS Features
* Uses the [CakePHP](http://www.cakephp.org/) framework so it should be easy 
for other people to maintain in the future if necessary.
* The current issued version of a document is always available to the public.
* Users can work on draft versions without affecting the publicly visible version.
  - User checks out document.
  - Other users can see who is working on it.
  - User checks in document making changes visible to ther users (but not the public).
* It uses a defined approval workflow
  - User creates a 'Route List' that identifies who must approve the document 
    for it to be issued.
  - User submits the route list for approval - reviewers are notified of request
    to approve document.
  - Reviewers view document and can either Approve or Reject the document,
    and record comments on the reasons for their decision.
  - Once all reviewers have approved the document, the document is issued and 
    becomes the publicly visible version.
  - If one of the reviewers rejects the document, the current draft is frozen
    and the user must create a new minor revision of the document, modify it to 
    address the reviewer's concerns, then re-issue the approval route list.

The workflow and structure of the application are shown in a [simple
presentation](https://github.com/jones139/hdms/blob/master/doc/HAT_DMS.pdf?raw=true).   

There is a demonstration installation of the system available for testing on the [catcotegb web site](http://catcotegb.co.uk/hdms_demo).

## Future additions
* Store both a native and an issued document (ie .docx and .pdf files)
* Each document should have a security classification that determines whether non-authenticated users can view it or not.
* Enforce some admin controls in code such as:
  * number of reviewers for a document
  * prevent submitting a route list if no document attached
  * prevent submitting a route list if document is checked out
* Add search functionality to make it easier to find the required documents.
* Extend the system to store 'Records' - ie filled in versions of forms etc. - 
  this is not trivial because we will have to be much more careful with data
  security as may records will contain personal data.
* Create a simple API so we can use an ajax based front end.
* A good, clear user guide so users can use it effectively.

## Installation
Basic installation instructions are provided [here](https://github.com/jones139/hdms/blob/master/doc/INSTALL.md).

You can see a demonstration version of the code [here](http://catcotegb.co.uk/hdms_demo).

## Testing
The testing plan (which is also a sort of tutorial on using the workflows can be
found [here](https://github.com/jones139/hdms/blob/master/doc/TESTING.md).

## Bugs / Issues / Feature Requests
If you find any issues with the code, or have suggestions for featuer requests,
plese raise an [Issue on GitHub](https://github.com/jones139/hdms/issues).

## Licence
This software is open source is released under the [Gnu Public Licence](https://github.com/jones139/hdms/raw/master/LICENSE).

This sofware includes a number of open source tools and libraries, including:
* [CakePHP](http://cakephp.org)
* [JQuery](http://jquery.org)
Please refer to the licences associated with those tools.
  

