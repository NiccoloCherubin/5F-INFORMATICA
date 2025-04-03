<?php
include_once 'Log.php';

class Database
{
    private static ?PDO $PDO = null;
    private static bool $connectionFailed = false;

    public static function connect(): ?PDO
    {
        if (self::$PDO !== null) {
            return self::$PDO;
        }

        $config = [
            'driver' => 'mysql',
            'host' => 'localhost',
            'dbname' => 'ecommerce',
            'user' => 'root',  // Cambia se hai un altro utente
            'password' => ''   // Cambia se hai una password diversa
        ];

        try {
            self::$PDO = new PDO(
                "$config[driver]:host=$config[host];dbname=$config[dbname]",
                $config['user'],
                $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]);
        } catch (PDOException $e) {
            self::$connectionFailed = true;
            Log::errlog($e, 'log/database.log');
            die("Errore di connessione al database: " . $e->getMessage());
        }

        return self::$PDO;
    }

    public static function select(string $query, array $bind = []): array
    {
        if (self::$PDO === null) {
            throw new Exception('Database connection is null');
        }
        $stm = self::$PDO->prepare($query);
        foreach ($bind as $key => $value) {
            $stm->bindValue($key, $value);
        }
        $stm->execute();
        return $stm->fetchAll();
    }
}

// Instanzia la connessione subito
Database::connect();
