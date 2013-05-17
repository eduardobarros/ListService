<?php

namespace LSBase\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use \PDO;

/**
 * UserCategoryTicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserCategoryTicketRepository extends EntityRepository
{
    /**
     * fetchAllTypeUserActive
     *
     * Retorna todos os tipos de usuarios ativos
     *
     * @return array
     */
    public function fetchAllUserCategoryTicket($id)
    {
        $query = "SELECT tu.description as roles, ct.description as permissions FROM LSBase\\Entity\\UserCategoryTicket uct JOIN uct.user u JOIN  u.typeUse tu JOIN uct.categoryTicket ct  WHERE tu.active = true AND u.id NOT IN(3) AND u.active = true AND ct.active = true AND u.id = {$id}";

        return $this->_em->createQuery($query)->getResult();
    }

    public function fetchAllUserCategory($id_ticket)
    {
        $query = "SELECT u.id, u.name FROM user_category_ticket uct JOIN user u ON ( uct.user_id = u.id ) JOIN ticket t ON (uct.`category_ticket_id` = t.`category_ticket_id`) WHERE u.active = 1 AND t.id = {$id_ticket} GROUP BY u.id ORDER BY u.name";

        $result = $this->getEntityManager()->getConnection()->query($query)->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
