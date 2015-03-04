.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _user-manual:

Users Manual
============

First of all please make sure that you have installed and set-up the extension "scheduler" properly. Therefore the "Setup check" is provided in the module "Scheduler".

Next step is to import and install the newest version of this extension from TYPO3 Extension Repository (TER).

Invoke scheduler via HTTP-Request
---------------------------------

If you want to invoke the scheduler via HTTP-Request you can set some configuration in the "Extension manager" for this extension:

* execCmd: With that option you can e.g. initialize a login shell with environment variables. This option requires system knowledge and is for advanced users only.
* accessList: A list of IP-addresses and/or hostnames allowed to run scheduler via HTTP can be specified. *-wildcard allowed but cannot be part of a number/string (eg. 192.168.*.* or myhost.*.com => correct, 192.168.*1.* or myhost.*domain.com => wrong). If list is "*" no check is done and the function returns TRUE immediately. An empty list always returns FALSE.
* allowForce: Activates force execution of single tasks. Parameters "i" and "f" has to be set on request.
* debug: Activates debug information in TYPO3 frontend output to determine possible configuration errors.
* execManual: Execution of tasks will be done by the webserver and without CLI, the same way you can run tasks in "Scheduler" module by hand. Maybe some exotic tasks require CLI environment, but this should be the way you go.

After installing this extension successfully you should run the scheduler via HTTP-Request by hand the first time, for testing purposes. If the URL of your TYPO3 frontend is "http://webentwickler.at/" you have to request "http://webentwickler.at/index.php?eID=scheduler_http" to invoke the scheduler. If everything was OK, the time listed under "Last run" in the "Setup check" of the module "Scheduler" has changed and "return_var" in frontend will be "0".

The values of return_var are a bit arbitrary, because they depend on the scripts and operating system (for Linux see http://tldp.org/LDP/abs/html/exitcodes.html#EXITCODESREF) being used.

If everything worked fine you are ready to run the scheduler periodically now, therefore "debug" should be disabled.

Parameters
^^^^^^^^^^

You can specify parameters "i" and "f" to influence execution of scheduler tasks. For example to execute disabled scheduler task with ID "1" run "http://webentwickler.at/index.php?eID=scheduler_http&i=1&f=1".

+----------------+---------------+-------------------------------------------------------------+
| Parameter      | Data type     | Description                                                 |
+================+===============+=============================================================+
| i              | integer       | Scheduler task ID                                           |
+----------------+---------------+-------------------------------------------------------------+
| f              | boolean       | Force execution (even if task is disabled or not scheduled) |
+----------------+---------------+-------------------------------------------------------------+

Add tasks doing GET-Requests
----------------------------
If you want to periodically run external or local scripts add a new scheduler_http-Task. Therefore open the "Scheduler" module, switch to "Scheduled tasks" view and click "Add task" button. In the provided form change "Class" to "Get URL (scheduler_http)", set time options to the desired values and "URL" to the URL which should be requested by this task. Save your changes and you are done.
