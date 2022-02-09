# LiftKit Project Base

## To install

### Install composer dependencies

```
composer install
```

### Update database credentials in the following files

```
config/database/connection/*
```

## Controllers

### Controller Basics

Controllers are object that determine an action to be performed. Controllers must extend `LiftKit\Controller\Controller`. Public methods of controllers are actions that may be routed to. All controller actions must return an instance of `LiftKit\Response\Response`, be it a view (instance of `LiftKit\Response\View`), a JSON response (instance of `LiftKit\Response\Json`), or your own custom type.

### Default Controllers

There are a few controllers that come with this package as a starting point. They are located in `src/Controller`.

#### Controller.php

Serves as the base class for all of your controllers. Put common functionality and load common libraries here. 

This file also defines a `display()` method that serves to display an html page to the screen. You should load common views  (i.e. headers and footers) here.

#### Index.php

This controller is the main controller for your static public pages. By default it defines methods for displaying an Iris welcome page and error pages.

#### Content.php

This controller is the controller where you should place your user-managed content pages. These pages will be inline-editable. A basic `interior()`  method is provided for standard content pages with no other dynamic content or partial views.

## Routing

Route configuration is stored in config/routes/default.php by default. We will address custom routing configuration files later.

The router (an instance of `LiftKit\Router\Http` available as `$router`) has a number of convenience methods for defining routes.

### Controller Routes

Controller routes "attach" a controller to a specific URI. There are two methods of defining them.

#### registerControllerFactory()

This method takes a URI and factory function that produces controller as its arguments. This method is preferred to `registerController()` because of the fact that it lazy loads the class, which can prevent a lot of problems.

```
use App\Controller\SomeController;

$router->registerControllerFactory(
	'/base-uri/',
	function () use ($container) {
		return new SomeController($container);
	}
);
```

#### registerController()

This method takes a URI and controller as its arguments. This method is not recommended.

```
use App\Controller\SomeController;

$router->registerController(
	'/base-uri/',
	new SomeController($container)
);
```

#### Request Mapping

Both methods above "attach" the controller at the URI `/base-uri/`.  Below is a mapping of requests and their actions. 

NOTE: Normal controller routes **do not** take the request method into account. They can be GET, POST, DELETE, etc.

- `GET /base-uri` => `SomeController::index()` 
- `POST /base-uri/test` => `SomeController::test()`
- `DELETE /base-uri/with-arg/123` => `SomeController::withArg('123')`
- `GET /base-uri/with-two-args/123/456` => `SomeController::withTwoArgs('123', '456')`

### REST Controller Routes

REST controller routes operate similarly to controller routes, but the controller must implement `\LiftKit\Controller\RestInterface`.

#### registerRestControllerFactory()

This method operates similarly to `registerControllerFactory()`, except that its factory function must produce an instance of `\LiftKit\Controller\RestInterface`.

```
use App\Controller\SomeRestController;

$router->registerRestControllerFactory(
	'/base-uri/',
	function () use ($container) {
		return new SomeRestController($container);
	}
);
```

#### registerController()

This method operates similarly to `registerController()`, except that it must provide an instance of `\LiftKit\Controller\RestInterface`.

```
use App\Controller\SomeRestController;

$router->registerController(
	'/base-uri/',
	new SomeRestController($container)
);
```

#### Request Mapping

Both methods above "attach" the controller at the URI `/base-uri/`.  Below is a mapping of requests and their actions. The methods defined in `\LiftKit\Controller\RestInterface` depend on particular HTTP methods being used. 

- `GET /base-uri/` => `SomeRestController::index()` 
- `POST /base-uri/`=> `SomeRestController::insert()`
- `GET /base-uri/1` => `SomeRestController::get(1)`
- `POST /base-uri/1`=> `SomeRestController::update(1)`
- `DELETE /base-uri/1`=> `SomeRestController::delete(1)`

Any other methods added to the controller with be routed to regardless of HTTP method.

- `GET /base-uri/test-action` => `SomeRestController::testAction()`
- `POST /base-uri/another-action` => `SomeRestController::anotherAction()`

### Pattern Routes

#### Pattern Basics

Pattern routes match URI patterns to actions. Pattern routes can use named placeholders for parameters. The first parameter is the URI pattern you wish to match, the second is a callback that gets executed when the pattern matches. The third parameter is an optional HTTP method the pattern should apply to.

Like controller actions, the callback to a pattern route **must** return an instance of `LiftKit\Response\Response`.

```
$router->registerPattern(
	'/products',
	function ()
	{
		// DO SOMETHING
	},
	'GET'
);
```

#### Patterns with Placeholders

Patterns can also accept named placeholders. Named placeholders are preceded by a `:` and must be defined in a chained call to `setPlaceholder()`. `setPlaceholder()` takes two parameters, the first an identifier for the placeholder (minus the `:`) and a regex character class that matches the correct sequence of characters. There are a few built in patterns, such as `LiftKit\Router\Route\Http\Pattern\Pattern::DIGITS`, `LiftKit\Router\Route\Http\Pattern\Pattern::SLUG`, and `LiftKit\Router\Route\Http\Pattern\Pattern::ALPHA_NUM`.

```
use LiftKit\Router\Route\Http\Pattern\Pattern;

$router->registerPattern(
	'/products/:productId',
	function ($matches)
	{
		// DO SOMETHING WITH: $matches['productId']
	},
	'GET'
)->setPlaceholder('productId', Pattern::DIGITS);
```

## Views

Much of the time, your controllers actions will likely return views. Let's get into how views are loaded and used to generate an HTML response.

### A Simple View

#### views/templates/default.php

Here is a simple view with a page title, and some page content. Let's say it is placed in `views/templates/default.php`. (The default view loader looks for views inside of `views/`.

```
<!doctype html>
<html>
	<head>
		<title><?php echo $title; ?></title>
	</head>
	<body>
		<?php echo $pageContent; ?>
	</body>
</html>
```

#### src/Controller/SimpleController.php

This view could be loaded in a simple controller as follows.

```
namespace App\Controller;

use App\Controller\Controller;

class SimpleController extends Controller
{

	public function index ()
	{
		return $this->viewLoader->load(
			'templates/default',
			[
				'title' => 'Page Title!',
				'pageContent' => 'This is some page content.',
			]
		);
	}
}
```

#### Generated response

Notice that the `viewLoader->load()` method accepts two arguments. The first is the relative path to the view file, relative to the `views/` directory. The second is an associative array of variables to be injected into the view, with the key being the name it appears as in the view. The `SimpleController::index()` method would generate the following response:

```
<!doctype html>
<html>
	<head>
		<title>Page Title!</title>
	</head>
	<body>
		This is some page content.
	</body>
</html>
```

### Nested Views

Views can also be loaded and inserted into other views.

#### views/simple.php

```
<h1><?php echo $heading; ?></h1>

<p><?php echo $information; ?></p>
```

#### src/Controller/SimpleController.php

Let's update our `SimpleController::index()` method to insert this view into `templates/default.php`.

```
namespace App\Controller;

use App\Controller\Controller;

class SimpleController extends Controller
{

	public function index ()
	{
		$innerView = $this->viewLoader->load(
			'simple',
			[
				'heading' => 'Simple Page Heading',
				'information' => 'Some info about the page.',
			]
		);

		return $this->viewLoader->load(
			'templates/default',
			[
				'title' => 'Page Title!',
				'pageContent' => innerView,
			]
		);
	}
}
```

#### Generated Response

```
<!doctype html>
<html>
	<head>
		<title>Page Title!</title>
	</head>
	<body>
		<h1>Simple Page Heading</h1>

		<p>Some info about the page.</p>
	</body>
</html>
```

## Dependency Injection

The dependency injection container abstracts away dependencies from the code that uses them. This results in much more flexible code. The container (an instance of `LiftKit\DependencyInjection\Container\Container`) is the glue that holds the application together.

Dependency injection configuration lives in `config/dependency-injection/`. There are a few dependency injection configuration files placed there by default.

### Rules

The basic unit of the dependency injection container are rules. Rules are callback functions that define *how* to created an object and map that action to a string identifier. By convention, the identifiers user StudlyCase with `.`'s as "namespace" separators.

#### A simple rule

Here is a simple rule to create an `App\Controller\SimpleController` we defined above. Notice the first parameter to the callback function is always the container itself. 

```
use LiftKit\DependencyInjection\Container\Container;
use App\Controller\SimpleController;

$container->setRule(
	'App.Controller.SimpleController',
	function (Container $container)
	{
		return new SimpleController($container);
	}
);
```

Now a new instance of `SimpleController` can be created by calling:

```
$container->getObject('App.Controller.SimpleController');
```

#### Using the Container in Controllers

The container is passed to the constructor of all controllers. It can then be used inside of any controller as follows:

```
$this->container->getObject('App.Controller.SimpleController');
```

#### Rules that Depend on Other Rules

Rules can use other rules.

```
use LiftKit\DependencyInjection\Container\Container;
use App\Parts\Engine;
use App\Vehicle\Car;

$container->setRule(
	'App.Engine',
	function ()
	{
		return new Engine();
	}
);

$container->setRule(
	'App.Car',
	function (Container $container)
	{
		return new Car(
			$container->getObject('App.Engine')
		);
	}
);
```

### More Info

More info on the dependency injection container can be found on [GitHub](https://github.com/liftkit/dependency-injection).

## Modules

Modules control the loading of configuration files and general bootstrapping of the application. Module object extend `LiftKit\Module\Module`. The main module object for the application is `App\Module\App`, which extends `App\Module\Module`.

### Types of Configuration Files

There are a few types of configuration files with built-in utility methods for loading (defined in `App\Module\Module`).

#### loadDependencyInjectionConfig()

This method is for loading dependency injection configuration files. By convention, these files live in `config/dependency-injection/`. The app's dependency injection container is injected into these files as `$container`.

#### loadSchemaConfig()

This method is for loading database schema configurations files. By convention, these files live in `config/database/schema/`. A database schema object (an instance of `LiftKit\Database\Schema\Schema`) is injected into these files as `$schema`. More information about the LiftKit database library can be found on [GitHub](https://github.com/liftkit/database).

#### loadRouteConfig()

This method is for loading routing configuration files. By convention these files live in `config/routes/`. A router (instance of `LiftKit\Router\Http`) is injected into these files as `$router`, as well as the dependency injection container as `$container`.

#### loadModule() and addSubModule()

This method is for loading other modules (Instances of `LiftKit\Module\Module`) as submodules of your application, exposing their functionality to your app. These generally are in external repos install by composer. Each submodule should expose a PHP file that created the module object and returns it. `loadModule()` assumes these files live in the `vendor/` folder. It `require`s that PHP file, and attaches the return module object as a submodule of the application.

For example, the `iris/iris` module file is located at `vendor/iris/iris/iris.php` and the `iris/content` module file is located at `vendor/iris/content/content.php`. Here is an example of an `App\Module\App` class which loads both and adds them as submodules.

```
<?php

	namespace App\Module;

	class App extends Module
	{
		protected function loadModules()
		{
			$this->addSubModule(
				'Iris',
				$this->loadModule('iris/iris/iris')
			);

			$this->addSubModule(
				'Iris.Content',
				$this->loadModule('iris/content/content')
			);
		}
	}
```


### Loading Your Own Configuration Files

Let's say you create a new dependency injection config file at `config/dependency-injection/products.php`. Here is an example of an `App\Module\App` class which loads that file. Notice the `extend()` method.

```
<?php

	namespace App\Module;

	class App extends Module
	{
		// ...

		protected function extend ()
		{
			$this->loadDependencyInjectionConfig('dependency-injection/products');
		}
	}
```

## Models and Interacting with the Database

Iris uses LiftKit's database library. You can find more information on [GitHub](https://github.com/liftkit/database). A simple example of a model can be found in the contacts model in the `iris/store` extension [here](https://git1.stream9.net/iris/store/blob/master/src/Model/Contacts.php).
