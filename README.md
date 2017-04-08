# hdms - Hartlepool Aspire Trust Document Management System

HDMS is a [Document Management System](http://en.wikipedia.org/wiki/Document_management_system) that has been devloped for Hartlepool Aspire Trust ([Catcote Academy](http://catcoteacademy.co.uk)).

It has been developed because the Trust is expected to have many policies
to ensure compliance with statutory regulations, and these policies are
implemented within the trust using procedures for detailed instructions, and
forms to record information.

It is important that the latest versions of the Policies, Procedures and Forms
are available to staff and key stakeholders, and that changes between versions
can be tracked and communicated to stakeholders so they know what has changed
when a new document is issued.

HDMS has been developed to store the Trust's documents in a single repository
(a web server) and present the latest version of documents to interested
parties.   Users are initially presented with a graphical summary of the
document structure.  
![Screenshot Image](https://github.com/jones139/hdms/raw/v1.2/doc/home_page_screenshot.png)
The user clicks on parts of the graphical summary to 
search for specific types of documents (such as Financial Procedures, 
or Human Resources Policies).  This gives  a list of documents, showing the 
latest revision number with date of issue, with clickable icons to download
either the PDF version or native version of the file.   
![Screenshot Image](https://github.com/jones139/hdms/raw/v1.2/doc/document_list_screenshot.png)
Authorised users
have options to create new revisions, or edit existing draft documents.


Draft versions of documents are not publicly visible, but can be
viewed by authorised users.   Approval and issue of documents is managed by
the draft document being sent electronically to reviewers/approvers.  
The document is issued and becomes the latest version once all the 
reviewers/approvers have approved the document.

The system stores both 'native' (e.g. MS Word) documents and PDF documents.
By default the PDF version is delivered to the public, as this can not be
modified accidentally.   The system can also store 'extra' files, which may
be the source files for drawings or tables of data that are used in the
document - this is useful for future updates so the author can obtain all the 
data used to produce the original document.

The live version of the system is running at (http://catcotegb.co.uk/hdms).

The software is quite general so may be of use to other small and medium size organisations who wish to manage their documentation in a systematic way.  There is a demonstration version of the system available at http://catcotegb.co.uk/hdms_demo - login as 'user1' with password 'test').

A brief Developers Guide can be found [here](https://github.com/jones139/hdms/blob/master/doc/DEV_GUIDE.md) 
to help new developers find 
their way around the code.  But really you need to understand 
[CakePHP](http://cakephp.org) to be able to follow the code properly, so a 
CakePHP tutorial would be a good start.

## HDMS Features
* Uses the [CakePHP](http://www.cakephp.org/) framework so it should be easy 
for other people to maintain in the future if necessary.
* The current issued version of a document is always available to the public.
* Users can work on draft versions without affecting the publicly visible version.
  - User checks out document.
  - Other users can see who is working on it.
  - User checks in document making changes visible to ther users (but not the public).
  - User requests the system to create a PDF version of the document, or manually attaches a PDF file.
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

It is possible to link directly to the latest issued version of a document using
docs/getIssuedFile/<docNo> or docs/getIssuedFile/<docNo>/type:native URLs

There is a demonstration installation of the system available for testing on the [catcotegb web site](http://catcotegb.co.uk/hdms_demo).

## Future additions
* Each document should have a security classification that determines whether non-authenticated users can view it or not.
* Enforce some admin controls in code such as:
  * number of reviewers for a document
  * prevent submitting a route list if no document attached
  * prevent submitting a route list if document is checked out
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
  

