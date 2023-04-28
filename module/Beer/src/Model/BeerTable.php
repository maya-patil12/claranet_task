<?php
namespace Beer\Model;
use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class BeerTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getBeer($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveBeer(Beer $beer)
    {
        $data = [
            'id'=>$beer->id,
            'brewery_id'=>$beer->brewery_id,
            'name'=>$beer->name,
            'cat_id'=>$beer->cat_id,
            'style_id'=>$beer->style_id,
            'abv'=>$beer->abv,
            'ibu'=>$beer->ibu,
            'srm'=>$beer->srm,
            'upc'=>$beer->upc,
            'filepath'=>$beer->filepath,
            'descript'=>$beer->descript,
            'add_user'=>$beer->add_user,
        ];

        $id = (int) $beer->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getBeer($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update Beer with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteBeer($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}