<?php


namespace App\Values\Http;


use App\Values\Code;



/**
 *
 * HTTP TokenType 클래스
 * Class TokenType
 * @package App\Values\Http
 */
class TokenType extends Code
{
    /** @var string 사용자 아이디와 암호를 Base64로 인코딩한 값을 토큰으로 사용한다. (RFC 7617) */
    const BASIC = 'basic';
    /** @var string JWT 혹은 OAuth에 대한 토큰을 사용한다. (RFC 6750) */
    const BEARER = 'bearer';
    /** @var string 서버에서 난수 데이터 문자열을 클라이언트에 보낸다. 클라이언트는 사용자 정보와 nonce를 포함하는 해시값을 사용하여 응답한다 (RFC 7616) */
    const DIGEST = 'digest';
    /** @var string 전자 서명 기반 인증 (RFC 7486) */
    const HOBA = 'hoba';
    /** @var string 암호를 이용한 클라이언트-서버 상호 인증 (draft-ietf-httpauth-mutual) */
    const MUTUAL = 'mutual';
    /** @var string AWS 전자 서명 기반 인증 */
    const AWS4_HMAC_SHA256 = 'aws4-hmac-sha256';

    /** @var string[] 유효한 코드 목록 */
    const CODES = [self::BASIC, self::BEARER, self::DIGEST, self::HOBA, self::MUTUAL, self::AWS4_HMAC_SHA256,];

    /**
     * @inheritdoc
     * @return array
     */
    public static function getCodes(): array
    {
        return static::CODES;
    }
}