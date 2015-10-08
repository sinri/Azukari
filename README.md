# Azukari

File Storage Service. It is designed to be a simple version of Aliyun OSS.

Open Source with GNU GPLv2 License.

# Preparation

Azukari would run under PHP 5.3 or later.

Apache2 with PHP 5.4/5.5 Tested.

You should understand how to deal with Apache or any other server platform.

# Install

## PHP Deployment

As it is completely indepedent project, you can place it to anywhere users can access to it.

## Storage Directory Deployment

You have serveral ways to deploy the storage directory of the files.

### Easiest Method

Open your project directory path in terminal, create a directory with any name you want (such as `store`), and then make it writable for anyone or make its owner to `www-data` or other username server process runs with. In some situations you might need add `sudo` before commands.

	mkdir store
	chmod 777 store

It is the easiest way but it is not so good for application on cloud-server with dynamic data size limitation.

### Recommended Method

It require `Options` of Apache `httpd.conf` or `.htaccess` contains `FollowSymLinks` value.

Open your project directory path in terminal, create a directory with any name you want in a safe place, such as `/var/Azukari/store`, and make soft link to it under the project directory.

	mkdir /var/Azukari/store
	chmod 777 /var/Azukari/store
	ln -s /var/Azukari/store store

### Set PHP Unrunnable There

Open the storage directory you created, make `.htaccess` file and write `php_flag engine off` into it.

	sudo echo php_flag engine off > .htaccess

It requires `AllowOverride All` in the Apache `httpd.conf` or `.htaccess`.

# Config

Edit `config.php` to make the path and url base right for use.

Edit `user.php` to set the user information.

# API Usage

Azukari provides three kinds of services, to upload, delete, and validate file, with `api.php`.

For each service, you would use `POST` request with fields listed below. And you must hold the fields `user` and `key` to compute `checksum` with other fields other than `act`.

	// Checksum Algorithm in PHP
	checksum = md5($user.$filename.$timestamp.$key.$body);

## Request Fields

Field | Format | Memo
----|----|----
act|String|One of three options, `upload`,`delete`,`validate`.
user|String|The user name. Refer to user.php.
filename|String|The name of file you want to process.
timestamp|Integer|The timestamp.
checksum|String|Checksum computed with the certain algorithm.
body|String|Base64 encoded file content for upload service; empty string for the others.

## Response Fields

Azukari would response with a json object, with three fields, `code`,`object` and `msg`.

When the service works well, the `code` responsed would be zero, or the `code` would be others with `msg` showing the error info. For `object` field, when you uploaded a file, it would be the url to the file stored on the server.
