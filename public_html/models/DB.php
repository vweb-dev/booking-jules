<?php

class DB {
    private static ?PDO $instance = null;

    /**
     * The constructor is private to prevent direct creation of a new instance.
     */
    private function __construct() {
    }

    /**
     * The clone method is private to prevent cloning of an instance.
     */
    private function __clone() {
    }

    /**
     * The wakeup method is private to prevent unserializing of an instance.
     */
    public function __wakeup() {
    }

    /**
     * Gets the single instance of the DB class.
     *
     * @return PDO The PDO database connection instance.
     */
    public static function getInstance(): PDO {
        if (self::$instance === null) {
            // The config file is expected to be created by the /setup wizard.
            // If it doesn't exist, this will fail, which is the desired behavior
            // as the app should not run without being configured.
            $configPath = __DIR__ . '/../config/database.php';

            if (!file_exists($configPath)) {
                // In a real application, you might redirect to setup or show an error.
                // For now, we'll die with a message.
                die("Database configuration not found. Please run the setup wizard at /setup");
            }

            $config = require($configPath);

            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $config['user'], $config['pass'], $options);
            } catch (\PDOException $e) {
                // In a production environment, log this error instead of echoing it.
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$instance;
    }
}
