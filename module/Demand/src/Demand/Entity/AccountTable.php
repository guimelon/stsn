<?php

namespace Demand\Entity;

use Zend\Db\TableGateway\TableGateway;

class AccountTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function get($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function save(Account $record)
    {
        $data = array(
            'user_id'  => $record->getUserId(),
            'username' => $record->getUsername(),
            'email'  => $record->getEmail(),
            'firstname'  => $record->getFirstname(),
            'lastname'  => $record->getLastname(),
            'photo'  => $record->getPhoto(),
        );

        $id = (int)$record->getId();
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->get($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function delete($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}
