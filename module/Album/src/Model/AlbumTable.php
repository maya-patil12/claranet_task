<?php 
namespace Album\Model;
use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;
class AlbumTable{
    private $tableGateway;
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway=$tableGateway;
    }

    public function fetchAll(){
        return $this->tableGateway->select();
    }
    public function getAlbum($id){
        $id=(int)$id;
        $formset=$this->tableGateway->select(['id'=>$id]);
        $row=$formset->current();
        if(!$row){
            throw new RuntimeException(
                sprintf("Couldnot find record with id %id",$id)
            );
        }
        return $row;
    }
    public function saveAlbum(Album $album){
        $data=[
            'artist'=>$album->artist,
            'title'=>$album->title,
        ];
        $id=(int)$album->id;
        if($id===0){
            $this->tableGateway->insert($data);
            return;
        }
        try{
            $this->getAlbum($id);
        }catch(RuntimeException $e){
            throw new RuntimeException(
                sprintf("Cannot Update record with id %id",$id)
            );
        }
        $this->tableGateway->update($data,['id'=>$id]);
    }

    public function deleteAlbum($id){
        return $this->tableGateway->delete(['id'=>(int)$id]);
    }

}


