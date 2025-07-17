<?php

namespace Oro\Bundle\ThemeBundle\Entity\Repository;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Oro\Bundle\ThemeBundle\Entity\ThemeConfiguration;

/**
 * Entity repository for {@see ThemeConfiguration} entity.
 */
class ThemeConfigurationRepository extends EntityRepository
{
    private array $curentTheme = [];

    public function getThemeByThemeConfigurationId(?int $id): ?string
    {
        if ($id === null) {
            return null;
        }

        if (isset($this->curentTheme[$id])) {
            return $this->curentTheme[$id];
        }

        $qb = $this->createQueryBuilder('tc');
        $qb->select('tc.theme as theme')
            ->where(
                $qb->expr()->eq('tc.id', ':id')
            )
            ->setParameter('id', $id, Types::INTEGER);

        $this->curentTheme[$id] = $qb->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
        return $this->curentTheme[$id];
    }
}
