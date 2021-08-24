<?php
 //Traits is a class in a php where we write function definition

trait DataTraits{
    public function updateById($data, $row_id){
        $attr = array(
            'where' => array(
                'id' => $row_id
               )
            );
            $status = $this->update($data,$attr);
            if($status){
                return $row_id;
            }else{
                return false;
            }
    }
}