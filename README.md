## Introduction
In this tutorial, I will show you how to install Laravel with Filament and create a small blog with articles and categories.
Filament will generate an admin template area to manage your data.
We will also use a ready-to-use Tailwind template.

## Laravel Installation
To begin, we will install a new Laravel project. Let’s name it "blog" (but you can name it whatever you like).

Be sure to have composer install on your computer : https://getcomposer.org/

Go into your default repetory (example, under Laragon : www repertory). Open a new terminal:
```
composer global require laravel/installer
```
Then run :
```
laravel new blog
```

During the installation, select the following options:
Breeze / Blade / Dark mode (choose what you prefer) / Pest / No Git / MySQL

Breeze will allow you to immediately use a login and registration area (ready to use).

Under the terminal, go into your folder :
```
cd blog
```

Once the installation is finished, we will need Livewire for Filament. Add this command in the terminal:
```
composer require livewire/livewire
```

Open VSCode, go to the .env file, and check if the name of your project matches the name given to your database.
For our example:
```
DB_DATABASE=blog
```

## Create the database
Open your SQL program to create the database.
Here I used Laragon and created the "blog" database with phpMyAdmin.
Use the name you set in your .env DB_DATABASE variable.

## Install Laravel's Tables
We will now add Laravel's tables to the database. In the terminal, run:
```
php artisan migrate
```
If everything is working correctly, you will see the tables added with a green "done" in your terminal.

![Description du GIF](https://www.imadeus.be/others/GithubGif/minion.gif)

## Filament Installation
It's time to add Filament to our project.
In the terminal, run:
```
composer require filament/filament:"^3.2" -W
```
Afterward, add the following command (we prepare the Filament environment to work better and faster):
```
php artisan filament:install --panels
```
At the step "What's the ID," just press Enter.

Next, we will add our first admin user (we will be able to use it as a Laravel member but also as a Filament admin user—it will be a unique user).
```
php artisan make:filament-user
```
Provide a name, an email (remember it), and a password.
Note: When typing the password, you won't see a cursor, just type the password and press Enter.

Open a second terminal (we will test if the Filament installation was successful):
```
php artisan serve
```

Click on the provided link and add /admin to the URL.
You should be able to access the Filament admin area using the email and password provided in the previous step.

## Filament - Creation of the model and migrations
Great job! But right now, we can't do much. We want to create our articles and categories for our blog.

![Description du GIF](https://www.imadeus.be/others/GithubGif/dance.gif)

To do that, we need to perform some actions. First, we will create our model (remember the MVC model, right?).
In the first terminal, run:
```
php artisan make:model
```
For the name, use: Categories
Then choose: migration

A migration file will be created in the following directory: database/migrations.
A model file will be created in the following directory: app/Models.

We will modify the migration file to define the structure of our table in the database.
In VSCode, open the database/migrations/xxxxxcreate_categories_table.php file and edit the up() function, replacing it with:
```
      public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
```
Nothing complicated here; we will keep it simple and create only the "name" column for our category's name.

In the first terminal again, we will create our second model for the articles:
```
php artisan make:model
```
For the name, use: Articles.
Then choose: migration.

We will modify the migration file to define the structure of our articles table.
In VSCode, open the database/migrations/xxxxxcreate_articles_table.php file and edit the up() function, replacing it with:
```
public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('user_id')->constrained('users')  ->onDelete('cascade');
            $table->foreignId('category_id')->constrainted('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }
```
As you can see, we use foreignId for the user and category. This creates links in our articles with the users and categories.
With this setup, we can retrieve the name of the user who posted the article and the category they selected.
constrained and onDelete are useful: for example, if you delete a category, it will also delete all related articles from that category in the database.

Now, let's add all this information to our database:
```
php artisan migrate
```
You can see the result in phpMyAdmin, MariaDB, or your chosen program.

Good? Perfect.

![Description du GIF](https://www.imadeus.be/others/GithubGif/dance2.gif)

## Filament - creation of the Resources Files
Now, we will create all the resource files we need.

Run the following commands in the terminal.

First: Category
```
php artisan make:filament-resource Categories --generate --view
```

Second: Article
```
php artisan make:filament-resource Articles --generate --view
```

Third: User
```
php artisan make:filament-resource User --generate --view
```

The --generate flag is really helpful, and I recommend using it every time you create a resource file.
This command will create the form structure for adding new entries to the database (automatically using the database field structure).
If this isn’t clear, it will be in a few minutes.

The --view flag will add a view icon in the admin area for the resource files you created.

Want to see the result? Go to your Filament admin area and refresh the page.
If everything works well, you should see a left menu with Articles, Categories and Users.

## Filament - small tips
Okay, but at this point, you might want to customize this menu a bit. This is quite easy to do (thanks to Filament).

### Change the icon
Go to the folder: app/Filament/Resources, and choose, for example: ArticleResource.php

Find the following line (at the beginning) and replace it with:
```
protected static ?string $navigationIcon = 'heroicon-o-newspaper';
```
Refresh the admin page, and the icon should have changed.

To know the name of the icon to use, it’s easy: Filament uses Heroicons (https://heroicons.com/).
Choose an icon from the website and type the name directly after heroicon-o-.

Let’s do the same for CategoryResource.php (replace the existing code with the following):
```
protected static ?string $navigationIcon = 'heroicon-o-tag';
```

And finally, for UserResource.php (replace the existing code with the following):
```
protected static ?string $navigationIcon = 'heroicon-o-user-group';
```

Refresh the page, and there you have your three new icons. Isn't it wonderful? Yes, it is.

### Change the menu's name
Let’s stay on UserResource.php and change the name from "User" to "Utilisateurs."
Add the following lines just under the line for the icon:
```
protected static ?string $navigationIcon = 'heroicon-o-user-group';
protected static ?string $navigationLabel = 'Utilisateurs';
```
Refresh the page : TADA :)

![Description du GIF](https://www.imadeus.be/others/GithubGif/fantastic.gif)

### Change the position of the menu
Imagine you want the menu in the following order: Categories, Articles, Users (Utilisateurs).
Just add the following command under the icon in each resource file:
In ArticleResource.php:
```
protected static ?int $navigationSort = 2;
````

In CategoryResource.php:
```
protected static ?int $navigationSort = 1;
````

In UserResource.php:
```
protected static ?int $navigationSort = 3;
````

Refresh and see the result.

### Display the number of articles, categories and user in the menu area
You want to add the number of articles, categories and users near to your menu (admin zone)

Open the app/Filament/ArticlesResource.php and add (under protected static ?int $navigationSort = 2;)
```
public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
```

Do the same in app/Filament/CategoriesResource.php and app/Filament/UserResource.php

Refresh the page and see the results. 

## Filament : add new categoriers and new articles

You may have already tried adding a category or article and encountered an error. You can try to add one now, but it won’t work.

But why? Because you haven’t told Laravel which database table columns are fillable.

Let’s solve that situation:
Open the Category.php file in App/Models and add the following line under use HasFactory;:
```
protected $fillable = ['name'];
```
Refresh the page and try adding a category now (example : fruits)!
Great! You can also view, edit, and delete the category. Yes, welcome to Filament. Everything is ready to use.

Next, in App/Models/Article.php, add the following line under use HasFactory;:
```
protected $fillable = ['title', 'content', 'user_id', 'category_id'];
```
But if you try to add an article, but you will have to add manually the id of the user and the id of the category ... ! 

Of course, since we’ve made some relationships between our tables, we need to define how to manage this situation:
Let’s go to App/Models/Article.php and add:
```
public function user()
    {
        return $this->belongsTo(User::class);
    }
public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
```
How to read this:
An article can only belong to one user (only one user can write an article).
An article can only belong to one category (for example, an article can’t be in both the fruit and vegetable categories at the same time).

We also need to return to App/Models/Category.php and add:
```
 public function articles()
    {
        return $this->hasMany(Articles::class);
    }
```
A category can contain many articles. For example, the fruit category can have many articles about fruit.

Lastly, go to App/Models/User.php and add:
```
public function articles()
    {
        return $this->hasMany(Articles::class);
    }

    public function categories()
    {
        return $this->hasMany(Categories::class);
    }
```
A user can write many articles and create many categories.

Before testing, we need to correct the view form. When you add an article, you’ll see the form you’ll use on the screen.
To edit the form, go to App/Filament/ArticleResource.php and search for the following code:
```
Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('category_id')
                    ->required()
                    ->numeric(),
```
And replace it with:
```
// On masque le champ user_id et on le remplit automatiquement
    Forms\Components\Hidden::make('user_id')
     ->default(auth()->user()->id),
//On fait en sorte que le champ category_id soit un select mais on affiche le nom pour le choix
    Forms\Components\Select::make('category_id')
    ->relationship('categories', 'name') // dans la relation, on reprend le nom de la méthode donnée dans le modèle Articles.php et dans le select, on affiche le nom de la catégorie
    ->searchable() // on peut rechercher dans le select
    ->preload() // on charge toutes les catégories
    ->required(),
```
I’ve hidden the user_id field in the form but kept the user information (useful because we’ll need it when displaying the article in our blog).
I’ve added a Select form, using the category relationship, and chosen to display the name.

Let’s try adding some categories (for exemple : fruits and vegetables) an somes articles now!
IT WORKS! Great!

Okay, that’s fun, but we only have our admin section. I want to see this data in a blog!
Alright, let's make that happen.

![Description du GIF](https://www.imadeus.be/others/GithubGif/go.gif)

## Laravel - Retrieving Data from Filament and the Database
Now we're going to build our blog for articles! Exciting!

First, create a home.blade.php file in the following folder: resources/views (remember, this is part of the MVC pattern). Add the following code:
```
<x-layout>
<h1>Hello from the Home Page</h1>
</x-layout>
```
In the next step, we'll build the layout components. These components will be rendered by Laravel using the following syntax: x-layout - /x-layout.

To display this file from the root of the project, go to routes/web.php and replace the following code:
```
Route::get('/', function () {
    return view('welcome');
});
```
with :
```
Route::get('/', function () {
    return view('home');
});
```
This tells Laravel to load the home.blade.php file when navigating to the root path.

Next, create a layout.blade.php file in the following folder: resources/views/components, 
Add the following code (or run ! in vscode)
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
```
Go to this Tailwind URL link :
https://tailwindui.com/components/application-ui/application-shells/stacked,
copy the first HTML code and paste it in your layout.blade.php file between the body tags.

Some adjustments are needed in the code. In the head section, add this line under the meta tag:
```
<script src="https://cdn.tailwindcss.com/"></script>
```
Now, navigate to your website (not the admin zone, but the regular URL of your project) and refresh the page.

For this tutorial, we will not correct the profile menu and profile links, so you can comments the following lines.
Comment the following lines :
```
<div class="mt-3 space-y-1 px-2">
    <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Your Profile</a>
    <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Settings</a>
    <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Sign out</a>
</div>
```

Next, let’s modify the top menu. Find the following lines:
```
<a href="#" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Dashboard</a>
<a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Team</a>
<a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Projects</a>
<a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Calendar</a>
<a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Reports</a>
```
And replace them with :
```
<a href="/" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Dashboard</a>
<a href="/articles" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Articles</a>
<a href="/categories" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Catégories</a>
```
As you can see, we've created three menu links: Dashboard, Articles, and Categories.

(If you want to edit the mobile menu,  you can do the same with the mobile link (further down in the code).

Now, at the end of the file, find the following lines:
```
<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <!-- Your content -->
</div>
```
And replace them with:
```
<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    {{ $slot }}
</div>
```
The $slot will display the content of home.blade.php when you click on the Dashboard link, articles.blade.php when you click on the Articles link (which we are going to create), and categories.blade.php when you click on the Categories link (which we are also going to create).

In the resources/views folder, create a file named articles.blade.php and add the following code:
```
<x-layout>
    <x-slot:heading>
        Article Page
    </x-slot:heading>
    <h1 class="text-xl font-semibold mb-10">Voici la liste de tous les articles</h1>
    <ul class="text-2xl font-bold mb-6">
        @foreach ($articles as $article)
        <li class="border p-6 rounded-lg shadow-md mb-4">
            <h2 class="text-xl font-semibold mb-4">{{ $article->title }}</h2>
            <p class="text-base text-gray-700 mb-6">Catégorie :
                <a href="{{ route('categories.show', ['category' => $article->categories->id]) }}">
                    {{ $article->categories->name }}
                </a>
            </p>
            <p class="text-base text-gray-700 mb-6">{{ $article->content }}</p>
            <div class="flex justify-end text-sm text-gray-500">
                <span>Rédacteur : {{ $article->user->name }}</span>
                <spanc class="ml-4">Posté le : {{ $article->created_at->format('d M Y') }}</span>
                <span class="ml-4">Edité le : {{ $article->updated_at->format('d M Y') }}</span>
            </div>
        </li>
        @endforeach
    </ul>
    {{ $articles->links() }}
</x-layout>
```
This file lists all the articles with their categories, the user who created the article, and the creation and edit dates.

Next, we need to create the route. Open routes/web.php and add: 
```
Route::get('/articles', [ArticlesController::class, 'showAllArticles']);
```
This creates a controller with a showAllArticles function.

Also, in the routes/web.php file, add the following line at the top (under use Illuminate\Support\Facades\Route;):
```
use App\Http\Controllers\ArticlesController;
```

We will create the controller : 
Open the terminal and run :
```
php artisan make:controller ArticlesController
```
In VSCode, navigate to app/Http/Controllers/ArticlesController.php and replace the code with:
```
<?php

namespace App\Http\Controllers;

use App\Models\Articles;

class ArticlesController extends Controller
{
    public function showAllArticles()
    {
        return view('articles', [
            'articles' => articles::latest()->paginate(3)
        ]);
    }
}
```
This function lists all the articles with pagination, displaying three articles per page (with the most recent first).

You may have noticed the following line in articles.blade.php: a href="{{ route('categories.show', ['category' => $article->categories->id]) }}"

This link will display articles by category.

Let’s create the route for that link. (The function is already ready in the controller: public function showByCategory($category)).

Open routes/web.php and add: 
```
Route::get('/categories/{category}', [ArticlesController::class, 'showByCategory'])->name('categories.show');
```

In app/Http/Controllers/ArticlesController.php, add the following function:
```
public function showByCategory($category)
    {
        return view('articles', [
            'articles' => articles::where('category_id', $category)->latest()->paginate(3)
        ]);
    }
```
This function lists the articles by the selected category. When you click on the link, you'll see articles from that specific category.

We're almost done! Keep up the great work!

In the resources/views folder, create a file named categories.blade.php with the following code:
```
<x-layout>
    <x-slot:heading>
        Categories Page
    </x-slot:heading>
    <h1 class="text-xl font-semibold mb-10">Voici la liste de tous les catégories</h1>
    <ul class="text-2xl font-bold mb-6">
        @foreach ($categories as $category)
        <li class="border p-6 rounded-lg shadow-md mb-4">
            <h2 class="text-xl font-semibold mb-4">{{ $category->name }}</h2>
            <div class="flex justify-end text-sm text-gray-500">
                <span>Posté le : {{ $category->created_at->format('d M Y') }}</span>
                <span class="ml-4">Edité le : {{ $category->updated_at->format('d M Y') }}</span>
            </div>
        </li>
        @endforeach
    </ul>
    {{ $categories->links() }}
</x-layout>
```
Open routes/web.php and add the route:
```
Route::get('/categories', [CategoriesController::class, 'showAllcategories']);
```
And also the link the controller (at the top of web.php, under :
use App\Http\Controllers\ArticlesController;
```
use App\Http\Controllers\CategoriesController;
```
Then create the controller by running:
```
php artisan make:controller CategoriesController
```

Navigate to app/Http/Controllers/CategoriesController.php and replace the code with:
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;

class CategoriesController extends Controller
{
    public function showAllCategories()
    {
        return view('categories', [
            'categories' => Categories::latest()->paginate(5)
        ]);
    }
}
```
Your blog is now up and running! Keep pushing forward, and continue learning and improving your Laravel skills. You're doing great!
```
php artisan serve
```
And see the result ! Great Job ! 

![Description du GIF](https://www.imadeus.be/others/GithubGif/welldone.gif)

## Want to go further ? 
Felicitations having following the tutorial till here.

Return to your admin zone.

Another great tool of Filament are charts ! So, lets dive :

## Widget installation
To get started with creating widgets in Filament, open your terminal and run the following command:
```
php artisan make:filament-widget StatsCategoriesOverview --stats-overview
```
When prompted with the question, "What is the resource you would like to create this in?", simply press Enter to continue.

Next, you'll be asked to choose an admin zone. For now, select admin. (Keep in mind that Filament allows you to create multiple admin zones, and you can choose where to create your chart in the future.)

Now, navigate to app/Filament/Widgets/StatsCategoriesOverview.php and replace the existing code with the following:
```
<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Categories;

class StatsCategoriesOverview extends BaseWidget
{

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Categories', Categories::query()->count())
                ->description('Toutes les catégories')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];

    }
}
```
Once you've updated the code, refresh your admin dashboard. Do you see the graph? Excellent! You've successfully created your first widget. However, notice that the chart (graph) you've created isn't yet linked to real database data.

To generate chart data from an Eloquent (Laravel database connection) model, Filament recommends installing an additional package. Let's go ahead and do that.

Open your terminal and run:
```
composer require flowframe/laravel-trend
```
After the installation is complete, let's create a chart using the Articles model.

In the terminal, run the following command:
```
php artisan make:filament-widget ArticlesAdminChart --chart
````
When prompted : What is the resource you would like to create this in? Press enter.
Then, choose admin and then select 0 for the chart type.

Next, open app/Filament/Widgets/ArticlesAdminChart.php and replace the code with the following:
```
<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Articles;

class ArticlesAdminChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Articles Graphique';

    protected function getData(): array
    {
       {
        $data = Trend::model(Articles::class)
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perDay()
        ->count();
 
    return [
        'datasets' => [
            [
                'label' => 'Articles',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    }
    protected function getType(): string
    {
        return 'bar';
    }
}
```

Now, return to your website and check out the result under the menu Dashboard. Do you see your bar chart? Fantastic!

You’ve successfully linked your chart to the database and displayed dynamic data.

Feel free to explore the Filament documentation for more features. In Filament, you can create departments, multiple admin zones, and much more. Keep experimenting and building!

If you want the project with the profile menu working:
- you can copy the resources/views/components/layout.blade.php file from this repositiry and replace your code.
- you can copy the app/Http/Controllers/Auth/AuthenticatedSessionController.php and replace your code.
