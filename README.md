# LaravelRepositories
## Artisan commands to create repositories

This package provides an easy way to quickly setup and create a Repository using Unit Of Work Pattern.

1. [Requirements](#1-requirements)
2. [Installation](#2-installation)
3. [Configuration](#3-configuration)
4. [Usage](#4-usage)
5. [Default Repository Methods](#5-default-repository-methods)
6. [Unit Of Work methods](#6-unit-of-work-methods)

### **1. Requirements**
- PHP >= 7.1.3
- laravel/framework ^5.8

---

### **2. Installation**
Require the package using composer:

```
composer require thalles/repositories-commands
```

### **3. Configuration**

Run the following command to create the main Repository and Interface for this repository.

```
php artisan repository:setup
```

> Pay attention to the terminal output. You will need to copy the output and paste on register method of AppServiceProvider.


### **4. Usage**

To create a new repository, use the following command.

```
php artisan repository:new RepositoryName ModelName
```

> The fisrt argument is the repository name. The second is the model that you want to use. If your model was not on default path, you can inform the path to file.

Exemple:

```
php artisan repository:new UserRepository Models/User
```

Add the repository attribute to the UnitOfWork class.

```
<?php

namespace App\Repositories;

use App\Interfaces\UnitOfWorkInterface;
use Illuminate\Support\Facades\DB;

class UnitOfWork implements UnitOfWorkInterface
{
    /**
     * UserRepository instance
     *
     * @return void
     */
    private $UserRepository;

    /**
     * ProductRepository instance
     *
     * @return void
     */
    private $ProductRepository;

    ...
}

```

Use the UnitOfWorkInterface on your code implementation.

```
<?php

namespace App\Http\Controllers;

use App\Interfaces\UnitOfWorkInterface;

class UserController extends Controller
{
    /**
     * UnitOfWork instance
     *
     * @var App\Interfaces\UnitOfWorkInterface
     */
    private $uow;

    /**
     * Constructor method
     *
     * @param App\Interfaces\UnitOfWorkInterface $uow
     */
    public function __construct(UnitOfWorkInterface $uow)
    {
        $this->uow = $uow;
    }

    public function index()
    {
        try {
            $this->uow->beginTransaction();

            $user = $this->uow->UserRepository->add([
                'name' => 'User Name',
                'email' => 'email@email.com',
                'password' => bcrypt('secret')
            ]);

            if ($user) {
                $this->uow->commit();
                return $this->uow->UserRepository->all();
            }

            throw new Exception();
        } catch (Exception $e) {
            $this->uow->rollback();
            return back()->with('error', 'Internal Server Error.');
        }
    }
}
```

### **5. Default Repository Methods**

This package makes available some methods to be used on CRUD.

1. Return an item with defined id.

```
/**
 * @param integer $id
 * @return stdClass|null
 */
function getById(int $id) : ?stdClass
```

2. Return all rows from database.

```
/**
 * @return Collection
 */
function all() : Collection;
```

3. Add a new item to database.

```
/**
 * @param array $data
 * @return stdClass|null
 */
function add(array $data) : ?stdClass;
```

4. Update an item in database.

```
/**
 * @param integer $id
 * @param array $data
 * @return stdClass|null
 */
function update(int $id, array $data) : ?stdClass;
```

5. Delete an item from database.

```
/**
 * @param integer $id
 * @return boolean
 */
function delete(int $id) : bool;
```

6. Return total of items in database.

```
/**
 * @return integer
 */
function count() : int;
```

7. Format model data.

```
/**
 * @param Model $model
 * @return array
 */
function dataFormat(Model $model) : array;
```

If you need to create another methods for your repository, fist register the method on the Interface, after implementing the method on Repository.

- Interface.

```
<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Make the search query
     *
     * @param string $search
     * @param int $pagination
     *
     * @return Collection
     */
    function search(string $search, int $id_user_auth) : Collection;
}
```

- Repository.

```
<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Interfaces\UserRepositoryInterface;

class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct(new User());
    }

    /**
     * Make the search query
     *
     * @param string $search
     * @param int $pagination
     *
     * @return Collection
     */
    public function search(string $search, int $id_user_auth) : Collection
    {
        $users = $this->model
            ->where('id', '<>', $id_user_auth)
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orderBy('name', 'ASC')
            ->get()
            ->toArray();

        $users = $this->arrayToStdClass($users);
        $users = new Collection($users);

        return $users;
    }
}
```

### **6. Unit Of Work methods**

1. Begin the database transaction.

```
/**
 * @return void
 */
function beginTransaction();
```

2. Commit the transaction changes.

```
/**
 * @return void
 */
function commit();
```

3. Rollback the transaction changes.

```
/**
 * @return void
 */
function rollback();
```
