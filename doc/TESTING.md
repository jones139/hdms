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
* Log in using user 'user1' with password 'test' - should give document list with options to: 
  * Edit revisions
  * Create major revisions of issued documents.
  * Create major or minor revisions of draft documents
  * Edit the document data.
  * Access the edit the user data form (from 'User 1' link in header)
  
### Test 2.2 - Access Denied
* Attempting the following when logged in as 'user1' with password 'test' should
result in an error:
  * /hdms/docs/add - Only an administrator can add a new document.
  * /hdms/users/index - Only an administrator can list users
  * /hdms/users/add - Only an administrator can add users.
  * /hdms/users/edit/3 - Only an administrator can edit other users' data.

### Test 2.3 - Edit User Data
* Log in using user 'user1' with password 'test', then click on the 'User 1' link in the header to access the edit user data form, then try the following in turn.
  * Change the user's full name to something different.  Submit form, then log out and in again to check change has been made correctly.
  * Change Password by putting a new password in both password fields in form - log out and in again to test.
  * Attempt to change password by putting different passwords in the two password fields - password should not update - log out and in again to test.
  * Attempt to change passwords leaving one of the password fields blank - should give an error and password remains unchanged.
  * Normal user should NOT be able to change username or role - check these fields are not shown.


### Test 2.4 - Create Revision and attach file.
* Log in using user 'user1'.
  * Create a major revision for the Finance Policy (2nd document on the list) by pressing the 'Major' button.   Should return to the Documents list, but a new revision 1_1 should be shown in the document data.
  * Edit the revision by pressing the '1_1' or 'Edit Rev' links.
  * Should show that no document is attached.   Click the 'Attach file' link and select any file to upload using the 'Choose File' button, then upload the file by pressing 'Upload File' - should return to the edit revision form without error.
  * Go back to the main documents list page - there should be a download native document icon which will download the newly attached file.

### Test 2.5 - Check-Out and Check-In file
* Following on from previous test...
  * From main document screen, click on the Edit Rev button for the Finance Policy document.
  * The edit form should show that there is a document attached, but it is not
checked out.
  * Click on 'Check Out File' - this should download the file automatically.
  * Refresh the page - the revision edit form should now show that the file is checked out and who checked it out.
  * Pressing 'Cancel Check Out' should cancel the check-out and show the 'Check Out File' option again.
  * Click on the 'Check Out File' - this should download the file automatically.
  * Refresh page and click on the 'Check In File' link.   Click 'Choose File' and select a Different file (so you can check it is uploaded correctly). and select 'Upload File'.
  * Should show new file as uploaded successfully.
  * Go back to the main document list and click on the download native document icon and check that the correct file is downloaded.

### Test 2.6 - Route List Set Up
* Following on from previous test...
  * From main document screen, click on the Edit Rev button for the Finance Policy document.
  * Click on the 'Create Route List' link - should show a blank route list with an 'add approver' option.
  * Select 'User 1' and press 'Submit' - should show a route list with User 1 on it.
  * Select 'User 2' and press 'Submit' - should now have 2 users on the route list.
  * Press 'Back' to return to Revision editing screen - the route list should now be shown, with 'Edit Route List' and 'Submit Route List' options.
  * Press 'Submit Route List' - should give a 'route list submitted' message.
  * User 1 should now have a notification shown in the header, and an option to approve the revision in the revision editing screen.
  * Click on 'Approve Revision'.   On the new screen, select the 'Approve' response, add a comment and press 'submit response'.   The revision editing form should be shown and the route list should show that User 1 has approved the revision.

### Test 2.7 - Document Approval and Issue
* Following on from the previous test....
  * Log out, and log in as 'User2' with password 'test'.
  * The header should show a notification - click on the 'notifications' link in the header - should show a 'Please Approve Revision' request.
  * Click on the 'Review/Approve Revision' link - should show the revision editing screen with an option for User 2 to approve the revision.
  * Click on the 'Approve Revision' link.  Select the 'Approve' response, add a comment and press 'Submit Response'.   In the revision editing screen, the route list status should change to 'Complete', and the document status to 'Issued'.
  * Press Back to go back to the document list - The document should now show as having an Issued Revision, with a download icon next to both the 'issued' and 'latest' revisions, which will both be the same.
  * Check that the notifications regarding approval of the revision have been deleted automatically.
  * Clicking on the 'Edit Rev' link will show the revision with no options to change it.   The route list section shows the reviewers' comments so it is clear why the document was approved.

### Test 2.8 - Rejecting a revision.
* Following on from previous test (as User 2).
  * Create major revision for the finance policy document - it should show that the latest revision is now newer than the issued one.   Click on the 'Edit Rev' for the latest revision.
  * Check out the file and upload a different file (to check the correct one is uploaded).
  * Create a route list and add User 1 and User 2 to the route list.
  * Submit the route list.
  * Approve the route list as User 2 - response should be accepted with a 'waiting for other reviewers' message.
  * Log out, and log in as user 1.
  * Select the approve revision notification.
  * Select the Approve Revision link, but this time, select the 'Reject' response, with a comment, and submit the response.
  * The document status should change to 'Rejected' with the route list complete (It is now necessary to create a minor revision and update the document to satisfy the reviewer).

