<?php
namespace Beer\Controller;
use Beer\Model\BeerTable;
use Beer\Form\BeerForm;
use Beer\Model\Beer;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class BeerController extends AbstractActionController
{
    private $table;

    public function __construct(BeerTable $table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {
        return new ViewModel([
            'beers' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        
        $form = new BeerForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $beer = new Beer();
        $form->setInputFilter($beer->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $beer->exchangeArray($form->getData());
        $this->table->saveBeer($beer);
        return $this->redirect()->toRoute('beer');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('beer', ['action' => 'add']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $album = $this->table->getBeer($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('beer', ['action' => 'index']);
        }

        $form = new BeerForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->saveBeer($beer);
        } catch (\Exception $e) {
        }

        // Redirect to album list
        return $this->redirect()->toRoute('beer', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('beer');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteBeer($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('beer');
        }

        return [
            'id'    => $id,
            'beer' => $this->table->getBeer($id),
        ];
    }
    
}