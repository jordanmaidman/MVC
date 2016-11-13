<?php
class Controller
{
	
    # instance of model class injected into the controller
    private $model;
    function __construct($model)
    {
		$this->model = $model;
    }
    # request handler method is responsible for handling all http requests
    public function requestHandler($server, $get, $post, $session)
    {
        # call method based on request, an example is shown below
        # example API format :
        # url for get request format for get by id: index.php?get=jazz&id=1
        # url for get request format for get all: index.php?get=jazz&limit=10
        # use your own API here
        # handling GET requests
        if($server['REQUEST_METHOD'] == 'GET')
        {
            # replace the url parameters based on your API parameters
            if(!empty($get["get"]))
            {
                switch ($get["get"]) {
					case 'session':
						echo $_SESSION['count'];
						break;
                    case 'jazz':
                        echo $this->getjazz($get["id"], $get["limit"], $get["sort"]);
                        break;
                    case 'delete':
                        echo $this->deleteJazz($get["id"]);
                        break;
			        default:
                        echo 'Error: Invalid Request';
                        break;
                }
            }
        }
        # handling POST requests
        elseif($server['REQUEST_METHOD'] == 'POST')
        {
            # if the ID_FIELD is empty it’s a create request
            if(empty($post['id']))
            {
            # replace FIELD NAMES as per your field names in the database
                echo $this->addjazz(['year', 'artist','album', 'subgenre', 'rating','Publisher'],[$post['year'], $post['artist'], $post['album'], $post['rating'], $post['subgenre'], $post['Publisher']]);
            }
            # if the ID_FIELD is not empty then it’s an update request
            else{
            # implement update here
			echo $this->updateJazz(['year'=>$post['year'], 'artist'=>$post['artist'],'album'=>$post['album']], $post['id']);
            }
        }
    }
    # change function name to one that represents your table name
    private function getjazz($id, $limit = 1000, $sort)
    {
        # get data from the model
        # replace TABLE_NAME with the table that is to be read
        # replace ID_FIELD with the name of the ID Field
        $data = $this->model->read('jazz', '*', $limit, $sort, $id, 'id');
        # process/transform data or apply application logic
        # return data as JSON string
        return json_encode($data);
    }
    # change function name to one that represents your table name
    # replace TABLE_NAME with the table that is to be read

    private function addjazz($fields, $values){
        return $this->model->write('jazz', $fields, $values);
    }
    # implement delete right here
    private function deleteJazz($id) {
        return $this->model->delete('jazz', $id);
    }

    # implementing updating
    private function updateJazz ($values, $id) {
        return $this->model->update('jazz', $values, $id);
    }

}

?>