<?php
namespace App\Models;
class listing {
    public static function viewalllistings(){
        return [
            
        [
            'id' => 1,
            'title' => 'listing one' 
        ],
        [
            'id' => 2,
            'title' => 'listing two' 
        ]
        ];
        

    }
    public static function find($id){
        $listings=self::viewalllistings();
        foreach ($listings as $listing){
            if($listing['id']==$id){
                return $listing;
            } 
        }
    }


}

?>