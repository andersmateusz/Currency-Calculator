<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

use App\Validator\ValidKey;
class ApiKey
{
    protected $apiKey;
    public function getApiKey():string
    {
        return $this->apiKey;
    }
    public function setApiKey($apiKey):void
    {
        $this->apiKey = $apiKey;
    }
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('apiKey', new NotBlank());
        $metadata->addPropertyConstraint('apiKey', new ValidKey());
    }
}

?>