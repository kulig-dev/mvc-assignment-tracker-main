# Assignment and Course Tracking Application

This is a `README.md` file for a PHP-based task and course tracking application. This application uses the MVC (Model-View-Controller) pattern to handle database operations and CRUD (Create, Read, Update, Delete) operations on courses and assignments.


## Table of Contents

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation](#installation)
- [Project Structure](#project-structure)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Author](#author)
- [Acknowledgements](#acknowledgements)


## Introduction

I decided to modify and expand the project described in the tutorial in the following ways:

- Restructured the project by organizing controllers into a separate `controllers` folder.
- Implemented routing to change the way controllers are invoked within the application.
- Kept the original database structure and list of actions.
- Made these modifications to gain a deeper understanding of the MVC pattern and the development of larger PHP applications.

I hope that these enhancements will positively impact my PHP learning journey and help me master not only the fundamentals but also more complex programming challenges.


## Requirements

- PHP 7.0 or higher
- Web server (e.g., Apache, Nginx) with PHP support
- MySQL database


## Installation

1. Clone the repository to your server:

```bash
   git clone <https://github.com/kulig-dev/mvc-assignment-tracker-main.git> assignment-tracker
   cd assignment-tracker
```

2. Create database `assignment_tracker` and configure database access by editing the config_db.php file and setting your database credentials:

```php
    <?php
    /**
     * Database configuration settings.
     *
     * @var string $host Hostname of the database server.
     * @var string $dbname Name of the database.
     * @var string $dbUser Database username.
     * @var string $dbPass Database password.
     */

    $dbHost = 'localhost';
    $dbName = 'assignment_tracker';
    $dbUser = 'your_db_username';
    $dbPass = 'your_db_password';

try {
    /**
     * Create a new PDO instance for database connection.
     *
     * @var PDO $db Database connection instance.
     */
    $db = new PDO("mysql:host=$host;dbname=$dbname", $dbUser, $dbPass);
    
    /**
     * Set PDO error mode to exception for better error handling.
     */
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    /**
     * Handle database connection error and display an error message.
     */
    echo "Database connection error: " . $e->getMessage();
    die();
}
?>

```

3. Run the setup.php script to create the necessary tables in the database:

```bash
    php setup_db.php
```


## Project Structure

```markdown
- `app/`: The main directory for your application.

  - `config/`: Contains configuration files, including `config_db.php` for database credentials.

  - `src/`: This is where your source code resides.
    - `controllers/`: Controllers handling user requests.
    - `models/`: Models representing the data structure and business logic.
    - `scss/`: Stylesheets for your application.
    - `views/`: Views responsible for presenting data to users.

- `public_html/`: The directory accessible to the public web server.
  - `assets/`: Holds public assets like CSS, JavaScript, and images.
```


## Usage

To use the application, follow these steps:

1. Open a web browser and navigate to your server's address where the application is installed.
2. You can browse the list of courses and assignments.
3. To add a new course, click the corresponding option and enter the course name.
4. To edit a course, click on the course name and update the details.
5. To delete a course, click on the course name and select the delete option.
6. To add a new assignment to a course, go to the course's assignment list and add a new assignment.
7. To edit an assignment, click on the assignment name and update the description.
8. To delete an assignment, click on the assignment name and select the delete option.


## Contributing

We welcome contributions from the community. If you'd like to contribute to this project, please follow these guidelines:

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Make your changes and commit them with clear and concise commit messages.
4. Push your changes to your fork.
5. Submit a pull request to the main repository.


## License

This project is licensed under the MIT License.


## Author

Robert Kulig


## Acknowledgements

To write this project, I used the tutorial "Create a PHP Application | PHP MVC Project Tutorial". 
This tutorial is available on the website (https://www.youtube.com/watch?v=Rkg731t47dc&t=2456s).
The tutorial was incredibly helpful as it provided explanations and tips on implementing functionality and using the MVC pattern.

Thanks to this tutorial, I was able to understand and implement task and course tracking features in my application.
Many thanks for Dave Gray.