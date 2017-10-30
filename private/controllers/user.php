<?php
class User
{
    private $user;

    public function __construct()
    {
        $this -> user = new TblUsers();
    }

    public function register($_params)
    {
        if ($this -> user -> get($_params['name'])) {
            return null;
        }

        $result = $this -> user -> insert($_params['name'], '123456', $_params['name'], '');

        return $result;
    }

    public function login($_params)
    {
        $userData = $this -> user -> authenticate($_params['username'], '123456');

        if ($userData != null) {
            if (Token::verify($userData['token'])) {
                $token = $userData['token'];
            } else {
                $token = Token::generate($userData['id'], LOGIN_TIMEOUT);
            }
        }

        if ($this -> user -> update(
            $userData['id'],
            ['token' => $token,
            'last_login' => NOW])
        ) {
            return ['token' => $token];
        }
    }

    public function logout($_token)
    {
        $userData = Token::parse($_token);
        $result = $this -> user -> update($userId['userId'], ['token' => null]);

        return $result;
    }

    public static function authorize()
    {
        http_response_code(BAD_REQUEST);

        $token = Validation::header(['Authorization'])['Authorization'];

        if (!$token) {
            return false;
        }
        if (!Token::verify($token)) {
            http_response_code(UNAUTHORIZED);

            return false;
        }

        return true;
    }
}
