# LaravelRepositories
## Artisan commands to create repositories

### **Requirements**
- PHP >= 7.1.3
- laravel/framework ^5.8

---

### **1. Installation**
Require the package using composer:

```
composer require thalles/repositories-commands
```

### **2. Configuration**

Run the following command to create the main Repository and Interface for this repository

```
php artisan repository:setup
```

> Pay attention to the terminal output. You will need to copy the output and paste on register method of AppServiceProvider.


### **3. Usage**

To create a new repository, use the following command.

```
php artisan repository:new RepositoryName ModelName
```
> Again, pay attention to the terminal output.

> The fisrt argument is the repository name. The second is the model that you want to use. If your model was not on default path, you can inform the path to file.

Exemple:

```
php artisan repository:new UserRepository Models/User
```

Use the interface on your code implementation.

```
<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    /**
     * User repository instance
     *
     * @var App\Interfaces\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Constructor method
     *
     * @param App\Interfaces\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return $this->userRepository->all();
    }
}
```

### **4. Default Methods**

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
