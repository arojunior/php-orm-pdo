# PHP ORM PDO Micro Framework

*I had to make a simple application but I didnt find good options of simple ORM for PHP, that's why I made this basic classes.* Ps.: It's under development yet.

Let's get started:

  - CRUD functions
  - Auto load Model classes in Controllers
  - To use the automatic functions you should use the filename and structure conventions
  - Just follow the exemple on /controller/UsersController.php
  - All controllers in /app/controllers folder
  - All models in /app/models folder

So you have two options: you can use like a framework puting your files inside the folder structure or just use like a vendor and extending the Model class (/core/model/Model.php)

**Convetions to use as a framework**

  - All controllers in /app/controller path
  - All models in /app/model path
  - All views in /app/view path
  - Filenames and classes must has the same name

**CRUD**

First of all you have to change the config.ini file and then create a model, for example, Users model.

```php
<?php
	namespace SimpleORM\app\model;

	use SimpleORM\core\model\Model;

	class Users extends Model
	{
    	/*
        * * Basic configuration
        * These arguments are optionals
        * protected $table = 'users'; //just if the class name a table name are different
        * protected $pk = 'id'; //just if the primary key name is not id
        */	    	    
	}

```
Createa a new user (without checking)
```php
    $this->Users->create([
    	'name' => 'Junior Oliveira',
        'email' => 'arojunior@gmail.com'
    ]);
```
Update user with id = 1
```php
	$this->Users->update([
		'id' => 1,
		'email' => 'contato@arojunior.com'
		]);
```
Let the ORM choose if it will create or update. The ORM will execute the find method before to decide if will create or update
```php
	$this->Users->save([
		'id' => 1,
		'name' => 'Junior Oliveira'
		]);
```
Delete
```php
	$this->Users->delete(['id' => 1]);
```
Read
```php
	$this->Users->find(); // Select all data
	$this->Users->find(['id' => 1]); // Select data with id = 1    
```
Row count (select/insert/update/delete)
```php
echo $this->Users->count;
```

Installing via composer and using as a lib

```shell
composer require arojunior/php-orm-pdo
```

Extending the Model class


```php
<?php
// create a file to overwrite the database config

require __DIR__ . '/../vendor/arojunior/php-orm-pdo/core/model/Model.php';
use SimpleORM\core\model\Model;

class AppModel extends Model
{
    public $db_config = [
        'db_host' => '192.168.1.1',
        'db_name' => 'test',
        'db_user' => 'root',
        'db_pass' => ''
    ];

}

```
And then you can extend this class in your classes

```php
<?php
require __DIR__ . '/AppModel.php';

class Example extends AppModel
{
    public $table = 't_user';
    public $pk = 'user_id';

    public function getAll()
    {
        return $this->find();
    }
}
```
