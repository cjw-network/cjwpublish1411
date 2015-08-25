About eZ Autosave
=================

Project page: http://projects.ez.no/ezautosave
Roadmap feature request:
http://share.ez.no/feature-requests/auto-store-draft-feature

eZ Autosave enables the automatic and transparent saving of the draft
while editing a content in eZ Publish. Based on this, it also provides
an "inline" preview from the content edit in the administration
interface.

This extension is based on QH Autosave by Quoc-Huy NGUYEN DINH


Features
========

- Regularly save the draft (interval defined in
  `autosave.ini/[AutosaveSettings]/Interval`)
- Save the draft when the user leaves a form field (enable/disable
  through `autosave.ini/[AutosaveSettings]/TrackUserInput`)
- Hide the "Store draft" button (enable/disable through
  `autosave.ini/[AutosaveSettings]/HideStoreDraftButton`)
- Try to save the draft if the editor unexpectedly quits the content
  edit page (back button, close browser, ...)

Requirements
============

- eZ Publish 2012.01 or 4.7 or newer
- ezjscore

TODO / Known issues
===================

- Add timeout support as soon as the YUI3 bug #2531308 is fixed
  http://yuilibrary.com/projects/yui3/ticket/2531308
- When timeout is implemented, add a Retry button in case of timeout
- Use the output of the ezjscore action to update the content edit form:
  for instance, after uploading an image, the preview could be updated
  or the unvalidated field could be hightlighted.
- Let the editor disable/enable the autosave process
- Let the editor choose the interval between two autosave attempts


Technical notes
===============

This extension provides a JavaScript component called `Y.eZ.AutoSubmit`.
It's the main part of the extension, it allows to automatically submit a
form at fixed interval or because the user has changed something.

This component extends the EventTarget YUI3 component and then triggers
some events during its life. The available events are (see example below
for details):

- init
- beforesave
- success
- error
- nochange
- abort

It also listens for the event 'autosubmit:forcesave'. When this events
is fired, the Y.eZ.AutoSubmit component will try to submit the form no
matter if its state has changed or not.

Example:

    {ezscript_require( array( 'ezjsc::yui3', 'ezautosubmit.js' ) )}
    <script type="text/javascript">

    YUI(YUI3_config).use('ezautosubmit', function (Y) {

        var as = new Y.eZ.AutoSubmit({
            form: '#selectorToTheForm',
            ignoreClass: 'no-autosave', // change in form fields with this class
                                        // will not trigger an auto submit
            action: 'url/to/post/the/form/content', // should answer in JSON
            interval: 30, // number of seconds between two submit attempts
            trackUserInput: true, // boolean, whether the component should try to
                                  // submit the form if the user leaves a field
                                  // and has made changes
            enabled: function () { return true; } // optional function to
                                                  // disable autosave in some circumstances
            });

        as.on('init', function () {
            // init event
            // triggered when the component is initialized
            // if the `enabled` function returns false, this event is not
            // triggered
            // "this" is the Y.eZ.AutoSubmit instance
        });

        as.on('beforesave', function () {
            // beforesave event
            // triggered right before the form is automatically submitted
            // "this" is the Y.eZ.AutoSubmit instance
        });

        as.on('sucess', function (e) {
            // success event
            // triggered if the form was correctly submitted
            // e.json contains the server response in JSON
            // "this" is the Y.eZ.AutoSubmit instance
        });

        as.on('error', function (e) {
            // error event
            // triggered if the form was not correctly submitted
            // e.json contains the server response in JSON if the
            // server response was JSON valid
            // "this" is the Y.eZ.AutoSubmit instance
        });

        as.on('nochange', function () {
            // nochange event
            // triggered if the component tries to submit the form but no
            // change has occurred since the last submit
            // "this" is the Y.eZ.AutoSubmit instance
        });

        as.on('abort', function () {
            // abort event
            // triggered if the component tried to submit the form but the
            // request is aborted for instance because of a call to stop()
            // "this" is the Y.eZ.AutoSubmit instance
        });

        // from anywhere in the application, the following line will make
        // the Y.eZ.AutoSubmit component to submit the form
        Y.fire('autosubmit:forcesave');

    });
    </script>
