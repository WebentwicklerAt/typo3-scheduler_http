.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _introduction:

Introduction
============


.. _what-it-does:

What does it do?
----------------

This extension allows to invoke the scheduler via HTTP-Request. This approach can be necessary if your webspace-provider offers periodical requests via HTTP only (e.g. on clustered systems) or if your webspace-provider does not provide cronjobs at all and you are advised to use a third-party service which initiates periodical HTTP-Request to your webspace.

Furthermore this extension provides the possibility to add tasks to your scheduler doing GET-Requests. Therefore you can add and periodically run external (e.g. invoking other Scheduler HTTP instances ;-)) or even local scripts very easily. The latter one can be some sort of export-job integrated as an alternative page type – the way you go if the whole frontend is required for rendering purposes - for example.


.. _links:

Links
-----

* Forge: http://forge.typo3.org/projects/show/extension-scheduler_http
* Git-Repository: https://github.com/WebentwicklerAt/typo3-scheduler_http
