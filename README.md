# M-PESA Payment Integration

This project is a Laravel application that demonstrates how to integrate M-PESA payments into your web application using Laravel and the Safaricom M-PESA API.

## Features

- Initiate M-PESA payments from your web application.
- Handle M-PESA payment callbacks securely.
- Store payment details and transaction history.
- Simple and easy-to-use interface for users to make payments.

## Installation

1. Clone the repository to your local machine:


2. Install composer dependencies:


3. Copy the `.env.example` file to `.env` and configure your environment variables, including M-PESA API credentials and database settings.

4. Generate an application key:


5. Run database migrations to set up the required tables:


6. Serve the application:


## Usage

1. Access the application in your web browser by navigating to `http://localhost:8000`.
2. Fill in the amount and phone number fields in the provided form.
3. Click the "Pay with M-PESA" button to initiate the payment.
4. Monitor the application logs and callback handling to ensure payments are processed successfully.

## Contributing

Contributions are welcome! If you encounter any issues or have suggestions for improvements, please feel free to open an issue or submit a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
