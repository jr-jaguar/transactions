# Transaction Commission Calculator

This is a simple PHP application that calculates transaction commissions based on predefined strategies and external data sources.

## Features

- **Commission Strategies**: Define commission calculation strategies based on transaction properties and conditions.
- **External Data Sources**: Retrieve currency exchange rates and country information from external APIs.
- **Flexible Configuration**: Easily configure commission strategies and external API endpoints.
- **Test Coverage**: Includes unit tests for core functionalities to ensure reliability.

## Requirements

- PHP 8.2 or higher
- Composer (for dependency management)

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/jr-jaguar/transactions.git
    ```

2. **Install dependencies using Composer:**

    ```bash
    composer install
    ```

## Configuration

1. Commission strategies can be configured in the `config/strategies.php` file. Add or remove strategies as needed.

2. External API endpoints and authentication keys can be configured in the respective provider classes located in the `Infrastructure` directory.

## Usage

1. Prepare a file containing transaction data in JSON format. Each line should represent a single transaction.

2. Run the application with the following command, specifying the input file:

    ```bash
    php public/index.php input.txt
    ```

   Replace `input.txt` with the path to your transaction data file.

