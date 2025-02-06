# Palisis Technical Test
Author: Belén Ruiz Juárez


## Installation Guide

Follow these steps to set up and run the project using Docker:

### Prerequisites
- Ensure you have [Docker](https://www.docker.com/get-started) installed on your system.
- Obtain the correct environment credentials.

### Steps

1. **Clone the Repository**
   ```sh
   git clone https://github.com/Belen-Dev/tour-cms-test.git
   ```

2. **Set Up Environment Variables**
   - Rename `.env.test` to `.env`.
   - Update `.env` with the correct credentials.

3. **Build and Run the Docker Container**
   ```sh
    docker compose build && docker compose up
   ```

4. **Stopping the Application**
   ```sh
    docker-compose down
   ```
   ---




