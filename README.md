# StreamlinePro: Empowering Organizational Efficiency

StreamlinePro is a comprehensive Laravel application designed to elevate organizational efficiency by integrating essential management functions into a single, user-friendly platform. With a focus on simplicity and effectiveness, StreamlinePro empowers businesses to streamline their operations and enhance productivity across various domains.

### Mission

Our mission is to write minimal effective code.

## Key Features:

1. **Support Tickets:** Seamlessly manage customer inquiries, issues, and support requests with our intuitive ticketing system.
2. **Company & Client Management:** Keep track of company details, client interactions, and key contacts all in one centralized location for enhanced relationship management.

3. **Task Management:** Efficiently assign, track, and prioritize tasks among team members to ensure timely completion of projects and goals.

4. **Personal Todo Management:** Enable individuals to organize their daily tasks and priorities, fostering personal productivity and accountability.

5. **Product Management:** Facilitate the management of products, including inventory tracking, pricing, and performance analysis, to optimize sales and profitability.

6. **Department Management:** Streamline internal communication and collaboration by organizing teams and departments within the application, promoting cohesion and coordination.

7. **Promotion Management:** Plan and execute promotional campaigns effectively, monitor their performance, and analyze their impact on business growth.

## Why StreamlinePro?

-   **Simplicity:** StreamlinePro offers a clean and intuitive interface, ensuring ease of use for both administrators and end-users.
-   **Customization:** Tailor the application to suit your organization's unique needs with customizable features and settings.
-   **Scalability:** Whether you're a small startup or a large enterprise, StreamlinePro scales effortlessly to accommodate your growing business requirements.
-   **Integration:** Seamlessly integrate StreamlinePro with existing tools and systems through robust APIs, enhancing interoperability and data exchange.

Experience the power of efficiency with StreamlinePro and take your organization to new heights of productivity and success.

## Instructions

To get started with StreamlinePro, follow these steps:

1.  Clone the repository using `git clone`
2.  Install the dependencies using `composer install` or `composer update`
3.  Copy .env.example to .env
4.  Configure the database settings in the `.env` file
5.  Run `php artisan key:generate` to generate a new application key
6.  Run `php artisan storage:link` to link your storage
7.  Run `php artisan migrate` to create the database tables
8.  Run `php artisan db:seed` to seed the database with some initial data
9.  Run `php artisan serve` to start the development server
10. Open your web browser and navigate to `http://localhost:8000` to access the
    application.

## Credentials Roles

Admin Routes are /backoffice/login

**Super Admin**

-   **Email:** superadmin@shaz3e.com
-   **Password:** 123456789

**Admin**

-   **Email:** admin@shaz3e.com
-   **Password:** 123456789

**Manager**

-   **Email:** manager@shaz3e.com
-   **Password:** 123456789

**Staff**

-   **Email:** staff@shaz3e.com
-   **Password:** 123456789

**Tester**

-   **Email:** tester@shaz3e.com
-   **Password:** 123456789

**Developer** (has special permissions to modify the permissions and applications settings)

-   **Email:** developer@shaz3e.com
-   **Password:** 123456789

## Extra configuration

-   Configure **SMTP** and **BACKUP SMTP** in your `.env` file
-   Updated **Notification Email** in **Settings** -> **General Setting** This email receive all activity in streamline pro
-   Run `php artisan schedule:run`
-   Run `php artisan queue:work`

## Todos

-   Middleware `/backoffice` to be redirected to `/backoffice/login` when user is unauthenticated
-   Implemente Email Builder Choices are **BeeFree**

## Contributing

Contributing in this repo are welcome please make sure to create pull requrest with single commit.

-   If you have any suggestions please let us know : https://github.com/Shaz3e/StreamlinePro/pulls.
-   Please help me improve code https://github.com/Shaz3e/StreamlinePro/pulls

#### License

SteamLine Pro built with Laravel is licensed under the MIT license. Enjoy!

## Credit

-   [Shaz3e](https://www.shaz3e.com)
-   [Team (dc) Diligent Creators](https://www.diligentcreators.com)

[YouTube](https://www.youtube.com/@shaz3e) | [Facebook](https://www.facebook.com/shaz3e) | [Twitter](https://twitter.com/shaz3e) | [Instagram](https://www.instagram.com/shaz3e) | [LinkedIn](https://www.linkedin.com/in/shaz3e/)
[Facebook](https://www.facebook.com/diligentcreators) | [Instagram](https://www.instagram.com/diligentcreators/) | [Twitter](https://twitter.com/diligentcreator) | [LinkedIn](https://www.linkedin.com/company/diligentcreators/) | [Pinterest](https://www.pinterest.com/DiligentCreators/) | [YouTube](https://www.youtube.com/@diligentcreator) [TikTok](https://www.tiktok.com/@diligentcreators) | [Google Map](https://g.page/diligentcreators)
