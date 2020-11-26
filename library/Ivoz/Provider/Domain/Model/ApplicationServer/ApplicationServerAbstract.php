<?php
declare(strict_types = 1);

namespace Ivoz\Provider\Domain\Model\ApplicationServer;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use \Ivoz\Core\Application\ForeignKeyTransformerInterface;

/**
* ApplicationServerAbstract
* @codeCoverageIgnore
*/
abstract class ApplicationServerAbstract
{
    use ChangelogTrait;

    /**
     * @var string
     */
    protected $ip;

    /**
     * @var string | null
     */
    protected $name;

    /**
     * Constructor
     */
    protected function __construct(
        $ip
    ) {
        $this->setIp($ip);
    }

    abstract public function getId();

    public function __toString()
    {
        return sprintf(
            "%s#%s",
            "ApplicationServer",
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
     * @return ApplicationServerDto
     */
    public static function createDto($id = null)
    {
        return new ApplicationServerDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param ApplicationServerInterface|null $entity
     * @param int $depth
     * @return ApplicationServerDto|null
     */
    public static function entityToDto(EntityInterface $entity = null, $depth = 0)
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, ApplicationServerInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        /** @var ApplicationServerDto $dto */
        $dto = $entity->toDto($depth-1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param ApplicationServerDto $dto
     * @return self
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, ApplicationServerDto::class);

        $self = new static(
            $dto->getIp()
        );

        $self
            ->setName($dto->getName());

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param ApplicationServerDto $dto
     * @return self
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, ApplicationServerDto::class);

        $this
            ->setIp($dto->getIp())
            ->setName($dto->getName());

        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     * @return ApplicationServerDto
     */
    public function toDto($depth = 0)
    {
        return self::createDto()
            ->setIp(self::getIp())
            ->setName(self::getName());
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'ip' => self::getIp(),
            'name' => self::getName()
        ];
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return static
     */
    protected function setIp(string $ip): ApplicationServerInterface
    {
        Assertion::maxLength($ip, 50, 'ip value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * Set name
     *
     * @param string $name | null
     *
     * @return static
     */
    protected function setName(?string $name = null): ApplicationServerInterface
    {
        if (!is_null($name)) {
            Assertion::maxLength($name, 64, 'name value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string | null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

}
