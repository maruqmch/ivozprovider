<?php
declare(strict_types = 1);

namespace Ivoz\Provider\Domain\Model\ExternalCallFilterRelSchedule;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use \Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\ExternalCallFilter\ExternalCallFilterInterface;
use Ivoz\Provider\Domain\Model\Schedule\ScheduleInterface;
use Ivoz\Provider\Domain\Model\ExternalCallFilter\ExternalCallFilter;
use Ivoz\Provider\Domain\Model\Schedule\Schedule;

/**
* ExternalCallFilterRelScheduleAbstract
* @codeCoverageIgnore
*/
abstract class ExternalCallFilterRelScheduleAbstract
{
    use ChangelogTrait;

    /**
     * @var ExternalCallFilterInterface
     * inversedBy schedules
     */
    protected $filter;

    /**
     * @var ScheduleInterface
     */
    protected $schedule;

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
            "ExternalCallFilterRelSchedule",
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
     * @return ExternalCallFilterRelScheduleDto
     */
    public static function createDto($id = null)
    {
        return new ExternalCallFilterRelScheduleDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param ExternalCallFilterRelScheduleInterface|null $entity
     * @param int $depth
     * @return ExternalCallFilterRelScheduleDto|null
     */
    public static function entityToDto(EntityInterface $entity = null, $depth = 0)
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, ExternalCallFilterRelScheduleInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        /** @var ExternalCallFilterRelScheduleDto $dto */
        $dto = $entity->toDto($depth-1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param ExternalCallFilterRelScheduleDto $dto
     * @return self
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, ExternalCallFilterRelScheduleDto::class);

        $self = new static(

        );

        $self
            ->setFilter($fkTransformer->transform($dto->getFilter()))
            ->setSchedule($fkTransformer->transform($dto->getSchedule()));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param ExternalCallFilterRelScheduleDto $dto
     * @return self
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, ExternalCallFilterRelScheduleDto::class);

        $this
            ->setFilter($fkTransformer->transform($dto->getFilter()))
            ->setSchedule($fkTransformer->transform($dto->getSchedule()));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     * @return ExternalCallFilterRelScheduleDto
     */
    public function toDto($depth = 0)
    {
        return self::createDto()
            ->setFilter(ExternalCallFilter::entityToDto(self::getFilter(), $depth))
            ->setSchedule(Schedule::entityToDto(self::getSchedule(), $depth));
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'filterId' => self::getFilter() ? self::getFilter()->getId() : null,
            'scheduleId' => self::getSchedule()->getId()
        ];
    }

    /**
     * Set filter
     *
     * @param ExternalCallFilterInterface | null
     *
     * @return static
     */
    public function setFilter(?ExternalCallFilterInterface $filter = null): ExternalCallFilterRelScheduleInterface
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Get filter
     *
     * @return ExternalCallFilterInterface | null
     */
    public function getFilter(): ?ExternalCallFilterInterface
    {
        return $this->filter;
    }

    /**
     * Set schedule
     *
     * @param ScheduleInterface
     *
     * @return static
     */
    protected function setSchedule(ScheduleInterface $schedule): ExternalCallFilterRelScheduleInterface
    {
        $this->schedule = $schedule;

        return $this;
    }

    /**
     * Get schedule
     *
     * @return ScheduleInterface
     */
    public function getSchedule(): ScheduleInterface
    {
        return $this->schedule;
    }

}
