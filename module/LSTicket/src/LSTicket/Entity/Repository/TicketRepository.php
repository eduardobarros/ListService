<?php

namespace LSTicket\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends EntityRepository
{

    // ==================================================================
    //
    // Metodos para retornar a quantidade de ticket's em andamento, aberto e fechado do usuário
    //
    // ------------------------------------------------------------------


    /**
     * TotalMyTicket
     *
     * Retorna aquantidade de ticket's em aberto
     * @param String|Integer $user ID do usuário
     */
    public function TotalMyTicket($user)
    {
        $query = "SELECT COUNT(t.id) FROM LSTicket\\Entity\\Ticket t WHERE t.user = {$user} AND t.active = TRUE AND t.dateEnd IS NULL";

        return $this->_em->createQuery($query)->getResult();
    }

    /**
     * TotalMyTicketResolved
     *
     * Retorna aquantidade de ticket's resolvidos
     * @param String|Integer $user ID do usuário
     */
    public function TotalMyTicketResolved($user)
    {
        $query = "SELECT COUNT(t.id) FROM LSTicket\\Entity\\Ticket t WHERE t.user = {$user} AND t.dateEnd IS NOT NULL AND t.active = TRUE";

        return $this->_em->createQuery($query)->getResult();
    }

    /**
     * TotalMyTicketOngoing
     *
     * Retorna aquantidade de ticket's em andamento
     * @param String|Integer $user ID do usuário
     */
    public function TotalMyTicketOngoing($user)
    {
        $query = "SELECT COUNT(t.id) FROM LSTicket\\Entity\\Ticket t WHERE t.user = {$user} AND t.dateEnd IS NULL AND t.dateEstimated IS NOT NULL AND t.active = TRUE";

        return $this->_em->createQuery($query)->getResult();
    }


    // ==================================================================
    //
    // Metodos para retornar a quantidade de ticket's em andamento, aberto e fechado (geral)
    //
    // ------------------------------------------------------------------


    /**
     * TotalTicketOpen
     *
     * Retorna aquantidade de ticket's em aberto
     */
    public function TotalTicketOpen()
    {
        $query = "SELECT COUNT(t.id) FROM LSTicket\\Entity\\Ticket t WHERE t.active = TRUE AND t.dateEnd IS NULL";

        return $this->_em->createQuery($query)->getResult();
    }

    /**
     * TotalTicketResolved
     *
     * Retorna aquantidade de ticket's resolvidos
     */
    public function TotalTicketResolved()
    {
        $query = "SELECT COUNT(t.id) FROM LSTicket\\Entity\\Ticket t WHERE t.dateEnd IS NOT NULL AND t.active = TRUE";

        return $this->_em->createQuery($query)->getResult();
    }

    /**
     * TotalTicketOngoing
     *
     * Retorna aquantidade de ticket's em andamento
     */
    public function TotalTicketOngoing()
    {
        $query = "SELECT COUNT(t.id) FROM LSTicket\\Entity\\Ticket t WHERE t.dateEnd IS NULL AND t.dateEstimated IS NOT NULL AND t.active = TRUE";

        return $this->_em->createQuery($query)->getResult();
    }

    // ==================================================================
    //
    // Metodos para retornar o ID e o titulo dos tickets em andamento, aberto e fechado
    //
    // ------------------------------------------------------------------

    /**
     * MyTicket
     *
     * Retorna os ticket's em aberto
     * @param String|Integer $user ID do usuário
     */
    public function MyTicket($user)
    {
        $query = "SELECT t.id, t.title FROM LSTicket\\Entity\\Ticket t WHERE t.user = {$user} AND t.active = TRUE AND t.dateEnd IS NULL";

        return $this->_em->createQuery($query)->getResult();
    }

    /**
     * MyTicketResolved
     *
     * Retorna os ticket's resolvidos
     * @param String|Integer $user ID do usuário
     */
    public function MyTicketResolved($user)
    {
        $query = "SELECT t.id, t.title FROM LSTicket\\Entity\\Ticket t WHERE t.user = {$user} AND t.dateEnd IS NOT NULL AND t.active = TRUE";

        return $this->_em->createQuery($query)->getResult();
    }

    /**
     * MyTicketOngoing
     *
     * Retorna os ticket's em andamento
     * @param String|Integer $user ID do usuário
     */
    public function MyTicketOngoing($user)
    {
        $query = "SELECT t.id, t.title FROM LSTicket\\Entity\\Ticket t WHERE t.user = {$user} AND t.dateEnd IS NULL AND t.dateEstimated IS NOT NULL AND t.active = TRUE";

        return $this->_em->createQuery($query)->getResult();
    }

    /**
     * [findAllTicket description]
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function findAllTicket($user)
    {

        $adm = "SELECT type_use_id FROM user WHERE id = {$user} AND active = true";
        $is_adm = $this->_em->getConnection()->executeQuery($adm)->fetchAll();

        if ($is_adm[0]['type_use_id'] == 1)
            $query = "SELECT t.id, t.active, ct.description AS category, IFNULL(p.description, 'Sem Prioridade' ) AS priority, t.title, DATE_FORMAT(t.date_begin, '%d/%m/%Y') AS date_begin , DATE_FORMAT(t.date_end, '%d/%m/%Y') AS date_end, DATE_FORMAT(t.date_estimated, '%d/%m/%Y') AS date_estimated, t.sought, IF(t.date_begin, IF(t.date_estimated, IF(t.date_end, '<span class=\"label label-success\">Fechado</span>', '<span class=\"label label-info\">Em Andamento</span>'), '<span class=\"label label-warning\">Em Análise</span>'), 'OPS Data inicio não foi definida!' ) AS status FROM ticket t JOIN category_ticket ct ON ( t.category_ticket_id = ct.id ) LEFT JOIN priority p ON (t.priority_id = p.id) JOIN interaction i ON (t.id = i.ticket_id) GROUP BY t.id ORDER BY t.id DESC";
        else
            $query = "SELECT t.id, t.active, ct.description AS category, IFNULL(p.description, 'Sem Prioridade' ) AS priority, t.title, DATE_FORMAT(t.date_begin, '%d/%m/%Y') AS date_begin , DATE_FORMAT(t.date_end, '%d/%m/%Y') AS date_end, DATE_FORMAT(t.date_estimated, '%d/%m/%Y') AS date_estimated, t.sought, IF(t.date_begin, IF(t.date_estimated, IF(t.date_end, '<span class=\"label label-success\">Fechado</span>', '<span class=\"label label-info\">Em Andamento</span>'), '<span class=\"label label-warning\">Em Análise</span>'), 'OPS Data inicio não foi definida!' ) AS status FROM ticket t JOIN category_ticket ct ON ( t.category_ticket_id = ct.id ) LEFT JOIN priority p ON (t.priority_id = p.id) JOIN interaction i ON (t.id = i.ticket_id) WHERE t.active = true AND i.user_id = {$user} OR t.user_id = {$user} GROUP BY t.id ORDER BY t.id DESC";

        return $this->_em->getConnection()->executeQuery($query)->fetchAll();

    }



}




























