NexusCore: Healthcare Data Management System
An Architectural Showcase of Scalable PHP Design Patterns

NexusCore is a patient management backend designed with a focus on the Separation of Concerns (SoC). Unlike monolithic or procedural PHP applications, NexusCore utilizes a decoupled architecture to ensure that the business logic, data modeling, and database persistence layers remain independent.

 Architectural Overview
The project is structured around the Repository Pattern, which acts as a mediator between the domain and data mapping layers.

Key Components:
Data Transfer Objects (DTOs): Uses a formal Patient Model to ensure type safety and consistent data structures throughout the application.

Repository Pattern: All SQL logic is encapsulated within PatientRepository.php. This allows the application to remain agnostic of the underlying database technology.

Dependency Injection: The PDO database connection is injected into the repository, facilitating easier unit testing and better resource management.

Defensive Programming: Implements robust error handling and existence checks to ensure system stability during database failures.

 Technology Stack
Backend: PHP 8.0 (utilizing strict typing and namespaces)

Database: MySQL / MariaDB via PDO

Environment: XAMPP / Windows Development Stack

Standards: PSR-4 Autoloading compliant

 Directory Structure
Plaintext
NexusCore/
├── config/          # Database configuration and environment settings
├── public/          # Application entry point (Document Root)
└── src/
    ├── Models/      # Domain entities (Data Transfer Objects)
    └── Repositories/ # Data access logic (SQL encapsulation)
 Getting Started
Database Setup: Import the provided SQL schema in phpMyAdmin to create the nexus_core database.

Configuration: Update config/database.php with your local database credentials.

Deployment: Point your Apache server to the public/ directory or access via localhost/NexusCore/public/.

Why This Approach?
By moving database queries out of the view files and into a dedicated Repository, the code becomes:

Testable: We can mock the repository to test logic without a database.

Maintainable: If the table schema changes, we only update one file (the Repository), not every page in the app.

Secure: Centralized use of PDO prepared statements significantly reduces the risk of SQL injection.