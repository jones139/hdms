hdms
====

HAT Document Management System

This repository is for an experimental simple document management system for Hartlepool Aspire Trust.   We are currently using a modified version of OpenDocMan, but there are some features that I would like us to have that OpenDocMan does not have, and the OpenDocMan structure does not lend itself to simple modification.   So, I'm going to write it myself.  The features will be:
* Use an established php framework to keep the basic code simple (cakePHP).
* Create a simple API so we can use an ajax based front end.
* It needs to have a few concepts:
  *    Currently issued version
  *    Draft version in progress - user checks out document modifies it and checks it in as another minor revision.
  *    Selectable approval routes (different document types need different approvals).
  *    Store both a native and an issued document (ie .docx and .pdf files)
  *    Non-authenticated users can only view the latest issued version of a file.
  *    Each document has a security classification that determines whether non-authenticated users can view it or not.
  
I may well abandon this and modify opendocman if this proves too difficult, but a quick experiment with cakePHP makes me think it is not too difficult to do.

