<?php

class HomeModel extends BaseModel
{
    public function getLatestRegisteredUserUsername(int $count = NULL){
        $query= "SELECT username FROM `users` ORDER BY users.date_registered DESC";
        
        return $this->executeQuery($query, $count);
    }
    
    
    
}