# Delivery Shop - Online delivery store

Web application for an online store with a delivery system, written in PHP using MySQL.

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer (for dependency management)

## Installation

1. Clone the repository:
bash
git clone https://github.com/your-username/delivery-shop.git
cd delivery-shop
2. Create a database and import the structure:bash
mysql -u root -p
CREATE DATABASE delivery_shop;
exit;
mysql -u root -p delivery_shop < database.sql

3. Create a database and import the structure:
4. Configure the database connection:
- Copy `config/database.example.php` to `config/database.php`
- Edit the connection parameters in `config/database.php`

5. Configure access rights:bash
chmod 755 -R ./
chmod 777 -R ./uploads
Project structure
delivery-shop/
│
├── admin/ # Admin panel
├── assets/ # Static files (CSS, JS, images)
├── config/ # Configuration files
├── includes/ # Common include files
├── uploads/ # Uploadable files
└── database.sql # Database structure
## Main functions

- User registration and authorization
- Product catalog with filtering and search
- Shopping cart
- Order processing
- User personal account
- Administrative panel:
- Product management
- Category management
- Order management
- User management

## Administrative panel

Access to the admin panel: `/admin`

Default login data:
- Login: admin
- Password: admin123

It is recommended to change the password after the first login.

## Database

Main tables:
- users - users
- products - products
- categories - categories
- orders - orders
- order_items - order items

## Security

1. Set up folder permissions:bash
chmod 755 ./
chmod 644 ./.php
chmod 777 ./uploads
2. Protect configuration files:apache
3. Restrict file uploads to uploads/:apache

## Development

### Styles
- `assets/css/style.css` - main styles
- `assets/css/admin.css` - admin panel styles
- `assets/css/auth.css` - authorization form styles
- `assets/css/catalog.css` - catalog styles

### JavaScript
- `assets/js/catalog.js` - catalog functionality
- `assets/js/cart.js` - cart functionality

## License

MIT License. See the LICENSE file for details.

## Support

If you have any problems, create an issue in the project repository or contact the developers:
- Email: support@example.com
- Telegram: @delivery_shop_support

## Authors

- Ivan Ivanov - Lead Developer
- Petr Petrov - Designer

## Contribution to the project

1. Fork the project
2. Create a branch for the new feature
3. Send a pull request

## Changelog

### Version 1.0.0 (2024-03-20)
- First release
- Main store functionality
- Administrative panel
