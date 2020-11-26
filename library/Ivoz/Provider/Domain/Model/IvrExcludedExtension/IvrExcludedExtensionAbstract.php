<?php
declare(strict_types = 1);

namespace Ivoz\Provider\Domain\Model\IvrExcludedExtension;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use \Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Ivr\IvrInterface;
use Ivoz\Provider\Domain\Model\Extension\ExtensionInterface;
use Ivoz\Provider\Domain\Model\Ivr\Ivr;
use Ivoz\Provider\Domain\Model\Extension\Extension;

/**
* IvrExcludedExtensionAbstract
* @codeCoverageIgnore
*/
abstract class IvrExcludedExtensionAbstract
{
    use ChangelogTrait;

    /**
     * @var IvrInterface
     * inversedBy excludedExtensions
     */
    protected $ivr;

    /**
     * @var ExtensionInterface
     */
    protected $extension;

    /**
     * Constructor
     */
    protected function __construct(

    ) {

    }

    abstract public function getId();

    public function __toString()
    {
        return sprintf(
            "%s#%s",
            "IvrExcludedExtension",
            $this->getId()
        );
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function sanitizeValues()
    {
    }

    /**
     * @param null $id
     * @return IvrExcludedExtensionDto
     */
    public static function createDto($id = null)
    {
        return new IvrExcludedExtensionDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param IvrExcludedExtensionInterface|null $entity
     * @param int $depth
     * @return IvrExcludedExtensionDto|null
     */
    public static function entityToDto(EntityInterface $entity = null, $depth = 0)
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, IvrExcludedExtensionInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        /** @var IvrExcludedExtensionDto $dto */
        $dto = $entity->toDto($depth-1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param IvrExcludedExtensionDto $dto
     * @return self
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, IvrExcludedExtensionDto::class);

        $self = new static(

        );

        $self
            ->setIvr($fkTransformer->transform($dto->getIvr()))
            ->setExtension($fkTransformer->transform($dto->getExtension()));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param IvrExcludedExtensionDto $dto
     * @return self
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, IvrExcludedExtensionDto::class);

        $this
            ->setIvr($fkTransformer->transform($dto->getIvr()))
            ->setExtension($fkTransformer->transform($dto->getExtension()));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     * @return IvrExcludedExtensionDto
     */
    public function toDto($depth = 0)
    {
        return self::createDto()
            ->setIvr(Ivr::entityToDto(self::getIvr(), $depth))
            ->setExtension(Extension::entityToDto(self::getExtension(), $depth));
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'ivrId' => self::getIvr() ? self::getIvr()->getId() : null,
            'extensionId' => self::getExtension()->getId()
        ];
    }

    /**
     * Set ivr
     *
     * @param IvrInterface | null
     *
     * @return static
     */
    public function setIvr(?IvrInterface $ivr = null): IvrExcludedExtensionInterface
    {
        $this->ivr = $ivr;

        return $this;
    }

    /**
     * Get ivr
     *
     * @return IvrInterface | null
     */
    public function getIvr(): ?IvrInterface
    {
        return $this->ivr;
    }

    /**
     * Set extension
     *
     * @param ExtensionInterface
     *
     * @return static
     */
    protected function setExtension(ExtensionInterface $extension): IvrExcludedExtensionInterface
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return ExtensionInterface
     */
    public function getExtension(): ExtensionInterface
    {
        return $this->extension;
    }

}
