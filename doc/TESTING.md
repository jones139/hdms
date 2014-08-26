# Testing of HDMS Installation

## Assumptions
* Clean installation as described in [INSTALL.md].

## Test 1 - Unauthenticated User

### Test 1.1 - Basic Access
* If logged in, press 'logout' link
* Viewing /hdms should show list of documents.   
* There should be no buttons or links to allow more detailed viewing or editing of data.
* Clicking 'login' link should take user to the login page.

### Test 1.2 - Access Denied
* Selecting `/hdms/docs/edit/1` should give an error (an unauthenticated user can not edit a document).
* Selecting `/hdms/revisions/edit/1` should give an error (an unauthenticated user can not edit a revision).
* Selecting `/hdms/users/index` should give an error (an unauthenticated user can not list users).
* Selecting `/hdms/users/view/1` should give an error (an unauthenticated user can not edit a user).
* Selecting `/hdms/users/edit/1` should give an error (an unauthenticated user can not edit a user).
* Selecting `/hdms/notifications/index` should give an error (an unauthenticated user can not list notifications).

## Test 2 - Normal User
### Test 2.1 - Basic Access
* Log in using user 'colin' with password 'test' - should give document list with options to create revisions and edit revisions.


