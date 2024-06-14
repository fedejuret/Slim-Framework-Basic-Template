# Slim API Project

This project is a basic skeleton for developing an API using the Slim microframework. It provides an initial structure with essential features to start building your API quickly and efficiently.

## Key Features

- **Attribute-defined routes**: Utilizes attribute definition to specify routes and associated controllers in a clear and concise manner.
- **Attribute-defined middlewares**: Supports the use of middlewares with attributes to apply middleware logic to routes.
- **Database connection**: Configuration for connecting to MySQL databases using Eloquent ORM.
- **Custom error handling**: Implements a custom error handler to respond with appropriate status codes and messages.
- **Environment configuration with dotenv**: Uses the Dotenv package to load environment variables from a .env file.
- **MIT License**: This project is distributed under the MIT License, meaning you can use and modify it as per your needs, even for commercial projects.

## Prerequisites

- PHP >= 8.2
- Composer

## Installation

1. Clone this repository on your local machine:

    ```bash
    git clone https://github.com/fedejuret/Slim-Framework-Basic-Template.git
    ```

2. Install project dependencies using Composer:

    ```bash
    cd slim-api-project
    composer install
    ```

3. Copy the `.env.example` file and rename it to `.env`, then configure the environment variables according to your development environment:

    ```bash
    cp .env.example .env
    ```

4. Configure your database in the `.env` file:

    ```dotenv
    DATABASE_DRIVER=mysql
    DATABASE_HOST=172.19.0.1
    DATABASE_USERNAME=root
    DATABASE_PASSWORD=secret
    DATABASE_NAME=hotelco0_motor
    ```

5. You're all set! Now you can run the development server:

    ```bash
    php -S localhost:8000 -t public
    ```

## Usage

- Visit `http://localhost:8000` in your browser to see the home page.
- All routes, controllers, and middlewares are defined using attributes. Check the files in the `app/Controller` directory for examples.
- Eloquent models are located in the `app/Model` directory.
- You can add new routes, controllers, and middlewares as needed for your application.

## Contact

If you have any questions or suggestions about this project, feel free to get in touch:

- Email: fedejuret@gmail.com

## License

This project is distributed under the [MIT License](LICENSE).
