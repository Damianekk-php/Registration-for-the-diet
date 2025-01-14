# Diet Registration Application

This application is designed to help users register and manage their dietary preferences and information efficiently. It provides a wide range of features to personalize and streamline the user experience.

## Key Features
- **Allergy Selection**: Users can select allergens to avoid in their dietary plan.
- **Account Management**: Users can update their email address and password with ease.
- **Body Measurements**: Users can input and track their current body measurements.
- **Family Management**: Add family members to the diet plan and view detailed information about them.
- **Physical Activity**: Choose and adjust levels of physical activity to tailor dietary recommendations.
- **Custom Backgrounds**: Upload custom backgrounds for a personalized application interface.
- **Styling Templates**: Select from various style templates to customize the application's appearance.
- **Language Support**: The application uses the `transition` function to dynamically change the application's language based on the user's region.
- **AJAX Functionality**: The application leverages AJAX for seamless, real-time updates without requiring page reloads.
- **Chart Visualization**: Includes interactive pie charts built with JavaScript for visualizing dietary and activity data.
- **PDF Generation**: Create PDF reports with detailed dietary and user information.

## Technologies Used

### Core Dependencies
- **PHP**: `^8.2` - A robust server-side scripting language.
- **Laravel Framework**: `^11.31` - A PHP framework known for its elegant syntax and comprehensive tools for web application development.
- **Barryvdh Laravel DomPDF**: `^3.0` - Simplifies creating PDF documents directly from Blade views.
- **Laravel Tinker**: `^2.9` - A powerful REPL for real-time interaction with the application.
- **Laravel UI**: `^4.6` - Provides front-end scaffolding for user authentication and more.

### Development Dependencies
- **FakerPHP/Faker**: `^1.23` - A PHP library for generating fake data during testing.
- **Laravel Pail**: `^1.1` - A package to manage and organize bucket-based storage solutions.
- **Laravel Pint**: `^1.13` - A zero-configuration PHP code style fixer tailored for Laravel projects.
- **Laravel Sail**: `^1.26` - A lightweight Docker development environment for Laravel.
- **Mockery**: `^1.6` - A flexible PHP mock object framework for testing.
- **Nuno Maduro Collision**: `^8.1` - A tool providing detailed and intuitive error reporting for PHP console applications.
- **PHPUnit**: `^11.0.1` - A unit testing framework for ensuring application reliability.

### Why These Technologies?
This project is built using Laravel's rich ecosystem to provide a seamless development workflow and a reliable, scalable application architecture. The additional tools and libraries further enhance the development process, enabling faster delivery of features with high-quality standards.

## Getting Started
1. Clone the repository to your local machine.
2. Run `composer install` to install dependencies.
3. Set up your `.env` file for environment configuration.
4. Run `php artisan migrate` to set up the database schema.
5. Use `php artisan serve` to start the development server.
