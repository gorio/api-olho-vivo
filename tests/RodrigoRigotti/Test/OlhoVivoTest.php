<?php

namespace RodrigoRigotti\Test;

use RodrigoRigotti\Api\OlhoVivo;

class OlhoVivoTest extends \PHPUnit_Framework_TestCase
{
    /** @var OlhoVivo $olhoVivo */
    private static $olhoVivo;
    
    public function __construct()
    {
        if (!$token = getenv('OLHOVIVO_API_TOKEN')) {
            throw new \Exception("Olho Vivo API token not set.");
        }
        self::$olhoVivo = new OlhoVivo($token);
    }
    
    public function testGetLinhas()
    {
        $linhas = self::$olhoVivo->getLinhas("brigadeiro");
    }
}
