# rexx systems

A set of tools to add features, services or more information

> I created this project with PHP 7,  MySQL and Docker so you can easily run it on any system that you want.

## Start

To use this system , Just enter the code below :

```sh
	
	docker compose up
	
```

## Description

> I have created a similar system to filter the closest post office to a person's location, for this project the process is as follows:
1. The page containing the required filters is displayed by the server and the Json file is read at the same time.
2. With the help of hash, the information of the Json file is checked to see if the Json file has changed or not, and if it has changed, the system will update the information.
3. According to the version of the event, the system finds out whether this event is based on Europe/Berlin time or UTC , and accordingly, if it is based Europe/Berlin time, it converts it to UTC time.

## Link

 [First Page](http://localhost:8037)
 
 [PhpMyAdmin Page](http://localhost:8127)

> It's possible to change Challenge.json json at any time , I did not optimize the file and used the same original file, you can easily change it.