<?php



class PlgDocmanHistory extends PlgKoowaSubscriber

{

    public function onAfterDocmanDocumentControllerAdd(KEventInterface $event)

    {



        $document_id = $event->result->id;

        $this->AddHistory($document_id, 'add');



    }



    public function onAfterDocmanDocumentControllerEdit(KEventInterface $event)

    {



        $document_id = $event->result->id;

        $this->AddHistory($document_id, 'upd');



    }



    public function onAfterDocmanDocumentControllerDelete(KEventInterface $event)

    {



        $document_id = $event->result->id;

        $this->DelHistory($document_id);



    }



    private function AddHistory($document_id, $action)

    {

        $history = new stdClass();

        $history->item_id = $document_id;

        $history->type = 'document';

        $history->action = $action;

        $history->date_action = date("Y-m-d H:i:s");

        return  JFactory::getDbo()->insertObject('#__notifications_history', $history);

    }



    private function DelHistory($document_id)

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);



        $conditions = array(

            $db->quoteName('item_id') . ' = '.$document_id,

            $db->quoteName('type') . ' = ' . $db->quote('document')

        );



        $query->delete($db->quoteName('#__notifications_history'));

        $query->where($conditions);



        $db->setQuery($query);



        $result = $db->execute();

    }

}

