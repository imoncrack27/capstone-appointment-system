<?php



namespace EA\Engine\Api\V1\Parsers;

/**
 * Parsers Interface
 *
 * Every parser needs the "encode" and "decode" methods.
 *
 * @deprecated
 */
interface ParsersInterface {
    /**
     * Encode Response Array
     *
     * @param array &$response The response to be encoded.
     */
    public function encode(array &$response);

    /**
     * Decode Request
     *
     * @param array &$request The request to be decoded.
     * @param array $base Optional (null), if provided it will be used as a base array.
     */
    public function decode(array &$request, array $base = NULL);
}
