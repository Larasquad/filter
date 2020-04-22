# Larasquad Filter

This package allows you to filter resource based on a request in a simple way and makes you controller code clean.

## Installation

You can install the package via composer:

```bash
composer require larasquad/filter
```

## Basic usage
Make a filter class and extend it by 
```bash
use Larasquad\Filter\Filter
```
or, you can generate it by 
```bash
php artisan make:filter User
```
It will generate a filter class on you app\Filters directory.
```php
<?php
namespace  App\Filters;

use Larasquad\Filter\Filter;

class  UserFilter  extends  Filter
{

    /**
     *  Whitelisted request filterable attributes
     *
     * @return array
     */
    protected $filterable = [];

}
```
Specify the `$request` attributes which you want to filter in `$filterable` array. 
```php
    protected $filterable = ["first_name", "last_name", "email"];
```
Note that, if you put an attribute on the `$filberable` array which is not available in database column, in these case, you have to write a method on it.

Example,

```php
    protected $filterable = ["first_name", "last_name", "email", "from", "to" ];
```
In these case, `from` and `to` attribute are not exists in my database column but I have send the attributes via `$request`, then I have to 
specify the `from` and `to` method else it will get an error.

```php
    public function from($value)
    {
        $this->query->whereDate('date', '>', $value);
    }

    public function to($value)
    {
        $this->query->whereDate('to', '>', $value);
    }
```

Now, inject the class in you controller method where you have injected the `Request $request`  class
```php

public  function  index(Request $request)
{
	//
}
```

Replace the `Request $request` from your method  with `UserFilter $filter`

```php

public  function  index(UserFilter $filter)
{
	//
}
```

It will automaticall initiate the `Request $request`  in it's parent constructor.
Now use the `Filterable` trait in you model.
```php
use Larasquad\Filter\Traits\Filterable;

class  User  extends  Authenticatable
{
	use Filterable;
}
```
It's done. Now you can you the `filter` method in your controller and pass the `$filter` object in the method.
```php

public  function  index(UserFilter $filter)
{
	$users = User::filter($filter)->get();
	return  view('pages.users.index', compact('users'));
}
```
By default, It filters the model by using `Laravel` default `where` clause.
Here,  `$request` input name is used as column and `$request` input value is used as `search value` 
You can override the `search query` by writing a method on your `Filter Class` . You have to name it like the `model` database column name or the `camelCase` or `snake_case` of it.
```php
/**
* Filters the first_name column of the resource
*
* @return  void
*/
public  function  firstName($value)
{
	$this->query->where('first_name', 'like', "%{$value}%");
}
```
## License

The MIT License (MIT)
