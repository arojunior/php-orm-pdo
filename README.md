### Installing via composer and using as a lib

```shell
composer require arojunior/php-orm-pdo
```

### create a file to overwrite the database config

```php
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

#### And then you can extend this class in your classes

```php
use YourNamespace\AppModel;

class Example extends AppModel
{
    public $table = 't_user';
    public $pk    = 'user_id';

    public function getAll()
    {
        return $this->findAll();
    }
}
```

### CRUD

```php

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

### Creating a new user (without check)

```php
$this->Users->create([
  'name' => 'Junior Oliveira',
  'email' => 'arojunior@gmail.com'
]);
```

**Let the ORM choose if it will be created or updated. The ORM will execute the find method before to decide if will create or update data**

### Saving data

```php
$this->Users->save([
  'id' => 1,
  'name' => 'Junior Oliveira'
]);
```

### Retrieving the id

```php
$this->Users->lastSavedId();
```

### Updating a user with id = 1

```php
$this->Users->update([
  'id' => 1,
  'email' => 'contato@arojunior.com'
]);
```

### Delete

```php
$this->Users->delete(['id' => 1]);
```

## Read

```php
$this->Users->findAll(); // fetchAll

$this->Users->findOne(['email' => 'arojunior@gmail.com']);

$this->Users->findById($id);
```

### Checking

```php
$this->Users->exists($id);
```

in case of true, you cat get the data with:

```php
$this->Users->fetch();
```

### Functionalities if used as Framework

- CRUD functions
- Auto load Model classes in Controllers
- To use the automatic functions you should use the filename and structure conventions
- Just follow the example on /controller/UsersController.php
- All controllers in /app/controllers folder
- All models in /app/models folder

### Convetions

- All controllers in /app/controller path
- All models in /app/model path
- All views in /app/view path
- Filenames and classes must has the same name
