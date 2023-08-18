<!DOCTYPE html>
<html>

<head>
  My Laravel Application
</head>

<body>

<h1>My Laravel Application</h1>

<p>Welcome to My Laravel Application! This is a simple guide to get you started with installing and using the application.</p>

<h2>Prerequisites</h2>
<ul>
  <li>PHP >= 8.2</li>
  <li>Composer</li>
</ul>

<h2>Installation</h2>
<ol>
  <li>Clone the repository:
    <pre><code>git clone git@github.com:andreurbanski/visionnaire-test.git
cd visionnaire-test</code></pre>
  </li>
  <li>Install Dependencies:
    <pre><code>composer install</code></pre>
  </li>
  <li>Configure Environment:
    <pre><code>cp .env.example .env
php artisan key:generate</code></pre>
  </li>

  <li>Create a local file database:
  <pre><code>touch database/database.sqlite</code></pre>
  <li>Migrate and Seed Database:
    <pre><code>php artisan migrate
php artisan db:seed --class=DocumentSeeder</code></pre>
  </li>
  <li>Run Tests:
    <pre><code>php artisan test</code></pre>
  </li>
  <li>Start the Development Server:
    <pre><code>php artisan serve</code></pre>
    The application will be available at <a href="http://127.0.0.1:8000">http://127.0.0.1:8000</a>.
  </li>
</ol>

<h2>Using Postman Collection</h2>
<p>To interact with the system's endpoints, you can use the provided Postman collection. The collection includes predefined API requests that you can use for querying the application.</p>

<ol>
  <li>Import the Postman collection: <code>Test-Laravel.postman_collection.json</code>.</li>
  <li>Configure Postman environment variables as needed (base URL, authentication, etc.).</li>
  <li>Use the imported requests to test the different endpoints of the application.</li>
</ol>

<h2>Contributing</h2>
<p>Feel free to contribute by opening issues or submitting pull requests. Your contributions are greatly appreciated!</p>

<h2>License</h2>
<p>This project is licensed under the MIT License - see the <a href="LICENSE">LICENSE</a> file for details.</p>

</body>

</html>
