<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of Category
 *
 * @author matthias
 */
class TagRepository extends EntityRepository
{

    public function findWithPostCount()
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->select('t as tag')
            ->addSelect('count(p.id) as postCount')
            ->innerJoin('t.blogPosts','p')
            ->groupBy('t.id')
            ->orderBy('t.name');

        $result = $queryBuilder->getQuery()->getResult();
        return $result;
    }

    public function findOneByUrlPart($urlPart)
    {
        return $this->findOneBy(array('url_part' => $urlPart));
    }
}
