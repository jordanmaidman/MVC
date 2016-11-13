<?php
class Model {
private $connection;
function __construct($conn) {
# intialize sql connection variable
$this->connection = $conn;
}

# generic read from database functionality
public function read($table, $fields = '*', $limit = 1000, $sort = 'ASC', $id = null, $id_field = null){
$sql = "";
$fieldString = '';
# create string from $fields array
if(is_array($fields)) $fieldString = implode(',', $fields); // the $fields array is in the format ['FIELD_1_NAME', 'FIELD_2_NAME', 'FIELD_3_NAME'] which is converted to the string 'FIELD_1_NAME, FIELD_2_NAME, FIELD_3_NAME' for the SQL query
else $fieldString = $fields;

if(is_null($id)){
# get all values from MyTable, use fields array to get requested #
//fields and sort parameter to sort
 $sql = "SELECT $fieldString FROM $table LIMIT $limit";
} else {
# get a single value by id
$sql = "SELECT $fieldString FROM $table WHERE $id_field = $id";
}
# SQL String test
# echo($sql);
if($result = $this->connection->query($sql)) {
$results = [];
# Generating Results as an array of Objects
while ($row= $result->fetch_object()) {
 $results[] = $row;
}
return $results;
} else {
	return false;
	}
}
# generic write to database functionality
public function write($table, $fields, $args)
{
# create string from $args array
$argString = implode('\',\'', $args); // the $args array is in the format
//['VALUE_1', ' VALUE_2', ' VALUE_3'] which is converted to the sting "'VALUE_1', 'VALUE_2',
//'VALUE_3'" for the SQL query
# create string from $fields array
$fieldString = implode(',', $fields); // the $fields array is in the format
//['FIELD_1_NAME', 'FIELD_2_NAME', 'FIELD_3_NAME'] which is converted to the sting
//'FIELD_1_NAME, FIELD_2_NAME, FIELD_3_NAME' for the SQL query
# creating the sql query
$sql = "INSERT INTO $table ($fieldString) VALUES('$argString')";
# SQL String test
# echo($sql);
return($this->connection->query($sql));
}
    public function update($table, $args, $id) {
        # update DB implementation
        $data = "";
		foreach ($args as $key=>$value){
			$data .= "$key = '$value',";
		}
		$data = substr ($data, 0, -1);
		$sql = "UPDATE $table SET $data WHERE id=$id";
        return($this->connection->query($sql));
	}
    
    public function delete($table, $id) {
        # delete DB implementation
        $sql = "DELETE FROM $table WHERE id=$id";
        return($this->connection->query($sql)); 
    } 
	 
    }

?>