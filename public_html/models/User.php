<?php

require_once __DIR__ . '/DB.php';

class User {
    public int $id;
    public int $role_id;
    public ?int $company_id;
    public string $email;
    public string $password_hash;
    public ?string $first_name;
    public ?string $last_name;
    public bool $is_active;
    public string $created_at;
    public string $updated_at;

    private array $role_map = [];

    /**
     * Finds a user by their email address.
     *
     * @param string $email The email address to search for.
     * @return self|null A User object if found, otherwise null.
     */
    public static function findByEmail(string $email): ?self {
        $pdo = DB::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $data = $stmt->fetch();

        if ($data) {
            $user = new self();
            $user->id = $data['id'];
            $user->role_id = $data['role_id'];
            $user->company_id = $data['company_id'];
            $user->email = $data['email'];
            $user->password_hash = $data['password_hash'];
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->is_active = (bool)$data['is_active'];
            $user->created_at = $data['created_at'];
            $user->updated_at = $data['updated_at'];
            return $user;
        }

        return null;
    }

    /**
     * Verifies the user's password.
     *
     * @param string $password The plain-text password to verify.
     * @return bool True if the password is correct, false otherwise.
     */
    public function verifyPassword(string $password): bool {
        return password_verify($password, $this->password_hash);
    }

    /**
     * Gets the role name of the user (e.g., 'Super Admin').
     * Caches the roles to avoid repeated DB queries.
     *
     * @return string The user's role name.
     */
    public function getRoleName(): string {
        if (empty($this->role_map)) {
            $pdo = DB::getInstance();
            $stmt = $pdo->query("SELECT id, role_name FROM roles");
            $roles = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            $this->role_map = $roles;
        }

        return $this->role_map[$this->role_id] ?? 'Unknown';
    }
}
