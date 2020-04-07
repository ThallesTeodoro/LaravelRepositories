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

Run the following command to create the main Ropository and Interface for this repository

```
php artisan repository:setup
```

> Be attention on terminal output. You will need to copy the output and paste on register method of AppServiceProvider.


### **3. Usage**

To create a new repository, use the following command.

```
php artisan repository:new RepositoryName ModelName
```

> The fisrt argument is the repository name. The second is the model that you want to use, if your model was not on default path, you can informate the path to file.

Exemple:

```
php artisan repository:new UserRepository Models/User
```
