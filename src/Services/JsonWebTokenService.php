<?php

namespace VeseluyRodjer\JsonWebToken\Services;

class JsonWebTokenService
{
    const ALG = 'sha256';
    const TYPE_TOKEN = 'JWT';

    public function createToken(array $data): string
    {
        $header = json_encode(['alg' => self::ALG, 'type' => self::TYPE_TOKEN]);
        $payload = json_encode($data['payload']);
        $unsignedToken = $this->base64UrlEncode($header) . '.' . $this->base64UrlEncode($payload);
        $signature = hash_hmac(self::ALG, $unsignedToken, $data['secret']);

        return $unsignedToken . '.' . $this->base64UrlEncode($signature);
    }

    public function base64UrlEncode(string $data): bool|string
    {
        $b64 = base64_encode($data);

        if ($b64 === false) {
            return false;
        }

        $url = strtr($b64, '+/', '-_');

        return rtrim($url, '=');
    }

    public function base64UrlDecode(string $data, bool $strict = false): string
    {
        $b64 = strtr($data, '-_', '+/');

        return base64_decode($b64, $strict);
    }

    public function getDataFromToken(string $token, string $secret): bool|array
    {
        $array = explode('.', $token);
        $signature = $this->base64UrlDecode($array[2]);

        $unsignedToken = $array[0] . '.' . $array[1];
        if ($signature === hash_hmac(self::ALG, $unsignedToken, $secret)) {
            return json_decode($this->base64UrlDecode($array[1]), true);
        }

        return false;
    }
}
