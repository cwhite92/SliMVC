SliMVC
======

A lightweight and fast PHP framework which was developed to learn about how a MVC application works and as a fun project.

A quick and dirty explanation
-------------

MVC stands for Model, View and Controller. It is a proven and widely used software design pattern that makes it easy to seperate the presentation logic from the business logic.

When a user requests a page, the "dispatcher" (the `run()` method in `app.php`) matches their request to a route (defined in `routes.php`). If a route matches, it loads the corresponding controller. The controller is where you handle the users request. You may simply print something to the page, or you may get data from your database and do something with it before showing it to your user.

Models are what interacts with your database. You define and use methods in your model to get data from your database or add data. Models are used from your controller like this:

    $this->loadModel('Users');
    $users = $this->models['Users']->getAllUsers();

In this example, the `getAllUsers()` method in the `Users` model returns all the users in the database and assigns them to `$users`, which we will use in a bit. The `getAllUsers()` method looks like this:

    public function getAllUsers() {
        $this->st = $this->db->query('SELECT name FROM users');
        $this->st->setFetchMode(PDO::FETCH_OBJ);
        $users = array();
        while($row = $this->st->fetch()) {
            array_push($users, $row->name);
        }

        return $users;
    }

Pretty simple. We're getting all of our users, adding them into an array and then returning that array.

Now, views. Views are just your presentation code. Be it HTML, JSON, XML, it doesn't matter. Views are what your end user will see when they request a page. It's usually a good idea to seperate your views into a header, the content for that particular page, and a footer. This reduces code duplication because your header and footer will usually be the same around your entire site. Views are stored in the `views` directory and named with a `.html` extension, you then load them by using their filename without the `.html` extension. You can also pass variables to a view in order to show dynamic content to your user. Once again, they're used from within your controller like this:

    $data = array(
                  'title' => 'SliMVC - lightweight PHP MVC framework',
                  'users' => $users // Remember our $users variable?
                 );
    $this->loadView('header', $data);
    $this->loadView('home', $data);
    $this->loadView('footer', $data);

The `$data` array is where you put all the variables that you want to be passed to your view. They're passed in an array format and the framework automatically makes them into their own variables, which in this case would be `$title` and `$users`. Then, in the `home.html` view file:

    <h1>Users list</h1>
    <ul>
        <?php foreach($users as $user): ?>
            <li><?php echo $user; ?></li>
        <?php endforeach; ?>
    </ul>

The nice thing about views in SliMVC is that you can use PHP code within them. Like here, I'm looping through all the users in the `$users` array (which came from our model, remember) and printing them to the page in a list.

Okay, maybe not such a quick explanation, but that's pretty much it. It may seem daunting right now but once you've used it for a while you'll wonder why everything else can't be this simple.

Cheers!