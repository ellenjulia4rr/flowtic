<?php

namespace App\Entity\Trait;

use App\Constants\SerializerGroups;
use JMS\Serializer\Expression\ExpressionEvaluator;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

trait ToArrayTrait
{
    protected array $extraFields = array();

    public function addExtraFields(string $property, mixed $data): self
    {
        $this->extraFields[$property] = $data;
        return $this;
    }

    public static function builder(): Serializer
    {
        return SerializerBuilder::create()
            ->setPropertyNamingStrategy(
                new SerializedNameAnnotationStrategy(
                    new IdenticalPropertyNamingStrategy()
                )
            )
            ->setExpressionEvaluator(new ExpressionEvaluator(new ExpressionLanguage()))
            ->build();
    }

    public function toArray(array|null $serializerGroups = [SerializerGroups::DEFAULT, SerializerGroups::ID]): array
    {
        $serializerGroups ??= [SerializerGroups::DEFAULT, SerializerGroups::ID];
        $context = SerializationContext::create()
            ->enableMaxDepthChecks()
            ->setGroups($serializerGroups)
        ;

        return array(
            ...self::builder()->toArray($this, $context),
            ...$this->extraFields
        );
    }
}