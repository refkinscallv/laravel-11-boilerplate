<?php

namespace App\Utils;

use Firebase\JWT\JWT as PHPJWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;
use Exception;

class JWT
{
    protected static bool $initialized = false;
    protected static string $algo;
    protected static string $secret;
    protected static int $ttl;

    public static function init(): void
    {
        self::$algo = env('JWT_ALGO', 'HS256');
        self::$secret = env('JWT_SECRET', 'jwtDefaultSecretKey');
        self::$ttl = (int) env('JWT_TTL', 3600);
        self::$initialized = true;
    }

    protected static function ensureInit(): void
    {
        if (!self::$initialized) {
            self::init();
        }
    }

    public static function generate(array $payload = [], int $ttl = 0): mixed
    {
        try {
            self::ensureInit();

            $ttl = $ttl > 0 ? $ttl : self::$ttl;
            $issuedAt = time();
            $expireAt = $issuedAt + $ttl;

            $payload = array_merge($payload, [
                'iat' => $issuedAt,
                'exp' => $expireAt,
            ]);

            return PHPJWT::encode($payload, self::$secret, self::$algo);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function verify(string $token): object
    {
        try {
            self::ensureInit();

            $decoded = self::decode($token);
            return (object) [
                'status' => true,
                'result' => $decoded,
            ];
        } catch (ExpiredException $e) {
            return (object) ['status' => false, 'result' => 'Token expired'];
        } catch (SignatureInvalidException $e) {
            return (object) ['status' => false, 'result' => 'Invalid signature'];
        } catch (BeforeValidException $e) {
            return (object) ['status' => false, 'result' => 'Token not yet valid'];
        } catch (Exception $e) {
            return (object) ['status' => false, 'result' => 'Invalid token'];
        }
    }

    public static function decode(string $token): array
    {
        self::ensureInit();

        return (array) PHPJWT::decode($token, new Key(self::$secret, self::$algo));
    }

    public static function encode(array $data): string
    {
        self::ensureInit();

        return PHPJWT::encode($data, self::$secret, self::$algo);
    }
}
