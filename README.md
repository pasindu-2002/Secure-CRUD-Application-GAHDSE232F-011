# Secure CRUD Application

## Overview

The **Secure CRUD Application** is a web-based application designed to perform Create, Read, Update, and Delete (CRUD) operations securely. It emphasizes best practices in web security, ensuring safe data handling and user interactions.

## Features

- **User Authentication**: Secure login and registration with JWT (JSON Web Tokens).
- **Role-Based Access Control**: Different user roles with specific permissions.
- **Data Encryption**: Secure data storage and transmission using encryption techniques.
- **Session Management**: Secure handling of user sessions with cookie attributes.
- **Account Locking**: Protection against brute force attacks through account locking mechanisms.
- **Responsive Design**: User-friendly interface compatible with various devices.

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript, Bootstrap
- **Backend**: PHP, MySQL
- **Libraries**: PDO for database interactions, JWT for authentication
- **Tools**: Apache, WAMP Server, Composer for dependency management

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/secure-crud.git

2. Navigate to the project directory:
   ```bash
   cd secure-crud

3. Configure database connection:
     - **Update the database configuration in (config.php).

4. Set up the database:
     - Create a MySQL database and import the provided SQL file.

5. Set up the database:
     - Use WAMP or any local server to run the application.
  
## Usage

- Visit `http://localhost/secure-crud` in your web browser.
- Register a new account or log in with existing credentials.
- Perform CRUD operations on the available resources.

## Security Measures

- **Input Validation**: All user inputs are validated and sanitized.
- **Prepared Statements**: SQL queries are executed using prepared statements to prevent SQL injection.
- **Content Security Policy**: Implemented to mitigate XSS attacks.
- **HTTPS**: Ensure secure transmission of data over the network.


## Acknowledgments

- Thanks to [OWASP](https://owasp.org) for their comprehensive security guidelines.
- Special thanks to the open-source community for their support and resources.


  
## Links

- **GitHub Repository**: [Secure CRUD Application](https://github.com/pasindu-2002/Secure-CRUD-Application-GAHDSE232F-011)
- **Project Website**: [Secure CRUD Application Website](https://www.yourprojectwebsite.com)


